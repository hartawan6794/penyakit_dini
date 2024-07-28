<?= $this->extend("layout/master") ?>

<?= $this->section("content") ?>

<style>
  .status {
    padding: 5px 20px;
    border-radius: 10px;
    color: white;
    font-weight: bold;
    font-size: 12px;
  }

  .status.active {
    background-color: green;
  }

  .status.inactive {
    background-color: red;
  }

  .level {
    padding: 5px 20px;
    border-radius: 10px;
    color: white;
    font-weight: bold;
    font-size: 12px;
    display: inline-block;
    /* Menjadikan elemen inline-block */
    line-height: 1.5;
    /* Menyesuaikan tinggi baris untuk menghindari pemotongan */
    overflow: hidden;
    /* Menghindari konten yang meluap */
    background-color: green;
    text-align: center;
  }
</style>

<!-- Main content -->
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-9 mt-2">
        <h3 class="card-title">Tabel User</h3>
      </div>
      <div class="col-3">
        <button type="button" class="btn float-end btn-success" onclick="save()" title="<?= lang("Tambah") ?>"> <i class="fa fa-plus"></i> <?= lang('Tambah') ?></button>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table id="data_table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No telp</th>
          <th>Alamat</th>
          <th>Level</th>
          <th>Status</th>
          <th>Dibuat</th>
          <!-- <th>Diubah</th> -->

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
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="text-center bg-info p-3" id="model-header">
        <h4 class="modal-title text-white" id="info-header-modalLabel"></h4>
      </div>
      <div class="modal-body">
        <form id="data-form" class="pl-3 pr-3">
          <div class="row">
            <input type="hidden" id="id_user" name="id_user" class="form-control" placeholder="Id user" required>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="username" class="col-form-label"> Username: <span class="text-danger">*</span> </label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" minlength="0" maxlength="255" required>
              </div>
            </div>
            <!-- <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="password" class="col-form-label"> Password: <span class="text-danger">*</span> </label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" minlength="0" maxlength="255" required>
              </div>
            </div> -->
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="nama" class="col-form-label"> Nama: </label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" minlength="0" maxlength="255">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="email" class="col-form-label"> Email: </label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" minlength="0" maxlength="255">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="no_telp" class="col-form-label"> No telp: </label>
                <input type="text" id="no_telp" name="no_telp" class="form-control" placeholder="No telp" minlength="0" maxlength="255">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="alamat" class="col-form-label"> Alamat: </label>
                <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat" minlength="0" maxlength="255">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="level" class="col-form-label"> Level: </label>
                <select name="level" class="form-control" id="level">
                  <!-- <option value="1">Admin</option> -->
                  <option value="2">Kepala Puskes</option>
                  <option value="3">Petugas</option>
                </select>
              </div>
            </div>
            <div class="col-md-12 uploaded">
              <div class="form-group mb-3">
                <label for="img_user" class="col-form-label"> Photo Profile: </label>
                <input type="file" id="img_user" name="img_user" class="form-control" minlength="0" maxlength="255">
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <div class="btn-group">
              <button type="submit" class="btn btn-success mr-2" id="form-btn"><?= lang("Simpan") ?></button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang("Batal") ?></button>
            </div>
          </div>
        </form>
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
    $('#data-modal').modal({
      backdrop: 'static',
      keyboard: false
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

  function save(id_user) {
    // reset the form 
    $("#data-form")[0].reset();
    $('.uploaded').show();

    $(".form-control").removeClass('is-invalid').removeClass('is-valid');
    if (typeof id_user === 'undefined' || id_user < 1) { //add
      urlController = '<?= base_url($controller . "/add") ?>';
      submitText = '<?= lang("Simpan") ?>';
      $('#model-header').removeClass('bg-info').addClass('bg-success');
      $("#info-header-modalLabel").text('<?= lang("Tambah") ?>');
      $("#form-btn").text(submitText);
      $('#data-modal').modal('show');
    } else { //edit
      urlController = '<?= base_url($controller . "/edit") ?>';
      submitText = '<?= lang("Perbarui") ?>';
      $.ajax({
        url: '<?php echo base_url($controller . "/getOne") ?>',
        type: 'post',
        data: {
          id_user: id_user
        },
        dataType: 'json',
        success: function(response) {
          $('#model-header').removeClass('bg-success').addClass('bg-info');
          $("#info-header-modalLabel").text('<?= lang("Ubah") ?>');
          $("#form-btn").text(submitText);
          $('#data-modal').modal('show');

          $('.uploaded').hide();
          //insert data to form
          $("#data-form #id_user").val(response.id_user);
          $("#data-form #username").val(response.username);
          $("#data-form #password").val(response.password);
          $("#data-form #nama").val(response.nama);
          $("#data-form #email").val(response.email);
          $("#data-form #no_telp").val(response.no_telp);
          $("#data-form #alamat").val(response.alamat);
          $("#data-form #level").val(response.level);
          $("#data-form #status").val(response.status);
          $("#data-form #created_at").val(response.created_at);
          $("#data-form #updated_at").val(response.updated_at);

        }
      });
    }
    $.validator.setDefaults({
      highlight: function(element) {
        $(element).addClass('is-invalid').removeClass('is-valid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid').addClass('is-valid');
      },
      errorElement: 'div ',
      errorClass: 'invalid-feedback',
      errorPlacement: function(error, element) {
        if (element.parent('.input-group').length) {
          error.insertAfter(element.parent());
        } else if ($(element).is('.select')) {
          element.next().after(error);
        } else if (element.hasClass('select2')) {
          //error.insertAfter(element);
          error.insertAfter(element.next());
        } else if (element.hasClass('selectpicker')) {
          error.insertAfter(element.next());
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form) {
        // var form = $('#data-form');
        // $(".text-danger").remove();
        $.ajax({
          // fixBug get url from global function only
          // get global variable is bug!
          url: getUrl(),
          type: 'post',
          data: new FormData(form),
          processData: false,
          contentType: false,
          cache: false,
          dataType: 'json',
          beforeSend: function() {
            $('#form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
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
                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                $('#data-modal').modal('hide');
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
            $('#form-btn').html(getSubmitText());
          }
        });
        return false;
      }
    });

    $('#data-form').validate({

      //insert data-form to database

    });
  }



  function remove(id_user) {
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
            id_user: id_user
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

  function active(id_user, type) {

    let message = type === 9 ? "<?= lang("Inactive user ini ?") ?>" : "<?= lang("Active user ini ?") ?>";

    Swal.fire({
      title: "<?= lang("Status") ?>",
      text: message,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<?= lang("Konfirmasi") ?>',
      cancelButtonText: '<?= lang("Batal") ?>'
    }).then((result) => {

      if (result.value) {
        $.ajax({
          url: '<?php echo base_url($controller . "/active") ?>',
          type: 'post',
          data: {
            id_user: id_user,
            type: type
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