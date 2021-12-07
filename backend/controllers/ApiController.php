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
      $draw       		 = $_POST['draw'];
			$start      		 = $_POST['start'];
			$rowperpage 		 = $_POST['length'];
			$columnIndex  	 = $_POST['order'][0]['column'];
			$columnName   	 = $_POST['columns'][$columnIndex]['data'];
			$columnSortOrder = $_POST['order'][0]['dir'];
			$searchValue     = $_POST['search']['value'];
      $where_like 		 = array(
				'nama_produk'   => $searchValue,
				'nama_kategoti' => $searchValue,
			);
      $where_like = ['like', 'nama_produk' , $where_like];
      $where      = ['=', 'produk.is_delete' , '1'];
      $modelApi = new Api();
			$query		= $modelApi->get_join_tabel($where, $where_like, $rowperpage, $start, 'updated_at', 'produk', 'kategori', 'kategori.kategori_id = produk.kategori_id');
			foreach ($query as $key => $value) {
				$query[$key]['no']	 = $key+1;
				$query[$key]['aksi'] = '<div class="btn-group btn-group-toggle">'
                               .Html::button('Detail', ['value' => Url::to(['../site/detail-produk?id='.$value['produk_id']]), 'class' => 'btn btn-sm btn-info showModalButton'])
                               .Html::button('Ubah', ['value' => Url::to(['../site/ubah-data-produk?id='.$value['produk_id']]), 'class' => 'btn btn-sm btn-success showModalButton'])
                               .Html::button('Hapus', ['value' => Url::to(['javascript:void(0)']), 'class' => 'btn btn-sm btn-danger hapus', 'data' => $value['produk_id']])
    												 .'</div>';
			}
      $result['draw'] 					 = $draw;
			$result['recordsTotal']    = count($modelApi->get_join_tabel(false, false, false, false, 'updated_at', 'produk', 'kategori', 'kategori.kategori_id = produk.kategori_id'));
			$result['recordsFiltered'] = count($modelApi->get_join_tabel($where, $where_like, false, false, 'updated_at', 'produk', 'kategori', 'kategori.kategori_id = produk.kategori_id'));
			$result['data'] 					 = $query;
			print_r(json_encode($result));
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionPostProduk()
    {
      $modelApi      = new Api();
      $modelProduk   = new ProdukForm();
      $modelKategori = new KategoriForm();
      if(Yii::$app->request->isAjax && $modelProduk->load(Yii::$app->request->post()) && $modelKategori->load(Yii::$app->request->post()))
      {
        $produk   = Yii::$app->request->post('ProdukForm');
        $kategori = Yii::$app->request->post('KategoriForm');
        $simpan = $modelApi->simpan_produk($modelProduk, $produk, $kategori);
      }
			print_r(json_encode($simpan));
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionUbahProduk()
    {
      $modelApi      = new Api();
      $modelProduk   = new ProdukForm();
      $modelKategori = new KategoriForm();
      if(Yii::$app->request->isAjax && $modelProduk->load(Yii::$app->request->post()) && $modelKategori->load(Yii::$app->request->post()))
      {
        $produk   = Yii::$app->request->post('ProdukForm');
        $kategori = Yii::$app->request->post('KategoriForm');
        $simpan = $modelApi->ubah_produk($modelProduk, $produk, $kategori);
      }
			print_r(json_encode($simpan));
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionDeleteProduk()
    {
      $modelApi  = new Api();
      $produk_id = Yii::$app->request->post('produk_id');
      $hapus     = $modelApi->delete_produk($produk_id);

			print_r(json_encode($hapus));
    }

}
