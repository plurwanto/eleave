<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
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
            content: "Page " counter(page) " of 6";
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
            <span>{{$contract->cont_no_footer}} - {{$contract->name}}</span>
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
            Nomor: <span>{{$contract->cont_no_new}}</span>
        </div>
        <div class="content-text">
            <div class="content-introduction">
                Pada hari ini <span>{{$contract->today_day}}</span></span> tanggal <span>{{$contract->today_day_numb}}</span></span> bulan <span>{{$contract->today_month}}</span></span> tahun <span>{{$contract->today_year}}</span>
                (<span>{{$contract->now}}</span>), yang bertanda tangan di bawah ini :
            </div>
            <div class="content-party">
                <ol type="1">
                    <li>
                        <span>{{$contract->approver}}</span>, dalam kedudukannya selaku <span>{{$contract->approver_position}}</span> PT Elabram Systems dalam hal ini
                        bertindak dalam jabatannya tersebut mewakili PT Elabram Systems berdasarkan Surat Kuasa Khusus Nomor
                        PTES/XI/2015/235 tanggal 4 November 2015, oleh karena itu berdasarkan Anggaran Dasar Perseroan yang dimuat dalam Akta
                        Pendirian Perusahaan No. 14, tanggal Sebelas bulan Oktober tahun Dua Ribu Lima (11-10-2005) dibuat dihadapan Sri
                        Intansih, S.H., Notaris di Jakarta dan telah disahkan melalui SK Menteri Hukum dan Hak Asasi Manusia tanggal Sembilan
                        Belas bulan Oktober tahun Dua Ribu Lima (19-10-2005), dengan perubahan terakhir Anggaran Dasar Perseroan yang dimuat
                        dalam terakhir telah diubah dengan Akta Nomor 01 tanggal 07 Agustus 2014 yang dibuat dihadapan Ummu Imama SH,
                        Notaris di Jakarta,, berkedudukan di Gedung Thamrin City Tower, Pusat Bisnis Thamrin City, 7th Floor, Jl. Thamrin Boulevard
                        (d/h Jl. Kebon Kacang Raya), Jakarta Pusat, 10230, Indonesia, untuk selanjutnya disebut <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                    <table>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Nama</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->name}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->gender}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Tempat / Tanggal Lahir</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->mem_dob_city}}</span>, <span>{{$contract->dob_day_numb}}</span> <span>{{$contract->dob_month}}</span> <span>{{$contract->dob_year}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Alamat</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->address}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>No. KTP</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->id_number}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Umur</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->age}}</span></td>
                            </tr>
                        </table>
                        <div>Dalam hal ini bertindak untuk dan atas nama dirinya sendiri, selanjutnya disebut <span>PIHAK KEDUA</span>.</div>
                    </li>
                </ol>
            </div>
            <div class="content-introduction">
                <span>PIHAK PERTAMA</span> dan <span>PIHAK KEDUA</span> yang selanjutnya secara bersama-sama disebut <span>PARA PIHAK</span> dengan ini menyatakan setuju
                untuk mengadakan Perjanjian Kerja Waktu Tidak Tertentu – selanjutnya disebut “Perjanjian Kerja” - berdasarkan ketentuan-ketentuan
                dan syarat-syarat sebagai berikut:
            </div>
            <div class="article-1">
                <div class="article-1-header">
                    <div>Pasal 1</div>
                    <div>DEFINISI</div>
                </div>
                Dalam Perjanjian Kerja ini yang dimaksud dengan :
                <ol type="1">
                    <li>
                        Jabatan adalah kedudukan yang menunjukan tugas, tanggung jawab dan wewenang Pekerja dalam organisasi <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                        Peraturan Perusahaan adalah seluruh ketentuan di bidang Perusahaan yang mengatur mengenai hak dan kewajiban Pekerja
                        serta mekanisme pengelolaan sumber daya manusia <span>PIHAK PERTAMA</span> yang penyusunan dan penyempurnaannya menjadi
                        kewenangan <span>PIHAK PERTAMA</span>, dengan tetap memperhatikan masukan dari Pekerja <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                        Unit Kerja atau Proyek adalah Unit Kerja atau Proyek <span>PIHAK PERTAMA</span> yang berada di dalam dan di luar negeri.
                    </li>
                    <li>
                        Pihak Klien adalah Pihak Perusahaan yang menyerahkan sebagian pelaksanaan pekerjaan kepada <span>PIHAK PERTAMA</span>.
                    </li>
                </ol>
            </div>
            <br><br><br><br><br><br><br>
            <div class="article-2">
                <div class="article-2-header">
                    <div>Pasal 2</div>
                    <div>RUANG LINGKUP PEKERJAAN</div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK PERTAMA</span> mempekerjakan <span>PIHAK KEDUA</span> sebagai Pekerja Tetap dengan Jabatan <span>{{$contract->position}}</span>
                    </li>
                    <li>
                        <span>PIHAK PERTAMA</span> dapat menempatkan dan memindahkan <span>PIHAK KEDUA</span> dari satu Jabatan dan/ atau Unit Kerja ke Jabatan
                        dan/ atau Unit Kerja lain di lingkungan <span>PIHAK PERTAMA</span> sesuai kebutuhan dan ketentuan yang berlaku di <span>PIHAK
                        PERTAMA</span>.
                    </li>
                </ol>
            </div>
            <div class="article-3">
                <div class="article-3-header">
                    <div>Pasal 3</div>
                    <div>PENUGASAN</div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK KEDUA</span> akan ditugaskan oleh <span>PIHAK PERTAMA</span> untuk melaksanakan pekerjaan pada Unit Kerja atau Proyek yang
                        berada di Pihak Klien.
                    </li>
                    <li>
                        Penugasan sebagaimana yang dimaksud dalam ayat (1) Pasal ini akan dibuat Surat Penugasan dari <span>PIHAK PERTAMA</span> kepada
                        <span>PIHAK KEDUA</span> dan merupakan satu kesatuan yang tidak terpisahkan dengan Perjanjian ini.

                    </li>
                </ol>
            </div>
            <div class="article-4">
                <div class="article-4-header">
                    <div>Pasal 4</div>
                    <div>JANGKA WAKTU PERJANJIAN KERJA</div>
                </div>
            Perjanjian Kerja dibuat untuk jangka waktu tidak tertentu sampai dengan usia pensiun yang ditetapkan dalam peraturan perusahaan,
            berlaku terhitung mulai tanggal <span>{{$contract->start_date_day_numb}}</span> <span>{{$contract->start_date_month}}</span> <span>{{$contract->start_date_year}}</span>.
            </div>
            <div class="article-5">
                <div class="article-5-header">
                    <div>Pasal 5</div>
                    <div>HAK DAN KEWAJIBAN <span>PIHAK PERTAMA</span></div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK PERTAMA</span> berhak menerima laporan hasil pekerjaan <span>PIHAK KEDUA</span> sesuai tugas-tugas sebagaimana dituangkan
                        secara rinci dalam bentuk Uraian Pekerjaan (Job Description).
                    </li>
                    <li>
                        <span>PIHAK PERTAMA</span> dan/ atau wakil yang sah wajib memberikan penjelasan perihal isi Perjanjian Kerja ini kepada <span>PIHAK
                        KEDUA</span>, yang terdokumentasi dalam Berita Acara Penjelasan Perjanjian Kerja yang ditandatangani dan merupakan satu
                        kesatuan yang tidak terpisahkan dengan Perjanjian Kerja ini.
                    </li>
                </ol>
            </div>
            <div class="article-6">
                <div class="article-6-header">
                    <div>Pasal 6</div>
                    <div>HAK DAN KEWAJIBAN <span>PIHAK KEDUA</span></div>
                </div>
                <ol>
                    <li>
                        <span>PIHAK KEDUA</span> berhak menerima Gaji, Tunjangan dan Fasilitas yang berlaku bagi Pekerja Tetap dari <span>PIHAK PERTAMA</span>
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> wajib tunduk pada ketentuan yang berlaku di <span>PIHAK PERTAMA</span> yang dituangkan dalam Peraturan
                        Perusahaan, peraturan lainnya yang berlaku di <span>PIHAK PERTAMA</span>, dan Peraturan Perundang-undangan yang berlaku, serta
                        menjaga kepentingan, data, dokumen dan peralatan <span>PIHAK PERTAMA</span> dengan sebaik-baiknya, termasuk namun tidak
                        terbatas pada :

                        <ol type="a">
                            <li>Melaksanakan tugas yang telah ditetapkan oleh <span>PIHAK PERTAMA</span> dengan sebaik-baiknya.</li>
                            <li>Bertanggung jawab atas segala tugas yang diberikan <span>PIHAK PERTAMA</span>.
                            </li>
                            <li>Mengganti dan menyelesaikan segala kerugian yang diderita <span>PIHAK PERTAMA</span> sebagai akibat kelalaian atau
                                penyimpangan <span>PIHAK KEDUA</span> dalam melaksanakan tugas atau <span>PIHAK KEDUA</span> dinyatakan tidak melaksanakan
                                dengan baik kewajiban sebagaimana dimaksud dalam Pasal ini.
                            </li>
                            <li>Bersedia ditempatkan di seluruh Posisi Jabatan dan Unit Kerja <span>PIHAK PERTAMA</span>.</li>
                            <li>Tidak memberikan keterangan-keterangan tentang rahasia perusahaan <span>PIHAK PERTAMA</span>, baik selama terikat dalam
                                Perjanjian Kerja ini maupun setelah berakhirnya Perjanjian Kerja.
                            </li>
                            <li>Tidak memberikan keterangan pada media cetak dan media elektronik serta media lain, tidak pula membicarakan di
                                luar hubungan jabatan segala persoalan yang diperoleh mengenai <span>PIHAK PERTAMA</span>, terkecuali dengan ijin <span>PIHAK
                                PERTAMA</span>.
                            </li>
                            <li>Tidak melakukan suatu perbuatan yang melanggar peraturan yang berlaku di <span>PIHAK PERTAMA</span> maupun peraturan
                                perundang-undangan yang berlaku, yang tidak sesuai dengan etika, moral dan kesusilaan atau yang tidak sepatutnya
                                dikerjakan oleh Pekerja Tetap yang baik, termasuk namun tidak terbatas pada kegiatan pornografi, berzina, berjudi,
                                dan menggunakan obat terlarang.
                            </li>
                        </ol>
                    </li>
                    <li><span>PIHAK KEDUA</span> wajib menjamin bahwa seluruh dokumen, keterangan, data dan informasi yang diberikan atau diserahkan
                        kepada <span>PIHAK PERTAMA</span> lengkap, benar dan sesuai dengan ketentuan dari <span>PIHAK PERTAMA</span>.
                    </li>
                    <li><span>PIHAK KEDUA</span> wajib menjamin bahwa sebelum perjanjian ini disepakati, <span>PIHAK KEDUA</span> tidak pernah melakukan perbuatan
                        yang melanggar peraturan maupun perundang-undangan yang berlaku atau tidak sesuai etika, moral dan kesusilaan,
                        termasuk namun tidak terbatas pada kegiatan memberikan keterangan palsu (tidak sesuai fakta), fraud, pornografi, berzina,
                        berjudi, dan menggunakan obat terlarang, yang dapat merugikan <span>PIHAK PERTAMA</span> setelah disepakatinya perjanjian ini.
                    </li>
                </ol>
            </div>
            <div class="article-7">
                <div class="article-7-header">
                    <div>Pasal 7</div>
                    <div>GAJI, TUNJANGAN DAN FASILITAS</div>
                </div>
                <ol type="1">
                    <li>
                    <span>PIHAK KEDUA</span> menerima Gaji dari <span>PIHAK PERTAMA</span> yang terdiri dari Gaji Pokok dan Tunjangan dengan perincian sebagai
                        <table>
                            <tr>
                                <td>a)</td>
                                <td>Gaji Pokok</td>
                                <td>&nbsp;:&nbsp;<span>{{$contract->basic_salary}}</span></td>
                            </tr>
                            <tr>
                                <td>b)</td>
                                <td>Makan & Transportasi  </td>
                                <td>&nbsp;:&nbsp;<span>{{$contract->allowance_salary}}</span></td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                            <tr>
                                <td colspan="2">Total Gaji kotor  </td><td>&nbsp;:&nbsp;<span>{{$contract->total}}</span></td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        Atas Gaji dan Tunjangan sebagaimana dimaksud dalam ayat (1) Pasal ini <span>PIHAK PERTAMA</span> dapat melakukan perubahan
                        sesuai dengan kebijakan perusahaan tanpa harus melakukan pemberitahuan kepada <span>PIHAK KEDUA</span> maupun melakukan
                        addendum terhadap perjanjian ini.
                    </li>
                    <li>
                        Pembayaran Gaji sebagaimana dimaksud dalam ayat (1) Pasal ini dilakukan <span>PIHAK PERTAMA</span> setiap bulan pada tanggal 28
                        (dua puluh delapan)
                    </li>
                    <li>Dalam hal tanggal <span>{{$contract->pay_tgl}}</span> sebagaimana dimaksud dalam ayat (2) tersebut di atas bertepatan dengan hari
                        libur, maka pembayaran gaji dilakukan pada hari kerja terakhir sebelum tanggal <span>{{$contract->pay_tgl}}</span> bulan yang
                        bersangkutan.
                    </li>
                    <li><span>PIHAK PERTAMA</span> memberikan Gaji dan Fasilitas lainnya sesuai ketentuan yang berlaku bagi Pekerja Tetap di <span>PIHAK
                        PERTAMA</span>, termasuk namun tidak terbatas pada :
                        <ol type="a">
                            <li>Uang lembur atas kelebihan jam kerja lembur ditetapkan sesuai dengan ketentuan yang berlaku bagi <span>PIHAK KEDUA</span>
                                di Pihak Klien.
                            </li>
                            <li>Fasilitas dan lumpsum biaya perjalanan dinas berdasarkan ketentuan yang berlaku bagi Pekerja Tetap di PIHAK
                                PERTAMA yang disetarakan dengan golongan jabatannya sebagaimana dimaksud dalam Pasal 2 ayat (1) Perjanjian
                                Kerja, dalam hal <span>PIHAK KEDUA</span> ditugaskan untuk melaksanakan perjalanan dinas oleh <span>PIHAK PERTAMA</span>.
                            </li>
                            <li>Cuti dan Tunjangan Cuti berdasarkan ketentuan yang berlaku bagi Pekerja Tetap <span>PIHAK PERTAMA</span> yang
                                disetarakan dengan golongan jabatannya sebagaimana dimaksud dalam Pasal 2 ayat (1) Perjanjian Kerja.
                            </li>
                            <li>Tunjangan Hari Raya Keagamaan (THRK).</li>
                        </ol>
                    </li>
                    <li> Kecuali diatur lain dalam ketentuan yang berlaku bagi Pekerja Tetap di <span>PIHAK PERTAMA</span>, Pajak Penghasilan atas Gaji dan
                        Fasilitas yang diterima <span>PIHAK KEDUA</span> menjadi beban <span>PIHAK KEDUA</span>.
                    </li>
                    <li><span>PIHAK KEDUA</span> dengan ini memberikan kewenangan dan kuasa kepada <span>PIHAK PERTAMA</span> untuk melakukan pemotongan,
                        terhadap Gaji, Tunjangan lainnya, Fasilitas, dan/ atau segala pembayaran baik tunai maupun non tunai yang diterima oleh
                        <span>PIHAK KEDUA</span> baik untuk kepentingan <span>PIHAK PERTAMA</span>, <span>PIHAK KEDUA</span> maupun Pihak Ketiga lainnya sesuai ketentuan
                        yang berlaku di <span>PIHAK PERTAMA</span>, termasuk namun tidak terbatas untuk kepentingan Pajak dan JAMSOSTEK.
                    </li>
                    <li>Gaji dan Fasilitas yang diterima <span>PIHAK KEDUA</span> dalam bentuk tunai dibayarkan <span>PIHAK PERTAMA</span> melalui pemindahbukuan
                        ke rekening <span>PIHAK KEDUA</span> Nomor BANK <span>{{$contract->bank_name}}</span>. di <span>{{$contract->bank_ac}}</span>
                    </li>
                </ol>
            </div>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Pasal 8</div>
                    <div>PELANGGARAN</div>
                </div>
                <ol type="1">
                    <li>
                        Dalam hal <span>PIHAK KEDUA</span> tidak hadir secara penuh selama jam kerja, maka Gaji Pokok yang diterima <span>PIHAK KEDUA</span>
                        dikenakan pengurangan dengan perhitungan pengurangan berdasarkan ketentuan yang berlaku bagi Pekerja Tetap di <span>PIHAK
                        PERTAMA</span>.
                    </li>
                    <li>
                        Dalam hal <span>PIHAK KEDUA</span> melanggar atau tidak memenuhi ketentuan dalam Perjanjian Kerja ini dan atau melanggar atau
                        tidak memenuhi ketentuan yang berlaku bagi Pekerja Tetap di <span>PIHAK PERTAMA</span>, maka <span>PIHAK PERTAMA</span> dapat
                        menjatuhkan Hukuman Disiplin kepada <span>PIHAK KEDUA</span> sesuai Peraturan Disiplin yang berlaku di <span>PIHAK PERTAMA</span>
                    </li>
                </ol>
            </div>
            <br><br><br><br><br>
            <div class="article-9">
                <div class="article-9-header">
                    <div>Pasal 9</div>
                    <div>PEMUTUSAN PERJANJIAN KERJA</div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK PERTAMA</span> dapat melakukan Pemutusan Hubungan Kerja dalam hal <span>PIHAK KEDUA</span> :
                        <ol>
                            <li>Mengundurkan diri atas permintaan sendiri;</li>
                            <li>Tidak cakap melaksanakan tugas dengan wajar sesuai dengan ketentuan yang berlaku di <span>PIHAK PERTAMA</span> dan/ atau
                                Pihak Klien;
                            </li>
                            <li>Adanya kelebihan tenaga kerja (rasionalisasi);</li>
                            <li>Mencapai usia pensiun yang ditetapkan sesuai Peraturan Perusahaan;</li>
                            <li>Ditahan pihak yang berwajib:</li>
                            <li>Dijatuhi Hukuman disiplin;</li>
                            <li>Dinyatakan bersalah berdasarkan Putusan Pengadilan;</li>
                            <li>Dikualifikasikan mengundurkan diri karena tidak masuk kerja tanpa kabar (mangkir);</li>
                            <li>Alasan kesehatan;</li>
                            <li>Pekerja meninggal dunia; atau</li>
                            <li>Alasan PHK lainnya sesuai peraturan perundang-undangan yang berlaku;</li>
                        </ol>
                    </li>
                    <li>Pemutusan Hubungan Kerja sebagaimana dimaksud dalam ayat (1) Pasal ini disampaikan secara tertulis oleh <span>PIHAK
                        PERTAMA</span> kepada <span>PIHAK KEDUA</span>.
                    </li>
                    <li>Dalam hal <span>PIHAK PERTAMA</span> melakukan Pemutusan Hubungan Kerja, maka <span>PIHAK PERTAMA</span> memberikan Uang
                        Pesangon, Uang Penghargaan Masa Kerja, Penggantian Hak, Uang Pisah dan/ atau hak-hak lainnya kepada <span>PIHAK KEDUA</span>
                        sesuai Peraturan Perusahaan yang berlaku di <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>Dengan tetap memperhatikan ketentuan sebagaimana dimaksud dalam Pasal ini, <span>PIHAK KEDUA</span> diwajibkan :
                        <ol>
                            <li>Mengganti sejumlah kerugian yang telah ditimbulkan sebagaimana dimaksud dalam Pasal 6 ayat (2) huruf c Perjanjian
                                Kerja ini;</li>
                            <li>Menyelesaikan dan/ atau melunasi seluruh kewajiban dan/ atau seluruh utangnya yang masih tersisa pada <span>PIHAK
                                PERTAMA</span> dan/ atau lembaga intern lainnya di <span>PIHAK PERTAMA</span> dan/ atau di Pihak Klien.
                            </li>
                        </ol>
                    </li>
                    <li>Hak-hak <span>PIHAK KEDUA</span> akibat Pemutusan Hubungan Kerja sebagaimana dimaksud dalam ayat (3) Pasal ini, diberikan
                        setelah diperhitungkan terlebih dahulu dengan kewajiban <span>PIHAK KEDUA</span> kepada <span>PIHAK PERTAMA</span> dan/ atau lembaga
                        intern lainnya di <span>PIHAK PERTAMA</span> dan/ atau di Pihak Klien.
                    </li>
                    <li>Pembayaran kewajiban sebagaimana dimaksud dalam ayat (4) dan ayat (5) Pasal ini harus dipenuhi dalam waktu selambatlambatnya 1 (satu) bulan sejak tanggal Pemutusan Hubungan Kerja</li>
                    <li>Dalam hal kewajiban tidak dipenuhi <span>PIHAK KEDUA</span> dalam jangka waktu yang ditetapkan dalam ayat (6) Pasal ini, baik
                        sebagian maupun seluruhnya, maka <span>PIHAK PERTAMA</span> dapat melakukan penagihan melalui media massa dan/ atau
                        menyerahkan penyelesaiannya melalui Saluran Hukum dan/ atau mendebet secara langsung dana pada rekening <span>PIHAK
                        KEDUA</span>
                    </li>
                </ol>
            </div>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Pasal 10</div>
                    <div>KUASA-KUASA</div>
                </div>
                <ol type="1">
                    <li>
                        Untuk kepentingan <span>PIHAK PERTAMA</span> dan atau kepentingan pihak lain, dengan ini <span>PIHAK KEDUA</span> memberi kuasa kepada
                        <span>PIHAK PERTAMA</span> sebagai berikut :
                        <ol>
                            <li>KUASA MEMBLOKIR DAN ATAU MENDEBET REKENING
                                <ol>
                                    <li><span>PIHAK PERTAMA</span> dengan ini diberi kuasa oleh <span>PIHAK KEDUA</span> untuk sewaktu-waktu memotong, mendebet,
                                        memindahbukukan dan/ atau memblokir rekening dan/ atau dana yang terdapat di dalam rekening PIHAK
                                        KEDUA yang ada pada <span>PIHAK PERTAMA</span> (termasuk rekening lain yang secara hukum penarikan dan
                                        transaksinya berada di dalam kekuasaan dan kewenangan <span>PIHAK KEDUA</span>), dengan ketentuan telah terjadi
                                        salah satu atau lebih hal-hal sebagai berikut :
                                        <ol>
                                            <li><span>PIHAK KEDUA</span> masih mempunyai utang dan/ atau kewajiban lain yang belum diselesaikan kepada
                                                <span>PIHAK PERTAMA</span>; atau</li>
                                            <li>Berdasarkan temuan auditor, temuan tim yang dibentuk oleh unit kerja, dan/ atau alat bukti yang ada,
                                                <span>PIHAK KEDUA</span> patut diduga telah melakukan perbuatan yang bertentangan dengan ketentuan yang
                                                berlaku yang berpotensi atau telah menimbulkan kerugian bagi <span>PIHAK PERTAMA</span>;
                                            </li>
                                        </ol>
                                    </li>
                                    <li>Dalam hal <span>PIHAK PERTAMA</span> memotong, mendebet dan/ atau memindahbukukan dana yang terdapat dalam
                                        rekening <span>PIHAK KEDUA</span> sebagaimana kuasa di atas, <span>PIHAK PERTAMA</span> wajib membayarkan dana hasil
                                        pendebetan dan/ atau pemindahbukuan tersebut untuk :

                                        <ol>
                                            <li>Membayar utang dan/ atau kewajiban <span>PIHAK KEDUA</span> kepada <span>PIHAK PERTAMA</span>; dan/ atau</li>
                                            <li>Membayar utang dan/ atau kewajiban <span>PIHAK KEDUA</span> kepada pihak lain yang memiliki kaitan secara
                                                langsung dan timbul selama masa hubungan kerja dengan <span>PIHAK PERTAMA</span>.
                                            </li>
                                        </ol>
                                    </li>
                                </ol>
                            </li>
                            <li>KUASA MEMINTA ATAU MEMBERI INFORMASI REKENING
                                <ol>
                                    <li><span>PIHAK PERTAMA</span> dengan ini diberi kuasa oleh <span>PIHAK KEDUA</span> untuk bertemu dan menghadap bank atau
                                        pihak lain maupun juga, tanpa ada yang dikecualikan, untuk melakukan salah satu atau lebih hal-hal sebagai
                                        berikut:
                                        <ol>
                                            <li>Meminta, menerima dan menandatangani tanda terimanya segala informasi mengenai rekeningrekening dan/ atau account-account atas nama <span>PIHAK KEDUA</span>, tanpa ada yang dikecualikan,
                                                termasuk informasi yang merupakan Rahasia Bank; dan/ atau
                                            </li>
                                            <li>Melihat dan memeriksa segala informasi dan mutasi rekening <span>PIHAK KEDUA</span> yang ada pada PIHAK
                                                PERTAMA atau pihak lainnya; dan/ atau
                                            </li>
                                            <li>Memberitahukan segala informasi mengenai rekening <span>PIHAK KEDUA</span> tersebut, termasuk informasi
                                                yang merupakan Rahasia Bank, kepada pihak lain manapun juga.
                                            </li>
                                        </ol>
                                    </li>
                                    <li>Meminta atau memberi informasi rekening dilakukan ketika telah terjadi salah satu atau lebih kondisi atau
                                        hal-hal sebagai berikut :
                                        <ol>
                                            <li><span>PIHAK KEDUA</span> masih mempunyai utang dan/ atau kewajiban lain yang belum diselesaikan kepada
                                                <span>PIHAK PERTAMA</span>; atau
                                            </li>
                                            <li>Berdasarkan temuan auditor, temuan tim yang dibentuk oleh unit kerja, dan/ atau alat bukti yang ada,
                                                <span>PIHAK KEDUA</span> patut diduga telah melakukan perbuatan yang bertentangan dengan ketentuan yang
                                                berlaku yang berpotensi atau telah menimbulkan kerugian bagi <span>PIHAK PERTAMA</span>.
                                            </li>
                                        </ol>
                                    </li>
                                    <li>Yang dimaksud dengan rekening atau account <span>PIHAK KEDUA</span> adalah segala macam rekening dan atau
                                        account milik <span>PIHAK KEDUA</span> tanpa ada yang dikecualikan, termasuk tetapi tidak terbatas rekening
                                        tabungan, deposito, giro, saham, reksadana, DPLK, Manfaat Pensiun, Jamsostek dan lain sebagainya.
                                    </li>
                                </ol>
                            </li>
                            <li>KUASA MEMPERJUMPAKAN UTANG
                                <br>
                                <span>PIHAK KEDUA</span> dengan ini memberi kuasa kepada <span>PIHAK PERTAMA</span> untuk memperjumpakan segala utang dan/
                                atau kewajiban <span>PIHAK KEDUA</span> kepada <span>PIHAK PERTAMA</span> yang timbul karena perjanjian ini, maupun karena
                                perjanjian-perjanjian lain dengan <span>PIHAK PERTAMA</span> dengan piutang-piutang <span>PIHAK KEDUA</span> yang ada pada PIHAK
                                PERTAMA yang berupa, tetapi tidak terbatas pada tabungan-tabungan, simpanan-simpanan dan/ atau rekeningrekening lain milik <span>PIHAK KEDUA</span> yang ada pada <span>PIHAK PERTAMA</span>, termasuk pembayaran-pembayaran dari Pihak
                                Ketiga kepada <span>PIHAK KEDUA</span> yang dibayarkan melalui <span>PIHAK PERTAMA</span>.
                            </li>
                        </ol>
                    </li>
                </ol>
                Kuasa-kuasa yang diberikan oleh <span>PIHAK KEDUA</span> kepada <span>PIHAK PERTAMA</span> ini tidak dapat dicabut, dibatalkan, dan/ atau diakhiri
                secara sepihak oleh <span>PIHAK KEDUA</span>. <span>PARA PIHAK</span> sepakat bahwa kuasa-kuasa dimaksud tidak berakhir karena sebab-sebab yang
                ditetapkan oleh undang-undang maupun oleh sebab lain apapun juga. Kuasa-kuasa tersebut merupakan bagian yang tidak dapat
                dipisahkan dari perjanjian ini yang tanpa adanya kuasa-kuasa tersebut perjanjian ini tidak dibuat.
            </div>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Pasal 11</div>
                    <div>PERSELISIHAN</div>
                </div>
                <ol type="1">
                    <li>
                        Dalam hal terjadi perselisihan dalam penafsiran dan Pelaksanaan Perjanjian Kerja ini, <span>PARA PIHAK</span> sepakat untuk sedapat
                        mungkin menyelesaikan secara musyawarah untuk mencapai mufakat.
                    </li>
                    <li>
                        Dalam hal cara musyawarah tidak mencapai kesepakatan, maka <span>PARA PIHAK</span> sepakat untuk menyelesaikannya melalui
                        saluran hukum.
                    </li>
                    <li>Untuk Perjanjian Kerja ini dan segala akibatnya, <span>PARA PIHAK</span> sepakat memilih domisili tetap di Kantor Kepaniteraan
                        Pengadilan Negeri Jakarta Pusat
                    </li>
                </ol>
            </div>
            <br><br><br><br><br><br><br><br><br>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Pasal 12</div>
                    <div>PENUTUP</div>
                </div>
                <ol type="1">
                    <li>
                        Hal-hal yang belum atau tidak cukup diatur dalam Perjanjian Kerja ini, akan diatur kemudian atas dasar pemufakatan bersama
                        oleh <span>PARA PIHAK</span> yang akan dituangkan dalam bentuk Surat atau Perjanjian Tambahan (Addendum) yang merupakan satu
                        kesatuan yang tidak dapat dipisahkan dari Perjanjian Kerja ini.
                    </li>
                    <li>
                        Perjanjian Kerja ini dibuat dalam rangkap 2 (dua) masing-masing bermeterai cukup dan mempunyai kekuatan hukum yang
                        sama dengan rangkap pertama dipegang oleh <span>PIHAK PERTAMA</span> dan rangkap kedua dipegang oleh <span>PIHAK KEDUA</span>.
                    </li>
                    <li>Perjanjian Kerja ini mulai berlaku dan mengikat <span>PARA PIHAK</span> sejak ditandatangani</li>
                    <li><span>PIHAK PERTAMA</span> dan <span>PIHAK KEDUA</span> setuju meskipun perjanjian telah berakhir, ketentuan pasal-pasal berikut tetap
                        berlaku :
                        <ol>
                            <li>Pasal tentang pelanggaran;</li>
                            <li>Pasal tentang Pemutusan Hubungan Kerja;</li>
                            <li>Pasal tentang Kuasa-Kuasa;</li>
                            <li>Pasal tentang Perselisihan; dan</li>
                            <li>Pasal tentang Penutup.</li>
                        </ol>
                    </li>
                </ol>
            </div>
            <div class="content-sign">
                <div class="content-left">
                    <div class="sign-header"><span>PIHAK PERTAMA</span></div>
                    <div class="sign-name">{{$contract->approver}}<br>{{$contract->approver_position2}}</div>
                </div>
                <div class="content-right">
                    <div class="sign-header"><span>PIHAK KEDUA</span></div>
                    <div class="sign-name">{{$contract->name}}<br>{{$contract->position}}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>