<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<div class="single_page_area">

	<div class="single_page_area">
		<h2><?= bilingual_text('election_candidate_list', ['date' => $tanggal_pemilihan]) ?></h2>

		<div class="table-responsive">
		<table id="dpt" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th class="text-center"><?= bilingual_text('no') ?></th>
			<th class="text-center"><?= bilingual_text('hamlet_name') ?></th>
			<th class="text-center">RW</th>
			<th class="text-center"><?= bilingual_text('people') ?></th>
			<th class="text-center">L</th>
			<th class="text-center">P</th>
		</tr>
		</thead><?php
		if(count($main) > 0){ ?>
			<tbody><?php
			foreach($main as $data){ ?>
				<tr>
					<td class="text-center"><?= $data["no"] ?></td>
					<td class="text-left"><?= strtoupper($data["dusun"]) ?></td>
					<td class="text-center"><?= strtoupper($data["rw"]) ?></td>
					<td class="text-right"><?= $data["jumlah_warga"] ?></td>
					<td class="text-right"><?= $data["jumlah_warga_l"] ?></td>
					<td class="text-right"><?= $data["jumlah_warga_p"] ?></td>
				</tr><?php
			} ?>
			</tbody>
			<tr>
				<th colspan="3" class="text-right"><?= strtoupper(bilingual_text('total')) ?></th>
				<th class="text-right"><?= $total["total_warga"] ?></th>
				<th class="text-right"><?= $total["total_warga_l"] ?></th>
				<th class="text-right"><?= $total["total_warga_p"] ?></th>
			</tr><?php
		} else { ?>
			<tr><td colspan=6 class="text-center"><?= bilingual_text('list_empty') ?></td></tr><?php
		} ?>
		</table>
		</div>
	</div>
</div> <!-- .list-frame -->
