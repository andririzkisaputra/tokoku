<?php

namespace backend\controllers;

use Yii;
use common\models\Api;
use common\models\ProdukForm;
use common\models\KategoriForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Site controller
 */
class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        // 'actions' => ['produk', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionGetProduk()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $draw       		 = $_POST['draw'];
			$start      		 = $_POST['start'];
			$rowperpage 		 = $_POST['length'];
			$columnIndex  	 = $_POST['order'][0]['column'];
			$columnName   	 = $_POST['columns'][$columnIndex]['data'];
			$columnSortOrder = $_POST['order'][0]['dir'];
			$searchValue     = $_POST['search']['value'];
      $where_like 		 = array(
				'produk.nama_produk'   => $searchValue,
				'produk.nama_kategoti' => $searchValue,
			);
      $where_like = ['like', 'nama_produk' , $where_like];
      $where      = ['=', 'produk.is_delete' , '1'];
      $modelApi = new Api();
			$query		= $modelApi->get_join_tabel($where, $where_like, $rowperpage, $start, 'produk.updated_at', 'produk', 'kategori', 'kategori.kategori_id = produk.kategori_id');
			foreach ($query as $key => $value) {
				$query[$key]['no']	 = $key+1;
				$query[$key]['aksi'] = '<div class="btn-group btn-group-toggle">'
                                 .Html::button('Detail', ['value' => Url::to(['../site/detail-produk?id='.$value['produk_id']]), 'class' => 'btn btn-sm btn-info showModalButton'])
                                 .Html::button('Ubah', ['value' => Url::to(['../site/ubah-data-produk?id='.$value['produk_id']]), 'class' => 'btn btn-sm btn-success showModalButton'])
                                 .Html::button('Hapus', ['value' => Url::to(['javascript:void(0)']), 'class' => 'btn btn-sm btn-danger hapus', 'data' => $value['produk_id']])
      												 .'</div>';
			}

      $result['draw'] 					 = $draw;
			$result['recordsFiltered'] = count($modelApi->get_join_tabel($where, $where_like, false, false, 'produk.updated_at', 'produk', 'kategori', 'kategori.kategori_id = produk.kategori_id'));
      $result['recordsTotal']    = count($query);
			$result['data'] 					 = $query;
      return $result;
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionGetKategori()
    {

      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $draw       		 = $_POST['draw'];
			$start      		 = $_POST['start'];
			$rowperpage 		 = $_POST['length'];
			$columnIndex  	 = $_POST['order'][0]['column'];
			$columnName   	 = $_POST['columns'][$columnIndex]['data'];
			$columnSortOrder = $_POST['order'][0]['dir'];
			$searchValue     = $_POST['search']['value'];
      $where_like 		 = array(
				'nama_kategori'   => $searchValue,
			);
      $where_like = ['like', 'nama_kategori' , $where_like];
      $where      = ['=', 'is_delete' , '1'];
      $modelApi = new Api();
			$query		= $modelApi->get_tabel($where, $where_like, $rowperpage, $start, 'updated_at', 'kategori');
			foreach ($query as $key => $value) {
				$query[$key]['updated_at_f']	 = date('d M Y H:i:s', $value['updated_at']);
				$query[$key]['no']	 = $key+1;
				$query[$key]['aksi'] = '<div class="btn-group btn-group-toggle">'
                                 .Html::button('Ubah', ['value' => Url::to(['../site/ubah-data-kategori?id='.$value['kategori_id']]), 'class' => 'btn btn-sm btn-success showModalButton'])
                                 .Html::button('Hapus', ['value' => Url::to(['javascript:void(0)']), 'class' => 'btn btn-sm btn-danger hapus', 'data' => $value['kategori_id']])
      												 .'</div>';
			}
      $result['draw'] 					 = $draw;
			$result['recordsFiltered'] = count($modelApi->get_tabel($where, $where_like, false, false, 'updated_at', 'kategori'));
      $result['recordsTotal']    = count($query);
			$result['data'] 					 = $query;
			return $result;
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionPostProduk()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $modelApi      = new Api();
      $modelProduk   = new ProdukForm();
      $modelKategori = new KategoriForm();
      if(Yii::$app->request->isAjax && $modelProduk->load(Yii::$app->request->post()) && $modelKategori->load(Yii::$app->request->post()))
      {
        $produk   = Yii::$app->request->post('ProdukForm');
        $kategori = Yii::$app->request->post('KategoriForm');
        $simpan = $modelApi->simpan_produk($modelProduk, $produk, $kategori);
      }
			return $simpan;
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionPostKategori()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $modelApi      = new Api();
      $modelKategori = new KategoriForm();
      if(Yii::$app->request->isAjax && $modelKategori->load(Yii::$app->request->post()))
      {
        $kategori = Yii::$app->request->post('KategoriForm');
        $simpan = $modelApi->simpan_kategori($modelKategori, $kategori);
      }
			return $simpan;
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionUbahProduk()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $modelApi      = new Api();
      $modelProduk   = new ProdukForm();
      $modelKategori = new KategoriForm();
      if(Yii::$app->request->isAjax && $modelProduk->load(Yii::$app->request->post()) && $modelKategori->load(Yii::$app->request->post()))
      {
        $produk   = Yii::$app->request->post('ProdukForm');
        $kategori = Yii::$app->request->post('KategoriForm');
        $simpan = $modelApi->ubah_produk($modelProduk, $produk, $kategori);
      }
			return $simpan;
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionUbahKategori()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $modelApi      = new Api();
      $modelKategori = new KategoriForm();
      if(Yii::$app->request->isAjax && $modelKategori->load(Yii::$app->request->post()))
      {
        $kategori = Yii::$app->request->post('KategoriForm');
        $simpan = $modelApi->ubah_kategori($kategori);
      }
			return $simpan;
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionDeleteProduk()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $modelApi  = new Api();
      $produk_id = Yii::$app->request->post('produk_id');
      $hapus     = $modelApi->delete_produk($produk_id);

			return $hapus;
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionDeleteKategori()
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $modelApi    = new Api();
      $kategori_id = Yii::$app->request->post('kategori_id');
      $hapus       = $modelApi->delete_kategori($kategori_id);

			return $hapus;
    }

}
