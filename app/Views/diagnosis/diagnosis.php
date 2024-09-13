<?php

use App\Models\RolesModel;
$roles = new RolesModel();
$role = $roles->select('name')->where('id',session()->get('id_role'))->first();
?>
<?= $this->extend("layout/master") ?>

<?= $this->section("content") ?>

<!-- Main content -->
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-9 mt-2">
        <h3 class="card-title">Diagnosis Pasien</h3>
      </div>
      <?php if($role->name === 'Dokter') {?>
      <div class="col-3">
        <a href="diagnosis/create" class="btn float-end btn-success" title="<?= lang("Tambah") ?>"> <i class="fa fa-plus"></i> <?= lang('Tambah') ?></a>
      </div>
      <?php }?>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table id="data_table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pasien</th>
          <th>Nama Penyakit</th>
          <th>Tanggal Pendaftaran</th>
          <th>Tanggal diagnosis</th>
          <th>Catatan</th>
          <th>Petugas</th>
          <th></th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

<!-- /Main content -->

<!-- ADD modal content -->
<div id="data-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="text-center bg-info p-3" id="model-header">
        <h4 class="modal-title text-white" id="info-header-modalLabel">Detail Diagnosis</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <h1 class="h5">Data Pasien</h1>
          <div class="table-responsive">
            <table class="table table-bordered no-margin">
              <tbody>
                <tr>
                  <th style="width: 20%;">No Pendaftaran</th>
                  <td style="width: 30%;"><span id="no_pendaftaran"></span></td>
                </tr>
                <tr>
                  <th style="width: 20%;">Nama Pasien</th>
                  <td style="width: 30%;"><span id="nama"></span></td>
                </tr>
                <tr>
                  <th style="width: 20%;">Umur</th>
                  <td style="width: 30%;"><span id="umur"></span></td>
                </tr>
                <tr>
                  <th style="width: 20%;">Keluhan</th>
                  <td style="width: 30%;"><span id="keluhan"></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <h1 class="h5">Data Penyakit</h1>
          <div class="table-responsive">
            <table class="table table-bordered no-margin">
              <tbody>
                <tr>
                  <th style="width: 20%;">Nama Penyakit</th>
                  <td style="width: 30%;"><span id="nama_penyakit"></span></td>
                  <th style="width: 20%;">Gejala</th>
                  <td style="width: 30%;"><span id="gejala"></span></td>
                </tr>
                <tr>
                  <th style="width: 20%;">Pengobatan</th>
                  <td style="width: 30%;"><span id="pengobatan"></span></td>
                  <th style="width: 20%;">Deskripsi</th>
                  <td style="width: 30%;"><span id="deskripsi"></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <h1 class="h5">Diagnosis Pasien</h1>
          <div class="table-responsive">
            <table class="table table-bordered no-margin">
              <tbody>
                <tr>
                  <th style="width: 20%;">Catatan</th>
                  <td style="width: 30%;"><span id="catatan"></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <h1 class="h5">Data Obat</h1>
          <div class="table-responsive">
            <table class="table table-bordered no-margin">
              <tbody>
                <tr>
                  <th style="width: 20%;">Dosis Obat</th>
                  <td style="width: 30%;"><span id="dosis"></span></td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn btn-md btn-default float-end" data-bs-dismiss="modal"><?= lang("Kembali") ?></button>
          </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- /ADD modal content -->



<?= $this->endSection() ?>
<!-- /.content -->


<!-- page script -->
<?= $this->section("pageScript") ?>
<script>
  // dataTables
  $(function() {
    var table = $('#data_table').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scrollY": '45vh',
      "scrollX": true,
      "scrollCollapse": false,
      "responsive": false,
      "ajax": {
        "url": '<?php echo base_url($controller . "/getAll") ?>',
        "type": "POST",
        "dataType": "json",
        async: "true"
      }
    });
  });

  var urlController = '';
  var submitText = '';

  function getUrl() {
    return urlController;
  }

  function getSubmitText() {
    return submitText;
  }

  function detail(id) {
    $('#data-modal').modal('show');
    urlController = '<?= base_url($controller . "/edit") ?>';
    $.ajax({
      url: '<?php echo base_url($controller . "/getOne") ?>',
      type: 'post',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(response) {
        $("#data-modal #no_pendaftaran").text(response.no_pendaftaran);
        $("#data-modal #nama").text(response.nama);
        $("#data-modal #catatan").text(response.catatan);
        $("#data-modal #umur").text(response.umur + ' Tahun');
        $("#data-modal #keluhan").text(response.keluhan);
        $("#data-modal #nama_penyakit").text(response.nama_penyakit);
        $("#data-modal #gejala").text(response.gejala);
        $("#data-modal #deskripsi").text(response.deskripsi);
        $("#data-modal #pengobatan").text(response.pengobatan);
        $("#data-modal #updated_at").text(response.updated_at);
        var dosis = '<table class="table no-margin table-bordered table-striped"><tr><th>Nama Obat</th><th>Dosis</th><th>Deskripsi</th></tr>'
        $.getJSON('<?= site_url($controller . '/obat/') ?>' + response.diagnosis_id, function(data) {
          $.each(data, function(key, val) {
            dosis += '<tr><td>' + val.nama_obat + '</td><td>' + val.dosis + '</td><td>' + val.deskripsi + '</td></tr>'
          })
          dosis += '</table>'
          $('#dosis').html(dosis)
        })
      }
    });
  }

  function remove(id) {
    Swal.fire({
      title: "<?= lang("Hapus") ?>",
      text: "<?= lang("Yakin ingin menghapus ?") ?>",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<?= lang("Konfirmasi") ?>',
      cancelButtonText: '<?= lang("Batal") ?>'
    }).then((result) => {

      if (result.value) {
        $.ajax({
          url: '<?php echo base_url($controller . "/remove") ?>',
          type: 'post',
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {

            if (response.success === true) {
              Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: response.messages,
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
              })
            } else {
              Swal.fire({
                toast: false,
                position: 'bottom-end',
                icon: 'error',
                title: response.messages,
                showConfirmButton: false,
                timer: 3000
              })
            }
          }
        });
      }
    })
  }
</script>


<?= $this->endSection() ?>