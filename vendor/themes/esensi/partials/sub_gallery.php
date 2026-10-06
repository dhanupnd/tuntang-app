<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
  <ol>
    <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
    <li><a href="<?= site_url('first/gallery') ?>"><?= bilingual_text('gallery') ?></a></li>
    <li aria-current="page"><?= $parent['nama'] ?></li>
  </ol>
</nav>
<h1 class="text-h2"><?= bilingual_text('gallery_album_title', ['name' => $parent['nama']]) ?></h1>

<?php if(count($gallery)) : ?>
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-5 py-4">
    <?php foreach($gallery as $album) : ?>
      <?php if(is_file(LOKASI_GALERI . "kecil_" . $album['gambar'])) : ?>
        <?php $link = AmbilGaleri($album['gambar'],'sedang') ?>
        <a href="<?= $link ?>" data-fancybox="images" data-caption="<?= $album['nama'] ?>" class="h-44 w-full block bg-gray-300">
          <img src="<?= AmbilGaleri($album['gambar'],'kecil') ?>" alt="<?= $album['nama'] ?>" class="h-44 w-full object-cover object-center" title="<?= $album['nama'] ?>">
        </a>
      <?php endif ?>
    <?php endforeach ?>
  </div>
  <?php else : ?>
    <div class="alert text-primary-100"><?= bilingual_text('gallery_album_empty') ?></div>
<?php endif ?>
