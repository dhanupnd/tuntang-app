<?php
  $idm_text = bilingual_current_language() === 'en'
    ? [
      'status_idm' => 'IDM Status',
      'idm_status_year' => 'Developing Village Index (IDM) Status :year',
      'current_idm_score' => 'CURRENT IDM SCORE',
      'idm_status' => 'IDM STATUS',
      'target_status' => 'TARGET STATUS',
      'minimum_score' => 'MINIMUM SCORE',
      'province' => 'PROVINCE',
      'regency' => 'REGENCY',
      'no' => 'NO',
      'idm_indicator' => 'IDM INDICATOR',
      'score' => 'SCORE',
      'description' => 'DESCRIPTION',
      'recommended_activity' => 'ACTIVITIES THAT CAN BE DONE',
      'score_increase' => '+SCORE',
      'activity_implementers' => 'WHO CAN IMPLEMENT THE ACTIVITIES',
      'central' => 'CENTRAL',
      'other' => 'OTHERS',
      'chart_title' => 'Developing Village Index (IDM)',
      'chart_subtitle' => 'SCORE: IKS, IKE, IKL',
    ]
    : [
      'status_idm' => 'Status IDM',
      'idm_status_year' => 'Status Indeks Desa Membangun (IDM) :year',
      'current_idm_score' => 'SKOR IDM SAAT INI',
      'idm_status' => 'STATUS IDM',
      'target_status' => 'TARGET STATUS',
      'minimum_score' => 'SKOR MINIMAL',
      'province' => 'PROVINSI',
      'regency' => 'KABUPATEN',
      'no' => 'NO',
      'idm_indicator' => 'INDIKATOR IDM',
      'score' => 'SKOR',
      'description' => 'KETERANGAN',
      'recommended_activity' => 'KEGIATAN YANG DAPAT DILAKUKAN',
      'score_increase' => '+NILAI',
      'activity_implementers' => 'YANG DAPAT MELAKSANAKAN KEGIATAN',
      'central' => 'PUSAT',
      'other' => 'LAINNYA',
      'chart_title' => 'Indeks Desa Membangun (IDM)',
      'chart_subtitle' => 'SKOR : IKS, IKE, IKL',
    ];
?>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
  <ol>
    <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
    <li aria-current="page"><?= $idm_text['status_idm'] ?></li>
  </ol>
</nav>

<h1 class="text-h2">
  <?= str_replace(':year', $idm->SUMMARIES->TAHUN, $idm_text['idm_status_year']) ?>
</h1>
<section class="content pt-2">
  <?php if ($idm->error_msg): ?>
  <div class="alert alert-error px-3 py-5 my-3">
    <?= $idm->error_msg ?>
  </div>
  <?php else : ?>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-5 max-w-full">
      <div class="rounded overflow-hidden bg-blue-500 relative text-white py-5 px-3 lg:px-4">
        <div class="flex flex-col">
          <span class="text-lg lg:text-xl font-bold"><?= number_format($idm->SUMMARIES->SKOR_SAAT_INI, 4) ?></span>
          <span class="text-sm"><?= $idm_text['current_idm_score'] ?></span>
        </div>
        <div class="icon absolute right-0 mr-5 text-5xl text-gray-300 text-opacity-30 top-1/2 transform -translate-y-1/2">
          <i class="ion ion-arrow-graph-up-right"></i>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-yellow-500 relative text-white py-5 px-3 lg:px-4">
        <div class="flex flex-col">
          <span class="text-lg lg:text-xl font-bold"><?= $idm->SUMMARIES->STATUS ?></span>
          <span class="text-sm"><?= $idm_text['idm_status'] ?></span>
        </div>
        <div class="icon absolute right-0 mr-5 text-5xl text-gray-300 text-opacity-30 top-1/2 transform -translate-y-1/2">
          <i class="ion ion-ios-pulse-strong"></i>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-green-500 relative text-white py-5 px-3 lg:px-4">
        <div class="flex flex-col">
          <span class="text-lg lg:text-xl font-bold"><?= $idm->SUMMARIES->TARGET_STATUS ?></span>
          <span class="text-sm"><?= $idm_text['target_status'] ?></span>
        </div>
        <div class="icon absolute right-0 mr-5 text-5xl text-gray-300 text-opacity-30 top-1/2 transform -translate-y-1/2">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-red-500 relative text-white py-5 px-3 lg:px-4">
        <div class="flex flex-col">
          <span class="text-lg lg:text-xl font-bold"><?= number_format($idm->SUMMARIES->SKOR_MINIMAL, 4) ?></span>
          <span class="text-sm"><?= $idm_text['minimum_score'] ?></span>
        </div>
        <div class="icon absolute right-0 mr-5 text-5xl text-gray-300 text-opacity-30 top-1/2 transform -translate-y-1/2">
          <i class="ion ion-ios-pie"></i>
        </div>
      </div>
    </div>

    <div class="flex flex-col lg:flex-row pt-5 justify-between">
      <div class="table-responsive">
        <table class="overflow-auto table-striped table text-sm capitalize">
          <tbody>
            <tr>
              <th class="horizontal"><?= $idm_text['province'] ?></th>
              <td><?= $idm->IDENTITAS[0]->nama_provinsi ?></td>
            </tr>
            <tr>
              <th class="horizontal"><?= $idm_text['regency'] ?></th>
              <td nowrap><?= $idm->IDENTITAS[0]->nama_kab_kota ?></td>
            </tr>
            <tr>
              <th class="horizontal"><?= strtoupper($this->setting->sebutan_kecamatan) ?></th>
              <td><?= $idm->IDENTITAS[0]->nama_kecamatan ?></td>
            </tr>
            <tr>
              <th class="horizontal"><?= strtoupper($this->setting->sebutan_desa) ?></th>
              <td><?= $idm->IDENTITAS[0]->nama_desa ?></td>
            </tr>

        </table>
      </div>
      <figure class="highcharts-figure">
        <div id="container"></div>
      </figure>
    </div>

    <div class="table-responsive text-xs">
      <table class="table table-bordered table-striped dataTable table-hover">
        <thead class="bg-gray color-palette">
          <tr>
            <th rowspan="2" class="padat"><?= $idm_text['no'] ?></th>
            <th rowspan="2"><?= $idm_text['idm_indicator'] ?></th>
            <th rowspan="2"><?= $idm_text['score'] ?></th>
            <th rowspan="2"><?= $idm_text['description'] ?></th>
            <th rowspan="2" nowrap><?= $idm_text['recommended_activity'] ?></th>
            <th rowspan="2"><?= $idm_text['score_increase'] ?></th>
            <th colspan="6" class="text-center"><?= $idm_text['activity_implementers'] ?></th>
          </tr>
          <tr>
            <th><?= $idm_text['central'] ?></th>
            <th><?= $idm_text['province'] ?></th>
            <th><?= $idm_text['regency'] ?></th>
            <th><?= strtoupper($this->setting->sebutan_desa) ?></th>
            <th>CSR</th>
            <th><?= $idm_text['other'] ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($idm->ROW as $data): ?>
          <tr class="<?php empty($data->NO) and print('judul'); ?> ">
            <td class="text-center"><?= $data->NO ?></td>
            <td style="min-width: 150px;"><?= $data->INDIKATOR ?></td>
            <td class="padat"><?= $data->SKOR ?></td>
            <td style="min-width: 250px;"><?= $data->KETERANGAN ?></td>
            <td><?= $data->KEGIATAN ?></td>
            <td><?= $data->NILAI ?></td>
            <td><?= $data->PUSAT ?></td>
            <td><?= $data->PROV ?></td>
            <td><?= $data->KAB ?></td>
            <td><?= $data->DESA ?></td>
            <td><?= $data->CSR ?></td>
            <td><?= $data->SKOR[INDIKATOR['IKS 2020']] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif ?>
</section>

<script type="text/javascript">

$(document).ready(function () {
  Highcharts.chart('container', {
    chart: {
      type: 'pie',
      options3d: {
        enabled: true,
        alpha: 45
      }
    },
    title: {
      text: '<?= $idm_text['chart_title'] ?>'
    },
    subtitle: {
      text: '<?= $idm_text['chart_subtitle'] ?>'
    },

    plotOptions: {
      series: {
        colorByPoint: true
      },
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        showInLegend: true,
        depth: 45,
        innerSize: 70,
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.y:,.2f} / {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: '<?= $idm_text['score'] ?>',
      shadow: 1,
      border: 1,
      data: [
        ['IKS', <?= $idm->ROW[35]->SKOR ?>],
        ['IKE', <?= $idm->ROW[48]->SKOR ?>],
        ['IKL', <?= $idm->ROW[52]->SKOR ?>]
      ]
    }]
});


});
</script>
