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

class Laporan_penduduk_model extends MY_Model
{
    private $lap;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('program_bantuan_model');
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari       = $_SESSION['cari'];
            $kw         = $this->db->escape_like_str($cari);
            $kw         = '%' . $kw . '%';
            $search_sql = " AND u.nama LIKE '{$kw}'";

            return $search_sql;
        }
    }

    private function dusun_sql()
    {
        if ($dusun = $this->session->userdata('dusun')) {
            return "AND a.dusun = '{$dusun}' ";
        }
    }

    private function rw_sql()
    {
        if ($rw = $this->session->userdata('rw')) {
            return "AND a.rw = '{$rw}' ";
        }
    }

    private function rt_sql()
    {
        if ($rt = $this->session->userdata('rt')) {
            return "AND a.rt = '{$rt}' ";
        }
    }

    protected function get_jumlah_sql($fk = false, $delimiter = false, $where = 0)
    {
        $sql = '(SELECT COUNT(b.id) FROM penduduk_hidup b
		LEFT JOIN tweb_wil_clusterdesa a ON b.id_cluster = a.id
		WHERE 1 ';
        $sql .= $fk ? "AND {$fk} = u.id " : '';
        $sql .= $where ?: '';
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $sql .= ') AS jumlah';
        $sql .= $delimiter ? ',' : '';

        return $sql;
    }

    protected function get_laki_sql($fk = false, $delimiter = false, $where = 0)
    {
        $sql = '(SELECT COUNT(b.id) FROM penduduk_hidup b
		LEFT JOIN tweb_wil_clusterdesa a ON b.id_cluster = a.id
		WHERE sex = 1 ';
        $sql .= $fk ? "AND {$fk} = u.id " : '';
        $sql .= $where ?: '';
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $sql .= ') AS laki';
        $sql .= $delimiter ? ',' : '';

        return $sql;
    }

    protected function get_perempuan_sql($fk = false, $delimiter = false, $where = 0)
    {
        $sql = '(SELECT COUNT(b.id) FROM penduduk_hidup b
		LEFT JOIN tweb_wil_clusterdesa a ON b.id_cluster = a.id
		WHERE sex = 2 ';
        $sql .= $fk ? "AND {$fk} = u.id " : '';
        $sql .= $where ?: '';
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $sql .= ') AS perempuan';
        $sql .= $delimiter ? ',' : '';

        return $sql;
    }

    public function judul_statistik($lap)
    {
        // Program bantuan berbentuk '50<program_id>'
        if ($lap > 50) {
            $program_id = preg_replace('/^50/', '', $lap);

            $program = $this->db
                ->select('nama')
                ->where('id', $program_id)
                ->get('program')
                ->row_array();

            return $this->terjemahkan_teks_statistik($program['nama']);
        }

        $list_judul = unserialize(STAT_PENDUDUK) + unserialize(STAT_KELUARGA) + unserialize(STAT_RTM) + unserialize(STAT_BANTUAN);

        return $this->terjemahkan_teks_statistik($list_judul[$lap]);
    }

    private function terjemahkan_teks_statistik($teks)
    {
        if (! function_exists('bilingual_current_language') || bilingual_current_language() !== 'en') {
            return $teks;
        }

        $peta = [
            'AGAMA' => 'Religion',
            'AKSEPTOR KB' => 'Family Planning Acceptors',
            'ASURANSI KESEHATAN' => 'Health Insurance',
            'AKTA KELAHIRAN' => 'Birth Certificate',
            'AKTA LAHIR' => 'Birth Certificate',
            'AKTA PERKAWINAN' => 'Marriage Certificate',
            'ALAMAT SEKARANG' => 'Current Address',
            'ALAMAT SEBELUMNYA' => 'Previous Address',
            'BELUM KAWIN' => 'Single',
            'BELUM MENGISI' => 'NOT FILLED',
            'BPJS KETENAGAKERJAAN' => 'Employment BPJS',
            'BUKAN PENERIMA' => 'NON-RECIPIENT',
            'CACAT FISIK' => 'Physical Disability',
            'CACAT GANDA' => 'Multiple Disabilities',
            'CACAT MENTAL/JIWA' => 'Mental Disability',
            'CACAT NETRA/BUTA' => 'Visual Impairment/Blind',
            'CACAT RUNGU/WICARA' => 'Hearing/Speech Impairment',
            'CERAI HIDUP' => 'Divorced',
            'CERAI MATI' => 'Widowed',
            'COVID' => 'COVID',
            'DALAM KELUARGA' => 'In Family',
            'DASAR' => 'Basic',
            'DIPLOMA I/II' => 'Diploma I/II',
            'DIPLOMA III/SARJANA MUDA' => 'Diploma III/Associate Degree',
            'DIPLOMA IV/STRATA I' => 'Diploma IV/Bachelor Degree',
            'E-KTP' => 'E-ID Card',
            'GOLONGAN DARAH' => 'Blood Type',
            'HIDUP' => 'Alive',
            'HUBUNGAN DALAM KK' => 'Family Card Relationship',
            'HUBUNGAN DALAM KELUARGA' => 'Family Relationship',
            'IBU' => 'Mother',
            'ID ASURANSI' => 'Insurance ID',
            'JANDA' => 'Widow',
            'JENIS KELAMIN' => 'Gender',
            'JUMLAH' => 'TOTAL',
            'KAWIN' => 'Married',
            'KELAS SOSIAL' => 'Social Class',
            'KELOMPOK UMUR' => 'Age Group',
            'KEPALA KELUARGA' => 'Head of Family',
            'KEPEMILIKAN KTP' => 'ID Card Ownership',
            'KEWARGANEGARAAN' => 'Citizenship',
            'KONTRAK' => 'Contract',
            'LAKI-LAKI' => 'Male',
            'MATI' => 'Dead',
            'PENERIMA' => 'RECIPIENT',
            'PENERIMA BANTUAN KELUARGA' => 'Family Aid Recipients',
            'PENERIMA BANTUAN PENDUDUK' => 'Resident Aid Recipients',
            'PENDATANG' => 'Newcomer',
            'PENDIDIKAN DALAM KK' => 'Education in Family Card',
            'PENDIDIKAN SEDANG DITEMPUH' => 'Current Education',
            'PENDUDUK' => 'Resident',
            'PENDUDUK BERDASARKAN UMUR' => 'Population by Age',
            'PENDUDUK BERDASARKAN UMUR KATEGORI' => 'Population by Age Category',
            'PENDUDUK BERDASARKAN PENDIDIKAN DALAM KK' => 'Population by Education in Family Card',
            'PENDUDUK BERDASARKAN PENDIDIKAN SEDANG DITEMPUH' => 'Population by Current Education',
            'PENDUDUK BERDASARKAN PEKERJAAN' => 'Population by Occupation',
            'PENDUDUK BERDASARKAN STATUS PERKAWINAN' => 'Population by Marital Status',
            'PENDUDUK BERDASARKAN AGAMA' => 'Population by Religion',
            'PENDUDUK BERDASARKAN JENIS KELAMIN' => 'Population by Gender',
            'PENDUDUK BERDASARKAN HUBUNGAN DALAM KK' => 'Population by Family Card Relationship',
            'PENDUDUK BERDASARKAN KEWARGANEGARAAN' => 'Population by Citizenship',
            'PENDUDUK BERDASARKAN STATUS PENDUDUK' => 'Population by Resident Status',
            'PENDUDUK BERDASARKAN GOLONGAN DARAH' => 'Population by Blood Type',
            'PENDUDUK BERDASARKAN CACAT' => 'Population by Disability',
            'PENDUDUK BERDASARKAN SAKIT MENAHUN' => 'Population by Chronic Illness',
            'PENDUDUK BERDASARKAN AKSEPTOR KB' => 'Population by Family Planning Acceptors',
            'PENDUDUK BERDASARKAN AKTA KELAHIRAN' => 'Population by Birth Certificate',
            'PENDUDUK BERDASARKAN KEPEMILIKAN KTP' => 'Population by ID Card Ownership',
            'PENDUDUK BERDASARKAN ASURANSI KESEHATAN' => 'Population by Health Insurance',
            'PENDUDUK BERDASARKAN STATUS COVID' => 'Population by COVID Status',
            'PENDUDUK BERDASARKAN SUKU' => 'Population by Ethnicity',
            'PENDUDUK BERDASARKAN BPJS KETENAGAKERJAAN' => 'Population by Employment BPJS',
            'PEREMPUAN' => 'Female',
            'PERGI' => 'Moved Away',
            'PEKERJAAN' => 'Occupation',
            'PENYAKIT MENAHUN' => 'Chronic Illness',
            'PENYANDANG CACAT' => 'Persons with Disabilities',
            'PROVINSI' => 'Province',
            'SAKIT MENAHUN' => 'Chronic Illness',
            'SARJANA' => 'Bachelor Degree',
            'SEDANG' => 'Current',
            'SEMUA' => 'All',
            'STATUS COVID' => 'COVID Status',
            'STATUS DASAR' => 'Basic Status',
            'STATUS KEHAMILAN' => 'Pregnancy Status',
            'STATUS KAWIN' => 'Marital Status',
            'STATUS PERKAWINAN' => 'Marital Status',
            'STATUS PENDUDUK' => 'Resident Status',
            'STATUS REKAM' => 'Recording Status',
            'SUAMI' => 'Husband',
            'SUKU / ETNIS' => 'Ethnicity',
            'TAMAT SD / SEDERAJAT' => 'Elementary School Graduate / Equivalent',
            'TAMAT SLTP / SEDERAJAT' => 'Junior High School Graduate / Equivalent',
            'TAMAT SLTA / SEDERAJAT' => 'Senior High School Graduate / Equivalent',
            'TIDAK / BELUM SEKOLAH' => 'No Schooling / Not Yet in School',
            'TIDAK ADA' => 'None',
            'TIDAK TAMAT SD / SEDERAJAT' => 'Did Not Graduate Elementary School / Equivalent',
            'TOTAL' => 'TOTAL',
            'UMUR (KATEGORI)' => 'Age Category',
            'UMUR (RENTANG)' => 'Age Range',
            'WARGA NEGARA' => 'Citizenship',
            'WARGA NEGARA ASING' => 'Foreign Citizen',
            'WARGA NEGARA INDONESIA' => 'Indonesian Citizen',
        ];

        $peta += [
            // Education in Family Card and current education.
            'AKADEMI/DIPLOMA III/S. MUDA' => 'Academy/Diploma III/Associate Degree',
            'BELUM MASUK TK/KELOMPOK BERMAIN' => 'Not Yet in Kindergarten/Playgroup',
            'BELUM TAMAT SD/SEDERAJAT' => 'Did Not Graduate Elementary School / Equivalent',
            'SEDANG D-1/SEDERAJAT' => 'Currently in Diploma I / Equivalent',
            'SEDANG D-2/SEDERAJAT' => 'Currently in Diploma II / Equivalent',
            'SEDANG D-3/SEDERAJAT' => 'Currently in Diploma III / Equivalent',
            'SEDANG S-1/SEDERAJAT' => 'Currently in Bachelor Degree / Equivalent',
            'SEDANG S-2/SEDERAJAT' => 'Currently in Master Degree / Equivalent',
            'SEDANG S-3/SEDERAJAT' => 'Currently in Doctoral Degree / Equivalent',
            'SEDANG SD/SEDERAJAT' => 'Currently in Elementary School / Equivalent',
            'SEDANG SLB A/SEDERAJAT' => 'Currently in Special School A / Equivalent',
            'SEDANG SLB B/SEDERAJAT' => 'Currently in Special School B / Equivalent',
            'SEDANG SLB C/SEDERAJAT' => 'Currently in Special School C / Equivalent',
            'SEDANG SLTA/SEDERAJAT' => 'Currently in Senior High School / Equivalent',
            'SEDANG SLTP/SEDERAJAT' => 'Currently in Junior High School / Equivalent',
            'SEDANG TK/KELOMPOK BERMAIN' => 'Currently in Kindergarten/Playgroup',
            'SLTA/SEDERAJAT' => 'Senior High School / Equivalent',
            'SLTP/SEDERAJAT' => 'Junior High School / Equivalent',
            'STRATA II' => 'Master Degree',
            'STRATA III' => 'Doctoral Degree',
            'TIDAK DAPAT MEMBACA DAN MENULIS HURUF LATIN/ARAB' => 'Cannot Read and Write Latin/Arabic Script',
            'TIDAK PERNAH SEKOLAH' => 'Never Attended School',
            'TIDAK SEDANG SEKOLAH' => 'Not Currently in School',

            // Family, citizenship, health, and social reference values.
            'ANAK' => 'Child',
            'ASURANSI LAINNYA' => 'Other Insurance',
            'BPJS NON PENERIMA BANTUAN IURAN' => 'Non-Subsidized BPJS',
            'BPJS PENERIMA BANTUAN IURAN' => 'Subsidized BPJS',
            'CUCU' => 'Grandchild',
            'DUA KEWARGANEGARAAN' => 'Dual Citizenship',
            'FAMILI LAIN' => 'Other Relative',
            'ISTRI' => 'Wife',
            'KEPALA RUMAH TANGGA' => 'Head of Household',
            'KELUARGA PRA SEJAHTERA' => 'Pre-Prosperous Family',
            'KELUARGA SEJAHTERA I' => 'Prosperous Family I',
            'KELUARGA SEJAHTERA II' => 'Prosperous Family II',
            'KELUARGA SEJAHTERA III' => 'Prosperous Family III',
            'KELUARGA SEJAHTERA III PLUS' => 'Prosperous Family III Plus',
            'MENANTU' => 'Child-in-law',
            'MERTUA' => 'Parent-in-law',
            'ORANGTUA' => 'Parent',
            'PEMBANTU' => 'Domestic Worker',
            'TETAP' => 'Permanent',
            'TIDAK TETAP' => 'Non-permanent',
            'TIDAK/ BELUM PUNYA' => 'Not Yet Covered',
            'TIDAK/BELUM PUNYA' => 'Not Yet Covered',
            'WNA' => 'Foreign Citizen',
            'WNI' => 'Indonesian Citizen',

            // Disability, chronic illness, family planning, and ID card values.
            'CACAT FISIK DAN MENTAL' => 'Physical and Mental Disability',
            'CACAT LAINNYA' => 'Other Disability',
            'TIDAK CACAT' => 'No Disability',
            'ASTHMA' => 'Asthma',
            'DIABETES MELITUS' => 'Diabetes Mellitus',
            'GILA/STRESS' => 'Mental Disorder/Stress',
            'GINJAL' => 'Kidney Disease',
            'JANTUNG' => 'Heart Disease',
            'KANKER' => 'Cancer',
            'LEPRA/KUSTA' => 'Leprosy',
            'LEVER' => 'Liver Disease',
            'MALARIA' => 'Malaria',
            'PARU-PARU' => 'Lung Disease',
            'TIDAK ADA/TIDAK SAKIT' => 'No Chronic Illness',
            'KONDOM' => 'Condom',
            'LAINNYA' => 'Other',
            'PIL' => 'Pill',
            'STERILISASI PRIA' => 'Male Sterilization',
            'STERILISASI WANITA' => 'Female Sterilization',
            'SUNTIK' => 'Injection',
            'SUSUK KB' => 'Contraceptive Implant',
            'TIDAK MENGGUNAKAN' => 'Not Using',
            'BELUM REKAM' => 'Not Yet Recorded',
            'BELUM WAJIB' => 'Not Yet Required',
            'SUDAH REKAM' => 'Recorded',

            // Occupation reference values.
            'AKUNTAN' => 'Accountant',
            'ANGGOTA BPK' => 'Village Consultative Body Member',
            'ANGGOTA DPD' => 'Regional Representative Council Member',
            'ANGGOTA DPR-RI' => 'House of Representatives Member',
            'ANGGOTA DPRD KABUPATEN/KOTA' => 'Regency/Municipal Council Member',
            'ANGGOTA DPRD PROVINSI' => 'Provincial Council Member',
            'ANGGOTA KABINET KEMENTERIAN' => 'Cabinet Member',
            'ANGGOTA MAHKAMAH KONSTITUSI' => 'Constitutional Court Member',
            'APOTEKER' => 'Pharmacist',
            'ARSITEK' => 'Architect',
            'BELUM/TIDAK BEKERJA' => 'Not Working',
            'BIARAWATI' => 'Nun',
            'BIDAN' => 'Midwife',
            'BUPATI' => 'Regent',
            'BURUH HARIAN LEPAS' => 'Casual Daily Worker',
            'BURUH NELAYAN/PERIKANAN' => 'Fishery Laborer',
            'BURUH PETERNAKAN' => 'Livestock Laborer',
            'BURUH TANI/PERKEBUNAN' => 'Farm/Plantation Laborer',
            'DOKTER' => 'Doctor',
            'DOSEN' => 'Lecturer',
            'DUTA BESAR' => 'Ambassador',
            'GUBERNUR' => 'Governor',
            'GURU' => 'Teacher',
            'IMAM MASJID' => 'Mosque Imam',
            'INDUSTRI' => 'Industry Worker',
            'JURU MASAK' => 'Cook',
            'KARYAWAN BUMD' => 'Regional-Owned Enterprise Employee',
            'KARYAWAN BUMN' => 'State-Owned Enterprise Employee',
            'KARYAWAN HONORER' => 'Contract Employee',
            'KARYAWAN SWASTA' => 'Private Employee',
            'KEPALA DESA' => 'Village Head',
            'KEPOLISIAN RI (POLRI)' => 'Indonesian National Police',
            'KONSTRUKSI' => 'Construction Worker',
            'KONSULTAN' => 'Consultant',
            'MEKANIK' => 'Mechanic',
            'MENGURUS RUMAH TANGGA' => 'Homemaker',
            'NELAYAN/PERIKANAN' => 'Fisher/Fishery Worker',
            'NOTARIS' => 'Notary',
            'PARAJI' => 'Traditional Birth Attendant',
            'PARANORMAL' => 'Paranormal Practitioner',
            'PASTOR' => 'Priest',
            'PEDAGANG' => 'Trader',
            'PEGAWAI NEGERI SIPIL (PNS)' => 'Civil Servant',
            'PELAJAR/MAHASISWA' => 'Student',
            'PELAUT' => 'Seafarer',
            'PEMBANTU RUMAH TANGGA' => 'Domestic Worker',
            'PENATA BUSANA' => 'Fashion Stylist',
            'PENATA RAMBUT' => 'Hair Stylist',
            'PENATA RIAS' => 'Makeup Artist',
            'PENDETA' => 'Pastor',
            'PENELITI' => 'Researcher',
            'PENGACARA' => 'Lawyer',
            'PENSIUNAN' => 'Retiree',
            'PENTERJEMAH' => 'Translator',
            'PENYIAR RADIO' => 'Radio Broadcaster',
            'PENYIAR TELEVISI' => 'Television Broadcaster',
            'PERANCANG BUSANA' => 'Fashion Designer',
            'PERANGKAT DESA' => 'Village Official',
            'PERAWAT' => 'Nurse',
            'PERDAGANGAN' => 'Trade',
            'PETANI/PEKEBUN' => 'Farmer/Planter',
            'PETERNAK' => 'Livestock Farmer',
            'PIALANG' => 'Broker',
            'PILOT' => 'Pilot',
            'PRESIDEN' => 'President',
            'PROMOTOR ACARA' => 'Event Promoter',
            'PSIKIATER/PSIKOLOG' => 'Psychiatrist/Psychologist',
            'SENIMAN' => 'Artist',
            'SOPIR' => 'Driver',
            'TABIB' => 'Traditional Healer',
            'TENTARA NASIONAL INDONESIA (TNI)' => 'Indonesian National Armed Forces',
            'TRANSPORTASI' => 'Transportation Worker',
            'TUKANG BATU' => 'Mason',
            'TUKANG CUKUR' => 'Barber',
            'TUKANG GIGI' => 'Dental Technician',
            'TUKANG JAHIT' => 'Tailor',
            'TUKANG KAYU' => 'Carpenter',
            'TUKANG LAS/PANDAI BESI' => 'Welder/Blacksmith',
            'TUKANG LISTRIK' => 'Electrician',
            'TUKANG SOL SEPATU' => 'Shoe Repairer',
            'USTADZ/MUBALIGH' => 'Islamic Preacher',
            'WAKIL BUPATI' => 'Deputy Regent',
            'WAKIL GUBERNUR' => 'Deputy Governor',
            'WAKIL PRESIDEN' => 'Vice President',
            'WAKIL WALIKOTA' => 'Deputy Mayor',
            'WALIKOTA' => 'Mayor',
            'WARTAWAN' => 'Journalist',
            'WIRASWASTA' => 'Entrepreneur',
        ];

        $normalisasi = static function ($nilai) {
            $nilai = strtoupper(trim((string) $nilai));
            $nilai = preg_replace('/\s+/', ' ', $nilai);

            return preg_replace('/\s*\/\s*/', '/', $nilai);
        };
        $peta = array_combine(array_map($normalisasi, array_keys($peta)), array_values($peta));
        $kunci = $normalisasi($teks);

        if (isset($peta[$kunci])) {
            return $peta[$kunci];
        }

        return preg_replace_callback('/\bUMUR\b|\bS\/D\b|\bTAHUN\b|\bDI ATAS\b/i', static function ($match) {
            $kata = strtoupper($match[0]);
            $pengganti = [
                'UMUR' => 'AGE',
                'S/D' => 'TO',
                'TAHUN' => 'YEARS',
                'DI ATAS' => 'ABOVE',
            ];

            return $pengganti[$kata] ?? $match[0];
        }, $teks);
    }

    // -------------------- Siapkan data untuk statistik kependudukan -------------------

    protected function hitung_total(&$data)
    {
        $total['no']        = '';
        $total['id']        = TOTAL;
        $total['jumlah']    = 0;
        $total['laki']      = 0;
        $total['perempuan'] = 0;

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['no'] = $i + 1;
            $data[$i]['nama'] = $this->terjemahkan_teks_statistik($data[$i]['nama']);
            $total['jumlah'] += $data[$i]['jumlah'];
            $total['laki'] += $data[$i]['laki'];
            $total['perempuan'] += $data[$i]['perempuan'];
        }

        return $total;
    }

    protected function isi_nomor(&$data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['no'] = $i + 1;
        }
    }

    protected function hitung_persentase(&$data, $semua)
    {
        // Hitung semua presentase
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['persen']  = persen($data[$i]['jumlah'] / $semua['jumlah']);
            $data[$i]['persen1'] = persen($data[$i]['laki'] / $semua['jumlah']);
            $data[$i]['persen2'] = persen($data[$i]['perempuan'] / $semua['jumlah']);
        }

        $data['total'] = $semua;
    }

    protected function baris_jumlah($total, $nama)
    {
        // Isi Total
        return [
            'no'        => '',
            'id'        => JUMLAH,
            'nama'      => $this->terjemahkan_teks_statistik($nama),
            'jumlah'    => $total['jumlah'],
            'perempuan' => $total['perempuan'],
            'laki'      => $total['laki'],
        ];
    }

    protected function baris_belum($semua, $total, $nama)
    {
        // Isi data jml belum mengisi
        $baris_belum = [
            'no'        => '',
            'id'        => BELUM_MENGISI,
            'nama'      => $this->terjemahkan_teks_statistik($nama),
            'jumlah'    => $semua['jumlah'] - $total['jumlah'],
            'perempuan' => $semua['perempuan'] - $total['perempuan'],
            'laki'      => $semua['laki'] - $total['laki'],
        ];
        if (isset($total['jumlah_nonaktif'])) {
            $baris_belum['jumlah'] += $total['jumlah_nonaktif'];
            $baris_belum['perempuan'] += $total['jumlah_nonaktif_perempuan'];
            $baris_belum['laki'] += $total['jumlah_nonaktif_laki'];
        }

        return $baris_belum;
    }

    private function select_jml_penduduk_per_kategori($id_referensi, $tabel_referensi)
    {
        $this->db
            ->select('u.*, COUNT(p.id) AS jumlah')
            ->select('COUNT(CASE WHEN p.sex = 1 THEN p.id END) AS laki')
            ->select('COUNT(CASE WHEN p.sex = 2 THEN p.id END) AS perempuan')
            ->from("{$tabel_referensi} u")
            ->join('penduduk_hidup p', "u.id = p.{$id_referensi}", 'left')
            ->join('tweb_wil_clusterdesa a', 'p.id_cluster = a.id', 'left')
            ->group_by('u.id');

        if ($dusun = $this->session->userdata('dusun')) {
            $this->db->where('a.dusun', $dusun);
        }
        if ($rw = $this->session->userdata('rw')) {
            $this->db->where('a.rw', $rw);
        }
        if ($rt = $this->session->userdata('rt')) {
            $this->db->where('a.rt', $rt);
        }
    }

    protected function data_jml_semua_penduduk()
    {
        $this->db
            ->select('COUNT(b.id) AS jumlah')
            ->select('COUNT(CASE WHEN b.sex = 1 THEN b.id END) AS laki')
            ->select('COUNT(CASE WHEN b.sex = 2 THEN b.id END) AS perempuan')
            ->from('penduduk_hidup b')
            ->join('tweb_wil_clusterdesa a', 'b.id_cluster = a.id', 'left');

        if ($dusun = $this->session->userdata('dusun')) {
            $this->db->where('a.dusun', $dusun);
        }
        if ($rw = $this->session->userdata('rw')) {
            $this->db->where('a.rw', $rw);
        }
        if ($rt = $this->session->userdata('rt')) {
            $this->db->where('a.rt', $rt);
        }

        return $this->db->get()->row_array();
    }

    protected function data_jml_semua_keluarga()
    {
        // Data jumlah
        return $this->db
            ->select('COUNT(k.id) as jumlah')
            ->select('COUNT(CASE WHEN p.sex = 1 THEN p.id END) AS laki')
            ->select('COUNT(CASE WHEN p.sex = 2 THEN p.id END) AS perempuan')
            ->from('keluarga_aktif k')
            ->join('tweb_penduduk p', 'p.id = k.nik_kepala', 'left')
            ->get()
            ->row_array();
    }

    protected function data_jml_semua_rtm()
    {
        // Data jumlah
        return $this->db
            ->select('COUNT(r.id) as jumlah')
            ->select('COUNT(CASE WHEN p.sex = 1 THEN p.id END) AS laki')
            ->select('COUNT(CASE WHEN p.sex = 2 THEN p.id END) AS perempuan')
            ->from('tweb_rtm r')
            ->join('tweb_penduduk p', 'p.id = r.nik_kepala', 'left') //TODO : Ganti kolom no_kk jadi no_rtm
            ->get()
            ->row_array();
    }

    protected function persentase_semua($semua)
    {
        // Hitung persentase
        $semua['no']      = '';
        $semua['id']      = TOTAL;
        $semua['nama']    = $this->terjemahkan_teks_statistik('TOTAL');
        $semua['persen']  = persen(($semua['laki'] + $semua['perempuan']) / $semua['jumlah']);
        $semua['persen1'] = persen($semua['laki'] / $semua['jumlah']);
        $semua['persen2'] = persen($semua['perempuan'] / $semua['jumlah']);

        return $semua;
    }

    protected function order_by($o, $lap)
    {
        //Ordering SQL
        switch (true) {
            case $o == 1 && $lap == 'suku': $this->db->order_by($lap);
                break;

            case $o == 2 && $lap == 'suku': $this->db->order_by($lap . ' DESC');
                break;

            case $lap == 'bdt': break;

            case $o == 1: $this->db->order_by('u.id');
                break;

            case $o == 1: $this->db->order_by('u.id');
                break;

            case $o == 2: $this->db->order_by('u.id DESC');
                break;

            case $o == 3: $this->db->order_by('laki');
                break;

            case $o == 4: $this->db->order_by('laki DESC');
                break;

            case $o == 5: $this->db->order_by('jumlah');
                break;

            case $o == 6: $this->db->order_by('jumlah DESC');
                break;

            case $o == 7: $this->db->order_by('perempuan');
                break;

            case $o == 8: $this->db->order_by('perempuan DESC');
                break;
        }
    }

    private function select_jml($where)
    {
        $str_jml_penduduk  = $this->str_jml_penduduk($where);
        $str_jml_laki      = $this->str_jml_penduduk($where, '1');
        $str_jml_perempuan = $this->str_jml_penduduk($where, '2');
        $this->db
            ->select("({$str_jml_penduduk}) as jumlah")
            ->select("({$str_jml_laki}) as laki")
            ->select("({$str_jml_perempuan}) as perempuan");
    }

    private function str_jml_penduduk($where, $sex = '')
    {
        if ($dusun = $this->session->userdata('dusun')) {
            $this->db->where('a.dusun', $dusun);
        }
        if ($rw = $this->session->userdata('rw')) {
            $this->db->where('a.rw', $rw);
        }
        if ($rt = $this->session->userdata('rt')) {
            $this->db->where('a.rt', $rt);
        }
        if ($sex) {
            $this->db->where('b.sex', $sex);
        }

        return $this->db->select('COUNT(b.id)')
            ->from('penduduk_hidup b')
            ->join('tweb_wil_clusterdesa a', 'b.id_cluster = a.id', 'left')
            ->where($where)
            ->get_compiled_select();
    }

    protected function select_per_kategori()
    {
        $lap = $this->lap;

        // Bagian Penduduk
        $statistik_penduduk = [
            '0'           => ['id_referensi' => 'pendidikan_kk_id', 'tabel_referensi' => 'tweb_penduduk_pendidikan_kk'],
            '1'           => ['id_referensi' => 'pekerjaan_id', 'tabel_referensi' => 'tweb_penduduk_pekerjaan'],
            '2'           => ['id_referensi' => 'status_kawin', 'tabel_referensi' => 'tweb_penduduk_kawin'],
            '3'           => ['id_referensi' => 'agama_id', 'tabel_referensi' => 'tweb_penduduk_agama'],
            '4'           => ['id_referensi' => 'sex', 'tabel_referensi' => 'tweb_penduduk_sex'],
            'hubungan_kk' => ['id_referensi' => 'kk_level', 'tabel_referensi' => 'tweb_penduduk_hubungan'],
            '5'           => ['id_referensi' => 'warganegara_id', 'tabel_referensi' => 'tweb_penduduk_warganegara'],
            '6'           => ['id_referensi' => 'status', 'tabel_referensi' => 'tweb_penduduk_status'],
            '7'           => ['id_referensi' => 'golongan_darah_id', 'tabel_referensi' => 'tweb_golongan_darah'],
            '9'           => ['id_referensi' => 'cacat_id', 'tabel_referensi' => 'tweb_cacat'],
            '10'          => ['id_referensi' => 'sakit_menahun_id', 'tabel_referensi' => 'tweb_sakit_menahun'],
            '14'          => ['id_referensi' => 'pendidikan_sedang_id', 'tabel_referensi' => 'tweb_penduduk_pendidikan'],
            '16'          => ['id_referensi' => 'cara_kb_id', 'tabel_referensi' => 'tweb_cara_kb'],
            '19'          => ['id_referensi' => 'id_asuransi', 'tabel_referensi' => 'tweb_penduduk_asuransi'],
        ];

        switch ("{$lap}") {
            // KELUARGA
            case 'kelas_sosial':
                // Kelas Sosial
                $this->db
                    ->select('u.*, COUNT(k.id) as jumlah')
                    ->select('COUNT(CASE WHEN kelas_sosial = u.id AND p.sex = 1 THEN p.id END) AS laki')
                    ->select('COUNT(CASE WHEN kelas_sosial = u.id AND p.sex = 2 THEN p.id END) AS perempuan')
                    ->from('tweb_keluarga_sejahtera u')
                    ->join('keluarga_aktif k', 'k.kelas_sosial = u.id', 'left')
                    ->join('tweb_penduduk p', 'p.id=k.nik_kepala', 'left')
                    ->group_by('u.id');
                break;

                // RTM
            case 'bdt':
                // BDT
                $this->db
                    ->select('COUNT(u.id) as jumlah')
                    ->select('COUNT(CASE WHEN p.sex = 1 THEN p.id END) AS laki')
                    ->select('COUNT(CASE WHEN p.sex = 2 THEN p.id END) AS perempuan')
                    ->from('tweb_rtm u')
                    ->join('tweb_penduduk p', 'p.id = u.nik_kepala', 'left')
                    ->group_by('u.id')
                    ->where('u.bdt !=', null);
                break;

                // BANTUAN
            case 'bantuan_penduduk': $sql = 'SELECT u.*,
				(SELECT COUNT(kartu_nik) FROM program_peserta WHERE program_id = u.id) AS jumlah,
				(SELECT COUNT(k.kartu_nik) FROM program_peserta k INNER JOIN tweb_penduduk p ON k.kartu_nik=p.nik WHERE program_id = u.id AND p.sex = 1) AS laki,
				(SELECT COUNT(k.kartu_nik) FROM program_peserta k INNER JOIN tweb_penduduk p ON k.kartu_nik=p.nik WHERE program_id = u.id AND p.sex = 2) AS perempuan
				FROM program u';
                break;

                // PENDUDUK
            case 'hamil':
                // Kehamilan
                $this->db->where('p.sex', 2);
                $this->select_jml_penduduk_per_kategori('hamil', 'ref_penduduk_hamil');
                break;

            case 'covid':
                // Covid
                $this->db
                    ->select('u.*, COUNT(k.id) as jumlah')
                    ->select('COUNT(CASE WHEN k.status_covid = u.id AND p.sex = 1 THEN k.id_terdata END) AS laki')
                    ->select('COUNT(CASE WHEN k.status_covid = u.id AND p.sex = 2 THEN k.id_terdata END) AS perempuan')
                    ->from('ref_status_covid u')
                    ->join('covid19_pemudik k', 'k.status_covid = u.id', 'left')
                    ->join('tweb_penduduk p', 'p.id=k.id_terdata', 'left')
                    ->group_by('u.id');
                break;

            case 'suku':
                // Suku
                $this->db
                    ->select('u.suku AS nama, u.suku AS id')
                    ->select('COUNT(u.sex) AS jumlah')
                    ->select('COUNT(CASE WHEN u.sex = 1 THEN 1 END) AS laki')
                    ->select('COUNT(CASE WHEN u.sex = 2 THEN 1 END) AS perempuan')
                    ->from('penduduk_hidup AS u')
                    ->group_by('u.suku')
                    ->where('u.suku IS NOT NULL')
                    ->where('u.suku != ""')
                    ->join('tweb_wil_clusterdesa a', 'u.id_cluster = a.id', 'left');
                if ($dusun = $this->session->userdata('dusun')) {
                    $this->db->where('a.dusun', $dusun);
                }
                if ($rw = $this->session->userdata('rw')) {
                    $this->db->where('a.rw', $rw);
                }
                if ($rt = $this->session->userdata('rt')) {
                    $this->db->where('a.rt', $rt);
                }

                break;

            case 'bpjs-tenagakerja':
                // BPJS Tenaga Kerja
                $this->select_jml_penduduk_per_kategori('pekerjaan_id', 'tweb_penduduk_pekerjaan');
                $this->db->where("(p.bpjs_ketenagakerjaan IS NOT NULL && p.bpjs_ketenagakerjaan != '')");
                break;

            case in_array($lap, array_keys($statistik_penduduk)):
                // Dengan tabel referensi
                $this->select_jml_penduduk_per_kategori($statistik_penduduk["{$lap}"]['id_referensi'], $statistik_penduduk["{$lap}"]['tabel_referensi']);
                break;

            case '13':
                // Umur rentang
                $where = "(DATE_FORMAT(FROM_DAYS(TO_DAYS( NOW()) - TO_DAYS(tanggallahir)) , '%Y')+0)>=u.dari AND (DATE_FORMAT(FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS(tanggallahir)) , '%Y')+0) <= u.sampai";
                $this->select_jml($where);
                $this->db
                    ->select('u.*')
                    ->from('tweb_penduduk_umur u')
                    ->where('u.status', '1');
                break;

            case '15':
                // Umur kategori
                $where = "(DATE_FORMAT(FROM_DAYS(TO_DAYS( NOW()) - TO_DAYS(tanggallahir)) , '%Y')+0)>=u.dari AND (DATE_FORMAT(FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS(tanggallahir)) , '%Y')+0) <= u.sampai ";
                $this->select_jml($where);
                $this->db
                    ->select("u.*, concat(u.nama, ' (', u.dari, ' - ', u.sampai, ')') as nama")
                    ->from('tweb_penduduk_umur u')
                    ->where('u.status', '0');
                break;

            case '17':
                // Akta kelahiran
                $where = "(DATE_FORMAT(FROM_DAYS(TO_DAYS( NOW()) - TO_DAYS(tanggallahir)) , '%Y')+0)>=u.dari AND (DATE_FORMAT(FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS(tanggallahir)) , '%Y')+0) <= u.sampai AND akta_lahir <> '' ";
                $this->select_jml($where);
                $this->db
                    ->select("u.*, concat('UMUR ', u.dari, ' S/D ', u.sampai, ' TAHUN') as nama")
                    ->from('tweb_penduduk_umur u')
                    ->where('u.status', '1');
                break;

            case '18':
                // Kepemilikan ktp
                $where = "((DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(tanggallahir)), '%Y')+0)>=17 OR (status_kawin IS NOT NULL AND status_kawin <> 1)) AND u.status_rekam = status_rekam ";
                $this->select_jml($where);
                $this->db
                    ->select('u.*')
                    ->from('tweb_status_ktp u');
                break;

            default:
                $this->select_jml_penduduk_per_kategori($statistik_penduduk['0']['id_referensi'], $statistik_penduduk['0']['tabel_referensi']);
        }

        return true;
    }

    protected function get_data_jml()
    {
        $lap = $this->lap;
        //Siapkan data baris rekap
        if ($lap == 18) {
            $this->db->where("((DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(tanggallahir)), '%Y')+0)>=17 OR (status_kawin IS NOT NULL AND status_kawin <> 1))");
            $semua = $this->data_jml_semua_penduduk();
        } elseif (in_array($lap, ['kelas_sosial', 'bantuan_keluarga'])) {
            $semua = $this->data_jml_semua_keluarga();
        } elseif (in_array($lap, ['bdt'])) {
            $semua = $this->data_jml_semua_rtm();
        } else {
            if ($lap == 'hamil') {
                $this->db->where('b.sex', 2);
            }
            $semua = $this->data_jml_semua_penduduk();
        }

        return $semua;
    }

    public function list_data($lap = 0, $o = 0)
    {
        $this->lap = $lap;

        $this->load->model('statistik_penduduk_model');
        if ($statistik = $this->statistik_penduduk_model->statistik($lap)) {
            // Statistik yg sudah di-refactor
            $namespace    = $statistik;
            $judul_belum  = $statistik->judul_belum;
            $judul_jumlah = $statistik->judul_jumlah;
        } else {
            $namespace    = $this;
            $judul_jumlah = 'JUMLAH';
            $judul_belum  = 'BELUM MENGISI';
        }

        if ($namespace->select_per_kategori()) {
            $this->order_by($o, $lap);
            $data = $this->db->get()->result_array();
            $this->isi_nomor($data);
        } else {
            $data = [];
        }
        $semua = $namespace->get_data_jml();
        $semua = $this->persentase_semua($semua);
        $total = $namespace->hitung_total($data);

        // Statistik tanpa tabel referensi
        if ($lap === 'bdt') {
            $data = [];
        }

        $data[] = $this->baris_jumlah($total, $judul_jumlah);

        $data[] = $this->baris_belum($semua, $total, $judul_belum);
        $this->hitung_persentase($data, $semua);

        return $data;
    }

    // -------------------- Akhir siapkan data untuk statistik kependudukan -------------------

    public function list_data_rentang()
    {
        $query = $this->db->where('status', 1)->order_by('dari')->get('tweb_penduduk_umur');

        return $query->result_array();
    }

    public function get_rentang($id = 0)
    {
        $sql   = "SELECT * FROM tweb_penduduk_umur WHERE id = {$id} ";
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    public function get_rentang_terakhir()
    {
        $sql   = "SELECT (case when max(sampai) is null then '0' else (max(sampai)+1) end) as dari FROM tweb_penduduk_umur WHERE status = 1 ";
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    public function insert_rentang()
    {
        $data           = $_POST;
        $data['status'] = 1;
        if ($data['sampai'] != '99999') {
            $data['nama'] = $data['dari'] . ' s/d ' . $data['sampai'] . ' Tahun';
        } else {
            $data['nama'] = 'Di atas ' . $data['dari'] . ' Tahun';
        }
        $outp = $this->db->insert('tweb_penduduk_umur', $data);

        status_sukses($outp); //Tampilkan Pesan
    }

    public function update_rentang($id = 0)
    {
        $data = $_POST;
        if ($data['sampai'] != '99999') {
            $data['nama'] = $data['dari'] . ' s/d ' . $data['sampai'] . ' Tahun';
        } else {
            $data['nama'] = 'Di atas ' . $data['dari'] . ' Tahun';
        }
        $outp = $this->db->where('id', $id)->update('tweb_penduduk_umur', $data);

        status_sukses($outp); //Tampilkan Pesan
    }

    public function delete_rentang($id = '', $semua = false)
    {
        if (! $semua) {
            $this->session->success = 1;
        }

        $outp = $this->db->where('id', $id)->delete('tweb_penduduk_umur');

        status_sukses($outp, $gagal_saja = true); //Tampilkan Pesan
    }

    public function delete_all_rentang()
    {
        $this->session->success = 1;

        $id_cb = $_POST['id_cb'];

        foreach ($id_cb as $id) {
            $this->delete_rentang($id, $semua = true);
        }
    }
}
