<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
  $analysis_text = bilingual_current_language() === 'en'
    ? [
      'analysis_data' => 'Analysis Data',
      'aggregate_title' => 'Village Analysis Data Aggregation List',
      'analysis' => 'Analysis',
      'data_collection' => 'Data Collection',
      'subject' => 'Subject',
      'year' => 'Year',
      'indicator' => 'Indicator',
      'data_not_available' => 'Data is not available',
    ]
    : [
      'analysis_data' => 'Data Analisis',
      'aggregate_title' => 'Daftar Agregasi Data Analisis Desa',
      'analysis' => 'Analisis',
      'data_collection' => 'Pendataan',
      'subject' => 'Subjek',
      'year' => 'Tahun',
      'indicator' => 'Indikator',
      'data_not_available' => 'Data tidak tersedia',
    ];
?>

<!DOCTYPE html>
<html lang="<?= bilingual_current_language() === 'en' ? 'en' : 'id' ?>">
<head>
  <?php $this->load->view($folder_themes . '/commons/meta') ?>
  <?php $this->load->view($folder_themes . '/commons/source_css') ?>
</head>
<body class="font-primary bg-gray-100">

  <?php $this->load->view($folder_themes . '/commons/loading_screen') ?>
  <?php $this->load->view($folder_themes . '/commons/header') ?>
  <div class="container mx-auto lg:px-5 px-3 flex flex-col lg:flex-row my-5 gap-3 lg:gap-5 justify-between text-gray-600">
    <main class="lg:w-2/3 w-full overflow-hidden space-y-1 bg-white rounded-lg px-4 py-2 lg:py-4 lg:px-5 shadow">
      <nav role="navigation" aria-label="navigation" class="breadcrumb">
        <ol>
          <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
          <li><?= $analysis_text['analysis_data'] ?></li>
        </ol>
      </nav>
      <?php if($list_jawab): ?>
        <?php $this->load->view("$folder_themes/partials/statistics/analisis.php"); ?>
        <?php else : ?>
          <h1 class="text-h2"><?= $analysis_text['aggregate_title'] ?></h1>
          <?php if ($list_indikator): ?>
            <?php if(IS_PREMIUM) : ?>
              <?php if (count($master_indikator) > 1) : ?>
                <form action="<?=site_url('data_analisis'); ?>" method="get">
                  <div class="space-y-1 flex gap-3 items-center">
                    <label for="master" class="block text-sm"><?= $analysis_text['analysis'] ?>:</label>
                    <select class="form-input inline-block w-auto" name="master" onchange="this.form.submit()" id="master">
                      <?php foreach ($master_indikator as $master): ?>
                        <option value="<?= $master['id']?>" <?= selected($list_indikator['0']['id_master'], $master['id'])?>><?= "{$master['master']} ({$master['tahun']})"?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </form>
              <?php endif; ?>
              <div class="table-responsive content py-2">
                <table>
                  <tr>
                    <td width="200"><?= $analysis_text['data_collection'] ?> </td>
                    <td width="20"> :</td>
                    <td><?= $list_indikator['0']['master']; ?></td>
                  </tr>
                  <tr>
                    <td><?= $analysis_text['subject'] ?> </td>
                    <td> : </td>
                    <td><?= $list_indikator['0']['subjek']; ?></td>
                  </tr>
                  <tr>
                    <td><?= $analysis_text['year'] ?> </td>
                    <td> :</td>
                    <td><?= $list_indikator['0']['tahun']; ?></td>
                  </tr>
                </table>
              </div>
              <h4 class="text-h4 py-2"><?= $analysis_text['indicator'] ?></h4>
              <div class="table-responsive content">
                <table>
                  <?php foreach ($list_indikator as $data): ?>
                    <tr>
                      <td><?= $data['nomor'].'.'; ?>
                      <td><a href="<?= site_url("jawaban_analisis/$data[id]/$data[subjek_tipe]/$data[id_periode]"); ?>" class="font-semibold"><?= $data['indikator']?></a></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
              <?php else : ?>
                <?php foreach ($list_indikator AS $data): ?>
                  <a href="<?= site_url("data_analisis/$data[id]/$data[subjek_tipe]/$data[id_periode]"); ?>"><?= $data['indikator']?></a>
                  <div class="table-responsive">
                    <table>
                        <tr>
                          <td width="20%"><?= $analysis_text['data_collection'] ?> </td>
                          <td width="1%"> :</td>
                          <td><?= $data['master']; ?></td>
                        </tr>
                        <tr>
                          <td><?= $analysis_text['subject'] ?> </td>
                          <td> : </td>
                          <td><?= $data['subjek']; ?></td>
                        </tr>
                        <tr>
                          <td><?= $analysis_text['year'] ?> </td>
                          <td> :</td>
                          <td><?= $data['tahun']; ?></td>
                        </tr>
                    </table>
                  </div>
                <?php endforeach; ?>
            <?php endif ?>
          <?php else: ?>
          <p class="py-3"><?= $analysis_text['data_not_available'] ?></p>
        <?php endif; ?>
      <?php endif; ?>
    </main>
    <div class="lg:w-1/3 w-full">
      <?php $this->load->view($folder_themes .'/partials/sidebar') ?>
    </div>
  </div>

  <?php $this->load->view($folder_themes .'/commons/footer') ?>
  <?php $this->load->view($folder_themes . '/commons/source_js') ?>
  <script src="<?= base_url("$this->theme_folder/$this->theme/assets/js/script.min.js?" . THEME_VERSION) ?>"></script>

</body>
</html>
