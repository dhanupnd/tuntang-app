<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
  <ol>
    <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
    <li aria-current="page"><?= bilingual_text('supplement_data') ?></li>
  </ol>
</nav>

<h1 class="text-h2"><?= bilingual_text('supplement_data_title', ['name' => $main['suplemen']['nama']]) ?></h1>

<h2 class="text-h4"><?= bilingual_text('supplement_data_detail') ?></h2>
<div class="table-responsive content">
  <table class="w-full text-sm">
    <tbody>
      <tr>
        <td width="20%"><?= bilingual_text('data_name') ?></td>
        <td width="1%">:</td>
        <td><?= $main['suplemen']['nama']; ?></td>
      </tr>
      <tr>
        <td><?= bilingual_text('recorded_target') ?></td>
        <td>:</td>
        <td><?= $sasaran[$main['suplemen']['sasaran']]; ?></td>
      </tr>
      <tr>
        <td><?= bilingual_text('description') ?></td>
        <td>:</td>
        <td><?= $main['suplemen']['keterangan']; ?></td>
      </tr>
    </tbody>
  </table>
</div>

<h2 class="text-h4"><?= bilingual_text('recorded_list') ?></h2>
<div class="table-responsive content">
  <table class="w-full text-sm" id="tabel-data">
    <thead class="bg-gray disabled color-palette">
      <tr>
        <th>No</th>
        <th><?= bilingual_text('name') ?></th>
        <th><?= bilingual_text('birth_place') ?></th>
        <th><?= bilingual_text('gender') ?></th>
        <th><?= bilingual_text('address') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($main['terdata'] as $key => $data): ?>
      <tr>
        <td class="text-center"><?= ($key + 1); ?></td>
        <td><?= $data['terdata_nama']; ?></td>
        <td><?= $data["tempat_lahir"]; ?></td>
        <td><?= $data["sex"]; ?></td>
        <td><?= $data["info"]; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function () {
    $('#tabel-data').DataTable({
      'processing': true,
      "pageLength": 10,
      'order': [],
      'columnDefs': [{
          'searchable': false,
          'targets': 0
        },
        {
          'orderable': false,
          'targets': 0
        }
      ],
      <?php if (bilingual_current_language() === 'id') : ?>
        'language': {
          'url': BASE_URL + '/assets/bootstrap/js/dataTables.indonesian.lang'
        },
      <?php endif ?>
    });
  });
</script>
