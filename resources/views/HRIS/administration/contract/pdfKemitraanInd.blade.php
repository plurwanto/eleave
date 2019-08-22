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
            content: "Page " counter(page) " of 4";
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
            <div>PERJANJIAN KEMITRAAN</div>
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
                Pada hari <span>{{$contract->today_day}}</span> tanggal <span>{{$contract->today_day_numb}}</span> bulan <span>{{$contract->today_month}}</span> tahun <span>{{$contract->today_year}}</span>
                (<span>{{$contract->now}}</span>), yang bertandatangan di bawah ini :
            </div>
            <div class="content-party">
                <ol type="1">
                    <li>
                        <span>{{$contract->approver}}</span>, dalam kedudukannya selaku <span>{{$contract->approver_position}}</span> PT Elabram Systems dalam hal ini
                        bertindak dalam jabatannya tersebut mewakili PT Elabram Systems berdasarkan Surat Kuasa Khusus Nomor
                        2018/PTES/SK/02-26-I, oleh karena itu berdasarkan Anggaran Dasar Perseroan yang dimuat dalam Akta Pendirian Perusahaan
                        No. 14, tanggal Sebelas bulan Oktober tahun Dua Ribu Lima (11-10-2005) dibuat dihadapan Sri Intansih, S.H., Notaris di
                        Jakarta dan telah disahkan melalui SK Menteri Hukum dan Hak Asasi Manusia tanggal Sembilan Belas bulan Oktober tahun
                        Dua Ribu Lima (19-10-2005), dengan perubahan terakhir Anggaran Dasar Perseroan yang dimuat dalam terakhir telah diubah
                        dengan Akta Nomor 01 tanggal 07 Agustus 2014 yang dibuat dihadapan Ummu Imama SH, Notaris di Jakarta,, berkedudukan
                        di Gedung Thamrin City Tower, Pusat Bisnis Thamrin City, 7th Floor, Jl. Thamrin Boulevard (d/h Jl. Kebon Kacang Raya),
                        Jakarta Pusat, 10230, Indonesia, untuk selanjutnya disebut <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                        <table>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Nama</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->name}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->gender}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Tempat dan Tanggal Lahir</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->mem_dob_city}}</span>, <span>{{$contract->dob_day_numb}}</span> <span>{{$contract->dob_month}}</span> <span>{{$contract->dob_year}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Alamat</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->address}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>No. {{$contract->identitas}}</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->id_number}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Umur</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->age}}</span></td>
                            </tr>
                        </table>
                    </li>
                </ol>
            </div>
            <div class="content-introduction">
                Dalam hal ini bertindak untuk dan atas nama dirinya sendiri, selanjutnya disebut <span>PIHAK KEDUA</span>. <span>PIHAK PERTAMA</span> dan <span>PIHAK
                KEDUA</span> yang selanjutnya secara bersama-sama disebut <span>PARA PIHAK</span> dengan ini menyatakan setuju untuk mengadakan Perjanjian
                Kemitraan yang untuk selanjutnya di sebut Perjanjian berdasarkan ketentuan-ketentuan dan syarat-syarat sebagai berikut :
            </div>
            <div class="article-1">
                <div class="article-1-header">
                    <div>Pasal 1</div>
                    <div>RUANG LINGKUP PEKERJAAN</div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK PERTAMA</span> menugaskan <span>PIHAK KEDUA</span> sebagai Mitra untuk melaksanakan pekerjaan <span>{{$contract->position}}</span> dengan
                        tugas-tugas sebagaimana dituangkan secara rinci dalam bentuk Uraian Pekerjaan (Job Description) yang merupakan lampiran
                        yang tidak terpisahkan dengan Perjanjian ini.
                    </li>
                    <li>
                        <span>PIHAK PERTAMA</span> berhak menempatkan dan memindahkan <span>PIHAK KEDUA</span> dari satu Unit Kerja (Department) ke Unit Kerja
                        (Department) lain di lingkungan <span>PIHAK PERTAMA</span> sesuai kebutuhan dan ketentuan yang berlaku di <span>PIHAK PERTAMA</span>.
                    </li>
                </ol>
            </div>
            <div class="article-2">
                <div class="article-2-header">
                    <div>Pasal 2</div>
                    <div>JANGKA WAKTU PERJANJIAN</div>
                </div>
                <ol type="1">
                    <li>
                        Perjanjian dibuat untuk jangka waktu selama <span>{{$contract->interval_contract}}</span> bulan terhitung mulai tanggal <span>{{$contract->start_date_day_numb}}</span> <span>{{$contract->start_date_month}}</span> <span>{{$contract->start_date_year}}</span> sampai dengan tanggal  <span>{{$contract->end_date_day_numb}}</span> <span>{{$contract->end_date_month}}</span> <span>{{$contract->end_date_year}}</span>
                    </li>
                    <li>
                        Apabila <span>PIHAK PERTAMA</span> bermaksud memperpanjang Perjanjian ini, maka <span>PIHAK PERTAMA</span> akan memberitahukan secara
                        tertulis rencana perpanjangan Perjanjian.
                    </li>
                    <li>
                        Dalam hal Perjanjian telah berakhir karena sebab apapun, apabila masih terdapat kewajiban masing-masing Pihak yang timbul
                        sebelum perjanjian berakhir yang belum dilaksanakan oleh masing-masing pihak, maka masing-masing Pihak tersebut wajib
                        menjalankan kewajiban tersebut hingga selesai.
                    </li>
                </ol>
            </div>
            <div class="article-3">
                <div class="article-3-header">
                    <div>Pasal 3</div>
                    <div>HAK DAN KEWAJIBAN <span>PIHAK PERTAMA</span></div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK PERTAMA</span> berhak melakukan evaluasi terhadap tugas yang dilaksanakan <span>PIHAK KEDUA</span>.
                    </li>
                </ol>
            </div>
            <div class="article-4">
                <div class="article-4-header">
                    <div>Pasal 4</div>
                    <div>HAK DAN KEWAJIBAN <span>PIHAK KEDUA</span></div>
                </div>
                <ol type="1">
                    <li>
                        <span>PIHAK KEDUA</span> berhak menerima biaya atas pelaksanaan pekerjaan dari <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> wajib mematuhi yang berlaku di <span>PIHAK PERTAMA</span> dan peraturan lainnya yang berlaku di PIHAK
                        PERTAMA, serta menjaga kepentingan, data, dokumen dan peralatan <span>PIHAK PERTAMA</span> dengan sebaik-baiknya, termasuk
                        namun tidak terbatas pada :
                        <ol type="2">
                            <li>Melaksanakan tugas yang telah ditetapkan oleh <span>PIHAK PERTAMA</span> dengan sebaik-baiknya</li>
                            <li>Bertanggung jawab atas segala tugas yang diberikan <span>PIHAK PERTAMA</span>, termasuk namun tidak terbatas pada tugas
                                yang berhubungan dengan tugas dan tanggung jawab dalam pelaksanaan pekerjaan.
                            </li>
                            <li>Mengganti dan menyelesaikan segala kerugian yang diderita <span>PIHAK PERTAMA</span> sebagai akibat kelalaian atau
                                penyimpangan <span>PIHAK KEDUA</span> dalam melaksanakan tugas atau <span>PIHAK KEDUA</span> dinyatakan tidak melaksanakan
                                dengan baik kewajiban sebagaimana dimaksud dalam Pasal ini.
                            </li>
                            <li>Tidak memberikan keterangan-keterangan tentang rahasia perusahaan <span>PIHAK PERTAMA</span>, baik selama terikat dalam
                                Perjanjian ini maupun setelah berakhirnya Perjanjian.
                            </li>
                            <li>Tidak memberikan keterangan pada media cetak dan media elektronik serta media lain, tidak pula membicarakan
                                diluar pelaksanaan pekerjaan segala persoalan yang diperoleh mengenai <span>PIHAK PERTAMA</span>, terkecuali dengan izin
                                <span>PIHAK PERTAMA</span>.
                            </li>
                            <li>Tidak melakukan suatu perbuatan yang melanggar peraturan yang berlaku di <span>PIHAK PERTAMA</span> maupun peraturan
                                perundang-undangan yang berlaku atau perbuatan yang tidak sesuai dengan etika, moral dan kesusilaan atau yang
                                tidak sepatutnya dikerjakandalam melaksanakan pekerjaan pada umumnya, termasuk namun tidak terbatas pada
                                kegiatan pornografi, berzina berjudi dan menggunakan obat terlarang.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> wajib menjamin bahwa seluruh dokumen, keterangan, data dan informasi yang diberikan/diserahkan kepada
                        <span>PIHAK PERTAMA</span> lengkap, benar dan sesuai dengan ketentuan dari <span>PIHAK PERTAMA</span>.
                    </li>
                    <li>
                        <span>PIHAK KEDUA</span> wajib menjamin bahwa sebelum Perjanjian ini disepakati, <span>PIHAK KEDUA</span> tidak pernah melakukan perbuatan
                        yang melanggar peraturan <span>PIHAK PERTAMA</span> maupun perundang-undangan yang berlaku atau tidak sesuai dengan etika,
                        moral dan kesusilaan, termasuk namun tidak terbatas pada kegiatan memberikan keterangan palsu (tidak sesuai fakta), fraud,
                        pornografi, berzina, berjudi, dan menggunakan obat terlarang, yang dapat merugikan <span>PIHAK PERTAMA</span> setelah
                        disepakatinya Perjanjian ini.
                    </li>
                </ol>
            </div>
            <div class="article-5">
                <div class="article-5-header">
                    <div>Pasal 5</div>
                    <div>BIAYA PELAKSANAAN PEKERJAAN</div>
                </div>
                <ol type="1">
                    <li>
                        Biaya pelaksanaan pekerjaan yang dibayarkan <span>PIHAK PERTAMA</span> kepada <span>PIHAK KEDUA</span> sebesar <span>{{$contract->cur_id}}</span> <span>{{$contract->total}}</span>,-
                        (<span>{{$contract->total_spell}}</span> <span>{{$contract->cur_name}}</span>)
                    </li>
                    <li>
                        Pembayaran sebagaimana dimaksud dalam ayat (1) Pasal ini dilakukan <span>PIHAK PERTAMA</span> setiap tanggal <span>{{$contract->pay_tgl}}</span>
                    </li>
                    <li>
                        Dalam hal tanggal pembayaran sebagaimana dimaksud dalam ayat (2) tersebut di atas bertepatan dengan hari libur, maka
                        pembayaran dilakukan pada hari kerja sebelumnya.
                    </li>
                    <li>
                        Pembayaran yang diterima <span>PIHAK KEDUA</span> dalam bentuk tunai dibayarkan <span>PIHAK PERTAMA</span> melalui pemindahbukuan ke
                        rekening <span>PIHAK KEDUA</span> Nomor <span>{{$contract->bank_name}}</span> di <span>{{$contract->bank_ac}}</span>
                    </li>
                </ol>
            </div>
            <br><br><br><br><br><br><br>
            <div class="article-6">
                <div class="article-6-header">
                    <div>Pasal 6</div>
                    <div>PELANGGARAN</div>
                </div>
                <ol type="a">
                    <li>
                        Dalam hal <span>PIHAK KEDUA</span> melanggar/tidak memenuhi ketentuan dalam Perjanjian ini dan atau melanggar/tidak memenuhi
                        ketentuan yang berlaku, maka <span>PIHAK PERTAMA</span> dapat memberikan peringatan kepada <span>PIHAK KEDUA</span> secara tertulis.
                        Dalam waktu 14 (empat belas) hari kalender sejak peringatan tersebut, <span>PIHAK KEDUA</span> wajib memberikan
                        pertanggungjawaban.
                    </li>
                    <li>
                        Dalam hal jangka waktu 14 (empat belas) hari kalender terlampaui ternyata <span>PIHAK KEDUA</span> tidak memberikan
                        pertanggungjawaban, maka <span>PIHAK KEDUA</span> dianggap telah menerima apa yang dinyatakan dalam peringatan tersebut dan
                        <span>PIHAK PERTAMA</span> dapat memutuskan Perjanjian secara sepihak sebelum berakhirnya jangka waktu Perjanjian dan/atau
                        meminta <span>PIHAK KEDUA</span> memenuhi ketentuan dalam Perjanjian ini/ketentuan yang berlaku bagi Pekerja Kontrak di <span>PIHAK
                        PERTAMA</span>.
                    </li>
                    <li>
                        Dalam hal pertanggungjawaban yang diberikan <span>PIHAK KEDUA</span>, berdasarkan alasan dan pertimbangan yang jelas, tidak
                        dapat diterima oleh <span>PIHAK PERTAMA</span>, maka <span>PIHAK PERTAMA</span> dapat memutuskan Perjanjian secara sepihak sebelum
                        berakhirnya jangka waktu Perjanjian dan/atau meminta <span>PIHAK KEDUA</span> memenuhi ketentuan dalam Perjanjian ini/ketentuan
                        yang berlaku bagi Pekerja Kontrak di <span>PIHAK PERTAMA</span>.
                    </li>
                </ol>
            </div>
            <div class="article-7">
                <div class="article-7-header">
                    <div>Pasal 7</div>
                    <div>PEMUTUSAN PERJANJIAN</div>
                </div>
                <ol type="1">
                    <li>
                        Perjanjian antara <span>PIHAK PERTAMA</span> dengan <span>PIHAK KEDUA</span> berakhir dalam hal memenuhi salah satu dari ketentuan
                        sebagai berikut:
                        <ol type="2">
                            <li>Jangka waktu Perjanjian berakhir;</li>
                            <li><span>PIHAK KEDUA</span> meninggal dunia;</li>
                            <li>Disepakati oleh <span>PARA PIHAK</span>; atau</li>
                            <li>Diputuskan oleh salah satu PIHAK</li>
                            <li>Pekerjaan yang diberikan (project) oleh Rekanan telah selesai.</li>
                        </ol>
                    </li>
                    <li>
                        <span>PIHAK PERTAMA</span> dapat memutuskan Perjanjian secara sepihak sebelum berakhirnya jangka waktu Perjanjian tanpa
                        memberikan ganti rugi apapun dalam hal :
                        <ol type="2">
                            <li>
                                <span>PIHAK KEDUA</span> melanggar/tidak memenuhi ketentuan dalam Perjanjian ini
                            </li>
                            <li>
                                <span>PIHAK KEDUA</span> tidak mencapai target (no performance) berdasarkan evaluasi pelaksanaan pekerjaan.
                            </li>
                            <li>
                                Pekerjaan yang diberikan (project) dari Rekanan telah selesai sebelum berakhirnya jangka waktu perjanjian
                            </li>
                        </ol>
                    </li>
                    <li>
                        Dalam hal salah satu pihak mengakhiri Perjanjian secara sepihak sebelum berakhirnya jangka waktu Perjanjian bukan karena
                        alasan sebagaimana dimaksud dalam ayat (2) Pasal ini, maka pihak yang mengakhiri Perjanjian wajib memberikan ganti rugi
                        sebesar biaya sampai batas waktu berakhirnya Perjanjian.
                    </li>
                    <li>
                        Pemutusan Perjanjian sebagaimana dimaksud dalam Pasal ini wajib disampaikan secara tertulis oleh pihak yang mengakhiri
                        Perjanjian.
                    </li>
                    <li>Selanjutnya <span>PARA PIHAK</span> sepakat untuk melepaskan diri dari ketentuan Pasal 1266 Kitab Undang-undang Hukum Perdata
                        tentang Pemutusan dan Pembatalan Perjanjian.
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
                        Dalam hal terjadi perselisihan dalam penafsiran dan melaksanakan Perjanjian ini, <span>PARA PIHAK</span> sepakat untuk sedapat
                        mungkin menyelesaikan secara musyawarah.

                    </li>
                    <li>
                        Dalam hal cara musyawarah tidak mencapai kesepakatan, maka <span>PARA PIHAK</span> sepakat untuk menyelesaikannya melalui
                        saluran hukum.
                    </li>
                    <li>
                        Untuk Perjanjian ini dan segala akibatnya, <span>PARA PIHAK</span> sepakat memilih domisili tetap di Kantor Kepaniteraan Pengadilan
                        Negeri Jakarta Pusat
                    </li>
                </ol>
            </div>
            <br><br>
            <div class="article-9">
                <div class="article-9-header">
                    <div>Pasal 9</div>
                    <div>P E N U T U P</div>
                </div>
                <ol type="1">
                    <li>
                        Hal-hal yang belum atau tidak cukup diatur dalam Perjanjian ini, akan diatur kemudian atas dasar pemufakatan bersama <br> oleh
                        <span>PARA PIHAK</span> yang akan dituangkan dalam bentuk Surat atau Perjanjian Tambahan (Addendum) yang merupakan satu
                        kesatuan yang tidak dapat dipisahkan dari Perjanjian ini.
                    </li>
                    <li>
                        Lampiran-lampiran sebagaimana dimaksud dalam Perjanjian ini merupakan satu kesatuan yang tidak dapat dipisahkan dari
                        Perjanjian ini, sehingga Perjanjian ini tidak akan dibuat tanpa adanya lampiran-lampiran tersebut.
                    </li>
                    <li>
                        Perjanjian ini dibuat dalam rangkap 2 (dua) masing-masing bermeterai cukup dan mempunyai kekuatan hukum yang sama.
                        Rangkap pertama disimpan oleh <span>PIHAK PERTAMA</span> dan rangkap kedua disimpan oleh <span>PIHAK KEDUA</span>.
                    </li>
                    <li>
                        Perjanjian ini mulai berlaku dan mengikat <span>PARA PIHAK</span> sejak tanggal ditandatangani.
                    </li>
                </ol>
            </div>
            <div class="content-sign" style="margin-top:200px">
                <div class="content-left">
                    <div class="sign-header"><span>PIHAK PERTAMA</span></div>
                    <div class="sign-name">{{$contract->approver}}<br>({{$contract->approver_position2}})</div>
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
