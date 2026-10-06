<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
  <ol>
    <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
    <li aria-current="page"><?= bilingual_text('complaint') ?></li>
  </ol>
</nav>
<h1 class="text-h2"><?= bilingual_text('complaint') ?></h1>
<form action="<?= $search_action; ?>" method="get">
  <div class="flex gap-3 lg:w-7/12 flex-col lg:flex-row py-5">
    <button type="button" class="btn btn-primary flex-shrink-0" data-bs-toggle="modal" data-bs-target="#newpengaduan"><i class="fas fa-pencil-alt mr-1"></i> <?= bilingual_text('create_complaint') ?></button>
    <select class="form-input inline-block select2" id="caristatus" name="caristatus">
      <option value=""><?= bilingual_text('all_statuses') ?></option>
      <option value="1" <?= selected($caristatus, 1); ?>><?= bilingual_text('pending_process') ?></option>
      <option value="2" <?= selected($caristatus, 2); ?>><?= bilingual_text('processing') ?></option>
      <option value="3" <?= selected($caristatus, 3); ?>><?= bilingual_text('completed_process') ?></option>
    </select>
    <input type="text" name="cari" value="<?= $cari; ?>" placeholder="<?= bilingual_text('search_complaint') ?>" class="form-input inline-block">
    <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i></button>
    <?php if ($cari) : ?>
      <a href="<?= site_url('pengaduan'); ?>" class="btn bg-red-500 hover:bg-red-500 text-white"><i class="fa fa-times"></i></a>
    <?php endif; ?>
  </div>
</form>

<?php if (($notif = session('notif')) && (! session('notif')['data'])) : ?>
  <div id="notifikasi" class="alert alert-<?= $notif['status']; ?>" role="alert">
    <?= $notif['pesan']; ?>
  </div>
<?php endif; ?>
<?php if($pengaduan) : ?>
  <section class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <?php foreach($pengaduan as $key => $value) : ?>
      <div class="card p-5 border cursor-pointer" data-bs-toggle="modal" data-bs-target="#pengaduan<?= $value['id'] ?>">
        <dl>
          <dt class="font-bold lg:text-xl"><?= $value['judul']; ?></dt>
          <ul class="inline-flex flex-wrap gap-2 w-full items-center text-xs">
            <li class="inline-flex items-center"><i class="fas fa-calendar-alt text-secondary-100 mr-2"></i> <?= $value['created_at'] ?></li>
            <li class="inline-flex items-center"><i class="fas fa-user text-secondary-100 mr-2"></i> <?= $value['nama'] ?></li>
            <li>
              <?php if ($value['status'] == '1') : ?>
                <span class="label label-danger"><?= bilingual_text('pending_process') ?></span>
              <?php elseif ($value['status'] == '2') : ?>
                <span class="label label-info"><?= bilingual_text('processing') ?></span>
              <?php elseif ($value['status'] == '3') : ?>
                <span class="label label-success"><?= bilingual_text('completed_process') ?></span>
              <?php endif; ?>
            </li>
          </ul>
          <dd class="pt-2 flex flex-col lg:flex-row items-end justify-between gap-3">
            <span class="italic"><?= substr($value['isi'], 0, 50); ?> <?php if (strlen($value['isi']) > 50) : ?>... <label class="underline"><?= bilingual_text('more_details') ?> ></label><?php endif; ?></span>
            <span class="label label-<?= $value['jumlah'] > 0 ? 'success' : 'info'; ?> pull-right text-xs flex-shrink-0"><i class="fas fa-comments"></i> <?= $value['jumlah']; ?> <?= bilingual_text('responses') ?></span>
          </dd>
        </dl>
      </div>
      <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="pengaduan<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="pengaduan<?= $value['id'] ?>" aria-hidden="true">
        <div class="modal-dialog relative w-auto pointer-events-none">
          <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
              <h4 class="text-h6 text-primary-200"><i class="fa fa-folder-open mr-1"></i> <?= $value['judul'] ?></h4>
            </div>
            <div class="modal-body relative py-2 px-3 lg:px-5 text-sm lg:text-base">
              <div class="w-full py-2 space-y-2">
                <p class="text-muted text-xs lg:text-sm"><?= bilingual_text('complaint_by', ['name' => $value['nama']]) ?> | <?= $value['created_at'] ?></p>
                <p class="italic">"<?= $value['isi'] ?></p>
                <?php $file_foto = LOKASI_PENGADUAN . $value['foto']; ?>
                <?php if (file_exists(FCPATH . $file_foto)) : ?>
                  <img class="w-auto max-w-full" src="<?= to_base64($file_foto) ?>">
                <?php endif; ?>
              </div>
              <?php foreach ($pengaduan_balas as $keyna => $valuena) : ?>
                <?php if ($valuena['id_pengaduan'] && $valuena['id_pengaduan'] == $value['id']) : ?>
                  <div class="alert alert-info text-green-600">
                    <p class="text-xs lg:text-sm"><?= bilingual_text('responded_by', ['name' => $valuena['nama']]) ?> | <?= $valuena['created_at'] ?></p>
                    <p class="italic">"<?= $valuena['isi'] ?></p>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
              <button type="button" class="btn bg-red-500 hover:bg-red-500 text-white" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?= bilingual_text('close') ?></button>
            </div>
          </div>
        </div>
      </div>
      <!-- END DETAIL TICKET -->
    <?php endforeach ?>
  </section>
  <?php $this->load->view($folder_themes . '/commons/paging') ?>
  <?php else : ?>
    <div class="alert alert-info text-primary-100" role="alert">
      <?= bilingual_text('no_data_available') ?>
    </div>
<?php endif ?>
<!-- Formulir Pengaduan -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" tabindex="-1" id="newpengaduan" tabindex="-1" role="dialog" aria-labelledby="newpengaduan" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h4 class="text-h6 text-primary-200"><i class="fas fa-pencil-alt mr-1"></i> <?= bilingual_text('new_complaint') ?></h4>
      </div>
      <form action="<?= $form_action; ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-body relative px-3 py-2 lg:px-5">
          <?php if (($notif = session('notif')) && ($data = session('notif')['data'])) : ?>
            <div class="alert alert-error" role="alert">
              <?= $notif['pesan']; ?>
            </div>
          <?php endif; ?>
          <div class="py-2">
            <input name="nik" type="text" maxlength="16" class="form-input" placeholder="NIK" value="<?= $data['nik'] ?>">
          </div>
          <div class="py-2">
            <input name="nama" type="text" required="" class="form-input" placeholder="<?= bilingual_text('name') ?>*" value="<?= $data['nama'] ?>">
          </div>
          <div class="py-2">
            <input name="email" type="email" class="form-input" placeholder="Email" value="<?= $data['email'] ?>">
          </div>
          <div class="py-2">
            <input name="telepon" type="text" class="form-input" placeholder="<?= bilingual_text('telephone') ?>" value="<?= $data['telepon'] ?>">
          </div>
          <div class="py-2">
            <input name="judul" type="text" class="form-input" required="" placeholder="<?= bilingual_text('title') ?>*" value="<?= $data['judul'] ?>">
          </div>
          <div class="py-2">
            <textarea name="isi" required="" class="form-textarea" placeholder="<?= bilingual_text('complaint_content') ?>*" rows="4"><?= $data['isi'] ?></textarea>
          </div>
          <div class="py-2">
            <div class="relative">
              <input type="text" accept="image/*" onchange="readURL(this);" class="form-input" id="file_path" placeholder="<?= bilingual_text('upload_photo') ?>" name="foto">
              <input type="file" accept="image/*" onchange="readURL(this);" class="hidden" id="file" name="foto">
              <span class="absolute top-1/2 right-0 transform -translate-y-1/2">
                <button type="button" class="btn btn-info button-flat" id="file_browser"><i class="fa fa-search"></i></button>
              </span>
            </div>
            <small><?= bilingual_text('image_formats') ?></small><br>
            <br><img id="blah" src="#" alt="<?= bilingual_text('supporting_image_alt') ?>" class="max-w-full w-full hidden" />
          </div>
          <div class="flex gap-3">
            <div class="w-full lg:w-1/3 overflow-hidden">
              <img id="captcha" src="<?= site_url('captcha') ?>" alt="CAPTCHA Image" class="w-full lg:w-11/12">
              <button type="button" class="btn bg-transparent text-xs" onclick="document.getElementById('captcha').src = '<?= site_url('captcha') ?>'; return false">[<?= bilingual_text('change_image') ?>]</button>
            </div>
            <div class="w-full lg:w-2/3">
              <input type="text" class="form-input required" name="captcha_code" maxlength="6" value="<?= $notif['data']['captcha_code']; ?>" placeholder="<?= bilingual_text('captcha_answer') ?>" required>
            </div>
          </div>
        </div>
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-between p-4 border-t border-gray-200 rounded-b-md">
          <a href="<?= site_url('pengaduan') ?>" class="btn bg-red-500 hover:bg-red-500 text-white pull-left"><i class="fa fa-times"></i> <?= bilingual_text('close') ?></a>
          <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-paper-plane"></i> <?= bilingual_text('send') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<style type="text/css">
  .label {
    border-radius: 4px;
    padding: 2px 8px;
    color: white;
  }
  .label-danger {
    background-color: #dc2626;
  }
  .label-info {
    background-color: #0891b2;
  }
  .label-success {
    background-color: #059669;
  }

  .support-content .fa-padding .fa {
    padding-top: 5px;
    width: 1.5em;
  }

  .support-content .info {
    color: #777;
    margin: 0px;
  }

  .support-content a {
    color: #111;
  }

  .support-content .info a:hover {
    text-decoration: underline;
  }

  .support-content .info .fa {
    width: 1.5em;
    text-align: center;
  }

  .support-content .number {
    color: #777;
  }

  .support-content img {
    margin: 0 auto;
    display: block;
  }

  .support-content .modal-body {
    padding-bottom: 0px;
  }

  .support-content-comment {
    padding: 10px 10px 10px 30px;
  }

  .italic {
    font-style:italic;
  }

  .items-end {
    align-items: flex-end;
  }
</style>

<script type="text/javascript">
  $('#file_browser').click(function(e)
  {
    e.preventDefault();
    $('#file').click();
  });
  $('#file').change(function()
  {
    $('#file_path').val($(this).val());
    if ($(this).val() == '')
    {
      $('#'+$(this).data('submit')).attr('disabled','disabled');
    }
    else
    {
      $('#'+$(this).data('submit')).removeAttr('disabled');
    }
  });
  $('#file_path').click(function()
  {
    $('#file_browser').click();
  });

  $(document).ready(function() {
    window.setTimeout(function() {
      $("#notifikasi").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 2000);

    var data = "<?= session('notif')['data'] ?>";
    if (data) {
      $('#newpengaduan').modal('show');
    }
  });

  $('#b-captcha').click();
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#blah').removeClass('hidden');
        $('#blah').attr('src', e.target.result).width(150).height(auto);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
