<?php

use App\Models\MasterModel;

$masterModel = new MasterModel();
?>
<?= $this->extend("layout/master") ?>


<?= $this->section("content") ?>

<style>
  .card,
  .small-box {
    border-radius: 10px !important;
  }

  .table-pasien {
    background-color: #066a19;
    color: white;
  }

  .card-same-height {
    display: flex;
    flex-direction: column;
  }

  .card-same-height .card-body {
    flex-grow: 1;
  }

  .card-same-height {
    height: 100%;
  }

  #pendaftaranChart {
    height: 200px;
    /* Atur tinggi sesuai kebutuhan */
  }

  @media (min-wdth:1400px) {
    .row>.col-md-6 {
      flex: 0 0 50%;
      max-width: 50%;
    }
  }
</style>

<div class="row">
  <div class="col-md-6">
    <div class="card card-same-height">
      <div class="card-header">
        <h1 class="h4 mb-3 font-weight-normal">Selamat Datang <?= session()->get('nama') ?></h1>
        <div class="text-center mb-4">
          <img src="<?= base_url('asset/img/logo-dashboard.png'); ?>" alt="Logo" class="mb-3">
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="small-box bg-success">
              <div class="inner">
                <p>Users</p>
                <h3><?= $masterModel->countData('tbl_user') ?></h3>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <p>Pasien</p>
                <h3><?= $masterModel->countData('tbl_pasien') ?></h3>
              </div>
              <div class="icon">
                <i class="fa fa-users-line"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <p>Pendaftaran</p>
                <h3><?= $masterModel->countData('pendaftaran_pasien') ?></h3>
              </div>
              <div class="icon">
                <!-- <i class="fa-solid fa-user-injured"></i> -->
                <i class="fa-solid fa-hospital-user"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="small-box bg-info">
              <div class="inner">
                <p>Obat</p>
                <h3><?= $masterModel->countData('tbl_obat') ?></h3>
              </div>
              <div class="icon">
                <i class="fa-solid fa-pills"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card card-same-height">
      <div class="card-header table-pasien">
        <div class="row">
          <div class="col-9 mt-2">
            <h1 class="h3 card-title">Daftar pasien hari ini</h1>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table id="data_table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Umur</th>
              <th>Keluhan</th>
              <th>Tanggal</th>
              <th>Tindakan</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row mt-3">
  <div class="col-md-8">
    <div class="card">

      <canvas id="pendaftaranChart"></canvas>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <canvas id="diagnosisChart"></canvas>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
<!-- /.content -->

<!-- page script -->
<?= $this->section("pageScript") ?>
<script>
  $(function() {

    // Doughnut chart for diagnosis
    var ctxDiagnosis = document.getElementById('diagnosisChart').getContext('2d');
    $('#diagnosisChart').height(400); // Set height

    $.ajax({
      url: '<?= base_url($controller . "/getDiagnosisData") ?>',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        var diagnosed = response.diagnosed;
        var notDiagnosed = response.notDiagnosed;

        var diagnosisChart = new Chart(ctxDiagnosis, {
          type: 'doughnut',
          data: {
            labels: ['Didiagnosis', 'Belum Didiagnosis'],
            datasets: [{
              data: [diagnosed, notDiagnosed],
              backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
              borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false, // Do not maintain aspect ratio
            plugins: {
              legend: {
                display: true,
                position: 'top'
              }
            }
          }
        });
      }
    });

    // Bar chart for monthly registrations
    var ctxPendaftaran = document.getElementById('pendaftaranChart').getContext('2d');
    $('#pendaftaranChart').height(400); // Set height

    $.ajax({
      url: '<?= base_url($controller . "/getPendaftaranData") ?>',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        var dates = response.map(data => data.tanggal);
        var counts = response.map(data => data.count);

        var pendaftaranChart = new Chart(ctxPendaftaran, {
          type: 'bar',
          data: {
            labels: dates,
            datasets: [{
              label: 'Jumlah Pendaftaran pada bulan ini',
              data: counts,
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false, // Do not maintain aspect ratio
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    });

    var table = $('#data_table').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scrollY": '39vh',
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
  })
</script>
<?= $this->endSection() ?>