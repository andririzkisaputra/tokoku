<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\ProdukForm;
use common\models\KategoriForm;
use common\models\Api;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        // 'actions' => ['produk', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays produk.
     *
     * @return string
     */
    public function actionProduk()
    {
        return $this->render('produk/index');
    }

    /**
     * Displays produk.
     *
     * @return string
     */
     public function actionTambahDataProduk() {
       $kategori      = [];
       $modelApi      = new Api();
       $modelProduk   = new ProdukForm();
       $modelKategori = new KategoriForm();
       $dataKategori  = $modelApi->get_tabel_by('kategori');
       foreach ($dataKategori as $key => $value) {
         $kategori[$value['kategori_id']] = $value['nama_kategori'];
       }
       return $this->renderAjax('produk/tambahDataProduk', [
           'modelProduk'   => $modelProduk,
           'modelKategori' => $modelKategori,
           'kategori'      => $kategori,
       ]);
     }

    /**
     * Displays pesanan.
     *
     * @return string
     */
    public function actionPesanan()
    {
        return $this->render('pesanan/index');
    }

    /**
     * Displays laporan.
     *
     * @return string
     */
    public function actionLaporan()
    {
        return $this->render('laporan/index');
    }

    /**
     * Displays kategori.
     *
     * @return string
     */
    public function actionKategori()
    {
        return $this->render('kategori/index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionRegistrasi()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $modelApi = new Api();
        $simpan   = $modelApi->registrasi($post);
        return $simpan;
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
