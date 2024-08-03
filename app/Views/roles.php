<?= $this->extend("layout/master") ?>

<?= $this->section("content") ?>

<style>
  /* The switch - the box around the slider */
  .switch {
    position: relative;
    display: inline-block;
    width: 55px;
    height: 24px;
  }

  /* Hide default HTML checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 20px;
    /* Adjusted height to fit within slider */
    width: 20px;
    /* Adjusted width to fit within slider */
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    transform: translateX(32px);
    /* Adjusted transform distance to fit the width */
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>

<!-- Main content -->
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-9 mt-2">
        <h3 class="card-title">roles</h3>
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
          <th>Name</th>
          <th>Description</th>

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
            <input type="hidden" id="id" name="id" class="form-control" placeholder="Id" required>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="name" class="col-form-label"> Name: <span class="text-danger">*</span> </label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Name" minlength="0" maxlength="255" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="description" class="col-form-label"> Description: </label>
                <textarea cols="40" rows="5" id="description" name="description" class="form-control" placeholder="Description" minlength="0"></textarea>
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

<!-- ADD modal content -->
<div id="roles-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="text-center bg-info p-3" id="model-header">
        <h4 class="modal-title text-white" id="info-header-modalLabel">Pilih menu untuk user</h4>
      </div>
      <div class="modal-body">
        <form id="roles-form" class="pl-3 pr-3">
          <div class="row">
            <input type="hidden" id="id_role" name="id_role" class="form-control" placeholder="Id" required>
          </div>
          <div class="row">
            <table id="roles_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width:10%">No</th>
                  <th style="width:70%">Menu</th>
                  <th style="width:20%">Pilih</th>
                </tr>
              </thead>
            </table>
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

        //function untuk menghandle tidak terjadi pemanggilan yang berulang
        function handleCheckboxChange() {
          var menuId = $(this).val();
          var roleId = $('#id_role').val(); // mendpatkan value id role
          var type = $(this).is(':checked') ? 1 : 0;

          $('#roles_table').off('change', '.checkbox-menu', handleCheckboxChange);

          tambahMenu(roleId, menuId, type)
            .always(function() {
              $('#roles_table').on('change', '.checkbox-menu', handleCheckboxChange);
            }).fail(function(error) {
              console.error('Error:', error);
            });;
        }

        $('#roles_table').on('change', '.checkbox-menu', handleCheckboxChange);

        function tambahMenu(roleId, menuId, type) {
          return $.ajax({
              url: '<?php echo base_url($controller . "/tambahRoleMenu") ?>',
              type: 'POST',
              data: {
                roleId: roleId,
                menuId: menuId,
                type: type
              },
              success: function(response) {
                console.log(response)
                if (response.status) {
                  Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                  })
                } else {

                  Swal.fire({
                      toast: false,
                      position: 'bottom-end',
                      icon: 'error',
                      title: response.message,
                      showConfirmButton: false,
                      timer: 3000

                    })
                  }
                },
                error: function(xhr, status, error) {
                  console.error('Error in Menu operation:', error);
                }
              });
          }
        });

      var urlController = '';
      var submitText = '';

      function getUrl() {
        return urlController;
      }

      function getSubmitText() {
        return submitText;
      }

      function set(id) {
        $('#roles-modal').modal('show')
        $('#id_role').val(id)
        // $('#data-modal').modal('show');
        if ($.fn.DataTable.isDataTable('#roles_table')) {
          // Hancurkan DataTable yang sudah ada
          $('#roles_table').DataTable().clear().destroy();
        }
        $('#roles_table').removeAttr('width').DataTable({
          "paging": false,
          "lengthChange": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "searching": false,
          "scrollY": true,
          "scrollX": true,
          "scrollCollapse": false,
          "responsive": false,
          "ajax": {
            "url": '<?php echo base_url($controller . "/getMenu") ?>',
            "type": "POST",
            "dataType": "json",
            "data": {
              id_role: id
            },
            async: "true"
          },
          "columnDefs": [{
              "width": "10%",
              "targets": 0
            },
            {
              "width": "70%",
              "targets": 1
            },
            {
              "width": "20%",
              "targets": 2
            }
          ]
        });
      }

      function save(id) {
        // reset the form 
        $("#data-form")[0].reset();
        $(".form-control").removeClass('is-invalid').removeClass('is-valid');
        if (typeof id === 'undefined' || id < 1) { //add
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
              id: id
            },
            dataType: 'json',
            success: function(response) {
              $('#model-header').removeClass('bg-success').addClass('bg-info');
              $("#info-header-modalLabel").text('<?= lang("Ubah") ?>');
              $("#form-btn").text(submitText);
              $('#data-modal').modal('show');
              //insert data to form
              $("#data-form #id").val(response.id);
              $("#data-form #name").val(response.name);
              $("#data-form #description").val(response.description);

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
            var form = $('#data-form');
            $(".text-danger").remove();
            $.ajax({
              // fixBug get url from global function only
              // get global variable is bug!
              url: getUrl(),
              type: 'post',
              data: form.serialize(),
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