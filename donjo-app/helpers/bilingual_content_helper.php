<?php

defined('BASEPATH') || exit('No direct script access allowed');

if (! function_exists('bilingual_field')) {
    function bilingual_field($row, $field)
    {
        $data = is_object($row) ? (array) $row : (array) $row;
        $fallback = $data[$field] ?? '';

        if (bilingual_current_language() === 'id') {
            return $fallback;
        }

        $translatedField = $field . '_' . bilingual_current_language();
        $translatedValue = $data[$translatedField] ?? '';

        return trim((string) $translatedValue) !== '' ? $translatedValue : $fallback;
    }
}
