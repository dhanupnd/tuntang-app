<?php

defined('BASEPATH') || exit('No direct script access allowed');

if (! function_exists('bilingual_languages')) {
    function bilingual_languages()
    {
        return [
            'id' => 'Indonesia',
            'en' => 'English',
        ];
    }
}

if (! function_exists('bilingual_current_language')) {
    function bilingual_current_language()
    {
        $ci = get_instance();
        $language = $ci->session->userdata('site_language') ?: ($_COOKIE['site_language'] ?? 'id');

        return array_key_exists($language, bilingual_languages()) ? $language : 'id';
    }
}

if (! function_exists('bilingual_text')) {
    function bilingual_text($key, array $replace = [])
    {
        $translations = [
            'id' => [
                'language'             => 'Bahasa',
                'language_id'          => 'ID',
                'language_en'          => 'EN',
                'home'                 => 'Beranda',
                'search'               => 'Cari',
                'search_article'       => 'Cari Artikel',
                'search_short'         => 'Cari...',
                'search_product'       => 'Cari Produk',
                'search_complaint'     => 'Cari pengaduan disini...',
                'show_all'             => 'Tampilkan Semua',
                'latest_articles'      => 'Artikel Terkini',
                'index'                => 'Indeks',
                'empty_article'        => 'Belum ada artikel yang dituliskan dalam :title',
                'come_back_later'      => 'Silakan kunjungi kembali dalam waktu dekat',
                'all_comments'         => 'Semua Komentar',
                'leave_comment'        => 'Beri Komentar',
                'comment_pending'      => 'Komentar baru terbit setelah disetujui oleh admin',
                'comment'              => 'Komentar',
                'name'                 => 'Nama',
                'email_address'        => 'Alamat Email',
                'phone_number'         => 'No. HP',
                'change_image'         => 'Ganti Gambar',
                'captcha_placeholder'  => 'Tulis kembali kode sebelah',
                'send_comment'         => 'Kirim Komentar',
                'menu'                 => 'Menu',
                'category_menu'        => 'Menu Kategori',
                'self_service'         => 'Layanan Mandiri',
                'admin_login'          => 'Login Admin',
                'article'              => 'Artikel',
                'article_archive'      => 'Arsip Artikel',
                'website_archive'      => 'Arsip Situs Web',
                'published_on'         => 'Diterbitkan pada :date',
                'by'                   => 'Oleh: :name',
                'no_archive'           => 'Belum ada arsip konten web.',
                'read_count'           => 'Dibaca :count',
                'read'                 => 'Dibaca',
                'attachment_document'  => 'Dokumen Lampiran',
                'back_to_home'         => 'Kembali ke Beranda',
                'not_found_home'       => 'Silahkan kembali lagi ke halaman Beranda',
                'copyright_site'       => 'Hak cipta situs',
                'hosting_supported'    => 'Hosting didukung',
                'toggle_to_indonesian' => 'Gunakan bahasa Indonesia',
                'toggle_to_english'    => 'Use English',
                'statistics'           => 'Statistik',
                'article_archive'      => 'Arsip Artikel',
                'agenda'               => 'Agenda',
                'program_sinergi'      => 'Sinergi Program',
                'gallery'              => 'Galeri',
                'village_apparatus'    => 'Aparatur Desa',
                'social_media'         => 'Media Sosial',
                'village_map'          => 'Peta Wilayah Desa',
                'office_location_map'  => 'Peta Lokasi Kantor',
                'visitor_statistics'   => 'Statistik Pengunjung',
                'population'           => 'Jumlah Penduduk',
                'latest'               => 'Terkini',
                'popular'              => 'Populer',
                'random'               => 'Acak',
                'open_map'             => 'Buka Peta',
                'details'              => 'Detail',
                'today'                => 'Hari ini',
                'yesterday'            => 'Kemarin',
                'visitors'             => 'Jumlah Pengunjung',
                'more_details'         => 'Selengkapnya',
                'day'                  => 'Hari',
                'shift_starts'         => 'Mulai',
                'shift_ends'           => 'Selesai',
                'day_off'              => 'Libur',
                'desa'                 => 'Desa'
            ],
            'en' => [
                'language'             => 'Language',
                'language_id'          => 'ID',
                'language_en'          => 'EN',
                'home'                 => 'Home',
                'search'               => 'Search',
                'search_article'       => 'Search articles',
                'search_short'         => 'Search...',
                'search_product'       => 'Search products',
                'search_complaint'     => 'Search complaints here...',
                'show_all'             => 'Show All',
                'latest_articles'      => 'Latest Articles',
                'index'                => 'Index',
                'empty_article'        => 'No articles have been written in :title yet',
                'come_back_later'      => 'Please come back again soon',
                'all_comments'         => 'All Comments',
                'leave_comment'        => 'Leave a Comment',
                'comment_pending'      => 'New comments will be published after admin approval',
                'comment'              => 'Comments',
                'name'                 => 'Name',
                'email_address'        => 'Email Address',
                'phone_number'         => 'Phone No.',
                'change_image'         => 'Change Image',
                'captcha_placeholder'  => 'Retype the code shown beside',
                'send_comment'         => 'Send Comment',
                'menu'                 => 'Menu',
                'category_menu'        => 'Category Menu',
                'self_service'         => 'Self Service',
                'admin_login'          => 'Admin Login',
                'article'              => 'Article',
                'article_archive'      => 'Article Archive',
                'website_archive'      => 'Website Archive',
                'published_on'         => 'Published on :date',
                'by'                   => 'By: :name',
                'no_archive'           => 'No web content archive yet.',
                'read_count'           => 'Read :count',
                'read'                 => 'Read',
                'attachment_document'  => 'Attachment Document',
                'back_to_home'         => 'Back to Home',
                'not_found_home'       => 'Please return to the Home page',
                'copyright_site'       => 'Site copyright',
                'hosting_supported'    => 'Hosting supported by',
                'toggle_to_indonesian' => 'Gunakan bahasa Indonesia',
                'toggle_to_english'    => 'Use English',
                'statistics'           => 'Statistics',
                'article_archive'      => 'Article Archive',
                'agenda'               => 'Agenda',
                'program_sinergi'      => 'Program Synergy',
                'gallery'              => 'Gallery',
                'village_apparatus'    => 'Village Apparatus',
                'social_media'         => 'Social Media',
                'village_map'          => 'Village Area Map',
                'office_location_map'  => 'Office Location Map',
                'visitor_statistics'   => 'Visitor Statistics',
                'population'           => 'Population Total',
                'latest'               => 'Latest',
                'popular'              => 'Popular',
                'random'               => 'Random',
                'open_map'             => 'Open Map',
                'details'              => 'Details',
                'today'                => 'Today',
                'yesterday'            => 'Yesterday',
                'visitors'             => 'All Time Visitors',
                'more_details'         => 'See More',
                'day'                  => 'Day',
                'shift_starts'         => 'Start Shift',
                'shift_ends'           => 'End Shift',
                'day_off'              => 'Day Off',
                'desa'                 => 'Village'
            ],
        ];

        $language = bilingual_current_language();
        $text = $translations[$language][$key] ?? $translations['id'][$key] ?? $key;

        foreach ($replace as $name => $value) {
            $text = str_replace(':' . $name, $value, $text);
        }

        return $text;
    }
}

if (! function_exists('bilingual_switch_url')) {
    function bilingual_switch_url($language)
    {
        $queryString = $_SERVER['QUERY_STRING'] ?? '';
        $currentUrl = current_url() . ($queryString ? '?' . $queryString : '');

        return site_url('bahasa/' . $language) . '?redirect=' . rawurlencode($currentUrl);
    }
}
