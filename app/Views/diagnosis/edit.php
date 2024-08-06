<?= $this->extend("layout/master") ?>
<?= $this->section("content") ?>
<style>
    .card {
        border-radius: 15px !important;
    }

    .card-header {
        background-color: #0dcaf0 !important;
        /* color: white !important; */
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card card-widget bg-info p-1">
            <div class="card-body">
                <h4>
                    <span color="white" class="h3">Form Diagnosis Pasien</span>
                </h4>
                <p>
                    <span color="white" class="h5">Form ini digunakan untuk mendiagnosis pasien, petugas memilih pasien terlebih dahulu, setalah itu memilih penyakit, dan memberikan dosis obat</span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h1 class="h3">Form Diagnosis</h1>
            </div>
            <div class="card-body">
                <form id="form-diagnosa">
                    <div class="row">
                        <input type="hidden" id="id_diagnosis" name="id_diagnosis" class="form-control" value="<?= $diagnosis->id ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="pasien_data" class="col-form-label"> Pilih Pasien: <span class="text-danger">*</span> </label>
                                        <select name="pasien_data" id="pasien_data" class="form-control" disabled>
                                            <option value="">Pilih Pasien</option>
                                            <?php foreach ($pasien as $value) : ?>
                                                <?php $valueEx = explode('-', $value['id']) ?>
                                                <option value="<?= $value['id']  ?>" <?= $diagnosis->pasien_id == $valueEx[1] ? 'selected' : '' ?>><?= $value['nama'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="keluhan" class="col-form-label"> Keluhan: </label>
                                        <textarea cols="40" rows="5" id="keluhan" name="keluhan" class="form-control" placeholder="Deskripsi keluhan pasien" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="penyakit_data" class="col-form-label"> Diagnosis Penyakit: <span class="text-danger">*</span> </label>
                                        <select name="penyakit_data" id="penyakit_data" class="form-control">
                                            <option value="">Pilih Diagnosa Penyakit</option>
                                            <?php foreach ($penyakit as $value) : ?>
                                                <option value="<?= $value->id ?>" <?= $diagnosis->penyakit_id == $value->id ? 'selected' : '' ?>><?= $value->nama_penyakit ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tanggal_diagnosis" class="col-form-label">Tanggal Diagnosis: <span class="text-danger">*</span> </label>
                                        <input type="date" id="tanggal_diagnosis" name="tanggal_diagnosis" class="form-control" value="<?= $diagnosis->tanggal_diagnosis ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="catatan" class="col-form-label"> Catatan: </label>
                                        <textarea cols="40" rows="5" id="catatan" name="catatan" class="form-control" placeholder="Catatan diagnosis pasien"><?= $diagnosis->catatan ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <h1 class="h5 mt-2">Form Obat</h1>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="pilih_obat" class="col-form-label">Pilih Obat: <span class="text-danger">*</span></label>
                                        <select name="pilih_obat[]" id="pilih_obat" class="form-control" multiple="multiple">
                                            <?php foreach ($obat as $value) : ?>
                                                <option value="<?= $value->id ?>" data-nama="<?= $value->nama_obat ?>" data-dosis="<?= $value->dosis ?>" <?= in_array($value->id, $selectedObatIds) ? 'selected' : '' ?>><?= $value->nama_obat ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_obat" class="col-form-label"> Nama Obat: </label>
                                            <textarea type="text" class="form-control" name="nama_obat" id="nama_obat" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dosis" class="col-form-label"> Dosis Obat: </label>
                                            <textarea type="text" class="form-control" name="dosis" id="dosis" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group text-center mt-3">
                                        <div class="">
                                            <button type="button" class="btn btn-info mr-2" id="form-btn"><?= lang("Simpan") ?></button>
                                            <a href="/diagnosis" class="btn btn-danger"><?= lang("Batal") ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section("pageScript") ?>

<script>
    $(function() {
        $("#pasien_data").select2({
            placeholder: "Pilih Pasien....",
            allowClear: true,
        });

        $("#penyakit_data").select2({
            placeholder: "Pilih Diagnosis...",
            allowClear: true,
        });
        $("#pilih_obat").select2({
            placeholder: "Pilih Obat...",
            allowClear: true,
        });

        function updateObatInfo() {
            var selectedOptions = $("#pilih_obat").find('option:selected');

            // Concatenate names and dosages
            var obatNames = selectedOptions.map(function() {
                return $(this).data('nama');
            }).get().join('\n');

            var obatDoses = selectedOptions.map(function() {
                return $(this).data('dosis');
            }).get().join('\n');

            $('#nama_obat').val(obatNames);
            $('#dosis').val(obatDoses);
        }

        $("#pilih_obat").on('change', updateObatInfo);

        // Call the function once when the page loads to fill the textarea
        updateObatInfo();

        // Add event listener to remove 'is-invalid' class on input change
        $('.form-diagnosa').find(':input').on('input change', function() {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
            $(this).closest('.form-control').removeClass('is-invalid').find('.invalid-feedback').remove();
        });

        $('#form-btn').on('click', function(e) {
            e.preventDefault(); // Mencegah form submit default
            $(".form-diagnosa").removeClass('is-invalid').removeClass('is-valid'); // Hapus kelas is-invalid dan is-valid
            $(".invalid-feedback").remove(); // Hapus pesan invalid feedback

            var formData = {};
            // Collect data from all forms
            $('#form-diagnosa').each(function() {
                $(this).find(':input').each(function() {
                    var inputName = $(this).attr('name');
                    var inputValue = $(this).val();
                    formData[inputName] = inputValue;
                });
            });

            $(".text-danger").remove();
            $.ajax({
                url: '<?= base_url($controller . "/update") ?>',
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
                            window.location.href = '/diagnosis';
                        });
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
                            });
                        }
                    }
                    $('.btn-simpan').html('Simpan');
                }
            });
        });

        function onUpdateKeluhan() {
            var selectedValue = $("#pasien_data").val();
            console.log(selectedValue)
            selectedValue = selectedValue.split('-')
            console.log(selectedValue)
            $.ajax({
                url: '<?php echo base_url($controller . "/getKeluhan") ?>',
                type: 'post',
                data: {
                    pendaftaran_id: selectedValue[0]
                },
                dataType: 'json',
                success: function(response) {
                    $('#keluhan').text(response.keluhan);
                }
            });
        }
        $("#pasien_data").on('change', onUpdateKeluhan)
        onUpdateKeluhan();
    });
</script>
<?= $this->endSection() ?>