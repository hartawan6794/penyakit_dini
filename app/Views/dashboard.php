<?= $this->extend("layout/master") ?>


<?= $this->section("content") ?>

<!-- <?php if (session()->get('role') != 'admin') : ?>
  <div class="row">
    <h1 class="mb-3">Selamat Datang, <?= session()->get('nama_lengkap') ?></h1>
  </div>

<?php endif ?> -->

<div class="row">
  <h1>Selamat Datang <?= session()->get('nama')?></h1>
</div>
<?= $this->endSection() ?>
<!-- /.content -->

<!-- page script -->
<?= $this->section("pageScript") ?>
<script>
  $(function() {
   })
</script>
<?= $this->endSection() ?>