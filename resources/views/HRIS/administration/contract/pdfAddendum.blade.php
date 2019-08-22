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
            <div>ADDENDUM OF PARTNERSHIP AGREEMENT</div>
            <div>BETWEEN</div>
            <div>PT ELABRAM SYSTEMS</div>
            <div>AND</div>
            <div>{{$contract->name}}</div>
        </div>
        <div class="content-number">
            Number: {{$contract->let_no_out}}
        </div>
        <div class="content-text">
            <div class="content-introduction">
                On this day <span>{{$contract->today_day_e}}</span> date <span>{{$contract->today_day_numb}}</span> month <span>{{$contract->today_month_e}}</span> year <span>{{$contract->today_year}}</span>
                (<span>{{$contract->now}}</span>), at Jakarta this Addendum is made between:
            </div>
            <div class="content-party">
                <ol type="1">
                    <li>
                        PT. Elabram Systems is domiciled at Thamrin City Tower Building, Thamrin City Business Center, 7th Floor, Thamrin
                        Boulevard Street, Central Jakarta, 10230, Indonesia, as of therefor authorized to act , hereinafter referred to as the <span>FIRST PARTY</span>.
                    </li>
                    <li>
                        <table>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Name</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->name}}</td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Address</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->address}}</td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Sex</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->gender_e}}</td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>No. {{$contract->identitas}}</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->id_number}}</td>
                            </tr>
                        </table>
                    </li>
                </ol>
                Acted as and for himself, hereinafter referred to as the <span>SECOND PARTY</span>.
            </div>
            <div class="content-introduction">
                The <span>FIRST PARTY</span> and the <span>SECOND PARTY</span> hereinafter referred as <span>THE PARTIES</span> previously has established a Partnership
                Agreement No. (<span>{{$contract->cont_no_new}}</span>). Thus, <span>THE PARTIES</span> has agreed to establish the Addendum of Partnership
                Agreement, pursuant to the following terms and conditions:
            </div>
            <div class="article-1">
                <div class="article-1-header">
                    <div>Article 1</div>
                </div>
                The intention to amend the Article 2 of Partnership Agreement as follows:
                <ol type="1">
                    <li>
                        The Agreement is extended for {{$contract->interval_contract}} month (s) effective as from <span>{{$contract->start_date_day_numb}}</span> <span>{{$contract->start_date_month_e}}</span> <span>{{$contract->start_date_year}}</span> until <span>{{$contract->end_date_day_numb}}</span> <span>{{$contract->end_date_month_e}}</span> <span>{{$contract->end_date_year}}</span>, unless it is notified to be
                        renewed upon the Agreement from both parties or decided according to the terms and conditions stated in this Agreement. In
                        the event of the Agreement for any reason whatsoever is not renewed, the <span>FIRST PARTY</span> shall notify the plan to the <span>SECOND
                        PARTY</span> in fourteen (14) days prior to the expiration period of the Agreement.
                    </li>
                </ol>
            </div>
            <div class="article-2">
                <div class="article-2-header">
                    <div>Article 2</div>
                </div>
                <ol type="1">
                    <li>
                        This Addendum is legally binding and effective as from <span>{{$contract->start_date_day_numb}}</span> <span>{{$contract->start_date_month_e}}</span> <span>{{$contract->start_date_year}}</span> until <span>{{$contract->end_date_day_numb}}</span> <span>{{$contract->end_date_month_e}}</span> <span>{{$contract->end_date_year}}</span> (Terms of the Agreement).
                    </li>
                    <li>
                        This Addendum is acting as an integral and inseparable part of the Agreement, thus, it has equal legal force and binding to
                        other Articles in the Agreement
                    </li>
                    <li>
                        Other Articles that are adequately covered in the Agreement and are not firmly amended in this Addendum are still valid<br>and
                        legally binding to <span>THE PARTIES</span>.
                    </li>
                    <li>
                        This Addendum is made in duplicate in which each copy shall be signed and both are equally legally binding
                    </li>
                </ol>
            </div>
            <div class="content-sign">
                <div class="content-left">
                    <div class="sign-header"><span>FIRST PARTY</span></div>
                    <div class="sign-name">{{$contract->approver}}<br>{{$contract->approver_position2}}</div>
                </div>
                <div class="content-right">
                    <div class="sign-header"><span>SECOND PARTY</span></div>
                    <div class="sign-name">{{$contract->name}}<br>{{$contract->position}}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>