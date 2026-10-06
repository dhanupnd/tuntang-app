<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>
<?php
    $sdgs_text = bilingual_current_language() === 'en'
        ? [
            'sdgs_village' => 'Village SDGs',
            'sdgs_score' => 'Village SDGs Score',
            'score' => 'SCORE',
        ]
        : [
            'sdgs_village' => 'SDGs ' . ucwords($this->setting->sebutan_desa),
            'sdgs_score' => 'Skor SDGs Desa',
            'score' => 'NILAI',
        ];
?>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
    <ol>
        <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
        <li aria-current="page"><?= $sdgs_text['sdgs_village'] ?></li>
    </ol>
</nav>

<h1 class="text-h2"><?= $sdgs_text['sdgs_village'] ?></h1>
<?php $evaluasi = sdgs() ?>
<?php if ($error_msg = $evaluasi->error_msg): ?>
    <div class="alert alert-danger">
        <p class="py-3"><?= $error_msg ?></p>
    </div>
<?php else: ?>
    <div class="space-y-12 text-center">
        <span class="text-h2"><?= $evaluasi->average ?></span>
        </br>
        <span class="text-h6"><?= $sdgs_text['sdgs_score'] ?></span>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 py-5">
        <?php foreach ($evaluasi->data as $key => $value): ?>
        <div class="space-y-3">
            <img class="h-44 w-full object-cover object-center bg-gray-300 dark:bg-gray-600" src="<?= asset("images/sdgs/{$value->image}") ?>" alt="<?= $value->images ?>" />

            <div class="space-y-1 text-sm text-center z-10">
                <span class="text-h6"><?= $sdgs_text['score'] ?></span>
                <span class="block"><?= $value->score ?></span>
            </div>
        </div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#total').prepend('<?= $hasil ?>')
});
</script>
