<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<?php $activeLanguage = bilingual_current_language(); ?>

<div class="bilingual-toggle" aria-label="<?= bilingual_text('language') ?>">
    <?php foreach (bilingual_languages() as $languageCode => $languageName) : ?>
        <a
            href="<?= bilingual_switch_url($languageCode) ?>"
            class="bilingual-toggle__item <?= $activeLanguage === $languageCode ? 'is-active' : '' ?>"
            title="<?= $languageCode === 'id' ? bilingual_text('toggle_to_indonesian') : bilingual_text('toggle_to_english') ?>"
            aria-current="<?= $activeLanguage === $languageCode ? 'true' : 'false' ?>"
        >
            <?= bilingual_text('language_' . $languageCode) ?>
        </a>
    <?php endforeach; ?>
</div>

<style>
    .bilingual-toggle {
        display: inline-flex;
        align-items: center;
        gap: 2px;
        padding: 2px;
        border: 1px solid rgba(255, 255, 255, 0.55);
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.22);
        line-height: 1;
    }

    .bilingual-toggle__item,
    .bilingual-toggle__item:hover,
    .bilingual-toggle__item:focus {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 24px;
        padding: 0 8px;
        border-radius: 999px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .bilingual-toggle__item.is-active {
        background: #fff;
        color: #1f2937;
    }
</style>
