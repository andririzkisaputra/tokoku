<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

class Api extends Model
{

  public function registrasi($post)
  {
    $modelUser = new User;
    $modelUser->username = $post['username'];
    $modelUser->nama     = $post['nama'];
    $modelUser->email    = $post['email'];
    $modelUser->role     = '2';
    $modelUser->setPassword($post['password']);
    $modelUser->generateAuthKey();
    if ($modelUser->save()) {
      $response  = [
        'code'    => 201,
        'status'  => 'sukses',
        'data'    => $modelUser,
        'message' => 'berhasil!'
      ];
    } else {
      $response  = [
        'code'    => 401,
        'status'  => 'error',
        'data'    => [],
        'message' => 'gagal!'
      ];
    }
    return $response;
  }

  public function get_join_tabel($where_like = false, $limit = false, $start = false, $order_by, $tabel, $tabelJoin, $selectJoin)
  {
    $semua = new Query;
    $semua->from($tabel)->leftJoin($tabelJoin, $selectJoin);
    if ($where_like) {
      $semua->where(['like', 'nama_produk' , $where_like]);
    }
    $semua->offset($start)->limit($limit);
    $semua->orderBy([$order_by => SORT_DESC]);
    return $semua->all();
  }

  public function get_tabel_by($tabel)
  {
    $semua = new Query;
    $semua->from($tabel);
    return $semua->all();
  }

  public function simpan_produk($model, $post)
  {
    $baseUrl = Yii::$app->getBasePath();
    $gambar  = UploadedFile::getInstance($model, 'gambar');
    $nama_format = strtolower($post['nama_produk'].' '.date('Y-m-d H:s:i'));
    $nama_format = str_replace(" ", "-", $nama_format).'.'.$gambar->extension;
    $gambar->saveAs('uploads/'.$nama_format);
    $model->nama_produk   = $post['nama_produk'];
    $model->qty           = $post['qty'];
    $model->nama_kategori = $post['nama_kategori'];
    $model->gambar        = $nama_format;
    return $model->save();

  }


}
