<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
  $letter_text = bilingual_current_language() === 'en'
    ? [
      'government' => 'Government of',
      'declares_that' => 'Declares That:',
      'letter_number' => 'Letter Number',
      'letter_date' => 'Letter Date',
      'subject' => 'Subject',
      'letter' => 'Letter',
      'on_behalf_of' => 'on behalf of',
      'signed_by' => 'Signed by:',
      'valid_record' => 'This is valid and recorded in our information system database.',
    ]
    : [
      'government' => 'Pemerintah',
      'declares_that' => 'Menyatakan Bahwa:',
      'letter_number' => 'Nomor Surat',
      'letter_date' => 'Tanggal Surat',
      'subject' => 'Perihal',
      'letter' => 'Surat',
      'on_behalf_of' => 'a/n',
      'signed_by' => 'Ditandatangani oleh:',
      'valid_record' => 'Adalah benar dan tercatat dalam database sistem informasi kami.',
    ];
?>

<!DOCTYPE html>
<html lang="<?= bilingual_current_language() === 'en' ? 'en' : 'id' ?>">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    <?= $this->setting->admin_title . ' ' . ucwords($this->setting->sebutan_desa) . (($config['nama_desa']) ? ' ' . $config['nama_desa']: '') . get_dynamic_title_page_from_path(); ?>
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
            <?= $letter_text['government'] ?> <?= ucwords($this->setting->sebutan_kabupaten . ' ' . $config['nama_kabupaten']); ?><br />
            <?= ucwords($this->setting->sebutan_kecamatan . ' ' . $config['nama_kecamatan']); ?><br />
            <?= ucwords($this->setting->sebutan_desa . ' ' . $config['nama_desa']); ?>
          </b>
        </h4>
        <hr style="border-bottom: 2px solid #000000; height:0px;">
        <table>
          <tbody>
            <tr>
              <td colspan="3"><u><b><?= $letter_text['declares_that'] ?></b></u></td>
            </tr>
            <tr>
              <td width="30%"><?= $letter_text['letter_number'] ?></td>
              <td width="1%">:</td>
              <td><?= $surat->nomor_surat; ?></td>
            </tr>
            <tr>
              <td><?= $letter_text['letter_date'] ?></td>
              <td>:</td>
              <td><?= tgl_indo($surat->tanggal); ?></td>
            </tr>
            <tr>
              <td><?= $letter_text['subject'] ?></td>
              <td>:</td>
              <td><?= $letter_text['letter'] . ' ' . $surat->perihal; ?></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td><?= $letter_text['on_behalf_of'] . ' ' . $surat->nama_penduduk ?></td>
            </tr>
            <tr>
              <td colspan="3"><u><b><?= $letter_text['signed_by'] ?></b></u></td>
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
          <h5><b><?= $letter_text['valid_record'] ?></b></h5>
        </div>
      </center>
    </div>
  </div>
</body>

</html>
