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
            content: "Page " counter(page) " of 1";
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
            margin-bottom: 65px;
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
            <div>ADDENDUM pERJANJIAN kERJA</div>
            <div>ANTARA</div>
            <div>PT ELABRAM SYSTEMS</div>
            <div>DENGAN</div>
            <div>{{$contract->name}}</div>
        </div>
        <div class="content-number">
            Nomor: {{$contract->let_no_out}}
        </div>
        <div class="content-text">
            <div class="content-introduction">
                Pada hari ini <span>{{$contract->today_day}}</span> tanggal <span>{{$contract->today_day_numb}}</span> bulan <span>{{$contract->today_month}}</span> tahun <span>{{$contract->today_year}}</span>
                (<span>{{$contract->now}}</span>),  yang bertandatangan di bawah ini :
            </div>
            <div class="content-party">
                <ol type="1">
                    <li>
                        PT Elabram Systems suatu perseroan terbatas yang didirikan berdasarkan hukum Negara Republik Indonesia, beralamat di
                        Gedung Thamrin City, Pusat Bisnis Thamrin City Lt. 7, Unit OS 01 A, B, dan OS 02 A, B, C, Jl. Thamrin Boulevard
                        (d/h Jl. Kebon Kacang Raya), Jakarta Pusat 10230,- dalam hal ini diwakili oleh <span>{{$contract->approver}}</span>, untuk selanjutnya disebut
                        sebagai <span>PERUSAHAAN</span>.
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
                    </li>
                </ol>
                untuk selanjutnya disebut <span>PEKERJA</span>.
            </div>
            <div class="content-introduction">
                Terlebih dahulu kedua belah pihak menerangkan bahwa antara <span>PERUSAHAAN</span> dan <span>PEKERJA</span> telah ditandatangani
                perjanjian kerja No. (<span>{{$contract->cont_no_new}}</span>) Berdasarkan hal tersebut di atas, <span>PERUSAHAAN</span> dan <span>PIHAK
                KEDUA</span> sepakat dan mengikatkan diri untuk melakukan Addendum perjanjian kerja menjadi sebagai berikut :
            </div>
            <div class="article-1">
                <div class="article-1-header">
                    <div>Pasal 1</div>
                </div>
                Mengubah Pasal 3 perjanjian kerja menjadi sebagai berikut.:
                <ol type="1">
                    <li>
                    perjanjian kerja diperpanjang selama {{$contract->interval_contract}} bulan terhitung mulai tanggal <span>{{$contract->start_date_day_numb}}</span> <span>{{$contract->start_date_month}}</span> <span>{{$contract->start_date_year}}</span> dan akan berakhir pada tanggal
                    <span>{{$contract->end_date_day_numb}}</span> <span>{{$contract->end_date_month}}</span> <span>{{$contract->end_date_year}}</span>, kecuali diperbaharui berdasarkan kesepakatan kedua belah pihak atau diputuskan sesuai dengan kondisi
                    yang tercantum dalam Perjanjian ini. Bila perjanjian kerja ini tidak akan diperbaharui, <span>PERUSAHAAN</span> akan
                    melakukan pemberitahuan peringatan akhir masa perjanjian kepada <span>PEKERJA</span> dalam periode empat (4) minggu
                    </li>
                </ol>
            </div>
            <div class="article-2">
                <div class="article-2-header">
                    <div>Pasal 2</div>
                </div>
                <ol type="1">
                    <li>
                        Addendum perjanjian kerja ini mulai berlaku dan mengikat kedua belah pihak sejak tanggal <span>{{$contract->start_date_day_numb}}</span> <span>{{$contract->start_date_month}}</span> <span>{{$contract->start_date_year}}</span> sd <span>{{$contract->end_date_day_numb}}</span> <span>{{$contract->end_date_month}}</span> <span>{{$contract->end_date_year}}</span> (jangka waktu kontrak).
                    </li>
                    <li>
                        Addendum perjanjian kerja ini merupakan bagian yang tidak terpisahkan dari perjanjian kerja, dengan demikian
                        mempunyai kekuatan hukum yang sama mengikat dengan Pasal-Pasal lain dalam perjanjian kerja.

                    </li>
                    <li>
                        Ketentuan lain yang telah diatur dalam perjanjian kerja yang tidak secara tegas diubah dengan Addendum Perjanjian
                        Kerja ini tetap berlaku dan mengikat <span>PARA PIHAK</span>.
                    </li>
                    <li>
                        Addendum perjanjian kerja ini dibuat dan ditandatangani oleh <span>PARA PIHAK</span> dalam rangkap 2 (dua); dan mempunyai
                        kekuatan hukum yang sama dan mengikat <span>PARA PIHAK</span> tanpa ada pengecualian.
                    </li>
                </ol>
            </div>
            <div class="content-sign">
                <div class="content-left">
                    <div class="sign-header"><span><span>PERUSAHAAN</span></span></div>
                    <div class="sign-name">{{$contract->approver}}<br>{{$contract->approver_position2}}</div>
                </div>
                <div class="content-right">
                    <div class="sign-header"><span><span>PEKERJA</span></span></div>
                    <div class="sign-name">{{$contract->name}}<br>{{$contract->position}}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
