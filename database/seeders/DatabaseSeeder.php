<?php

namespace Database\Seeders;

use App\Models\Carousel;
use App\Models\Category;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\NavMenu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database for Prodi Sarjana Terapan (D4) Manajemen Informasi Kesehatan (MIK).
     */
    public function run(): void
    {
        // 1. Akun Pengguna / Administrator
        // Super Admin khusus Orang IT (memiliki akses penuh & manajemen sistem)
        $itAdmin = User::updateOrCreate(
            ['email' => 'it@pantiwaluya.ac.id'],
            [
                'name' => 'Super Admin (Unit IT)',
                'role' => 'super_admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@pantiwaluya.ac.id'],
            [
                'name' => 'Super Admin IT Utama',
                'role' => 'super_admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Akun Kaprodi sebagai Admin Prodi (mengelola konten & layanan akademik)
        $kaprodi = User::updateOrCreate(
            ['email' => 'mik@pantiwaluya.ac.id'],
            [
                'name' => 'Kaprodi D4 Manajemen Informasi Kesehatan',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Akun Admin Berita / Humas Prodi
        $newsAdmin = User::updateOrCreate(
            ['email' => 'berita@pantiwaluya.ac.id'],
            [
                'name' => 'Admin Humas & Berita Prodi MIK',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Pengaturan Profil & Identitas Prodi D4 Manajemen Informasi Kesehatan
        $defaultSettings = [
            // Identitas Program Studi
            'division_name' => 'Program Studi Sarjana Terapan (D4) Manajemen Informasi Kesehatan',
            'division_short_name' => 'Prodi D4 Manajemen Informasi Kesehatan',
            'division_acronym' => 'D4 MIK',
            'division_type' => 'prodi',
            'prodi_degree' => 'Sarjana Terapan Kesehatan (S.Tr.Kes)',
            'prodi_accreditation' => 'Terakreditasi Baik Sekali (LAM-PTKes)',
            'division_tagline' => 'Mewujudkan Sarjana Terapan Manajemen Informasi Kesehatan yang Unggul, Inovatif dalam Digitalisasi Rekam Medis, dan Berkarakter Kasih',
            'parent_institution' => 'STIKES Panti Waluya Malang',
            
            // Visual & Branding
            'theme_primary_color' => '#7c3aed', // Violet-600 (Ungu Modern Elegan)
            'theme_secondary_color' => '#4c1d95', // Violet-900 (Deep Royal Purple)
            'theme_accent_color' => '#a855f7', // Purple-500
            'logo_url' => '',
            'hero_banner_title' => 'Program Studi Sarjana Terapan (D4) Manajemen Informasi Kesehatan',
            'hero_banner_subtitle' => 'Mencetak tenaga ahli rekam medis elektronik, casemix/pembiayaan kesehatan, dan analis data kesehatan yang adaptif terhadap transformasi digital kesehatan berlandaskan kasih.',

            // Tentang & Visi Misi
            'about_title' => 'Tentang Prodi D4 Manajemen Informasi Kesehatan',
            'about_description' => "Program Studi Sarjana Terapan (D4) Manajemen Informasi Kesehatan STIKES Panti Waluya Malang merupakan program pendidikan vokasi kesehatan jenjang sarjana terapan yang memadukan ilmu manajemen informasi kesehatan, rekam medis klinis, teknologi informasi kesehatan, serta analisis data statistik kesehatan.\n\nKurikulum dirancang berbasis Outcome-Based Education (OBE) dan standar KKNI yang selaras dengan Permenkes No. 24 Tahun 2022 tentang Rekam Medis Elektronik (RME). Mahasiswa dibekali keterampilan komprehensif mulai dari klasifikasi & kodifikasi penyakit dan tindakan medis (ICD-10 & ICD-9-CM), manajemen casemix INA-CBGs, implementasi Sistem Informasi Manajemen Rumah Sakit (SIMRS), hingga interoperabilitas platform SatuSehat Kemenkes RI.\n\nDidukung fasilitas Laboratorium Komputer Rekam Medis Terpadu, software simulasi SIMRS & RME, kemitraan strategis dengan Rumah Sakit Tipe A, B, C, Puskesmas, Dinas Kesehatan, serta organisasi profesi PORMIKI, lulusan siap menjadi motor penggerak transformasi digital kesehatan di Indonesia.",
            'vision' => 'Menjadi Program Studi Sarjana Terapan Manajemen Informasi Kesehatan yang Unggul, Inovatif dalam Pengembangan Rekam Medis Elektronik dan Analisis Informasi Kesehatan, serta Berdaya Saing di Tingkat Nasional Berlandaskan Semangat Kasih pada Tahun 2035.',
            'mission' => "1. Menyelenggarakan pendidikan sarjana terapan manajemen informasi kesehatan yang berkualitas dan adaptif terhadap kemajuan teknologi rekam medis elektronik (RME) dan SIMRS.\n2. Mengembangkan penelitian terapan yang inovatif dan solutif di bidang manajemen informasi kesehatan, kodifikasi klinis, dan analisis data kesehatan guna meningkatkan mutu fasyankes.\n3. Melaksanakan pengabdian kepada masyarakat berbasis pemanfaatan informasi kesehatan untuk mendukung derajat kesehatan masyarakat dan literasi digital.\n4. Membentuk karakter lulusan yang profesional, beretika luhur, berintegritas tinggi, menjunjung kerahasiaan medis, dan berjiwa cinta kasih.\n5. Memperluas kerjasama strategis dengan institusi pelayanan kesehatan (RS, Puskesmas, Klinik), BPJS Kesehatan, industri teknologi kesehatan, dan organisasi profesi PORMIKI.",
            'prodi_graduate_profile' => "Lulusan disiapkan sebagai Health Information Manager (Manajer Rekam Medis & SIMRS), Clinical Coder & Casemix Specialist (Spesialis Kodifikasi Penyakit & Klaim Asuransi/INA-CBGs), Health Data Analyst & Quality Auditor (Analis Data Kesehatan & Mutu Pelayanan), serta Health Information System Specialist (Spesialis RME & Interoperabilitas SatuSehat).",
            
            // Kontak & Lokasi
            'contact_email' => 'mik@pantiwaluya.ac.id',
            'contact_phone' => '(0341) 569275',
            'contact_whatsapp' => '6281234567890',
            'enable_whatsapp_floating' => '1',
            'whatsapp_floating_message' => 'Halo Admin Prodi D4 Manajemen Informasi Kesehatan, saya ingin bertanya seputar informasi akademik.',
            'contact_room' => 'Gedung Rektorat Lt. 2, Ruang Prodi D4 Manajemen Informasi Kesehatan',
            'contact_address' => 'Jl. Yulius Usman No. 62, Kasin, Kec. Klojen, Kota Malang, Jawa Timur 65117',
            'operating_hours' => 'Senin - Jumat: 08.00 - 16.00 WIB',
            'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.213601444588!2d112.62473467499647!3d-7.976868692048386!2m3!1f0!2f0!3f0!3m2!1i1024!2f768!4f13.1!3m3!1m2!1s0x2dd62828b49e1a17%3A0xc3cb73f1d3c01fa9!2sSTIKes%20Panti%20Waluya%20Malang!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',

            // Media Sosial
            'social_instagram' => 'https://instagram.com/stikespantiwaluya',
            'social_facebook' => 'https://facebook.com/stikespantiwaluyamalang',
            'social_youtube' => 'https://youtube.com/@stikespantiwaluya',
            'social_website' => 'https://pantiwaluya.ac.id',

            // Statistik Capaian di Beranda
            'stat_1_number' => '100%',
            'stat_1_label' => 'Kelulusan UKOM Nasional MIK',
            'stat_2_number' => '100%',
            'stat_2_label' => 'Dosen Magister & Praktisi SIMRS',
            'stat_3_number' => '30+',
            'stat_3_label' => 'RS & Fasilitas Kesehatan Mitra',
            'stat_4_number' => '95%',
            'stat_4_label' => 'Lulusan Bekerja < 6 Bulan',
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => 'general']);
        }

        // 3. Kategori Berita & Dokumen
        $cat1 = Category::updateOrCreate(['slug' => 'akademik-kurikulum'], ['name' => 'Akademik & Kurikulum', 'type' => 'post', 'description' => 'Informasi perkuliahan, kurikulum dan kompetensi MIK']);
        $cat2 = Category::updateOrCreate(['slug' => 'praktik-kerja-lapangan'], ['name' => 'Praktik Kerja Lapangan (PKL)', 'type' => 'post', 'description' => 'Informasi penempatan dan stase PKL Rumah Sakit']);
        $cat3 = Category::updateOrCreate(['slug' => 'pengumuman-prodi'], ['name' => 'Pengumuman Resmi', 'type' => 'post', 'description' => 'Edaran dan pengumuman resmi program studi']);
        $catDoc1 = Category::updateOrCreate(['slug' => 'pedoman-panduan'], ['name' => 'Buku Panduan & Pedoman', 'type' => 'document', 'description' => 'Buku pedoman akademik dan panduan praktikum laboratorium']);
        $catDoc2 = Category::updateOrCreate(['slug' => 'format-skripsi-ta'], ['name' => 'Format Skripsi Terapan', 'type' => 'document', 'description' => 'Format penulisan skripsi dan laporan tugas akhir sarjana terapan']);
        $catDoc3 = Category::updateOrCreate(['slug' => 'formulir-pkl'], ['name' => 'Formulir & Logbook PKL', 'type' => 'document', 'description' => 'Logbook kegiatan dan formulir administrasi praktik kerja lapangan']);

        // 4. Berita & Pengumuman Prodi
        Post::updateOrCreate(
            ['slug' => 'pelepasan-mahasiswa-pkl-manajemen-informasi-kesehatan'],
            [
                'title' => 'Pelepasan Mahasiswa Praktik Kerja Lapangan (PKL) MIK di Rumah Sakit Mitra Pendidikan',
                'category_id' => $cat2->id,
                'user_id' => $superAdmin->id,
                'type' => 'berita',
                'summary' => 'Prodi D4 Manajemen Informasi Kesehatan secara resmi memberangkatkan mahasiswa untuk menjalani PKL di fasilitas pelayanan kesehatan.',
                'content' => '<p>Program Studi Sarjana Terapan (D4) Manajemen Informasi Kesehatan STIKES Panti Waluya Malang secara resmi menyelenggarakan pembekalan dan pelepasan mahasiswa Praktik Kerja Lapangan (PKL) di instalasi rekam medis berbagai Rumah Sakit Tipe A dan B mitra pendidikan wilayah Jawa Timur.</p><p>Kegiatan PKL ini berfokus pada penguasaan alur berkas rekam medis manual maupun elektronik (RME), assembling, koding diagnosis dan tindakan medis, pelaporan SIRS, serta verifikasi klaim BPJS Kesehatan berbasis sistem casemix INA-CBGs.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'views_count' => 210,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'workshop-nasional-rekam-medis-elektronik-dan-kodifikasi-klinis'],
            [
                'title' => 'Workshop Penerapan Rekam Medis Elektronik (RME) & Optimalisasi Casemix INA-CBGs',
                'category_id' => $cat1->id,
                'user_id' => $superAdmin->id,
                'type' => 'berita',
                'summary' => 'Peningkatan kompetensi mahasiswa dalam implementasi regulasi Permenkes No. 24 Tahun 2022 dan integrasi SatuSehat.',
                'content' => '<p>Dalam rangka merespons transformasi digital kesehatan nasional, Prodi D4 MIK menyelenggarakan workshop pendalaman teknis sistem Rekam Medis Elektronik (RME) dan audit kodifikasi klinis menggunakan ICD-10 serta ICD-9-CM. Narasumber praktisi SIMRS membedah standar interoperabilitas HL7 FHIR dan integrasi data dengan platform SatuSehat Kementerian Kesehatan.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views_count' => 315,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'sosialisasi-alur-penyusunan-skripsi-terapan-tahun-akademik-2025'],
            [
                'title' => 'Sosialisasi Alur Penyusunan Skripsi Terapan & Tugas Akhir D4 MIK',
                'category_id' => $cat3->id,
                'user_id' => $superAdmin->id,
                'type' => 'pengumuman',
                'summary' => 'Pedoman pengajuan proposal penelitian terapan, penetapan dosen pembimbing, hingga syarat kelayakan ujian sidang hasil.',
                'content' => '<p>Diberitahukan kepada seluruh mahasiswa tingkat akhir Program Studi Sarjana Terapan Manajemen Informasi Kesehatan mengenai timeline pengusulan proposal skripsi terapan. Fokus topik mencakup perancangan sistem informasi kesehatan, evaluasi efektivitas RME, analisis keakuratan koding penyakit, dan kepuasan pengguna SIMRS. Pedoman penulisan dapat diunduh di Pusat Unduhan.</p>',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(8),
                'views_count' => 180,
            ]
        );

        // 5. Layanan Mahasiswa & Akademik Prodi
        Service::updateOrCreate(
            ['slug' => 'layanan-praktik-kerja-lapangan-pkl'],
            [
                'title' => 'Layanan Praktik Kerja Lapangan (PKL) & Magang Industri',
                'icon' => 'fa-solid fa-hospital',
                'summary' => 'Koordinasi penempatan, administrasi surat izin, dan supervisi stase PKL manajemen rekam medis di rumah sakit mitra.',
                'description' => 'Program Studi memfasilitasi rotasi PKL mahasiswa D4 MIK di berbagai fasyankes (Rumah Sakit, Puskesmas, Klinik, dan Dinas Kesehatan) dengan fokus pada pengarsipan rekam medis, sistem informasi manajemen RS, dan unit casemix.',
                'requirements' => "1. Telah menyelesaikan beban SKS prasyarat akademik\n2. Lulus praktikum laboratorium SIMRS dan Klasifikasi Penyakit\n3. Surat Izin Orang Tua/Wali\n4. Bukti kepesertaan jaminan kesehatan aktif",
                'procedure' => "1. Mahasiswa mendaftar peminatan wahana PKL melalui portal akademik prodi.\n2. Mengikuti pembekalan teknis dan etika kerahasiaan informasi medis.\n3. Pelepasan dan penyerahan ke instansi fasyankes mitra.\n4. Pelaksanaan praktik lapangan dan bimbingan preseptor faskes.",
                'order_index' => 1,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'bimbingan-skripsi-dan-tugas-akhir-terapan'],
            [
                'title' => 'Bimbingan Skripsi & Sidang Tugas Akhir Terapan',
                'icon' => 'fa-solid fa-graduation-cap',
                'summary' => 'Pelayanan pengajuan judul riset sistem informasi kesehatan, seminar proposal, hingga sidang hasil tugas akhir.',
                'description' => 'Layanan akademik bagi mahasiswa D4 MIK untuk penyusunan Skripsi Terapan yang menghasilkan karya inovatif rancang bangun sistem, evaluasi implementasi teknologi kesehatan, atau audit mutu rekam medis.',
                'requirements' => "1. KRS Skripsi telah disetujui Dosen PA\n2. Naskah Proposal Penelitian Terapan\n3. Lembar Persetujuan Pembimbing\n4. Surat Bebas Tanggungan Perpustakaan & Keuangan",
                'procedure' => "1. Pengajuan judul dan rancangan riset ke Koordinator Skripsi Prodi.\n2. Penerbitan Surat Keputusan Dosen Pembimbing.\n3. Proses bimbingan intensif minimal 8 kali pertemuan.\n4. Pendaftaran seminar proposal dan ujian sidang akhir.",
                'order_index' => 2,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'bimbingan-uji-kompetensi-nasional-mik'],
            [
                'title' => 'Pendampingan & Try Out Uji Kompetensi (UKOM) MIK',
                'icon' => 'fa-solid fa-award',
                'summary' => 'Program pemantapan materi kodifikasi klinis, SIMRS, dan simulasi CBT berskala nasional untuk persiapan exit exam.',
                'description' => 'Fasilitasi pembekalan intensif menghadapi Uji Kompetensi Nasional Sarjana Terapan MIK melalui review soal vignete, penguatan konsep klasifikasi penyakit, dan simulasi Computer Based Test (CBT) berkala.',
                'requirements' => "1. Mahasiswa terdaftar pada semester akhir program sarjana terapan\n2. Telah menuntaskan seluruh mata kuliah teori & praktikum\n3. Mengikuti rangkaian Try Out Internal Prodi\n4. Berkas registrasi peserta UKOM Nasional",
                'procedure' => "1. Registrasi data calon peserta di sekretariat prodi.\n2. Mengikuti bimbingan intensif dosen ahli & pembahasan soal.\n3. Uji coba simulasi CBT di Lab Komputer Kampus.\n4. Pelaksanaan UKOM resmi dan penerbitan Surat Tanda Registrasi (STR).",
                'order_index' => 3,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'pelayanan-administrasi-akademik-mahasiswa'],
            [
                'title' => 'Layanan Administrasi Akademik & Surat Izin Penelitian',
                'icon' => 'fa-solid fa-file-signature',
                'summary' => 'Penerbitan surat izin survei pendahuluan, izin penelitian di fasyankes, legalisir berkas, dan keterangan aktif kuliah.',
                'description' => 'Pusat layanan administrasi persuratan akademik bagi mahasiswa yang membutuhkan surat pengantar izin penelitian, studi banding SIMRS, magang mandiri, maupun rekomendasi beasiswa.',
                'requirements' => "1. Mengisi formulir permohonan persuratan secara online\n2. Persetujuan Dosen Pembimbing / Wali Akademik\n3. Proposal / kerangka acuan kegiatan (untuk izin riset)",
                'procedure' => "1. Mengajukan surat permohonan via sistem informasi persuratan prodi.\n2. Verifikasi berkas oleh staf tata usaha prodi.\n3. Penandatanganan oleh Ketua Program Studi.\n4. Pengambilan dokumen resmi dalam 1-2 hari kerja.",
                'order_index' => 4,
                'is_active' => true,
            ]
        );

        // 6. Dosen & Susunan Pengelola Prodi D4 Manajemen Informasi Kesehatan
        TeamMember::updateOrCreate(
            ['name' => 'Tri Wahyuni, S.KM., M.Kes.'],
            [
                'title_degree' => 'S.KM., M.Kes.',
                'identifier' => 'NIDN. 0715068601',
                'position' => 'Ketua Program Studi D4 Manajemen Informasi Kesehatan',
                'type' => 'dosen',
                'expertise' => 'Manajemen Rekam Medis & Casemix INA-CBGs',
                'academic_rank' => 'Lektor',
                'bio' => 'Dosen Manajemen Informasi Kesehatan dengan fokus keahlian pada sistem pembiayaan casemix INA-CBGs, manajemen mutu rekam medis, dan kepemimpinan fasyankes.',
                'email' => 'tri.wahyuni@pantiwaluya.ac.id',
                'phone' => '081234567891',
                'order_index' => 1,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'Rizky Hendrawan, S.ST., M.Kom.'],
            [
                'title_degree' => 'S.ST., M.Kom.',
                'identifier' => 'NIDN. 0721088902',
                'position' => 'Sekretaris Prodi & Koordinator Akademik',
                'type' => 'dosen',
                'expertise' => 'Sistem Informasi Manajemen RS (SIMRS) & RME',
                'academic_rank' => 'Lektor',
                'bio' => 'Dosen Sistem Informasi Kesehatan dengan kepakaran pada arsitektur SIMRS, perancangan Rekam Medis Elektronik (RME), dan interoperabilitas data kesehatan SatuSehat.',
                'email' => 'rizky.hendrawan@pantiwaluya.ac.id',
                'phone' => '081234567892',
                'order_index' => 2,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'Nurul Hidayati, S.ST., M.Kes.'],
            [
                'title_degree' => 'S.ST., M.Kes.',
                'identifier' => 'NIDN. 0719039003',
                'position' => 'Koordinator Praktik Kerja Lapangan (PKL)',
                'type' => 'dosen',
                'expertise' => 'Klasifikasi & Kodifikasi Penyakit (ICD-10 & ICD-9-CM)',
                'academic_rank' => 'Asisten Ahli',
                'bio' => 'Dosen spesialis kodifikasi klinis dengan pengalaman luas dalam pelatihan koding morbiditas dan mortalitas sesuai standar WHO dan audit koding fasyankes.',
                'email' => 'nurul.hidayati@pantiwaluya.ac.id',
                'phone' => '081234567893',
                'order_index' => 3,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'Bambang Setyawan, S.Kom., M.T.'],
            [
                'title_degree' => 'S.Kom., M.T.',
                'identifier' => 'NIDN. 0709048704',
                'position' => 'Koordinator Laboratorium Komputer & SIMRS',
                'type' => 'dosen',
                'expertise' => 'Basis Data Medis & Keamanan Informasi Kesehatan',
                'academic_rank' => 'Asisten Ahli',
                'bio' => 'Dosen teknologi informasi medis dengan fokus penelitian pada keamanan data rekam medis, database relasional faskes, dan komputasi awan kesehatan.',
                'email' => 'bambang.setyawan@pantiwaluya.ac.id',
                'phone' => '081234567894',
                'order_index' => 4,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'Dian Anggraini, S.ST., M.M.'],
            [
                'title_degree' => 'S.ST., M.M.',
                'identifier' => 'NIDN. 0714028805',
                'position' => 'Dosen Manajemen Mutu & Hukum Kesehatan',
                'type' => 'dosen',
                'expertise' => 'Akreditasi Rumah Sakit & Etika Hukum Rekam Medis',
                'academic_rank' => 'Asisten Ahli',
                'bio' => 'Dosen bidang hukum informasi kesehatan, aspek legal rekam medis elektronik, serta persiapan akreditasi instalasi rekam medis rumah sakit (STARKES).',
                'email' => 'dian.anggraini@pantiwaluya.ac.id',
                'phone' => '081234567896',
                'order_index' => 5,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'Aditya Pratama, S.Kom.'],
            [
                'title_degree' => 'S.Kom.',
                'identifier' => 'NIP. 202109004',
                'position' => 'Pranata Laboratorium Komputer & Rekam Medis Digital',
                'type' => 'tendik',
                'expertise' => 'Pengelolaan Server Lab SIMRS, Jaringan & Hardware',
                'academic_rank' => 'Laboran Komputer',
                'bio' => 'Pengelola sarana dan prasarana laboratorium komputer, server simulasi SIMRS, dan instalasi aplikasi praktikum rekam medis elektronik.',
                'email' => 'aditya.pratama@pantiwaluya.ac.id',
                'phone' => '081234567895',
                'order_index' => 6,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'Dewi Lestari, A.Md.Kes.'],
            [
                'title_degree' => 'A.Md.Kes.',
                'identifier' => 'NIP. 202201012',
                'position' => 'Staf Tata Usaha & Administrasi Akademik Prodi',
                'type' => 'tendik',
                'expertise' => 'Administrasi Persuratan, Arsip & Layanan Mahasiswa',
                'academic_rank' => 'Pengadministrasi Akademik',
                'bio' => 'Staf pelayanan tata usaha prodi yang menangani registrasi akademik mahasiswa, surat izin PKL/penelitian, dan logistik perkuliahan.',
                'email' => 'dewi.lestari@pantiwaluya.ac.id',
                'phone' => '081234567898',
                'order_index' => 7,
                'is_active' => true,
            ]
        );

        // 7. Agenda Kegiatan Prodi
        Event::updateOrCreate(
            ['slug' => 'kuliah-pakar-akselerasi-transformasi-digital-rme'],
            [
                'title' => 'Kuliah Pakar: Akselerasi Transformasi Digital Rumah Sakit Melalui Rekam Medis Elektronik (RME)',
                'location' => 'Auditorium STIKES Panti Waluya Malang & Hybrid Zoom',
                'start_date' => now()->addDays(14)->setTime(8, 30),
                'end_date' => now()->addDays(14)->setTime(13, 0),
                'description' => 'Seminar pakar mengupas strategi integrasi platform SatuSehat, tata kelola keamanan cyber data rekam medis, dan kepatuhan Permenkes No. 24 Tahun 2022.',
                'registration_link' => '',
                'is_active' => true,
            ]
        );

        Event::updateOrCreate(
            ['slug' => 'simulasi-try-out-cbt-uji-kompetensi-mik-batch-1'],
            [
                'title' => 'Simulasi Try Out CBT Uji Kompetensi Nasional Sarjana Terapan MIK Batch 1',
                'location' => 'Laboratorium Komputer CBT Center STIKES Panti Waluya',
                'start_date' => now()->addDays(28)->setTime(9, 0),
                'end_date' => now()->addDays(28)->setTime(12, 30),
                'description' => 'Simulasi ujian Computer Based Test (CBT) standar nasional untuk mengukur kesiapan materi kodifikasi klinis, SIMRS, dan manajemen rekam medis.',
                'registration_link' => '',
                'is_active' => true,
            ]
        );

        // 8. Dokumen & Buku Panduan Prodi
        Document::updateOrCreate(
            ['title' => 'Buku Pedoman Praktik Kerja Lapangan (PKL) D4 MIK Edisi 2025'],
            [
                'category_id' => $catDoc1->id,
                'file_path' => 'documents/buku_pedoman_pkl_d4_mik_2025.pdf',
                'file_type' => 'PDF',
                'file_size' => '2.8 MB',
                'description' => 'Panduan lengkap capaian kompetensi, tata tertib, dan format evaluasi stase PKL manajemen rekam medis dan SIMRS.',
                'downloads_count' => 380,
                'is_published' => true,
            ]
        );

        Document::updateOrCreate(
            ['title' => 'Buku Pedoman Penulisan Skripsi & Tugas Akhir Terapan D4 MIK'],
            [
                'category_id' => $catDoc2->id,
                'file_path' => 'documents/panduan_skripsi_terapan_d4_mik.pdf',
                'file_type' => 'PDF',
                'file_size' => '2.1 MB',
                'description' => 'Petunjuk teknis penulisan skripsi terapan, sistematika laporan rancang bangun sistem informasi kesehatan, dan tata cara sidang.',
                'downloads_count' => 320,
                'is_published' => true,
            ]
        );

        Document::updateOrCreate(
            ['title' => 'Buku Logbook Praktikum Manajemen Rekam Medis & SIMRS'],
            [
                'category_id' => $catDoc3->id,
                'file_path' => 'documents/format_logbook_praktik_mik.docx',
                'file_type' => 'DOCX',
                'file_size' => '480 KB',
                'description' => 'Format resmi pencatatan aktivitas praktikum kodifikasi penyakit, assembling berkas, dan supervisi lapangan.',
                'downloads_count' => 260,
                'is_published' => true,
            ]
        );

        // 9. Banner Carousel Beranda
        Carousel::updateOrCreate(
            ['title' => 'Program Studi Sarjana Terapan (D4) Manajemen Informasi Kesehatan'],
            [
                'subtitle' => 'Mencetak tenaga ahli rekam medis digital, casemix/pembiayaan kesehatan, dan analis data kesehatan yang unggul dan berdaya saing digital.',
                'image_path' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Profil Program Studi',
                'button_link' => '/profil',
                'order_index' => 1,
                'is_active' => true,
            ]
        );

        Carousel::updateOrCreate(
            ['title' => 'Laboratorium Rekam Medis Elektronik (RME) & SIMRS Terpadu'],
            [
                'subtitle' => 'Fasilitas komputasi modern dengan simulasi sistem informasi manajemen rumah sakit, kodifikasi klinis, dan tata kelola data kesehatan.',
                'image_path' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Jelajahi Layanan & Fasilitas',
                'button_link' => '/layanan',
                'order_index' => 2,
                'is_active' => true,
            ]
        );

        // 10. Navigasi Menu Default
        $defaultMenus = [
            ['label' => 'Beranda', 'url' => '/', 'target' => '_self', 'order_index' => 1, 'is_active' => true],
            ['label' => 'Profil Prodi', 'url' => '/profil', 'target' => '_self', 'order_index' => 2, 'is_active' => true],
            ['label' => 'Dosen & Tendik', 'url' => '/dosen-tendik', 'target' => '_self', 'order_index' => 3, 'is_active' => true],
            ['label' => 'Layanan Akademik', 'url' => '/layanan', 'target' => '_self', 'order_index' => 4, 'is_active' => true],
            ['label' => 'Berita & Informasi', 'url' => '/berita', 'target' => '_self', 'order_index' => 5, 'is_active' => true],
            ['label' => 'Agenda Kegiatan', 'url' => '/agenda', 'target' => '_self', 'order_index' => 6, 'is_active' => true],
            ['label' => 'Pusat Unduhan', 'url' => '/unduhan', 'target' => '_self', 'order_index' => 7, 'is_active' => true],
            ['label' => 'Galeri Foto', 'url' => '/galeri', 'target' => '_self', 'order_index' => 8, 'is_active' => true],
            ['label' => 'Kontak Kami', 'url' => '/kontak', 'target' => '_self', 'order_index' => 9, 'is_active' => true],
        ];

        foreach ($defaultMenus as $menu) {
            NavMenu::updateOrCreate(['url' => $menu['url']], $menu);
        }
    }
}
