<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<div class="single_page_area">
	<div style="margin-top:0px;">
		<?php if (!empty($teks_berjalan)): ?>
			<marquee onmouseover="this.stop()" onmouseout="this.start()">
				<?php $this->load->view("$folder_themes/layouts/teks_berjalan"); ?>
			</marquee>
		<?php endif; ?>
	</div>
	<div class="single_category wow fadeInDown">
		<h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span> <span class="title_text"><?= bilingual_text('website_content_archive_title', ['village' => ucwords($desa["nama_desa"])]) ?></span> </h2>
	</div>
	<div style="margin-top:50px;">
		<div class="box-body">
			<?php if(count($farsip)>0): ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<td width="3%"><b><?= bilingual_text('no') ?></b></td>
							<td width="20%"><b><?= bilingual_text('article_date') ?></b></td>
							<td><b><?= bilingual_text('article_title') ?></b></td>
							<td width="20%"><b><?= bilingual_text('author') ?></b></td>
							<td width="10%"><b><?= bilingual_text('read') ?></b></td>
						</tr>
					</thead>
					<tbody>
						<?php foreach($farsip AS $data): ?>
							<tr>
								<td style="text-align:center;">
									<?= $data["no"]?>
								</td>
								<td>
									<?= tgl_indo($data["tgl_upload"])?>
								</td>
								<td>
									<a href="<?= site_url('artikel/'.buat_slug($data))?>"><?= $data["judul"]?></a>
								</td>
								<td style="text-align:center;">
									<?= $data["owner"]?>
								</td>
								<td style="text-align:center;">
									<?= hit($data['hit']) ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php

					$data['paging_page'] = 'first/arsip';

					$this->load->view("$folder_themes/commons/page", $data);

				?>

				<?php else: ?>
					<?= bilingual_text('no_archive') ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
