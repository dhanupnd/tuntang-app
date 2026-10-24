<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<!DOCTYPE html>
<html lang="<?= bilingual_current_language() === 'en' ? 'en' : 'id' ?>">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    <?= $this->setting->admin_title . ' ' . bilingual_village_name($config['nama_desa'], $this->setting->sebutan_desa) . get_dynamic_title_page_from_path(); ?>
  </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css')?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin-style.css')?>">
</head>

<body class="hold-transition verifikasi-page">
  <div class="verifikasi-box">
    <div class="verifikasi-box-body">
      <center>
        <img class="logo" src="<?= gambar_desa($config['logo']); ?>" alt="<?= bilingual_current_language() === 'en' ? 'village-logo' : 'logo-desa' ?>">
        <h4>
          <b>
            <?= bilingual_text('government') ?> <?= (bilingual_current_language() === 'en' ? bilingual_text('regency') : ucwords($this->setting->sebutan_kabupaten)) . ' ' . ucwords($config['nama_kabupaten']); ?><br />
            <?= (bilingual_current_language() === 'en' ? bilingual_text('subdistrict') : ucwords($this->setting->sebutan_kecamatan)) . ' ' . ucwords($config['nama_kecamatan']); ?><br />
            <?= bilingual_village_name($config['nama_desa'], $this->setting->sebutan_desa); ?>
          </b>
        </h4>
        <hr style="border-bottom: 2px solid #000000; height:0px;">
        <table>
          <tbody>
            <tr>
              <td colspan="3"><u><b><?= bilingual_text('declares_that') ?></b></u></td>
            </tr>
            <tr>
              <td width="30%"><?= bilingual_text('letter_number') ?></td>
              <td width="1%">:</td>
              <td><?= $surat->nomor_surat; ?></td>
            </tr>
            <tr>
              <td><?= bilingual_text('letter_date') ?></td>
              <td>:</td>
              <td><?= bilingual_date($surat->tanggal); ?></td>
            </tr>
            <tr>
              <td><?= bilingual_text('subject') ?></td>
              <td>:</td>
              <td><?= bilingual_text('letter') . ' ' . $surat->perihal; ?></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td><?= bilingual_text('on_behalf_of') . ' ' . $surat->nama_penduduk ?></td>
            </tr>
            <tr>
              <td colspan="3"><u><b><?= bilingual_text('signed_by') ?></b></u></td>
            </tr>
            <tr>
              <td><?= bilingual_text('name') ?></td>
              <td>:</td>
              <td><?= $surat->pamong_nama; ?></td>
            </tr>
            <tr>
              <td><?= bilingual_text('position') ?></td>
              <td>:</td>
              <td><?= $surat->pamong_jabatan; ?></td>
            </tr>
          </tbody>
        </table>
        <br />
        <div class="callout callout-success">
          <h5><b><?= bilingual_text('valid_record') ?></b></h5>
        </div>
      </center>
    </div>
  </div>
</body>

</html>
