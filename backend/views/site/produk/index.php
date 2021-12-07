<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Modal;

$this->title = 'Admin';

$this->registerJs("
  $(document).ready(function(){
    $('#tabel_produk').DataTable({
      dom: 'Blfrtip',
      buttons: [],
      'lengthMenu': [10, 20, 50, 100, 200, 500, 1000, 5000, 10000],
      'pageLength': 10,
      'lengthChange': true,
      'processing': true,
      'serverSide': true,
      ajax : {
        url  : '".Url::base(true)."/api/get-produk',
        type : 'POST',
        data : {},
      },
      columns: [
        { data: 'no'},
        { data: 'nama_produk', 'className' : 'text-left' },
        { data: 'qty', 'className' : 'text-left' },
        { data: 'aksi', 'className' : 'text-left' },
      ],
    });

  });

  $(document).on('click', '.hapus', function() {
    var produk_id = $(this).attr('data');
    if (produk_id) {
      $.ajax({
          type     : 'POST',
          url      : '".Url::base(true)."/api/delete-produk',
          dataType : 'JSON',
          data     : {
            produk_id : produk_id
          },
          success: function(data){
            $('#tabel_produk').DataTable().ajax.reload();
            return true;
          },
          error: function(){
            alert('ERROR at PHP side!!');
            return false;
          }
      });
    } else {
      return false;
    }
  });
");
?>
<div class="site-index">
  <div class="">
    <h3>Produk</h3>
  </div>
  <div class="tambah-data btn-group">
    <?= Html::button('Tambah Data', ['value' => Url::to(['tambah-data-produk']), 'class' => 'btn btn-sm btn-info showModalButton']); ?>
  </div>
  <div class="">
    <table id="tabel_produk" class="table table-bordered table-striped" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    </table>
  </div>
</div>
<?php
  Modal::begin([
    'id'=>'modal',
    'size'=>'modal-md',
  ]);

  echo "<div id='modalContent'></div>";

  Modal::end();
?>
