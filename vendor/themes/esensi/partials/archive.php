<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
  <ol>
    <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
    <li aria-current="page"><?= bilingual_text('article_archive') ?></li>
  </ol>
</nav>
<h1 class="text-h2"><?= bilingual_text('website_archive') ?></h1>
<?php if(count($farsip) > 0) : ?>
  <ol class="divide-y mb-5">
    <?php foreach($farsip AS $data): ?>
      <li class="py-5">
        <span class="fas fa-external-link-alt mr-2"></span>
        <a class="text-h6 transition-all duration-200 hover:text-link" href="<?= site_url('artikel/'.buat_slug($data))?>"><?= $data["judul"]?></a>
        <p class="text-xs lg:text-sm"><?= bilingual_text('published_on', ['date' => tgl_indo($data["tgl_upload"])]) ?></p>
        <p class="text-xs lg:text-sm"><?= bilingual_text('by', ['name' => $data["owner"]]) ?></p>
      </li>
    <?php endforeach; ?>
  </ol>
    <?php else: ?>
      <p class="py-5"><?= bilingual_text('no_archive') ?></p>
<?php endif ?>
