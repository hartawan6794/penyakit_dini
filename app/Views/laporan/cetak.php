<?php
// use App\Models\Master_model;

// $model = new Master_model();
// helper("settings");
?>
<!-- <link rel="stylesheet" href="<?=base_url('asset/plugins/fontawesome-free/css/fontawesome.css')?>">
<link rel="stylesheet" href="<?= base_url() ?>/asset/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="<?=base_url('asset/plugins/fontawesome-free/css/fontawesome.min.css')?>"> -->
<style type="text/css">
  table.tableizer-table {
    font-size: 12px;
    max-width: 100%;
    border: 1px solid #CCC;
    font-family: Arial, Helvetica, sans-serif;
  }

  .tableizer-table td {
    padding: 4px;
    margin: 3px;
    border: 1px solid #CCC;
  }

  .tableizer-table th {
    background-color: #00a65a !important;
    color: #FFF;
    font-weight: bold;
  }

  .header-img-las{
    text-align: center;
  }
</style>

<div>
  <div class="">
    <center><img class="header-img-las" src="<?= base_url() ?>/asset/img/logo_puskes.png" style="width:80px;"></center>
    <div style="font-size:16px; font-weight:bold;" class="roboto">
      <center> LAPORAN DATA DIAGNOSIS PASIEN </center>
    </div>
    <div style="font-size:20px; font-weight:bold;" class="roboto">
      <center>PUSKESMAS GEDUNG KARYA JITU</center>
    </div>
    <div style="font-size:12px;" class="roboto">
      <center>Kecamatan Rawa Jitu Selatan</center>
    </div>
    <!-- <div style="font-size:12px;" class="roboto">
      <center>Kabupaten Tanggamus, Lampung</center>
    </div> -->
    

  </div>
</div>
<div style="float:right;" class="roboto"></div>

<div class="header-logo-right"></div>


</div>
<hr>
<p>
<h4>Dari Tanggal <?= $tgl_mulai ?> Sampai <?= $tgl_sampai ?></h4>
</p>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <thead>
    <tr bgcolor="#00CC66" align="center">
      <th>No</th>
      <th>No Pendaftaran</th>
      <th>No RM</th>
      <th>Nama</th>
      <th>Umur</th>
      <th>Keluhan</th>
      <th>Penyakit</th>
      <th>Catatan Diagnosis</th>
      <th>Tanggal Daftar</th>
    </tr>

  </thead>
  <?php $no = 1;
  foreach ($diagnosis as $d) : ?>
    <tr align="center">
      <td><?= $no++ ?></td>
      <td><?= $d->no_pendaftaran ?></td>
      <td><?= $d->no_rekam_medis ?></td>
      <td><?= $d->nama ?></td>
      <td><?= $d->umur ?></td>
      <td><?= $d->keluhan ?></td>
      <td><?= $d->nama_penyakit ?></td>
      <td><?= $d->catatan?></td>
      <td><?= $d->tanggal_daftar?></td>
    </tr>
  <?php endforeach; ?>
</table>



<script>
  window.print();
</script>
</p>