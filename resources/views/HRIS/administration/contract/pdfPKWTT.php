<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-size: 13px;
            color: black;
            counter-increment: pageTotal;
        }

        @page {
            margin: 90px 50px 110px 50px;
        }

        #clear {
            clear: both;
        }

        #header {
            position: fixed;
            left: 0px; right: 0px; top: 0px;
            text-align: center;
            height: 90px;
        }

        #header-second {
            position: absolute;
            left: -20px; right: -20px; top: -200px;
            text-align: center;
            height: 190px;
        }

        #header-second img{
            width: 300px;
            top: 120px;
            position: absolute;
            right: 0;
        }
        
        #footer {
            position: fixed;
            bottom: -110px;
            left: 0px;
            height: 110px;
            right: 0px;
            border-top: 2px solid black;
        }

        #footer .right {
            float: right;
        }

        #footer .left {
            float: left;
        }

        #footer .page:after {
            counter-increment: page;
            content: "Page " counter(page) " of " counter(pageTotal);
        }

        #footer .footer-confidential {
            font-size: 11px;
            font-style: italic;
        }

        #footer .footer-company {
            text-align: center;
        }

        #footer.footer-company div {
            margin-bottom: 5px;
        }

        #footer .footer-company div:first-child {
            font-weight: bold
        }

        #content .content-header {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 15px;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid black;
        }

        #content .content-number {
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            padding: 5px 0;
            margin-bottom: 20px;
        }

        #content .content-introduction span {
            font-weight: bold;
        }

        #content .content-party {
            text-align: justify;
            padding-left:20px;
        }
        #content .content-party li,
        #content .content-party li:last-child div:last-child {
            margin-top: 10px;
        }

        #content .content-party span {
            font-weight: bold;
        }

        #content .article-1,
        #content .article-2,
        #content .article-3,
        #content .article-4,
        #content .article-5,
        #content .article-6,
        #content .article-7,
        #content .article-8,
        #content .article-9 {
            margin-top: 20px;
        }

        #content .article-1 span,
        #content .article-2 span,
        #content .article-3 span,
        #content .article-4 span,
        #content .article-5 span,
        #content .article-6 span,
        #content .article-7 span,
        #content .article-8 span,
        #content .article-9 span  {
            font-weight: bold;
        }

        #content .article-1-header,
        #content .article-2-header,
        #content .article-3-header,
        #content .article-4-header,
        #content .article-5-header,
        #content .article-6-header,
        #content .article-7-header,
        #content .article-8-header,
        #content .article-9-header {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
        
        #content .article-1-header div:last-child,
        #content .article-2-header div:last-child,
        #content .article-3-header div:last-child,
        #content .article-4-header div:last-child,
        #content .article-5-header div:last-child,
        #content .article-6-header div:last-child,
        #content .article-7-header div:last-child,
        #content .article-8-header div:last-child,
        #content .article-9-header div:last-child {
            text-transform: uppercase;
        }

        #content .content-sign{
            display: table;
            width: 100%;
            margin-top: 50px;
        }
        
        #content .content-sign .sign-header {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 100px;
            text-transform: uppercase;
        }

        #content .content-sign .sign-name {
            font-weight: bold;
            text-align: center;
        }

        #content .content-sign .content-left {
            position: absolute;
            left: 0px;
            width: 50%;
        }

        #content .content-sign .content-right {
            position: absolute;
            right: 0px;
            width: 50%;
        }
    </style>
</head>

<body>
    <div id="header"></div>
    <div id="header-second">
        <img src="http://elabram.com/wp-content/uploads/2016/08/Elarbam-600px.png">
    </div>
    <div id="footer">
        <div class="left">
            <span>{{$contract->cont_no_new}} - {{$contract->name}}</span>
        </div>
        <div class="right">
            <span class="page"></span>
        </div>
        <div id="clear"></div>
        <p class="footer-confidential">This document is confidential and released by PT. Elabram Systems</p>
        <div class="footer-company">
            <div>PT. Elabram Systems</div>
            <div>Pusat Bisnis Thamrin City Lt. 7 Jl. Thamrin Boulevard (d/h Jl. Kebon Kacang Raya), Jakarta Pusat
                10340</div>
            <div>Telp : +62 21 2955 8688</div>
        </div>
    </div>
    <div id="content">
        <div class="content-header">
            <div>PERJANJIAN KERJA</div>
            <div>ANTARA</div>
            <div>PT ELABRAM SYSTEMS</div>
            <div>DENGAN</div>
            <div>{{$contract->name}}</div>
        </div>
        <div class="content-number">
            Nomor: 106/PKWT-PTES/015/XII/2018
        </div>
        <div class="content-text">
            <div class="content-introduction">
                Pada hari ini <span>{{$contract->today_day}}</span> tanggal <span>{{$contract->today_day_numb}}</span> bulan <span>{{$contract->today_month}}</span> tahun <span>{{$contract->today_year}}</span>
                (<span>27-12-2018</span>), yang bertandatangan di bawah ini :
            </div>
            <div class="content-party">
                <ol type="1">
                    <li>
                        <span>{{$contract->approver}}</span>, dalam kedudukannya selaku {{$contract->approver_position}} PT
                        Elabram Systems dalam hal ini bertindak dalam jabatannya tersebut mewakili PT Elabram Systems
                        berdasarkan Surat Kuasa Khusus Nomor 2018/PTES/SK/02-26-I, oleh karena itu berdasarkan Anggaran
                        Dasar Perseroan yang dimuat dalam Akta
                        Pendirian Perusahaan No. 14, tanggal Sebelas bulan Oktober tahun Dua Ribu Lima (11-10-2005)
                        dibuat dihadapan Sri Intansih, S.H., Notaris di Jakarta dan telah disahkan melalui SK Menteri
                        Hukum dan Hak
                        Asasi Manusia tanggal Sembilan Belas bulan Oktober tahun Dua Ribu Lima (19-10-2005), dengan
                        perubahan terakhir Anggaran Dasar Perseroan yang dimuat dalam terakhir telah diubah dengan Akta
                        Nomor 01 tanggal
                        07 Agustus 2014 yang dibuat dihadapan Ummu Imama SH, Notaris di Jakarta,, berkedudukan di
                        Gedung Thamrin City Tower, Pusat Bisnis Thamrin City, 7th Floor, Jl. Thamrin Boulevard (d/h Jl.
                        Kebon Kacang
                        Raya), Jakarta Pusat, 10230, Indonesia selanjutnya disebut <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                        <table>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Nama</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->name}}</td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Alamat</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->address}}</td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->gender}}</td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>No. {{$contract->identitas}}</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->id_number}}</td>
                            </tr>
                        </table>
                        <div>untuk selanjutnya disebut <span>PIHAK KEDUA</span>.</div>
                    </li>
                </ol>
            </div>
            <div class="content-introduction">
                Dengan ini <span>PIHAK PERTAMA</span> dan <span>PIHAK KEDUA</span>, selanjutnya secara bersama-sama
                disebut <span>PARA PIHAK</span> sepakat
                untuk mengikatkan diri dan mengadakan Perjanjian Kerja Waktu Tertentu dengan ketentuan-ketentuan dan
                syarat-syarat sebagai berikut :
            </div>
            <div class="article-1">
                <div class="article-1-header">
                    <div>Pasal 1</div>
                    <div>PENGERTIAN UMUM</div>
                </div>
                Dalam Perjanjian Kerja ini yang dimaksud dengan:
                <ol type="1">
                    <li>
                        Pekerja adalah <span>PIHAK KEDUA</span>/Pekerja yang mempunyai hubungan kerja dengan <span>PIHAK
                            PERTAMA</span> karena
                        pelaksanaan
                        tugas/pekerjaan yang dimaksud pasal 2 berdasarkan Perjanjian Kerja Waktu Tertentu menurut
                        Perjanjian Kerja ini.
                    </li>
                    <li>
                        Daftar Hadir adalah catatan kehadiran Pekerja yang dikelola oleh
                        koordinator/supervisor/pengawas bagi Pekerja di perusahan
                        tempat Pekerja menjalankan tugas/pekerjaannya.
                    </li>
                    <li>
                        Rekanan adalah orang, badan, atau institusi yang bekerjasama dengan dan / atau menyerahkan
                        sebagian pelaksanaan
                        pekerjaan kepada <span>PIHAK PERTAMA</span> melalui “Perjanjian Pemborongan Pekerjaan dan /
                        atau Penyediaan
                        Jasa Pekerja” dan
                        untuk itu <span>PIHAK PERTAMA</span> menempatkan <span>PIHAK KEDUA</span> sebagai Pekerja.
                    </li>
                </ol>
            </div>
            <div class="article-2">
                <div class="article-2-header">
                    <div>Pasal 2</div>
                    <div>JENIS DAN LINGKUP PEKERJAAN</div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK KEDUA</span> setuju untuk melaksanakan tugas/pekerjaan yang diberikan oleh <span>PIHAK
                            PERTAMA</span> sebagai
                        <span>Product Assistant Engineer</span> dengan status/kedudukan sebagai Pekerja dengan
                        Perjanjian Kerja Waktu
                        Tertentu (P-PKWT), yang ditempatkan di <span>Klien</span> (selanjutnya disebut <span>REKANAN</span>).
                    </li>
                    <li>
                        Ruang lingkup tugas/pekerjaan yang diserahkan oleh <span>PIHAK PERTAMA</span> kepada <span>PIHAK
                            KEDUA</span> disesuaikan
                        dengan
                        jabatan/tugas dari <span>PIHAK KEDUA</span> dan dituangkan dalam bentuk Surat Penugasan dan
                        Uraian
                        tugas/pekerjaan (Job
                        Description) yang diberikan oleh <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                        Surat Penugasan dan Uraian tugas/pekerjaan (Job Description) tersebut dalam ayat (2) Pasal ini
                        merupakan bagian yang tidak
                        terpisahkan dengan perjanjian ini.
                    </li>
                </ol>
            </div>
            <div class="article-3">
                <div class="article-3-header">
                    <div>Pasal 3</div>
                    <div>JANGKA WAKTU PERJANJIAN</div>
                </div>
                <ol type="1">
                    <li>
                        Perjanjian Kerja ini berlaku sejak tanggal <span>{{$contract->start_date_day_numb}} {{$contract->start_date_day}} {{$contract->start_date_year}}</span> sampai dengan 
                        <span>{{$contract->end_date_day_numb}} {{$contract->end_date_day}} {{$contract->end_date_year}}</span> tanggal atau sampai dengan saat
                        Perjanjian ini diputus oleh <span>PIHAK PERTAMA</span> karena <span>PIHAK KEDUA</span>
                        melanggar ketentuan yang tercantum dalam Pasal 6
                        Perjanjian ini dan / atau ketentuan lain yang berlaku bagi Pekerja di <span>PIHAK PERTAMA</span>
                        dan / atau <span>REKANAN</span>.
                    </li>
                    <li>
                        Jangka waktu Perjanjian Kerja yang dimaksud dalam ayat (1) Pasal ini dapat diperpanjang
                        berdasarkan kesepakatan kedua
                        belah pihak.
                    </li>
                </ol>
            </div>
            <div class="article-4">
                <div class="article-4-header">
                    <div>Pasal 4</div>
                    <div>KEWAJIBAN PIHAK PERTAMA</div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK PERTAMA</span> berkewajiban membayar upah kepada <span>PIHAK KEDUA</span> sebesar
                        <span>{{$contract->cur_id}}. {{$contract->total}}</span> per bulan.
                    </li>
                    <li>
                        Upah yang dimaksud ayat (1) Pasal ini dibayarkan secara bulanan setiap tanggal <span>{{$contract->pay_tgl}}</span>
                        bulan pembayaran.
                    </li>
                    <li>
                        Pembayaran yang diterima <span>PIHAK KEDUA</span> dalam bentuk tunai dibayarkan <span>PIHAK
                            PERTAMA</span> melalui
                        pemindahbukuan ke
                        rekening <span>PIHAK KEDUA</span>.
                    </li>
                    <li>
                        <span>PIHAK PERTAMA</span> memberikan cuti selama 12 (dua belas) hari kerja dalam 1 (satu)
                        tahun kepada <span>PIHAK KEDUA</span>, sesuai
                        ketentuan yang berlaku pada <span>PIHAK PERTAMA</span> dan / atau <span>REKANAN</span>.
                    </li>
                    <li>
                        <span>PIHAK PERTAMA wajib mengikutsertakan <span>PIHAK KEDUA</span> dalam Program BPJS yang
                            terdiri dari Jaminan
                            Kecelakaan
                            Kerja, Jaminan Kematian, Jaminan Hari Tua, Jaminan Pensiun dan Jaminan Pemeliharaan
                            Kesehatan
                            yang perhitungannya
                            atau preminya dihitung sesuai ketentuan yang berlaku.
                    </li>
                </ol>
            </div>
            <div class="article-5">
                <div class="article-5-header">
                    <div>Pasal 5</div>
                    <div>KEWAJIBAN PIHAK KEDUA</div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK KEDUA</span> dengan segala kemampuan melaksanakan tugas/pekerjaan yang telah
                        diberikan
                        dan dipercayakan oleh
                        <span>PIHAK PERTAMA</span> dan / atau <span>REKANAN</span> kepadanya dengan sebaik-baiknya dan
                        dengan penuh rasa tanggung
                        jawab serta
                        senantiasa melindungi kepentingan <span>PIHAK PERTAMA</span> dan / atau <span>REKANAN</span>.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> tidak melakukan pelanggaran dan / atau kejahatan, baik yang diatur
                        dalam
                        Kitab Undang- undang Hukum
                        Pidana, Undang-undang Tindak Pidana Khusus (Korupsi) maupun Peraturan-perundangan lainnya yang
                        berlaku, serta tidak
                        melakukan perbuatan/tindakan yang secara langsung maupun tidak langsung dapat menimbulkan
                        kerugian
                        secara
                        administrasi, finansial dan / atau dapat merusak citra <span>PIHAK PERTAMA</span> dan / atau
                        <span>REKANAN</span>.

                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> wajib mentaati ketentuan Perjanjian ini, Peraturan Perusahaan dan
                        Peraturan-peraturan
                        lainnya yang
                        dikeluarkan oleh <span>PIHAK PERTAMA</span> dan / atau <span>REKANAN</span> dan menjaga
                        kepentingan
                        <span>PIHAK PERTAMA</span> dan / atau
                        <span>REKANAN</span> dengan sebaik-baiknya.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> diwajibkan untuk memberikan kepada <span>REKANAN</span> dan / atau
                        <span>PIHAK
                            PERTAMA</span> segala
                        informasi yang
                        menyangkut tugas pekerjaan yang menjadi tanggung jawabnya setiap saat <span>REKANAN</span> dan
                        /
                        atau <span>PIHAK
                            PERTAMA</span>
                        membutuhkan.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> tidak memberikan keterangan kepada media cetak dan media elektronik
                        serta
                        pihak lain, dan tidak pula
                        membicarakan diluar hubungan dinas segala sesuatu yang diketahuinya mengenai <span>REKANAN</span>
                        dan / atau <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> bersedia dikenakan pengurangan atas upahnya berdasarkan
                        peraturan/ketentuan yang
                        berlaku bagi Pekerja
                        Waktu Tertentu di <span>PIHAK PERTAMA</span> apabila tidak hadir secara penuh selama jam kerja
                        berdasarkan
                        Daftar Hadir yang telah
                        disetujui <span>REKANAN</span> dan akan diperhitungkan pada pembayaran upah.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> tidak menuntut fasilitas/hak/kesejahteraan lain selain yang telah
                        ditentukan/ditetapkan
                        dalam Pasal 4
                        Perjanjian ini.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> tidak diperkenankan bekerja pada perusahaan selain perusahaan yang di
                        tunjuk <span>PIHAK PERTAMA</span> selama
                        jangka waktu pelaksanaan Perjanjian Kerja ini.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> wajib memberitahukan kepada <span>PIHAK PERTAMA</span> setiap terjadi
                        perubahan alamat
                        rumah/tempat tinggal,
                        ahli waris, susunan keluarga yang menjadi tanggung jawabnya.
                    </li>
                </ol>
            </div>
            <div class="article-6">
                <div class="article-6-header">
                    <div>Pasal 6</div>
                    <div>PERJANJIAN KERJA BERAKHIR</div>
                </div>
                Perjanjian Kerja ini berakhir apabila :
                <ol type="a">
                    <li>
                        <span>PIHAK KEDUA</span> meninggal dunia.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> menderita sakit berkepanjangan.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> baik secara langsung maupun tidak langsung melanggar/tidak memenuhi
                        ketentuan Perjanjian ini dan
                        Ketentuan yang ditetapkan oleh <span>REKANAN<span> dan / atau <span>PIHAK PERTAMA<span>.
                    </li>
                    <li>
                        Jangka Waktu Perjanjian Berakhir.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> dinyatakan/dianggap tidak cakap oleh <span>REKANAN</span> atau tidak
                        melaksanakan
                        tugasnya sesuai kualifikasi yang
                        telah ditentukan pada jabatan tertentu.
                    </li>
                    <li>
                        <span>PIHAK PERTAMA</span> tidak memungkinkan lagi untuk mempekerjakan <span>PIHAK KEDUA</span>
                        disebabkan
                        oleh hal-hal yang berada
                        diluar kekuasaan <span>PIHAK PERTAMA</span> (force majeur).
                    </li>
                    <li>
                        Apabila salah satu pihak mengakhiri hubungan kerja sebelum berakhirnya jangka waktu yang
                        ditetapkan dalam Perjanjian
                        Kerja Waktu Tertentu, atau berakhirnya hubungan kerja bukan karena ketentuan sebagaimana
                        dimaksud dalam pasal ini,
                        pihak yang mengakhiri hubungan kerja diwajibkan membayar ganti rugi kepada pihak lainya sebesar
                        upah pekerja/buruh
                        sampai batas waktu berakhirnya jangka waktu perjanjian kerja.
                    </li>
                </ol>
            </div>
            <div class="article-7">
                <div class="article-7-header">
                    <div>Pasal 7</div>
                    <div>S A N K S I</div>
                </div>
                Dalam Perjanjian Kerja ini yang dimaksud dengan:
                <ol type="1">
                    <li>
                        <span>PIHAK PERTAMA</span> dapat memutuskan/mengakhiri Perjanjian Kerja ini secara sepihak
                        sebelum jangka
                        waktu Perjanjian Kerja
                        ini berakhir (selanjutnya disebut ”Pengakhiran Dini”) apabila <span>PIHAK KEDUA</span>
                        melanggar dan / atau
                        tidak memenuhi
                        ketentuan yang tercantum dalam Pasal 6 Perjanjian ini, Peraturan Perusahaan, dan / atau
                        ketentuan yang berlaku bagi
                        Pekerja waktu tertentu di <span>PIHAK PERTAMA</span> atau karena kinerja/perilaku <span>PIHAK
                            KEDUA</span> mengakibatkan
                        <span>REKANAN</span> tidak
                        bersedia menerima <span>PIHAK KEDUA</span> sebagai Pekerja yang ditempatkan di Perusahaan <span>REKANAN</span>.
                    </li>
                    <li>
                        “Pengakhiran Dini” sebagai dimaksud ayat (1) Pasal ini dapat dilakukan <span>PIHAK PERTAMA</span>
                        tanpa
                        harus memberikan
                        “peringatan tertulis ke 1, ke 2 dan / atau terakhir ke 3” kepada <span>PIHAK KEDUA</span>
                        dengan ketentuan
                        bahwa :
                        <ol type="a">
                            <li>
                                Pengakhiran dini tersebut diberitahukan secara tertulis sebelumnya oleh <span>PIHAK
                                    PERTAMA</span>
                                kepada <span>PIHAK KEDUA</span>.
                            </li>
                            <li>
                                Dalam hal <span>PIHAK KEDUA</span> dituduh melakukan pelanggaran dengan ancaman
                                “Pengakhiran Dini”
                                maka <span>PIHAK
                                    KEDUA</span> wajib menyampaikan pertanggung- jawaban/pembelaan diri kepada <span>PIHAK
                                    PERTAMA</span> dalam
                                waktu 14
                                (empat belas) hari dan jika dalam 14 (empat belas) hari sejak pemberitahuan tersebut
                                diterima <span>PIHAK KEDUA</span> tidak
                                memberikan pertanggungjawaban atau apabila pertanggungjawaban yang diberikan <span>PIHAK
                                    KEDUA</span> tidak dapat
                                diterima oleh <span>PIHAK PERTAMA</span> berdasarkan alasan dan pertimbangan yang
                                semestinya maka
                                <span>PIHAK KEDUA</span>
                                dianggap telah dapat menerima keputusan “Pengakhiran Dini” tersebut diatas dari <span>PIHAK
                                    PERTAMA</span>.
                            </li>
                        </ol>
                    </li>
                    <li>
                        Dalam hal “Pengakhiran Dini” ini terjadi karena <span>PIHAK KEDUA</span> melakukan pelanggaran
                        yang mengakibatkan kerugian
                        finansial bagi <span>REKANAN</span> dan / atau <span>PIHAK PERTAMA</span>, maka <span>PIHAK
                            KEDUA</span> wajib mengganti seluruh kerugian yang
                        diderita oleh <span>REKANAN</span> dan / atau <span>PIHAK PERTAMA</span> dan <span>REKANAN</span>
                        dan / atau <span>PIHAK PERTAMA</span> dapat menempuh
                        penyelesaian terhadap <span>PIHAK KEDUA</span> melalui jalur hukum sesuai ketentuan
                        peraturan-perundangan yang berlaku.
                    </li>
                    <li>Tanpa mengurangi ketentuan ayat (5) Pasal ini, apabila <span>PIHAK PERTAMA</span> melakukan
                        “Pengakhiran
                        Dini” Perjanjian Kerja ini
                        disebabkan bukan karena ketentuan yang dimaksud ayat (1), (2), (3) Pasal ini, atau bukan karena
                        kesalahan/kelalaian dari
                        <span>PIHAK KEDUA</span>, maka <span>PIHAK PERTAMA</span> akan memberikan ganti rugi sebesar
                        jumlah upah untuk jangka
                        waktu Perjanjian
                        Kerja yang tersisa serta hak-hak <span>PIHAK KEDUA</span> yang belum dibayarkan oleh <span>PIHAK
                            PERTAMA</span>.
                    </li>
                    <li>Apabila <span>PIHAK PERTAMA</span> melakukan “Pengakhiran Dini” tersebut disebabkan karena
                        ketentuan yang dimaksud ayat (1), (2),
                        (3) Pasal ini, atau karena kelalaian/kesalahan <span>PIHAK KEDUA</span>, maka <span>PIHAK
                            PERTAMA</span>
                        tidak berkewajiban memberikan
                        kompensasi atau penggantian dalam bentuk apapun kepada <span>PIHAK KEDUA</span>.
                    </li>
                    <li>Selanjutnya mengenai “Pengakhiran Dini” Perjanjian Kerja ini, kedua belah pihak sepakat untuk
                        melepaskan diri dari
                        ketentuan Pasal 1266 dan 1267 Kitab Undang Undang Hukum Perdata tentang Pemutusan dan
                        Pembatalan Perjanjian.
                    </li>
                </ol>
            </div>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Pasal 8</div>
                    <div>P E R S E L I S I H A N</div>
                </div>
                <ol type="1">
                    <li>
                        Dalam hal terjadi perselisihan dalam melaksanakan Perjanjian Kerja ini, maka kedua belah pihak
                        bersepakat untuk sedapat
                        mungkin menyelesaikan secara musyawarah.
                    </li>
                    <li>
                        Dalam hal tidak terdapat kesesuaian pendapat dalam musyawarah, maka kedua belah pihak sepakat
                        untuk menyerahkannya
                        kepada Pengadilan Negeri <span>Jakarta Pusat</span>.
                    </li>
                    <li>
                        Untuk Perjanjian Kerja ini dan segala akibatnya kedua belah pihak memilih tempat kedudukan
                        hukum (domisili) yang tetap
                        dan umum di Kantor Kepaniteraan Pengadilan Negeri <span>Jakarta Pusat</span>.
                    </li>
                </ol>
            </div>
            <div class="article-9">
                <div class="article-9-header">
                    <div>Pasal 9</div>
                    <div>P E N U T U P</div>
                </div>
                <ol type="1">
                    <li>
                        Hal-hal yang tidak atau belum cukup diatur dalam Perjanjian Kerja ini akan diatur kemudian atas
                        dasar permufakatan
                        bersama oleh kedua belah pihak yang akan dituangkan ke dalam bentuk surat, lampiran atau
                        Perjanjian tambahan
                        (addendum) yang merupakan satu kesatuan yang tidak dapat dipisahkan dari Perjanjian Kerja ini.
                    </li>
                    <li>
                        Perjanjian Kerja ini dibuat dalam rangkap 2 (dua) bermaterai cukup dan mempunyai kekuatan hukum
                        yang sama, dan
                        mengikat <span>PARA PIHAK</span> tanpa ada pengecualian. Rangkap pertama dipegang oleh <span>PIHAK
                            PERTAMA</span> dan rangkap kedua
                        dipegang oleh <span>PIHAK KEDUA</span>.
                    </li>
                    <li>
                        Semua Perjanjian atau Kesepakatan Kerja yang ditandatangani oleh <span>PIHAK KEDUA</span> dan
                        <span>PIHAK PERTAMA</span> sebelum tanggal
                        Perjanjian Kerja ini, bila ada, dengan ini dinyatakan batal atau tidak berlaku lagi.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> dengan ini menyatakan tidak ada janji-janji, syarat-syarat atau
                        pengertian lain apapun selain dari apa yang
                        tercantum dalam Perjanjian Kerja ini.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> memahami sepenuhnya bahwa semua hal yang tercantum dalam peraturan
                        Perusahaan
                        berlaku baginya,
                        kecuali jika telah ditentukan lain dalam Perjanjian Kerja ini maka ketentuan dalam Perjanjian
                        Kerja inilah yang berlaku.
                    </li>
                    <li>
                        Perjanjian Kerja ini dibuat dengan sebenar-benarnya tanpa adanya tekanan atau paksaan apapun
                        dan setelah dibaca secara
                        seksama maka kedua belah pihak sepakat menandatangani Perjanjian Kerja ini.
                    </li>
                </ol>
            </div>
            <div class="content-sign">
                <div class="content-left">
                    <div class="sign-header">PIHAK PERTAMA</div>
                    <div class="sign-name">{{$contract->approver}}<br>({{$contract->approver_position2}})</div>
                </div>
                <div class="content-right">
                    <div class="sign-header">PIHAK KEDUA</div>
                    <div class="sign-name">{{$contract->name}}<br>({{$contract->position}})</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>