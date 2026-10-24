<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<div class="single_page_area">
    <h2 class="post_titile"><?= $title ?></h2>
    <?= $detail['keterangan']?>
    <h3 class="post_titile"><?= bilingual_text('officer_list') ?></h3>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th><?= bilingual_text('position') ?></th>
                        <th><?= bilingual_text('name') ?></th>
                        <th><?= bilingual_text('address') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengurus as $key => $data): ?>
                    <tr>
                        <td><?= ($key + 1) ?></td>
                        <td><?= $data['jabatan']?></td>
                        <td nowrap><?= $data['nama']?></td>
                        <td><?= $data['alamat']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <h3 class="post_titile"><?= bilingual_text('member_list') ?></h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tabel-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th><?= bilingual_text('member_number') ?></th>
                        <th><?= bilingual_text('name') ?></th>
                        <th><?= bilingual_text('address') ?></th>
                        <th><?= bilingual_text('gender') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($anggota as $key => $data): ?>
                    <tr>
                        <td class="text-center"></td>
                        <td><?= $data['no_anggota'] ?:'-'; ?></td>
                        <td nowrap><?= $data['nama']; ?></td>
                        <td><?= $data['alamat']; ?></td>
                        <td class="text-center"><?= $data['sex']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var tabelData = $('#tabel-data').DataTable({
            'processing': false,
            'order': [[1, 'desc']],
            'pageLength': 10,
            'lengthMenu': [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "<?= bilingual_text('all') ?>"]
            ],
            'columnDefs': [
                {
                    'searchable': false,
                    'targets': [0]
                },
                {
                    'orderable': false,
                    'targets': [0]
                }
            ],
            <?php if (bilingual_current_language() === 'id') : ?>
            'language': {
                'url': BASE_URL + '/assets/bootstrap/js/dataTables.indonesian.lang'
            },
            <?php endif; ?>
        });

        tabelData.on( 'order.dt search.dt', function () {
            tabelData.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1;
            } );
        } ).draw();
    });
</script>

