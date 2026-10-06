<?php  defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $not_found_text = bilingual_current_language() === 'en'
    ? [
      'title' => 'OOPS! PAGE NOT FOUND',
      'message' => 'You have reached a page whose data is no longer available on this website. Please check again, or report it to us.',
      'back_home' => 'Back to homepage',
    ]
    : [
      'title' => 'UPS! HALAMAN TIDAK DITEMUKAN',
      'message' => 'Anda telah terdampar di halaman yang datanya tidak ada lagi di web ini. Mohon periksa kembali, atau laporkan kepada kami.',
      'back_home' => 'Kembali ke halaman utama',
    ];
?>

<main class="w-11/12 md:w-9/12 lg:w-7/12 mx-auto px-3 space-y-5 min-h-screen mb-5 flex flex-col items-center justify-center text-center text-gray-700">
  <h2 class="text-h3"><?= $not_found_text['title'] ?></h2>
  <p><?= $not_found_text['message'] ?></p>
  <a href="<?= site_url('first') ?>" class="btn btn-secondary"><?= $not_found_text['back_home'] ?></a>
</main>
