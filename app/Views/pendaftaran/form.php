<?= $this->extend("layout/master") ?>
<?= $this->section("content") ?>
<style>
  .card {
    border-radius: 15px !important;
  }

  .card-header {
    background-color: #198754 !important;
    color: white !important;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="card card-widget bg-success p-1">
      <div class="card-body">
        <h4>
          <span color="white" class="h3">Form Pendaftaran Pasien</span>
        </h4>
        <p>
          <span color="white" class="h6">Pilih atau masukan nama pasien untuk input pasien baru, sebelum input pasien baru pastikan untuk cek pasien terdaftar terlebih dahulu dengan mengklik tombol <i>search</i>/pencarian</span>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6">
    <div class="card card-widget">
      <div class="card-header">
        <span class="h4">Form Pasien</span>
      </div>
      <div class="card-body">
        <form class="form-pendaftaran" class="pl-3 pr-3">
          <div class="row">
            <input type="hidden" id="id_pasien" name="id_pasien" class="form-control" placeholder="id_pasien" required>
            <input type="hidden" id="id" name="id" class="form-control" placeholder="id" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="nama" class="col-form-label"> Nama: <span class="text-danger">*</span> </label>
                <div class="input-group mb-3">
                  <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" minlength="0" maxlength="255" required>
                  <button class="btn btn-primary" id="search-pasien" type="button"><i class="fa fa-search"></i></button>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="umur" class="col-form-label"> Usia: <span class="text-danger">*</span> </label>
                <input type="text" id="umur" name="umur" class="form-control" dateISO="true" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="tanggal_lahir" class="col-form-label"> Tanggal lahir: <span class="text-danger">*</span> </label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" dateISO="true" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="jenis_kelamin" class="col-form-label"> Jenis kelamin: <span class="text-danger">*</span> </label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="nama_orang_tua" class="col-form-label"> Nama orang tua: <span class="text-danger">*</span> </label>
                <input type="text" id="nama_orang_tua" name="nama_orang_tua" class="form-control" placeholder="Nama orang tua" minlength="0" maxlength="255" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="no_telepon" class="col-form-label"> No telepon: <span class="text-danger">*</span> </label>
                <input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="No telepon" minlength="0" maxlength="15" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="alamat" class="col-form-label"> Alamat: <span class="text-danger">*</span> </label>
                <textarea cols="40" rows="5" id="alamat" name="alamat" class="form-control" placeholder="Alamat" minlength="0" required></textarea>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card card-widget">
      <div class="card-header">
        <span class="h4">Form Keluhan</span>
      </div>
      <div class="card-body">
        <form class="form-pendaftaran">
          <div class="row">
            <input type="hidden" id="id_keluhan" name="id_keluhan" class="form-control" placeholder="Id_keluhan">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="rekam_medis" class="col-form-label">No. Rekam Medis: <span class="text-danger">*</span> </label>
                <input type="text" id="rekam_medis" name="rekam_medis" class="form-control" dateISO="true" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="tanggal_keluhan" class="col-form-label"> Tanggal Mulai Keluhan: <span class="text-danger">*</span> </label>
                <input type="date" id="tanggal_keluhan" name="tanggal_keluhan" class="form-control" dateISO="true" max="<?= date('m-d-Y') ?>" required readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="keluhan" class="col-form-label"> Keluhan: <span class="text-danger">*</span> </label>
                <textarea cols="40" rows="5" id="keluhan" name="keluhan" class="form-control" placeholder="Deskripsi keluhan pasien"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="deskripsi" class="col-form-label"> Keterangan: </label>
                <textarea cols="40" rows="5" id="deskripsi" name="deskripsi" class="form-control" placeholder="Keterangan lainya"></textarea>
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <div class="">
              <button type="button" class="btn btn-success mr-2" id="form-btn"><?= lang("Simpan") ?></button>
              <a href="/pendaftaran" class="btn btn-danger"><?= lang("Batal") ?></a>
              <!-- <button type="button" class="btn btn-danger"><?= lang("Batal") ?></button> -->
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal item -->
<div class="modal fade" id="pasien-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-tittle">Ambil Data Pasien</h4>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
        <!-- <span aria-hidden="true">&times;</span> -->
        <!-- </button> -->
      </div>
      <div class="modal-body table-responsive" style="width: 100%;">
        <table class="table table-bordered table-striped" id="data_table_pasien">
          <thead>
            <tr>
              <td>No</td>
              <td>Nama</td>
              <td>Nama Orang Tua</td>
              <td>Jenis Kelamin</td>
              <td>Umur</td>
              <td>Aksi</td>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
<!-- /.content -->
<!-- page script -->
<?= $this->section("pageScript") ?>
<script>
  $(function() {
    document.getElementById('tanggal_keluhan').setAttribute('max', new Date().toISOString().split('T')[0]);
    document.getElementById('tanggal_lahir').setAttribute('max', new Date().toISOString().split('T')[0]);


    const tanggalInput = document.getElementById('tanggal_keluhan');
    tanggalInput.addEventListener('click', function() {
      this.removeAttribute('readonly');
    });

    tanggalInput.addEventListener('blur', function() {
      this.setAttribute('readonly', true);
    });

    tanggalInput.addEventListener('change', function() {
      this.setAttribute('readonly', true);
    });

    $('#search-pasien').on('click', function() {
      $('#pasien-modal').modal('show')
      if ($.fn.DataTable.isDataTable('#data_table_pasien')) {
        // Hancurkan DataTable yang sudah ada
        $('#data_table_pasien').DataTable().clear().destroy();
      }
      $('#data_table_pasien').removeAttr('width').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
          "url": '<?php echo base_url($controller . "/getPasien") ?>',
          "type": "POST",
          "dataType": "json",
          async: "true"
        }
      });
    })

    // Add event listener to remove 'is-invalid' class on input change
    $('.form-pendaftaran').find(':input').on('input change', function() {
      $(this).removeClass('is-invalid');
      $(this).addClass('is-valid');
      $(this).closest('.form-control').removeClass('is-invalid').find('.invalid-feedback').remove();
    });

    $('#form-btn').on('click', function(e) {
      e.preventDefault(); // Mencegah form submit default
      $(".form-pendaftaran").removeClass('is-invalid').removeClass('is-valid'); // Hapus kelas is-invalid dan is-valid
      $(".invalid-feedback").remove(); // Hapus pesan invalid feedback
      var formData = {};
      // Collect data from all forms
      $('.form-pendaftaran').each(function() {
        $(this).find(':input').each(function() {
          var inputName = $(this).attr('name');
          var inputValue = $(this).val();
          formData[inputName] = inputValue;
        });
      });

      // var formData = $('#formPermohonan').serialize();
      console.log(formData)
      $(".text-danger").remove();
      $.ajax({
        // fixBug get url from global function only
        // get global variable is bug!
        url: '<?= base_url($controller . "/add") ?>',
        type: 'post',
        data: formData,
        cache: false,
        dataType: 'json',
        beforeSend: function() {
          $('.btn-submit').html('<i class="fa fa-spinner fa-spin"></i>');
        },
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
              window.location.href = '/pendaftaran';
            })
          } else {
            if (response.messages instanceof Object) {
              $.each(response.messages, function(index, value) {
                var ele = $("#" + index);
                ele.closest('.form-control')
                  .removeClass('is-invalid')
                  .removeClass('is-valid')
                  .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
                ele.after('<div class="invalid-feedback">' + response.messages[index] + '</div>');
              });
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
          $('.btn-simpan').html('Simpan');
        }
      });
    })

  })

  // Attach event handler using delegation
  $(document).on('click', '#pilih_pasien', function() {
    $('#pasien-modal').modal('hide')
    $('#id_pasien').val($(this).data('id'))
    $('#nama').val($(this).data('nama'))
    $('#tanggal_lahir').val($(this).data('tgl-lahir'))
    $('#jenis_kelamin').val($(this).data('jns-kelamin'))
    $('#alamat').val($(this).data('alamat'))
    $('#nama_orang_tua').val($(this).data('nama-orang-tua'))
    $('#no_telepon').val($(this).data('no-telp'))
    $('#umur').val($(this).data('umur'))
  });
</script>
<?= $this->endSection() ?>