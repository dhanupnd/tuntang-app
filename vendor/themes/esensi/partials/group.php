<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
  <ol>
    <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
    <li aria-current="page"><?= bilingual_text('group_data') ?></li>
  </ol>
</nav>

<h1 class="text-h2"><?= $title ?></h1>
<div class="space-y-3 content py-3">
  
  <p class="py-4"><?= $detail['keterangan'] ?></p>

  <h2 class="text-h4"><?= bilingual_text('officer_list') ?></h2>
  <div class="table-responsive content">
    <table class="w-full text-sm">
      <thead>
        <tr>
          <th>No</th>
          <th><?= bilingual_text('position') ?></th>
          <th><?= bilingual_text('name') ?></th>
          <th><?= bilingual_text('address') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pengurus as $key => $data): ?>
          <tr>
            <td><?= $key + 1?></td>
            <td><?= $data['jabatan'] ?></td>
            <td nowrap><?= $data['nama']?></td>
            <td><?= $data['alamat']?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <h2 class="text-h4"><?= bilingual_text('member_list') ?></h2>
  <div class="table-responsive content">
    <table class="w-full text-sm" id="tabel-data">
      <thead>
        <tr>
          <th>No</th>
          <th><?= bilingual_text('member_number') ?></th>
          <th><?= bilingual_text('name') ?></th>
          <th><?= bilingual_text('address') ?></th>
          <th><?= bilingual_text('gender') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($anggota as $key => $data): ?>
        <tr>
          <td></td>
          <td><?= $data['no_anggota'] ?:'-' ?></td>
          <td nowrap><?= $data['nama'] ?></td>
          <td><?= $data['alamat'] ?></td>
          <td><?= $data['sex'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<script>
  $(document).ready(function(){
    var tabelData = $('#tabel-data').DataTable({
      'processing': false,
      'order': [[1, 'desc']],
      'pageLength': 10,
      'lengthMenu': [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "<?= bilingual_text('all') ?>"]
      ],
      'columnDefs': [
        {
            'searchable': false,
            'targets': [0]
        },
        {
            'orderable': false,
            'targets': [0]
        }
      ],
      <?php if (bilingual_current_language() === 'id') : ?>
        'language': {
          'url': BASE_URL + '/assets/bootstrap/js/dataTables.indonesian.lang'
        },
      <?php endif ?>
    });

    tabelData.on( 'order.dt search.dt', function () {
      tabelData.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();
  });
</script>
