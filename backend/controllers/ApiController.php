<?php

namespace backend\controllers;

use common\models\Api;
use common\models\ProdukForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

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
      $modelApi = new Api();
			$query		= $modelApi->get_join_tabel($where_like, $rowperpage, $start, 'updated_at', 'produk', 'kategori', 'kategori.kategori_id = produk.kategori_id');
			foreach ($query as $key => $value) {
				$query[$key]['no']	 = $key+1;
				$query[$key]['aksi'] = '<div class="btn-group btn-group-toggle">'
    													 .'<a href="javascript:void(0)" type="button" class="btn btn-sm btn-success edit" data="'.$value['produk_id'].'">Ubah</a>'
    												   .'<a href="javascript:void(0)" type="button" class="btn btn-sm btn-danger hapus" data="'.$value['produk_id'].'">Hapus</a>'
    												 .'</div>';
			}
      $result['draw'] 					 = $draw;
			$result['recordsTotal']    = count($modelApi->get_join_tabel(false, false, false, 'updated_at', 'produk', 'kategori', 'kategori.kategori_id = produk.kategori_id'));
			$result['recordsFiltered'] = count($modelApi->get_join_tabel($where_like, false, false, 'updated_at', 'produk', 'kategori', 'kategori.kategori_id = produk.kategori_id'));
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

      $modelApi = new Api();
      $model   = new ProdukForm();
      if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
      {
        $simpan = $modelApi->simpan_produk($model, Yii::$app->request->post('ProdukForm'));
      }
			print_r(json_encode($simpan));
    }

}
