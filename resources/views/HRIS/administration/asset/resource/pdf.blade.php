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

        img{
            padding-right: 50px;
            width: 300px;
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
            text-align: left;
            margin-bottom: 65px;
            text-transform: uppercase;
        }

        #content .content-sign .sign-name {
            text-align: left;
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


    <div id="content" style="margin-top: -50px;">
        <div class="content-header">
        <div><img src="http://elabram.com/wp-content/uploads/2016/08/Elarbam-600px.png"></div>
            <div><h3>EQUIPMENT ASSIGNMENT FORM</h3></div>

        </div>
        <div>
            <table width="100%">
                <tr>
                    <td height="20"><b>&nbsp;Employee Name</b></td>
                    <td>&nbsp;{{$contract->mem_name}}</td>
                    <td height="20"><b>&nbsp;Company Name</b></td>
                    <td>&nbsp;{{$contract->cus_name}}</td>

                </tr>
                <tr>
                    <td height="20"><b>&nbsp;Department</b></td>
                    <td>&nbsp;{{$contract->cont_dept}}</td>
                    <td height="20"><b>&nbsp;Contact Number</b></td>
                    <td>&nbsp;{{$contract->cont_no_new}}</td>

                </tr>
                <tr>
                    <td height="20"><b>&nbsp;Position</b></td>
                    <td>&nbsp;{{$contract->cont_position}}</td>
                    <td height="20"><b>&nbsp;Email</b></td>
                    <td>&nbsp;{{$contract->mem_email}}</td>

                </tr>
                <tr>
                    <td height="20"><b>&nbsp;Gender</b></td>
                    <td>&nbsp;{{$contract->mem_gender}}</td>
                    <td height="20"><b>&nbsp;Date</b></td>
                    <td>&nbsp;{{$contract->date}}</td>

                </tr>
            </table>
        </div>
        <div style="margin-top:30px;margin-bottom:30px">
            <font style="font-size:11;  text-align: justify">
                I, acknowledge that the following electronic equipment/company asset has been assigned to and received by the undersigned:
            <font>
        </div>
        <div>
        @if($contract->vendor_name !='')
            <table width="100%">
                <tr>
                    <td height="20"><b>&nbsp;Tag</b></td>
                    <td height="20"><b>&nbsp;Type</b></td>
                    <td height="20"><b>&nbsp;Manufacturer</b></td>
                    <td height="20"><b>&nbsp;Serial No.</b></td>
                    <td height="20"><b>&nbsp;Service Tag/Sim No.</b></td>
                    <td height="20"><b>&nbsp;Remark</b></td>
                </tr>
                <tr>
                    <td height="20">&nbsp;{{$contract->elabram_tag}}</td>
                    <td height="20">&nbsp;{{$contract->type_name}}</td>
                    <td height="20">&nbsp;{{$contract->brand_name}}</td>
                    <td height="20">&nbsp;{{$contract->serial_number}}</td>
                    <td height="20">&nbsp;{{$contract->service_tag}}</td>
                    <td height="20">&nbsp;{{$contract->note}}</td>
                </tr>
                <tr>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                </tr>
            </table>
            @else
            <table width="100%">
                <tr>
                    <td height="20"><b>&nbsp;Tag</b></td>
                    <td height="20"><b>&nbsp;Type</b></td>
                    <td height="20"><b>&nbsp;Serial No.</b></td>
                    <td height="20"><b>&nbsp;Service Tag/Sim No.</b></td>
                    <td height="20"><b>&nbsp;Remark</b></td>
                </tr>
                <tr>
                    <td height="20">&nbsp;{{$contract->elabram_tag}}</td>
                    <td height="20">&nbsp;{{$contract->type_name}}</td>
                    <td height="20">&nbsp;{{$contract->serial_number}}</td>
                    <td height="20">&nbsp;{{$contract->service_tag}}</td>
                    <td height="20">&nbsp;{{$contract->note}}</td>
                </tr>
                <tr>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                    <td height="20"></td>
                </tr>
            </table>
            @endif
        </div>
        <div style="margin-top:30px;margin-bottom:30px;">
            <ol style="font-size:11;">
                <li style="margin-bottom:20px;text-align: justify">This equipment is the property of PT. Elabram Systems.  It is expensive equipment for which I will have legal and financial responsibility during the term of my temporary custody and use.</li>
                <li style="margin-bottom:20px;text-align: justify">Ensuring that stated equipment is to be used only by me, and only for Elabram Systems official business.</li>
                <li style="margin-bottom:20px;text-align: justify">I promise to protect and take care of this property to the best of my ability.  Problems with or damage to the equipment, will be reported by me to the Head of Department & HR Department immediately upon detection.  </li>
                <li style="margin-bottom:20px;text-align: justify">I should return the items and the above license software in its original working condition upon my termination of service with the PT. Elabram Systems.</li>
                <li style="margin-bottom:20px;text-align: justify">I promise follow asset assignment policy to use this asset for working purpose.</li>
                <li style="margin-bottom:20px;text-align: justify">By signing this agreement, I promise to reimburse PT. Elabram Systems for any loss or damage to the equipment incurred due to personal while in my possession.  If I do not return the equipment intact to PT. Elabram Systems and/or the monitoring staff upon demand, or upon reaching the end of my service in PT. Elabram Systems (whichever comes first), I realize I may be charged with felony theft.</li>
            </ol>
        </div>
        <div  style="margin-left:100px;">
            <div class="content-sign">
                <div class="content-left">
                    <div class="sign-header"><span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of Responsible Employee </span></span></div>
                    <div class="sign-name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receive Date :</div>
                </div>
                <div class="content-right">
                    <div class="sign-header"><span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of Responsible Employee</span></span></div>
                    <div class="sign-name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Date :</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
