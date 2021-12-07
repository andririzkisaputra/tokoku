<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Login form
 */
class KategoriForm extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%kategori}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
      return [
          TimestampBehavior::className(),
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['nama_kategori', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
     public function scenarios() {
       $scenarios = parent::scenarios();
       $scenarios['create'] = ['nama_kategori', 'created_by', 'created_at', 'updated_at'];
       return $scenarios;
     }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kategori_id'   => 'Kategori ID',
            'nama_kategori' => 'Nama Kategori',
            'created_by'    => 'Created By',
            'created_at'    => 'Created At',
            'updated_at'    => 'Updated At',
        ];
    }
}
