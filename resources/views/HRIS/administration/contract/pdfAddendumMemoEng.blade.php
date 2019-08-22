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

        table, th {
            border-spacing: 0;
            border: 1px solid black;
        }
        td{
            border-right: 1px solid black;
        }
        td:last-child{
            border-right: unset;
        }
        tr td{
            border-bottom: 1px solid black;
        }
        tr:last-child td{
            border-bottom: unset;
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
            <div>ANNOUNCEMENT LETTER</div>
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
                Notice of Department Change/Position Change/Salary Increment.<br>
                <span>{{$contract->today_day_numb}}</span> <span>{{$contract->today_month_e}}</span> <span>{{$contract->today_year}}</span>
                <br><br>
                Dear,<br>
                <span>{{$contract->name}}</span>
                <br><br>
                Refer to your notice <span>{{$contract->cont_sta_name}}</span> ( <span>{{$contract->cont_no_new}}</span> ), we would like to inform you that effectively from <span>{{$contract->effective_date_day_numb}}</span> <span>{{$contract->effective_date_month_e}}</span> <span>{{$contract->effective_date_year}}</span>, your:
                <br><br>
                <table width="100%">
                <tr>
                    <td></td>
                    <td><span>From</span></td>
                    <td><span>To</span></td>
                </tr>
                @if(strtolower($contract->departement_before) != strtolower($contract->departement))
                <tr>
                    <td><span>Department</span></td>
                    <td>{{$contract->departement_before}}</td>
                    <td>{{$contract->departement}}</td>
                </tr>
                @endif
                @if(strtolower($contract->position_before) != strtolower($contract->position))
                <tr>
                    <td><span>Position</span></td>
                    <td>{{$contract->position_before}}</td>
                    <td>{{$contract->position}}</td>
                </tr>
                @endif
                @if($contract->total_before != $contract->total)
                    <tr>
                        <td><span>Basic Salary</span></td>
                        <td align="right">{{$contract->cur_id}}. {{$contract->basic_salary_before}}</td>
                        <td align="right">{{$contract->cur_id}}. {{$contract->basic_salary}}</td>
                    </tr>
                @endif

                @if($contract->allowance_tot_before != $contract->allowance_tot)
                    <tr>
                        <td colspan="3"><span>Allowance </span></td>
                    </tr>
                    @for($i = 0; $i< count($contract->alltype);$i++)
                        @if($contract->alltype[$i]->tot_det_before != $contract->alltype[$i]->tot_det)
                            <tr>
                                <td><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- {{$contract->alltype[$i]->fix_allow_type_name}} </span></td>
                                <td align="right">{{$contract->cur_id}}. {{number_format($contract->alltype[$i]->tot_det_before, 0, ".", ".")}}</td>
                                <td align="right">{{$contract->cur_id}}. {{number_format($contract->alltype[$i]->tot_det, 0, ".", ".")}}</td>
                            </tr>
                        @elseif($contract->alltype[$i]->tot_det_before !='' OR $contract->alltype[$i]->tot_det_before = 0)
                            <tr>
                                <td><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- {{$contract->alltype[$i]->fix_allow_type_name}} </span></td>
                                <td align="right">{{$contract->cur_id}}. {{number_format($contract->alltype[$i]->tot_det_before, 0, ".", ".")}}</td>
                                <td align="right">No Changes</td>
                            </tr>
                        @endif
                    @endfor
                @endif
                @if($contract->total_before != $contract->total)
                    <tr>
                        <td><span>Gross Salary</span></td>
                        <td align="right">{{$contract->cur_id}}. {{$contract->total_before}}</td>
                        <td align="right">{{$contract->cur_id}}. {{$contract->total}}</td>
                    </tr>
                @endif
                </table>
                <br><br>
                @if($contract->allowance_tot_before == $contract->allowance_tot)
                Your other remuneration will remain the same as stated on your previous notice. <br><br>
                @endif
                This increment is part of the values added to improve our total performance. It is also consequent to you having demonstrated excellent work performance for the Company since your commencement.<br><br>

                With this, the management hopes you will continue to perform your best and add more values to your service to the Company.<br><br>
                Congratulations and thank you for your good performance.

            </div>

            <div class="content-sign" style="margin-top:100px">
                <div class="content-right">
                    <div class="sign-name">Accepted by,</div>
                    <br><br><br><br><br><br>
                    <div class="sign-name">{{$contract->name}}<br>{{$contract->position}}</div>
                </div>
                <div class="content-left">
                    <div class="sign-name"><span>Yours truly,</span></div>
                    <div class="sign-name"><span>PT. ELABRAM SYSTEMS</span>
                    <br><br><br><br><br><br>
                    <div><span>{{$contract->approver}}</span><br><span>{{$contract->approver_position2}}</span></div>

                </div>
            </div>








        </div>
    </div>
</body>

</html>
