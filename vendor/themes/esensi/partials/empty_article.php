<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="text-center space-y-5 mx-auto w-11/12 py-5">
  <img src="<?= base_url($this->theme_folder.'/'.$this->theme .'/assets/images/empty.svg')?>" class="w-full mx-auto w-1/4 lg:w-1/4"/>
  <div class="space-y-1">
    <span class="block text-heading"><?= bilingual_text('empty_article', ['title' => $title]) ?></span>
    <span class="block text-sm"><?= bilingual_text('come_back_later') ?></span>
  </div>
</div>
