<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="breadcrumb">
    <ol>
        <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
        <li><?= bilingual_text('statistical_data') ?></li>
    </ol>
</div>
<h1 class="text-h2"><?= bilingual_text('population_data_by', ['heading' => $heading]) ?></h1>
<div class="flex justify-between items-center space-x-1 py-5">
    <h2 class="text-h4"><?= bilingual_text('chart_by', ['heading' => $heading]) ?></h2>
    <div class="text-right space-x-2 text-sm space-y-2 md:space-y-0">
        <button class="btn btn-secondary button-switch" data-type="column"><?= bilingual_current_language() === 'en' ? 'Bar Graph' : 'Grafik Batang' ?></button>
        <button class="btn btn-secondary button-switch is-active" data-type="pie"><?= bilingual_current_language() === 'en' ? 'Pie Graph' : 'Grafik Lingkaran' ?></button>
    </div>
</div>
<div id="statistics"></div>
<h2 class="text-h4"><?= bilingual_text('table_by', ['heading' => $heading]) ?></h2>
<div class="content py-3">
    <div class="table-responsive">
        <table class="w-full text-sm">
            <thead>
                <tr>
                <th rowspan="2">No</th>
                <th rowspan="2"><?= bilingual_text('group') ?></th>
                <th colspan="2"><?= bilingual_text('total') ?></th>
                <th colspan="2"><?= bilingual_text('male') ?></th>
                <th colspan="2"><?= bilingual_text('female') ?></th>
                </tr>
                <tr>
                <th>n</th>
                <th>%</th>
                <th>n</th>
                <th>%</th>
                <th>n</th>
                <th>%</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0; $l=0; $p=0; $hide=''; $h=0; $jm1=1; $jm = count($stat);?>
                <?php foreach ($stat as $data):?>
                <?php $jm1++; if (1):?>
                <?php $h++; if ($h > 12 AND $jm > 10): $hide='more'; ?>
                <?php endif;?>
                <tr class="<?=$hide?>">
                    <td class="text-center">
                    <?php if ($jm1 > $jm - 2):?>
                        <?=$data['no']?>
                    <?php else:?>
                        <?=$h?>
                    <?php endif;?>
                    </td>
                    <td><?=$data['nama']?></td>
                    <td class="text-right <?php ($jm1 <= $jm - 2) and ($data['jumlah'] == 0) and print('zero')?>"><?=$data['jumlah']?>
                    </td>
                    <td class="text-right"><?=$data['persen']?></td>
                    <td class="text-right"><?=$data['laki']?></td>
                    <td class="text-right"><?=$data['persen1']?></td>
                    <td class="text-right"><?=$data['perempuan']?></td>
                    <td class="text-right"><?=$data['persen2']?></td>
                </tr>
                <?php $i += $data['jumlah'];?>
                <?php $l += $data['laki']; $p += $data['perempuan'];?>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="flex justify-between py-5">
        <?php if($hide == 'more') : ?>
            <button class="btn btn-primary button-more" id="showData"><?= bilingual_text('more_details') ?>...</button>
        <?php endif ?>
        <button id="showZero" class="btn btn-secondary"><?= bilingual_text('show_zero') ?></button>
    </div>

    <?php if ($this->setting->daftar_penerima_bantuan && in_array($st, array('bantuan_keluarga', 'bantuan_penduduk'))):?>
        <script>
        const bantuanUrl = '<?= site_url('first/ajax_peserta_program_bantuan')?>';
        </script>

        <input id="stat" type="hidden" value="<?=$st?>">
        <h2 class="text-h4"><?= bilingual_text('list_of', ['name' => $heading]) ?></h2>

        <div class="table-responsive content py-3">
            <table class="w-full text-sm" id="peserta_program">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Program</th>
                        <th><?= bilingual_text('participant_name') ?></th>
                        <th><?= bilingual_text('address') ?></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
    .button-switch.is-active {
        background-color: #efefef;
        color: #999;
    }
</style>
<script>
    const dataStats = Object.values(<?= json_encode($stat) ?>);
</script>
