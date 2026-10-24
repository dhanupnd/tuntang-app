<div class="box box-danger" style="padding-bottom: 2rem;">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $heading ?></h3>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="tabel-data">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2"><?= bilingual_text('name') ?></th>
                    <th rowspan="2"><?= bilingual_text('hamlet_address') ?></th>
                    <th rowspan="2"><?= bilingual_text('date') ?></th>
                    <th colspan="6"><?= bilingual_text('vaccine') ?></th>
                </tr>
                <tr>
                    <th>I</th>
                    <th>II</th>
                    <th>III</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($main as $data) : ?>
                <?php if ($data->vaksin_1 == 1 || $data->vaksin_2 == 1 || $data->vaksin_3 == 1) : ?>
                    <tr>
                        <td class="text-center"></td>
                        <td><?= $data->nama ?></td>
                        <td><?= $data->dusun ?></td>
                        <td>
                            <?php if ($data->vaksin_1 == 1 && $data->vaksin_2 == 0 && $data->vaksin_3 == 0) : ?>
                                <?= $data->tgl_vaksin_1 ?>
                            <?php endif ?>

                            <?php if ($data->vaksin_1 == 1 && $data->vaksin_2 == 1 && $data->vaksin_3 == 0) : ?>
                                <?= $data->tgl_vaksin_2 ?>
                            <?php endif ?>

                            <?php if ($data->vaksin_1 == 1 && $data->vaksin_2 == 1 && $data->vaksin_3 == 1) : ?>
                                <?= $data->tgl_vaksin_3 ?>
                            <?php endif ?>
                        </td>
                        <td class="text-center">
                            <?php if ($data->vaksin_1 == 1 && $data->tunda == 0) : ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php endif ?>
                        </td>
                        <td class="text-center">
                            <?php if ($data->vaksin_2 == 1 && $data->tunda == 0) : ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php endif ?>
                        </td>
                        <td class="text-center">
                            <?php if ($data->vaksin_3 == 1 && $data->tunda == 0) : ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach ?>
            </tbody>
        </table>
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
                    'targets': [0, 4, 5, 6]
                },
                {
                    'orderable': false,
                    'targets': [0, 4, 5, 6]
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

