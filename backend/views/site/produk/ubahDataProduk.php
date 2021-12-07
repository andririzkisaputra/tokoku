<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;

$this->registerJs("
  $('#ubah-produk').click(function(e) {
    var formData = new FormData($('form')[1]);
    var nama_produk   = $('#nama_produk').val();
    var qty           = $('#qty').val();
    var gambar        = $('#gambar').val();
    var nama_kategori = $('#nama_kategori').val();
    if (nama_produk && qty && nama_kategori) {
      $.ajax({
          type     : 'POST',
          url      : '".Url::base(true)."/api/ubah-produk',
          dataType : 'JSON',
          data     : formData,
          success: function(data){
            $('#nama_produk').val('');
            $('#qty').val('');
            $('#gambar').val('');
            $('#tabel_produk').DataTable().ajax.reload();
            return true;
          },
          error: function(){
            alert('ERROR at PHP side!!');
            return false;
          },
          cache: false,
          contentType: false,
          processData: false
      });
    } else {
      return false;
    }
  });
");
?>

<div class="site-index">
  <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
      <?= $form->field($modelProduk, 'produk_id')->textInput(['id' => 'produk_id', 'value' => $produk['produk_id'], 'readonly' => true]) ?>
      <?= $form->field($modelProduk, 'nama_produk')->textInput(['autofocus' => true, 'id' => 'nama_produk', 'value' => $produk['nama_produk']]) ?>
      <?= $form->field($modelKategori, 'nama_kategori')->dropDownList(
            $kategori, ['id' => 'nama_kategori', 'value' => $produk['kategori_id']],
      ) ?>
      <?= $form->field($modelProduk, 'qty')->textInput(['id' => 'qty', 'value' => $produk['qty']]) ?>
      <?= $form->field($modelProduk, 'gambar')->fileInput(['class' => 'btn btn-primary', 'accept' => 'image/*', 'capture' => 'camera', 'id' => 'gambar', 'value' => $produk['gambar']])->label(false) ?>
      <?= Html::button('Ubah', ['class' => 'btn btn-sm btn-success', 'id' => 'ubah-produk', 'data-dismiss' => 'modal']); ?>
  <?php ActiveForm::end(); ?>
</div>
