<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if($pembangunan) : ?>
  <nav role="navigation" aria-label="navigation" class="breadcrumb">
    <ol>
      <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
      <li><a href="<?= site_url('pembangunan') ?>"><?= bilingual_text('construction') ?></a></li>
      <li aria-current="page"><?= $pembangunan->judul ?></li>
    </ol>
  </nav>
  <h1 class="text-h2"></i> <?= $pembangunan->judul ?></h1>
  <div class="flex flex-col lg:flex-row justify-between gap-3 lg:gap-5 py-5">
    <div class="w-full px-2">
      <?php if($pembangunan->foto && is_file(LOKASI_GALERI . $pembangunan->foto)) : ?>
        <img class="h-auto w-full" src="<?= base_url() . LOKASI_GALERI . $pembangunan->foto ?>" alt="<?= bilingual_text('construction_photo') ?>"/>
        
        <?php else: ?>
        <img class="h-auto w-full" src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" alt="<?= bilingual_text('not_found') ?>"/>
      <?php endif ?>

      <div class="table-responsive py-5 content">
        <table class="w-full">
          <tr>
            <th width="150px"><?= bilingual_text('activity_name') ?></th>
            <td width="20px">:</td>
            <td><?= $pembangunan->judul ?></td>
          </tr>
          <tr>
            <th><?= bilingual_text('address') ?></th>
            <td width="20px">:</td>
            <td><?= $pembangunan->alamat ?></td>
          </tr>
          <tr>
            <th><?= bilingual_text('funding_source') ?></th>
            <td width="20px">:</td>
            <td><?= $pembangunan->sumber_dana ?></td>
          </tr>
          <tr>
            <th><?= bilingual_text('budget') ?></th>
            <td width="20px">:</td>
            <td>Rp. <?= number_format($pembangunan->anggaran,0) ?></td>
          </tr>
          <tr>
            <th><?= bilingual_text('volume') ?></th>
            <td width="20px">:</td>
            <td><?= $pembangunan->volume?></td>
          </tr>
          <tr>
            <th><?= bilingual_text('implementer') ?></th>
            <td width="20px">:</td>
            <td><?= $pembangunan->pelaksana_kegiatan ?></td>
          </tr>
          <tr>
            <th><?= bilingual_text('year') ?></th>
            <td width="20px">:</td>
            <td><?= $pembangunan->tahun_anggaran ?></td>
          </tr>
          <tr>
            <th><?= bilingual_text('description') ?></th>
            <td width="20px">:</td>
            <td><?= $pembangunan->keterangan ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="w-full px-2 space-y-3">
      <h2 class="text-h4"><?= bilingual_text('construction_progress') ?></h2>
      <hr>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <?php foreach ($dokumentasi as $value): ?>
          <div class="w-full text-center py-2">
            <?php if (is_file(LOKASI_GALERI . $value->gambar)): ?>
              <img width="auto" class="h-auto w-full" src="<?= base_url(LOKASI_GALERI . $value->gambar); ?>" alt="<?= bilingual_text('construction_photo_with_percent', ['percent' => $value->persentase]) ?>"/>
            <?php else: ?>
              <img width="auto" class="h-auto w-full" src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" alt="<?= bilingual_text('construction_photo_with_percent', ['percent' => $value->persentase]) ?>"/>
            <?php endif; ?>
            <b><?= bilingual_text('construction_photo_with_percent', ['percent' => $value->persentase]) ?></b>
          </div>
        <?php endforeach; ?>
        <?php if(!$dokumentasi) : ?>
          <p class="py-1"><?= bilingual_text('no_documentation') ?></p>
        <?php endif ?>
      </div>

      <div class="mt-5 space-y-3">
        <h2 class="text-h4"><?= bilingual_text('construction_location') ?></h2>
        <div id="map" style="height: 340px"></div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {
      let lat = "<?= $pembangunan->lat ?? $desa['lat']; ?>";
      let lng = "<?= $pembangunan->lng ?? $desa['lng']; ?>";
      let posisi = [lat, lng];
      let zoom = 15;
      let logo = L.icon({
        iconUrl: "<?= base_url('assets/images/gis/point/construction.png'); ?>",
      });

      var options = {
          maxZoom: <?= setting('max_zoom_peta') ?>,
          minZoom: <?= setting('min_zoom_peta') ?>,
      };

      pembangunan = L.map('map', options).setView(posisi, zoom);
      getBaseLayers(pembangunan, "<?= setting('mapbox_key') ?>", "<?= setting('jenis_peta') ?>");
      pembangunan.addLayer(new L.Marker(posisi, {icon:logo}));
    });
  </script>
  <?php else : ?>
    <?php $this->load->view($folder_themes .'/commons/404') ?>
<?php endif ?>
