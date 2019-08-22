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
            <div>PARTNERSHIP AGREEMENT</div>
            <div>BETWEEN</div>
            <div>PT ELABRAM SYSTEMS</div>
            <div>AND</div>
            <div>{{$contract->name}}</span></div>
        </div>
        <div class="content-number">
            Number: <span>{{$contract->cont_no_new}}</span>
        </div>
        <div class="content-text">
            <div class="content-introduction">
                On this day <span>{{$contract->today_day_e}}</span></span> date <span>{{$contract->today_day_numb}}</span></span> month <span>{{$contract->today_month_e}}</span></span> year <span>{{$contract->today_year}}</span></span>
                (<span>{{$contract->now}}</span>), at Jakarta this Partnership Agreement is made between :
            </div>
            <div class="content-party">
                <ol type="1">
                    <li>
                    <span>{{$contract->approver}}</span>, in his capacity acting as a <span>{{$contract->approver_position}}</span> of PT Elabram Systems according to the
                    Power of Attorney Number PTES/XI/2015/235 dated on 4th November 2015, therefore according to the Articles of Association
                    concluded in the Deed of Establishment Number 14, dated on Eleventh of October year Two Thousand and (11-10-2005) made
                    before Sri Intansih, S.H. as a Notary in Jakarta and has been ratified through Justice and Human Rights Ministerial Decree
                    dated on Nineteenth of October year Two Thousand and Five (19-10-2005), with the last amendment of Articles of Association
                    included in the Deed Number 01 dated on 7th Agustus 2014 made before Ummu Imama, S.H., a Notary in Jakarta, domiciled
                    at Thamrin City Tower Building, Thamrin City Business Center, 7th Floor, Thamrin Boulevard Street, Central Jakarta, 10230,
                    Indonesia, hereinafter referred to as the <span>FIRST PARTY</span>.
                    </li>
                    <li>
                        <table>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Name</td>
                                <td>:</td>
                                <td style="font-weight:bold">{{$contract->name}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Sex</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->gender_e}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Place and Date of Birth</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->mem_dob_city}}</span>, <span>{{$contract->dob_day_numb}}</span> <span>{{$contract->dob_month_e}}</span> <span>{{$contract->dob_year}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Address</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->address}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>ID Number</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->id_number}}</span></td>
                            </tr>
                            <tr style="line-height: 13px; vertical-align:top">
                                <td>Age</td>
                                <td>:</td>
                                <td style="font-weight:bold"><span>{{$contract->age}}</span></td>
                            </tr>
                        </table>
                    </li>
                </ol>
            </div>
            <div class="content-introduction">
                Acted as and for himself, hereinafter referred to as the <span>SECOND PARTY</span>. The <span>FIRST PARTY</span> and the <span>SECOND PARTY</span> hereinafter
                referred as <span>THE PARTIES</span> hereby agreed to establish a Partnership Agreement, hereinafter referred as Agreement, pursuant to the
                following terms and conditions:
            </div>
            <div class="article-1">
                <div class="article-1-header">
                    <div>Article 1</div>
                    <div>SCOPE OF THE WORK</div>
                </div>
                <ol type="1">
                    <li>
                        The <span>FIRST PARTY</span> assign the <span>SECOND PARTY</span> as a Partner to perform the work <span>{{$contract->position}}</span> with the duties set forth
                        specifically in a form of Job Description as an inseparable addendum of this Agreement.
                    </li>
                    <li>
                        The <span>FIRST PARTY</span> entitled to assign or transfer the <span>SECOND PARTY</span> from one Department to another in the vicinity of the
                        <span>FIRST PARTY</span> in consideration to necessities and prevailing provision to the <span>FIRST PARTY</span>.
                    </li>
                </ol>
            </div>
            <div class="article-2">
                <div class="article-2-header">
                    <div>Article 2</div>
                    <div>TERMS OF THE AGREEMENT</div>
                </div>
                <ol type="1">
                    <li>
                        This Agreement is made for the term of <span>{{$contract->interval_contract}}</span> month(s) effective as from <span>{{$contract->start_date_day_numb}}</span> <span>{{$contract->start_date_month_e}}</span> <span>{{$contract->start_date_year}}</span> until <span>{{$contract->end_date_day_numb}}</span> <span>{{$contract->end_date_month_e}}</span> <span>{{$contract->end_date_year}}</span>
                    </li>
                    <li>
                        If the <span>FIRST PARTY</span> intended to renew this Agreement, therefore the <span>FIRST PARTY</span> shall notify in written the plan for the
                        Agreement renewal.
                    </li>
                    <li>
                        In the event of the Agreement for any reason whatsoever becomes terminated, if each Parties hold an undone obligations that
                        arising prior to the expiration date of the Agreement, therefore <span>THE PARTIES</span> shall complete the said obligations.
                    </li>
                </ol>
            </div>
            <div class="article-3">
            <br><br><br><br><br><br>
                <div class="article-3-header">
                    <div>Article 3</div>
                    <div>RIGHTS AND OBLIGATIONS OF THE <span>FIRST PARTY</span></div>
                </div>
                <ol type="1">
                    <li>
                        The <span>FIRST PARTY</span> is entitled to perform evaluation towards the duties performed by the <span>SECOND PARTY</span>
                    </li>
                </ol>
            </div>
            <div class="article-4">
                <div class="article-4-header">
                    <div>Article 4</div>
                    <div>RIGHTS AND OBLIGATIONS OF THE <span>SECOND PARTY</span></div>
                </div>
                <ol type="1">
                    <li>
                        The <span>SECOND PARTY</span> is entitled to receive payment for the work performance from the <span>FIRST PARTY</span>
                    </li>
                    <li>
                        The <span>FIRST PARTY</span> shall comply to the provisions prevailing for the <span>FIRST PARTY</span> and other provisions prevailing for the
                        <span>FIRST PARTY</span>, also to keep the interest, data, documents, and equipment belongs to the <span>FIRST PARTY</span> to whatever extent
                        necessary, including but not limited to:
                        <ol type="a">
                            <li>Perform the duties assigned by the <span>FIRST PARTY</span> to the best of ability</li>
                            <li>Responsible for each duties assigned by the <span>FIRST PARTY</span>, including but not limited to the duties related to the
                                duties and responsibilities in the performance of work.
                            </li>
                            <li>Make restitution and to settle every losses suffered by the <span>FIRST PARTY</span> as a result of negligence or deviation by the
                                <span>SECOND PARTY</span> in performing the duties or if the <span>SECOND PARTY</span> failed to perform the duties well as required in
                                this Article
                            </li>
                            <li>Not providing statements regarding the confidentiality of the <span>FIRST PARTY</span> company, either during the Agreement is
                                binding or after the expiration of the Agreement
                            </li>
                            <li>Not providing statements to the print media and electronic media, as well as not to discussing the matters acquired by
                                the <span>FIRST PARTY</span> outside the performance of work, unless by permission of the <span>FIRST PARTY</span>.
                            </li>
                            <li> Not performing actions contrary to the prevailing provisions to the <span>FIRST PARTY</span> as well as prevailing regulations or
                                actions contrary to ethics and morality, or shall not be performed during work in general rules, including but not
                                limited to pornography, adultery, gambling, and use of drugs.
                            </li>
                        </ol>
                    </li>
                    <li>
                        The <span>SECOND PARTY</span> shall guarantee the documents, statements, data and information given to the <span>FIRST PARTY</span> are
                        complete, correct and in compliance with the provisions from the <span>FIRST PARTY</span>.
                    </li>
                    <li>
                        The <span>SECOND PARTY</span> shall guarantee that prior to the conclusion of this Agreement, the <span>SECOND PARTY</span> never perform any
                        actions contrary to the provisions of the <span>FIRST PARTY</span>, prevailing regulations, or contrary to ethics and morality, including
                        but not limited to providing false statement, fraud, pornography, adultery, gambling, and use of drugs, in which the said
                        actions may incur damage to the <span>FIRST PARTY</span> after this Agreement agreed.
                    </li>
                </ol>
            </div>
            <div class="article-5">
                <div class="article-5-header">
                    <div>Article 5</div>
                    <div>PERFORMANCE OF WORK FEE</div>
                </div>
                <ol type="1">
                    <li>
                        The <span>FIRST PARTY</span> will pay the performance of work fee to the <span>SECOND PARTY</span> of <span>{{$contract->cur_id}}</span> <span>{{$contract->total}}</span>,-
                        (<span>{{$contract->total_spell_e}}</span> <span>{{$contract->cur_name}}</span>)
                    </li>
                    <li>
                        The payment referred to in paragraph (1) of this Article to be made by the <span>FIRST PARTY</span> on the <span>{{$contract->pay_tgl}}</span>
                    </li>
                    <li>
                        In the event of the date referred in paragraph (2) coincide with holidays, thus the payment shall be made earlier on the previous working day
                        days.
                    </li>
                    <li>
                        The Payment received by the <span>SECOND PARTY</span> in cash form paid by the <span>FIRST PARTY</span> through transfer to the SECOND
                        PARTY</span> account Number <span>{{$contract->bank_name}}</span> at <span>{{$contract->bank_ac}}</span>
                    </li>
                </ol>
            </div>
            <div class="article-6">
                <div class="article-6-header">
                    <div>Article 6</div>
                    <div>INFRINGEMENT</div>
                </div>
                <ol type="1">
                    <li>
                        In the event of the <span>SECOND PARTY</span> breach/not comply to the provisions of this Agreement and or breach/not comply to the
                        prevailing provisions, therefore the <span>FIRST PARTY</span> shall notify the <span>SECOND PARTY</span> with non-compliance letter. Within a
                        period of 14 (fourteen) calendar days since the notification, the <span>SECOND PARTY</span> shall provide liability.
                    </li>
                    <li>
                        After the period of 14 (fourteen) calendar days exceeded and the <span>SECOND PARTY</span> failed to provide liability, therefore the
                        <span>SECOND PARTY</span> shall be considered to accept the stated notification and the <span>FIRST PARTY</span> may revoke the Agreement
                        unilaterally prior to the expiration period of the Agreement and/or to request the <span>SECOND PARTY</span> to comply with the
                        provisions in this Agreement/prevailing provisions for the Contract Workers of the <span>FIRST PARTY</span>.
                    </li>
                    <li>
                        In regards with liability provided by the <span>SECOND PARTY</span>, in consideration to explicit grounds in which the <span>FIRST PART</span>
                        unable to accept, therefore may revoke the Agreement unilaterally prior to the expiration period of the Agreement and/or to
                        request the <span>SECOND PARTY</span> to comply with the provisions in this Agreement/prevailing provisions for the Contract Workers
                        of the <span>FIRST PARTY</span>.
                    </li>
                </ol>
            </div>
            <div class="article-7">
                <div class="article-7-header">
                    <div>Article 7</div>
                    <div>DISCONTINUATION OF THE AGREEMENT</div>
                </div>
                <ol type="1">
                    <li>
                        The Agreement between the <span>FIRST PARTY</span> and the <span>SECOND PARTY</span> cease to be current in compliance to the following
                        provisions:
                        <ol type="a">
                            <li>The period of the Agreement has expired;</li>
                            <li>The <span>SECOND PARTY</span> deceased;</li>
                            <li>With consent of <span>THE PARTIES</span>; or</li>
                            <li>Revoke by one PARTY</span>;</li>
                            <li>The job/project assigned by the Partner has completed.</li>
                        </ol>
                    </li>
                    <li>
                        The <span>FIRST PARTY</span> may revoke the Agreement unilaterally prior to the expiration period of the Agreement without giving any
                        compensation whatsoever if
                        <ol type="a">
                            <li>
                                The <span>SECOND PARTY</span> breach/not comply with the provisions of this Agreement;
                            </li>
                            <li>
                                The <span>SECOND PARTY</span> unable to achieve the target (no performance) according to work performance evaluation; or
                            </li>
                            <li>
                                The job/project assigned by the Partner has completed prior to the expiration period of the Agreement.
                            </li>
                        </ol>
                    </li>
                    <li>
                        In the event of one <span>PARTY</span> revoke the Agreement unilaterally prior to the expiration period of the Agreement without any
                        grounds stated in the paragraph (2) of this Article, thus the said <span>PARTY</span> shall provide a liability in the total amount of the
                        expense until the period of this Agreement ends.
                    </li>
                    <li>
                        Discontinuation of the Agreement as stated in this Article shall be notified through written notice by the <span>PARTY</span> who wish to
                        revoke the Agreement.
                    </li>
                    <li>Furthermore, <span>THE PARTIES</span> shall make concession of a waiver to the Article 1266 provision of the Civil Code regarding the
                        Termination of Agreement.
                    </li>
                </ol>
            </div>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Article 8</div>
                    <div>D I S P U T E</div>
                </div>
                <ol type="1">
                    <li>
                        In the event of dispute arising due to interpretation and application of this Agreement, <span>THE PARTIES</span> agreed to settle the
                        dispute through consultation.
                    </li>
                    <li>
                        If the consultation did not meet the consensus, therefore <span>THE PARTIES</span> agreed to settle the dispute by legally means.
                    </li>
                    <li>
                        For this Agreement and the consequence arising, <span>THE PARTIES</span> agreed to select domicile at Clerk Office of the District Court
                        Central Jakarta.
                    </li>
                </ol>
            </div>
            <div class="article-9">
                <div class="article-9-header">
                    <div>Article 9</div>
                    <div>C L O S I N G</div>
                </div>
                <ol type="1">
                    <li>
                        All matters that are not provided or not adequately covered in this Agreement shall be governed further by the mutual consent
                        of <span>THE PARTIES</span> hereinafter set forth in a form of Letter or Addendum as an integral and inseparable part of this Agreement.
                    </li>
                    <li>
                        All attachments as mentioned in this Agreement acting as an integral and inseparable part of this Agreement, therefore this
                        Agreement shall not be made without the said attachments.
                    </li>
                    <li>
                        This agreement is made in duplicate in which each copy shall be included with sufficient duty stamp and both are equally
                        legally binding. The <span>first copy shall be given to the <span>FIRST PARTY</span>, and the <span>second copy shall be given to the SECOND
                        PARTY</span>
                    </li>
                    <li>
                        This Agreement come into force and binding to <span>THE PARTIES</span> from the date of signing.
                    </li>
                </ol>
            </div>
            <br><br><br><br><br><br>
            <div class="content-sign">
                <div class="content-left">
                    <div class="sign-header"><span>FIRST PARTY</span></div>
                    <div class="sign-name">{{$contract->approver}}<br>{{$contract->approver_position2}}</span></div>
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
