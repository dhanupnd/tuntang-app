<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2023 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2023 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2309_ke_2310 extends MY_Model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2303');
        $hasil = $hasil && $this->tambah_kolom_bilingual_web($hasil);

        status_sukses($hasil);

        return $hasil;
    }

    private function tambah_kolom_bilingual_web($hasil)
    {
        if (! $this->db->field_exists('nama_en', 'dokumen')) {
            $hasil = $hasil && $this->dbforge->add_column('dokumen', [
                'nama_en' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                    'null'       => true,
                    'after'      => 'nama',
                ],
            ]);
        }

        // MySQL menyimpan daftar kolom saat view dibuat. Bangun ulang agar nama_en ikut tersedia.
        $hasil = $hasil && $this->db->query('CREATE OR REPLACE VIEW dokumen_hidup AS SELECT * FROM dokumen WHERE deleted <> 1');

        if (! $this->db->field_exists('judul_en', 'artikel')) {
            $hasil = $hasil && $this->dbforge->add_column('artikel', [
                'judul_en' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                    'null'       => true,
                    'after'      => 'judul',
                ],
            ]);
        }

        if (! $this->db->field_exists('isi_en', 'artikel')) {
            $hasil = $hasil && $this->dbforge->add_column('artikel', [
                'isi_en' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'isi',
                ],
            ]);
        }

        if (! $this->db->field_exists('kategori_en', 'kategori')) {
            $hasil = $hasil && $this->dbforge->add_column('kategori', [
                'kategori_en' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => 'kategori',
                ],
            ]);
        }

        if (! $this->db->field_exists('nama_en', 'menu')) {
            $hasil = $hasil && $this->dbforge->add_column('menu', [
                'nama_en' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                    'after'      => 'nama',
                ],
            ]);
        }

        if (! $this->db->field_exists('teks_en', 'teks_berjalan')) {
            $hasil = $hasil && $this->dbforge->add_column('teks_berjalan', [
                'teks_en' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'teks',
                ],
            ]);
        }

        if (! $this->db->field_exists('judul_tautan_en', 'teks_berjalan')) {
            $hasil = $hasil && $this->dbforge->add_column('teks_berjalan', [
                'judul_tautan_en' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                    'after'      => 'judul_tautan',
                ],
            ]);
        }

        if (! $this->db->field_exists('nama_en', 'gambar_gallery')) {
            $hasil = $hasil && $this->dbforge->add_column('gambar_gallery', [
                'nama_en' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                    'after'      => 'nama',
                ],
            ]);
        }

        if (! $this->db->field_exists('nama_en', 'ref_jabatan')) {
            $hasil = $hasil && $this->dbforge->add_column('ref_jabatan', [
                'nama_en' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => 'nama',
                ],
            ]);
        }

        $kolomPembangunan = [
            'sumber_dana_en' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'sumber_dana'],
            'judul_en' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'judul'],
            'keterangan_en' => ['type' => 'TEXT', 'null' => true, 'after' => 'keterangan'],
            'lokasi_en' => ['type' => 'TEXT', 'null' => true, 'after' => 'lokasi'],
            'volume_en' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'volume'],
            'pelaksana_kegiatan_en' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'pelaksana_kegiatan'],
            'manfaat_en' => ['type' => 'TEXT', 'null' => true, 'after' => 'manfaat'],
        ];

        foreach ($kolomPembangunan as $kolom => $atribut) {
            if (! $this->db->field_exists($kolom, 'pembangunan')) {
                $hasil = $hasil && $this->dbforge->add_column('pembangunan', [$kolom => $atribut]);
            }
        }

        $kolomProduk = [
            'nama_en' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'nama'],
            'satuan_en' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'satuan'],
            'deskripsi_en' => ['type' => 'TEXT', 'null' => true, 'after' => 'deskripsi'],
        ];

        foreach ($kolomProduk as $kolom => $atribut) {
            if (! $this->db->field_exists($kolom, 'produk')) {
                $hasil = $hasil && $this->dbforge->add_column('produk', [$kolom => $atribut]);
            }
        }

        if (! $this->db->field_exists('kategori_en', 'produk_kategori')) {
            $hasil = $hasil && $this->dbforge->add_column('produk_kategori', [
                'kategori_en' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => 'kategori',
                ],
            ]);
        }

        return $hasil;
    }
}
