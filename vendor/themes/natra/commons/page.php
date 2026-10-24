<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<?php if ($paging->num_rows > $paging->per_page): ?>
    <div class="pagination_area text-center">
        <div><?= bilingual_text('page_x_of_y', ['page' => $paging->page, 'total' => $paging->end_link]) ?></div>
        <ul class="pagination">
            <?php if ($paging->start_link): ?>
                <li><a href="<?= site_url("$paging_page/$paging->start_link" . $paging->suffix); ?>" title="<?= bilingual_text('first_page') ?>"><i class="fa fa-fast-backward"></i>&nbsp;</a></li>
            <?php endif; ?>
            <?php if ($paging->prev): ?>
                <li><a href="<?= site_url("$paging_page/$paging->prev" . $paging->suffix); ?>" title="<?= bilingual_text('previous_page') ?>"><i class="fa fa-backward"></i>&nbsp;</a></li>
            <?php endif; ?>
            <?php for ($i=$paging->start_link; $i<=$paging->end_link; $i++): ?>
                <li class="<?php ($paging->page != $i) or print('active'); ?>"><a href="<?=site_url("$paging_page/$i" . $paging->suffix); ?>" title="<?= bilingual_text('page_number', ['number' => $i]) ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <?php if ($paging->next): ?>
                <li><a href="<?= site_url("$paging_page/$paging->next" . $paging->suffix); ?>" title="<?= bilingual_text('next_page') ?>"><i class="fa fa-forward"></i>&nbsp;</a></li>
            <?php endif; ?>
            <?php if ($paging->end_link): ?>
                <li><a href="<?= site_url("$paging_page/$paging->end_link" . $paging->suffix); ?>" title="<?= bilingual_text('last_page') ?>"><i class="fa fa-fast-forward"></i>&nbsp;</a></li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>
