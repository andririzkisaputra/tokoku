<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Login form
 */
class ProdukForm extends ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%produk}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_produk', 'qty', 'gambar'], 'required'],
            ['gambar', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
     public function scenarios() {
       $scenarios = parent::scenarios();
       $scenarios['create'] = ['nama_produk', 'qty', 'gambar', 'created_by', 'created_at', 'updated_at'];
       return $scenarios;
     }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produk_id'   => 'Produk ID',
            'anggota_id'  => 'Anggota ID',
            'nama_produk' => 'Nama Produk',
            'qty'         => 'Qty',
            'gambar'      => 'Gambar',
            'created_by'  => 'Created By',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

}
