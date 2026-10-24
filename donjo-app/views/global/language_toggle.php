<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<?php
$activeLanguage = bilingual_current_language();
$targetLanguage = $activeLanguage === 'en' ? 'id' : 'en';
$toggleLabel = bilingual_text('toggle_to_' . ($targetLanguage === 'id' ? 'indonesian' : 'english'));
?>

<a
    href="<?= bilingual_switch_url($targetLanguage) ?>"
    class="bilingual-toggle <?= $activeLanguage === 'en' ? 'is-en' : 'is-id' ?>"
    title="<?= $toggleLabel ?>"
    aria-label="<?= $toggleLabel ?>"
    role="switch"
    aria-checked="<?= $activeLanguage === 'en' ? 'true' : 'false' ?>"
>
    <span class="bilingual-toggle__label">ID</span>
    <span class="bilingual-toggle__label">EN</span>
</a>

<style>
    .bilingual-toggle,
    .bilingual-toggle:hover,
    .bilingual-toggle:focus {
        position: relative;
        display: inline-grid;
        grid-template-columns: repeat(2, 1fr);
        align-items: center;
        width: 76px;
        height: 34px;
        padding: 3px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 999px;
        background: rgba(3, 25, 38, 0.56);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        color: rgba(255, 255, 255, 0.78);
        cursor: pointer;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        text-decoration: none;
        transition: border-color 150ms ease, box-shadow 150ms ease, transform 150ms ease;
    }

    .bilingual-toggle::before {
        position: absolute;
        top: 3px;
        bottom: 3px;
        left: 3px;
        width: calc(50% - 3px);
        border-radius: 999px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.22);
        content: '';
        transition: transform 180ms ease;
    }

    .bilingual-toggle.is-en::before {
        transform: translateX(100%);
    }

    .bilingual-toggle:hover,
    .bilingual-toggle:focus {
        border-color: rgba(255, 255, 255, 0.85);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.24);
        outline: none;
        transform: translateY(-1px);
    }

    .bilingual-toggle__label {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .bilingual-toggle.is-id .bilingual-toggle__label:first-child,
    .bilingual-toggle.is-en .bilingual-toggle__label:last-child {
        color: #006a82;
    }
</style>
