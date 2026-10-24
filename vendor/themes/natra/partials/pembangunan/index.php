<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<div class="single_category wow fadeInDown">
	<h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span> <span class="title_text"><?= bilingual_text('construction') ?></span></h2>
</div>

<div class="box box-primary">
	<div class="box-body">
		<?php if ($pembangunan): ?>
			<div class="row">
				<?php foreach ($pembangunan as $data): ?>
					<div class="col-sm-4">
						<div class="card">
							<?php if (is_file(LOKASI_GALERI . $data->foto)): ?>
								<img width="auto" class="img-fluid img-thumbnail card-img-top" src="<?= base_url() . LOKASI_GALERI . $data->foto ?>" alt="<?= bilingual_text('construction_photo') ?>"/>
							<?php else: ?>
								<img width="auto" class="img-fluid img-thumbnail card-img-top" src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" alt="<?= bilingual_text('construction_photo') ?>"/>
							<?php endif; ?>
							<div class="card-body">
								<table class="table">
									<tbody>
										<tr>
                      <th width="auto"><?= bilingual_text('activity_name') ?></th>
                      <td width="1%">:</td>
                      <td><?= d($data->judul) ?></td>
                    </tr>
										<tr>
                      <th><?= bilingual_text('address') ?></th>
                      <td>:</td>
											
                      <td><?= ($data->alamat == "=== Lokasi Tidak Ditemukan ===") ? bilingual_text('unknown_location') : d($data->alamat); ?></td>
                    </tr>
                    <tr>
                      <th><?= bilingual_text('year') ?></th>
                      <td>:</td>
                      <td>
												<?= $data->tahun_anggaran ?></td>
                    </tr>
                    <tr>
                      <th><?= bilingual_text('description') ?></th>
                      <td>:</td>
                      <td><?= d($data->keterangan) ?></td>
                    </tr>
									</tbody>
								</table>
								<a href="<?= site_url("pembangunan/$data->slug"); ?>" class="btn btn-primary"><?= bilingual_text('read_more') ?></a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php $this->load->view("$folder_themes/commons/page"); ?>

		<?php else: ?>
			<h5><?= bilingual_text('construction_empty') ?></h5>
		<?php endif; ?>
	</div>
</div>
