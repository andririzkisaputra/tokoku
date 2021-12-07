<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
?>

<div class="site-index">
  <div class="">

    <?php echo Html::img('@web/uploads/'.$produk['gambar'], ['class' => 'detail-img']);?>
    <table class="detail-tabel">
      <tbody>
        <tr>
          <td>Nama Kategori</td>
          <td>:</td>
          <td><?= $kategori['nama_kategori'] ?></td>
        </tr>
        <tr>
          <td>Nama Produk</td>
          <td>:</td>
          <td><?= $produk['nama_produk'] ?></td>
        </tr>
        <tr>
          <td>Status Produk</td>
          <td>:</td>
          <td><?= $produk['is_active'] ?></td>
        </tr>
        <tr>
          <td>Produk Posting</td>
          <td>:</td>
          <td><?= $produk['posting'] ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
