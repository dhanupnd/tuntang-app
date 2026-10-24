<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<div class="single_page_area">
	<h2><?= $heading ?></h2>
	<div class="table-responsive">
		<table class="table table-striped table-bordered" id="info_publik">
			<thead>
				<tr>
					<th><?= bilingual_text('no') ?></th>
					<th><?= bilingual_text('information_title') ?></th>
					<th><?= bilingual_text('year') ?></th>
					<th><?= bilingual_text('category') ?></th>
					<th><?= bilingual_text('upload_date') ?></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var url = "<?= site_url('first/ajax_informasi_publik')?>";
		table = $('#info_publik').DataTable({
			'processing': true,
			'serverSide': true,
			"pageLength": 10,
			'order': [],
			"ajax": {
				"url": url,
				"type": "POST"
			},
      //Set column definition initialisation properties.
      "columnDefs": [
      {
          "targets": [ 0 ], //first column / numbering column
          "orderable": false, //set not orderable
      },
      ],
      <?php if (bilingual_current_language() === 'id') : ?>
      'language': {
        'url': BASE_URL + '/assets/bootstrap/js/dataTables.indonesian.lang'
      },
      <?php endif; ?>
      'drawCallback': function (){
      	$('.dataTables_paginate > .pagination').addClass('pagination-sm no-margin');
      }
  });

	} );

</script>
