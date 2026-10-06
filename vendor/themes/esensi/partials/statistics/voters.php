<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="breadcrumb">
  <ol>
    <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
    <li><?= bilingual_text('statistical_data') ?></li>
  </ol>
</div>
<h1 class="text-h2"><?= bilingual_text('voter_list_by_region', ['date' => $tanggal_pemilihan]) ?></h1>

<div class="content py-3 table-responsive">
  <table class="w-full text-sm">
    <thead>
      <tr>
        <th>No</th>
        <th><?= bilingual_text('hamlet_name') ?></th>
        <th>RW</th>
        <th><?= bilingual_text('people') ?></th>
        <th><?= bilingual_current_language() === 'en' ? 'M' : 'Lk' ?></th>
        <th><?= bilingual_current_language() === 'en' ? 'F' : 'Pr' ?></th>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
        <?php foreach($main as $data): ?>
          <tr>
            <td class="text-center"><?= $data['no'] ?></td>
            <td class="text-right"><?= strtoupper($data['dusun']) ?></td>
            <td class="text-right"><?= strtoupper($data['rw']) ?></td>
            <td class="text-right"><?= $data['jumlah_warga'] ?></td>
            <td class="text-right"><?= $data['jumlah_warga_l'] ?></td>
            <td class="text-right"><?= $data['jumlah_warga_p'] ?></td>
          </tr>
        <?php $i = $i+$data['jumlah']; ?>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr class="font-bold">
        <td colspan="3" class="text-left">TOTAL</td>
        <td class="text-right"><?= $total['total_warga']; ?></td>
        <td class="text-right"><?= $total['total_warga_l']; ?></td>
        <td class="text-right"><?= $total['total_warga_p']; ?></td>
      </tr>
    </tfoot>
  </table>
</div>
