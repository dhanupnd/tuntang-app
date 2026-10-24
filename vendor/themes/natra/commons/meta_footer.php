<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<script src="<?= base_url("{$this->theme_folder}/{$this->theme}/assets/js/wow.min.js") ?>"></script>
<script src="<?= base_url("{$this->theme_folder}/{$this->theme}/assets/js/slick.min.js") ?>"></script>
<script src="<?= base_url("{$this->theme_folder}/{$this->theme}/assets/js/custom.js") ?>"></script>
<script>
    $.extend($.fn.dataTable.defaults, {
        lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "<?= bilingual_text('all') ?>"]
        ],
        pageLength: 10,
        <?php if (bilingual_current_language() === 'id') : ?>
        language: {
        url: "<?= base_url('assets/bootstrap/js/dataTables.indonesian.lang') ?>",
        },
        <?php endif; ?>
    });
</script>
<?php if (! setting('inspect_element')): ?>
    <script src="<?= asset('js/disabled.min.js') ?>"></script>
<?php endif ?>