<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Bahasa extends CI_Controller
{
    public function index($language = 'id')
    {
        if (! array_key_exists($language, bilingual_languages())) {
            $language = 'id';
        }

        $this->session->set_userdata('site_language', $language);
        setcookie('site_language', $language, time() + 31536000, '/');

        redirect($this->safeRedirectUrl($this->input->get('redirect', true)));
    }

    private function safeRedirectUrl($redirect)
    {
        if (! $redirect) {
            return site_url();
        }

        if (strpos($redirect, site_url()) === 0 || strpos($redirect, base_url()) === 0) {
            return $redirect;
        }

        if (strpos($redirect, '/') === 0 && strpos($redirect, '//') !== 0) {
            return site_url(ltrim($redirect, '/'));
        }

        return site_url();
    }
}
