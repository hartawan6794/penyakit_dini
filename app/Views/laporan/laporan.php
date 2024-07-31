<?= $this->extend("layout/master") ?>
<?= $this->section("content") ?>

<!-- /.content -->
<!-- Default box -->
<div class="card">
    <div class="card-body row">
        <div class="col-sm-12 text-center d-flex align-items-center justify-content-center">
            <div class="">
                <img src="<?= base_url('/asset/img/logo_puskes.png') ?>" alt="Logo Puskes" style="width: 100px;">
                <h2> Laporan <br></h2>
                <h1 class="h4 mb-3 font-weight-normal">SISTEM INFORMASI TENTANG PENYAKIT PADA ANAK USIA DINI<br>DI PUSKESMAS GEDUNG KARYA JITU</h1>
                <p id="time"></p>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    <div class="alert alert-success" role="alert">
                        <h5>Cetak laporan data diagnosis pasien berdasarkan tanggal pendaftaran</h5>
                    </div>
                    <form target="_blank" action="<?= base_url("laporan/cetak_diagnosis") ?>" method="post">
                        <div class="form-group">
                            <label for="tgl_mulai">Tanggal Mulai:</label>
                            <input type="date" id="tgl_mulai" name="tgl_mulai" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="tgl_sampai">Tanggal Sampai</label>
                            <input type="date" id="tgl_sampai" name="tgl_sampai" class="form-control" required />
                        </div>

                        <div class="form-group float-end mt-2">
                            <input type="submit" class="btn btn-primary float-sm-right" value="Cetak">
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
<?= $this->endSection() ?>

<!-- page script -->
<?= $this->section("pageScript") ?>
<script>
    function showTime() {
        var a_p = "";
        var today = new Date();
        var curr_hour = today.getHours();
        var curr_minute = today.getMinutes();
        var curr_second = today.getSeconds();
        if (curr_hour < 12) {
            a_p = "AM";
        } else {
            a_p = "PM";
        }
        if (curr_hour == 0) {
            curr_hour = 12;
        }
        if (curr_hour > 12) {
            curr_hour = curr_hour - 12;
        }
        curr_hour = checkTime(curr_hour);
        curr_minute = checkTime(curr_minute);
        curr_second = checkTime(curr_second);
        document.getElementById('time').innerHTML = curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    setInterval(showTime, 500);
</script>
<?= $this->endSection() ?>