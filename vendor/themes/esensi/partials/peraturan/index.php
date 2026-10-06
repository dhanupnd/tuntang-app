<nav role="navigation" aria-label="navigation" class="breadcrumb">
    <ol>
        <li><a href="<?= site_url() ?>"><?= bilingual_text('home') ?></a></li>
        <li aria-current="page"><?= bilingual_text('legal_product') ?></li>
    </ol>
</nav>

<h1 class="text-h2"><?= bilingual_text('legal_product') ?></h1>
<hr>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
    <div class="space-y-2">
        <label for="owner" class="text-xs lg:text-sm"><?= bilingual_text('year') ?></label>
        <select class="form-control input-sm" id="tahun" name="tahun">
            <option selected value=""><?= bilingual_text('all') ?></option>
            <?php foreach ($pilihan_tahun as $tahun) : ?>
                <option value="<?= $tahun ?>"><?= $tahun ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="space-y-2">
        <label for="email" class="text-xs lg:text-sm"><?= bilingual_text('category_menu') ?></label>
        <select class="form-control input-sm" id="kategori" name="kategori">
            <option selected value=""><?= bilingual_text('all') ?></option>
            <?php foreach ($pilihan_kategori as $id => $kategori) : ?>
                <option value="<?= $id ?>"><?= $kategori ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="space-y-3 content py-3">
    <div class="table-responsive content">
        <table class="w-full text-sm" id="tabeldata">
            <thead class="bg-gray disabled color-palette">
                <tr>
                    <th>No</th>
                    <th><?= bilingual_text('legal_product_title') ?></th>
                    <th><?= bilingual_text('type') ?></th>
                    <th><?= bilingual_text('year') ?></th>
                    <th><?= bilingual_text('action') ?></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var TableData = $('#tabeldata').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('fweb/peraturan/datatables') ?>",
                data: function(req) {
                    req.tahun    = $('#tahun').val();
                    req.kategori = $('#kategori').val();
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '5%',
                },
                {
                    data: 'nama',
                    name: 'nama',
                    width: '50%',
                },
                {
                    data: 'kategori_dokumen',
                    name: 'kategori_dokumen',
                    width: '10%',
                },
                {
                    data: 'tahun',
                    name: 'tahun',
                    width: '10%',
                },
                {
                    data: function (data) {
                        if (data.url != null) {
                            return `<button onclick="window.location.href='${data.url}'" class="btn btn-primary btn-block" target="_blank" rel="noopener noreferrer"><?= bilingual_text('view') ?></button>`;
                        }
                        return '<a href="<?= site_url('dokumen_web/unduh_berkas/') ?>' + data.id + '" class="btn btn-primary btn-block" target="_blank" rel="noopener noreferrer"><?= bilingual_text('download') ?></a>';
                    },
                    name: 'aksi',
                    searchable: false,
                    orderable: false,
                    width: '10%',
                },
            ],
            order: [
                [3, 'asc']
            ]
        });

        $('select[name="tahun"]').on('change', function() {
            $(this).val();
            TableData.ajax.reload();
        });

        $('select[name="kategori"]').on('change', function() {
            $(this).val();
            TableData.ajax.reload();
        });
    });
</script>
