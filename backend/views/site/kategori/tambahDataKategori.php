<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;

$this->registerJs("
  $('#simpan-kategori').click(function(e) {
    var formData = new FormData($('form')[1]);
    var nama_kategori = $('#nama_kategori').val();
    if (nama_kategori) {
      $.ajax({
          type     : 'POST',
          url      : '".Url::base(true)."/api/post-kategori',
          dataType : 'JSON',
          data     : formData,
          success: function(data){
            console.log(data);
            $('#nama_kategori').val('');
            $('#tabel_kategori').DataTable().ajax.reload();
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
      <?= $form->field($model, 'nama_kategori')->textInput(['autofocus' => true, 'id' => 'nama_kategori']) ?>
      <?= Html::button('Simpan', ['class' => 'btn btn-sm btn-success', 'id' => 'simpan-kategori', 'data-dismiss' => 'modal']); ?>
  <?php ActiveForm::end(); ?>
</div>
