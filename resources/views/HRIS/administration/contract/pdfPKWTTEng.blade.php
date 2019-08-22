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
            <div>EMPLOYMENT AGREEMENT</div>
            <div>BETWEEN</div>
            <div>PT ELABRAM SYSTEMS</div>
            <div>AND</div>
            <div>{{$contract->name}}</div>
        </div>
        <div class="content-number">
            Number: <span>{{$contract->cont_no_new}}</span>
        </div>
        <div class="content-text">
            <div class="content-introduction">
                On this day <span>{{$contract->today_day_e}}</span></span> date <span>{{$contract->today_day_numb}}</span></span> month <span>{{$contract->today_month_e}}</span></span> year <span>{{$contract->today_year}}</span></span>
                (<span>{{$contract->now}}</span>), this Employment Agreement is made between:
            </div>
            <div class="content-party">
                <ol type="1">
                    <li>
                    <span>{{$contract->approver}}</span>, in his capacity acting as <span>{{$contract->approver_position}}</span> of PT Elabram Systems according to the
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
                        <div>Acted as and for himself, hereinafter referred to as the <span>SECOND PARTY</span>.</div>
                    </li>
                </ol>
            </div>
            <div class="content-introduction">
                The <span>FIRST PARTY</span> and the <span>SECOND PARTY</span> hereinafter referred as <span>THE PARTIES</span> hereby agreed to establish an Indefinite-Term
                Employment Agreement hereinafter referred as Employment Agreement, pursuant to the following terms and conditions:  
            </div>
            <div class="article-1">
                <div class="article-1-header">
                    <div>Article 1</div>
                    <div>DEFINITIONS</div>
                </div>
                In This Employment Agreement, the following terms shall have the respective meaning ascribed below:
                <ol type="1">
                    <li>
                        Position is a position that manifest the duties, responsibilities, and authority of the Workers in the organization of the <span>FIRST PARTY</span>.
                    </li>
                    <li>
                        Company Regulations is the whole provisions in the area of Company which governing right and duties of the Workers as well
                        as human resources management mechanism of the <span>FIRST PARTY</span> in which the conclusion and completion becomes the
                        authorization of the <span>FIRST PARTY</span>, in conformity to inputs made by the Workers of the <span>FIRST PARTY</span>.
                    </li>
                    <li>
                        Working Units or Project is a Working Units or Project of the <span>FIRST PARTY</span> located domestically or overseas.
                    </li>
                    <li>
                        Client is the Company Party that assign part of the work performance to the <span>FIRST PARTY</span>.
                    </li>
                </ol>
            </div>
            <br><br><br><br><br><br><br><br>
            <div class="article-2">
                <div class="article-2-header">
                    <div>Article 2</div>
                    <div>SCOPE OF WORK</div>
                </div>
                <ol type="1">
                    <li>
                        The <span>FIRST PARTY</span> hires the <span>SECOND PARTY</span> as a Permanent Worker with position of <span>{{$contract->position}}</span>.
                    </li>
                    <li>
                        The <span>FIRST PARTY</span> is entitled to assign or transfer the <span>SECOND PARTY</span> from one Position and/or Working Units to another in
                        the vicinity of the <span>FIRST PARTY</span> in consideration to necessities and prevailing provision to the <span>FIRST PARTY</span>.
                    </li>
                </ol>
            </div>
            <br>
            <div class="article-3">
                <div class="article-3-header">
                    <div>Article 3</div>
                    <div>ASSIGNMENT</div>
                </div>
                <ol type="1">
                    <li>
                        The <span>SECOND PARTY</span> will be assigned by the <span>FIRST PARTY</span> to perform the duties of the Working Units or Project on the
                        Client side.
                    </li>
                    <li>
                        Assignment as referred in the paragraph (1) of this Article will be made through Letter of Assignment from the <span>FIRST PARTY</span>
                        to the <span>SECOND PARTY</span> and acting as an integral and inseparable part of this Agreement.
                    </li>
                </ol>
            </div>
            <div class="article-4">
                <div class="article-4-header">
                    <div>Article 4</div>
                    <div>TERMS OF THE EMPLOYMENT AGREEMENT</div>
                </div>
                    The Employment Agreement is made for an indefinite period until the pension age set forth by the company regulation, effective as
                    from <span>{{$contract->start_date_day_numb}}</span> <span>{{$contract->start_date_month_e}}</span> <span>{{$contract->start_date_year}}</span>.
            </div>
            <div class="article-5">
                <div class="article-5-header">
                    <div>Article 5</div>
                    <div>RIGHTS AND OBLIGATIONS OF THE <span>FIRST PARTY</span></div>
                </div>
                <ol type="1">
                    <li>
                        The <span>FIRST PARTY</span> is entitled to receive the report of working result from the <span>SECOND PARTY</span> in compliance with the duties
                        stipulated precisely in the Job Description.
                    </li>
                    <li>
                        The <span>FIRST PARTY</span> and/or the legitimate representative shall providing an elucidation regarding the text of this Employment
                        Agreement to the <span>SECOND PARTY</span>, which documented through the Minutes of Employment Agreement Explanatory signed
                        by <span>THE PARTIES</span> as an inseparable part with this Employment Agreement.
                    </li>
                </ol>
            </div>
            <div class="article-6">
                <div class="article-6-header">
                    <div>Article 6</div>
                    <div>RIGHTS AND OBLIGATIONS OF THE <span>SECOND PARTY</span></div>
                </div>
                <ol>
                    <li>
                        The <span>SECOND PARTY</span> is entitled to receive Salary, Allowance, and Amenities applied for the Permanent Worker from the
                        <span>FIRST PARTY</span>.
                    </li>
                    <li>
                        The <span>FIRST PARTY</span> shall comply to the provisions prevailing for the <span>FIRST PARTY</span> and other provisions prevailing for the
                        <span>FIRST PARTY</span> which stipulated in the Company Regulation, other provisions prevailing to the <span>FIRST PARTY</span>, prevailing
                        regulations, also to keep the interest, data, documents, and equipment belongs to the <span>FIRST PARTY</span> to whatever extent
                        necessary, including but not limited to:
                        <ol type="a">
                            <li>Perform the duties assigned by the <span>FIRST PARTY</span> to the best of ability;</li>
                            <li>Responsible for each duties assigned by the <span>FIRST PARTY</span>, including but not limited to the duties related to the
                                duties and responsibilities in the performance of work;
                            </li>
                            <li>Make restitution and to settle every losses suffered by the <span>FIRST PARTY</span> as a result of negligence or deviation by the
                                <span>SECOND PARTY</span> in performing the duties or if the <span>SECOND PARTY</span> failed to perform the duties well as required in
                                this Article;
                            </li>
                            <li>Willing to be assigned in every Position and Working Units of the <span>FIRST PARTY</span>;</li>
                            <li>Not providing statements regarding the confidentiality of the <span>FIRST PARTY</span> company, either during the Agreement is
                                binding or after the expiration of the Employment Agreement ;
                            </li>
                            <li>Not providing statements to the print media and electronic media, as well as not to discussing the matters acquired by
                                the <span>FIRST PARTY</span> outside the relation of position, unless by permission of the <span>FIRST PARTY</span>; and
                            </li>
                            <li> Not performing actions contrary to the prevailing provisions to the <span>FIRST PARTY</span> as well as prevailing regulations or
                                actions contrary to ethics and morality, or shall not be performed during work in general rules, including but not
                                limited to pornography, adultery, gambling, and use of drugs.
                            </li>
                        </ol>
                    </li>
                    <li>The <span>SECOND PARTY</span> shall guarantee the documents, statements, data and information given to the <span>FIRST PARTY</span> are
                        complete, correct and in compliance with the provisions from the <span>FIRST PARTY</span></li>
                    <li>The <span>SECOND PARTY</span> shall guarantee that prior to the conclusion of this Employment Agreement, the <span>SECOND PARTY</span>
                        never perform any actions contrary to the provisions of the <span>FIRST PARTY</span>, prevailing regulations, or contrary to ethics and
                        morality, including but not limited to providing false statement, fraud, pornography, adultery, gambling, and use of drugs, in
                        which the said actions may incur damage to the <span>FIRST PARTY</span> after this Employment Agreement agreed.
                    </li>
                </ol>
            </div>
            <div class="article-7">
                <div class="article-7-header">
                    <div>Article 7</div>
                    <div>SALARY, ALLOWANCE, AND AMENITIES</div>
                </div>
                <ol type="1">
                    <li>
                        The <span>SECOND PARTY</span> receives Salary from the <span>FIRST PARTY</span> which consist of Basic Salary and Allowance with details as
                        follows:
                        <table>
                            <tr>
                                <td>a)</td>
                                <td>Basic Salary</td>
                                <td>&nbsp;:&nbsp;<span>{{$contract->basic_salary}}</span></td>
                            </tr>
                            <tr>
                                <td>b)</td>
                                <td>Meal & Transportation  </td>
                                <td>&nbsp;:&nbsp;<span>{{$contract->allowance_salary}}</span></td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                            <tr>
                                <td colspan="2">Total amount of Gross Salary  </td><td>&nbsp;:&nbsp;<span>{{$contract->total}}</span></td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        For Salary and Allowance referred in the paragraph (1) of this Article the <span>FIRST PARTY</span> is entitled to amend in consideration
                        of the company policy without notification to the <span>SECOND PARTY</span> or to establish an addendum to this Employment
                        Agreement.
                    </li>
                    <li>
                        The payment of Salary referred in paragraph (1) of this Article to be made by the <span>FIRST PARTY</span> on the date <span>{{$contract->pay_tgl}}</span> each
                        month.
                    </li>
                    <li>In the event of the date referred in paragraph (2) coincide with holidays, thus the payment of Salary shall be made on the last
                        working day prior to the date <span>{{$contract->pay_tgl}}</span> of concerned month.
                    </li>
                    <li>The <span>FIRST PARTY</span> provides Salary and other Amenities according to the prevailing provisions for the Permanent Worker of
                        the <span>FIRST PARTY</span>, including but not limited to:
                        <ol type="a">
                            <li>Overtime for an exceeded working hours, set forth according to the prevailing provisions for the <span>SECOND PARTY</span> on
                                Client Side.
                            </li>
                            <li>Amenities and lumpsum of official travel expenses accordin to the prevailing provisions applied for the Permanent
                                Workers of the <span>FIRST PARTY</span> equal to the level of Position as stipulated in the Article 2 paragraph (1) of the
                                Employment Agreement, in the event of the <span>SECOND PARTY</span> assigned to perform an official travel by the <span>FIRST
                                PARTY</span>.
                            </li>
                            <li>Vacation and Leave Allowance according to the prevailing provisions for the Permanent Workers equal to the level of
                                Position as stipulated in the Article 2 paragraph (1) of the Employment Agreement.
                            </li>
                            <li>Allowance for Religious Holidays (THRK).</li>
                        </ol>
                    </li>
                    <li>Unless otherwise stipulated in the provisions applied for the Permanent Workers of the <span>FIRST PARTY</span>, Income Tax of Salary
                        and received Amenities by the <span>SECOND PARTY</span> encumbered to the <span>SECOND PARTY</span>.
                    </li>
                    <li>The <span>SECOND PARTY</span> authorize the <span>FIRST PARTY</span> for the deduction to Salary, other Allowances, Amenities, and/or any kind
                        of payment either cash or non-cash accepted by the <span>SECOND PARTY</span> for the interest of the <span>FIRST PARTY</span>, <span>SECOND
                        PARTY</span>, or other Third Party according to the prevailing provisions of the <span>FIRST PARTY</span>, including but not limited to Taxes
                        and JAMSOSTEK.
                    </li>
                    <li>Salary and Amenities received by the <span>SECOND PARTY</span> in cash form paid by the <span>FIRST PARTY</span> through transfer to the
                        <span>SECOND PARTY</span> account Number BANK <span>{{$contract->bank_name}}</span> on <span>{{$contract->bank_ac}}</span>.
                    </li>
                </ol>
            </div>
            <br><br>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Article 8</div>
                    <div>INFRINGEMENT</div>
                </div>
                <ol type="1">
                    <li>
                        In the event the <span>SECOND PARTY</span> absent for the whole working hour, therefore the Basic Salary received by the <span>SECOND
                        PARTY</span> will be subject to deduction with calculation according to the prevailing provisions applied to the Permanent Workers
                        of the <span>FIRST PARTY</span>
                    </li>
                    <li>
                        In the event of the <span>SECOND PARTY</span> breach or not comply to the provisions of this Employment Agreement and or breach or
                        not comply to the provisions prevailing to the Permanent Workers of the <span>FIRST PARTY</span>, therefore the <span>FIRST PARTY</span> shall
                        rule down Disciplinary Punishment to the <span>SECOND PARTY</span> according to the prevailing Disciplinary Provisions of the <span>FIRST
                        PARTY</span>.
                    </li>
                </ol>
            </div>
            <div class="article-9">
                <div class="article-9-header">
                    <div>Article 9</div>
                    <div>DISCONTINUATION OF THE EMPLOYMENT AGREEMENT</div>
                </div>
                <ol type="1">
                    <li>
                        The <span>FIRST PARTY</span> is entitled to perform Termination of Employment in the event of the <span>SECOND PARTY</span>:
                        <ol>
                            <li>Resignation upon request;</li>
                            <li>Incompetent to perform the duties reasonably according to the prevailing provisions to the <span>FIRST PARTY</span> and/or
                                Client Side;
                            </li>
                            <li>Excess of workers;</li>
                            <li>Have reached the pension age according to the Company Regulation;</li>
                            <li>In custody by the officials;</li>
                            <li>Declared guilty by the Court Decision;</li>
                            <li>Sentenced by Diciplinary Punishment;</li>
                            <li>Qualified as resign due to absent without notice;</li>
                            <li>Health matters;</li>
                            <li>Deceased worker; or</li>
                            <li>Other reasons for Termination of Employment according to the prevailing regulations.</li>
                        </ol>
                    </li>
                    <li>Termination of Employment as referred in paragraph (1) of this Article to be notify through written notification by the <span>FIRST
                        PARTY</span> to the <span>SECOND PARTY</span>
                    </li>
                    <li>In the event of the <span>FIRST PARTY</span> to perform Termination of Employment, therefore the <span>FIRST PARTY</span> to give Severance
                        Pay, Service Pay, Payment of Outstanding Leave and Entitlements, and/or other rights to the <span>SECOND PARTY</span> in compliance
                        with the prevailing Company Regulation to the <span>FIRST PARTY</span>.
                    </li>
                    <li>In compliance with the provisions stated in this Article, the <span>SECOND PARTY</span> shall:
                        <ol>
                            <li>Make restitution of the losses arising in regards with Article 6 paragraph (2) point c of this Employment Agreement;</li>
                            <li>Complete and/or redeem all undone obligations and/or debts to the <span>FIRST PARTY</span> and/or other internal agencies from
                                the <span>FIRST PARTY</span> and/or to the Client Party.
                            </li>
                        </ol>
                    </li>
                    <li>The rights of the <span>SECOND PARTY</span> due to Termination of Employment as referred in paragraph (3) of this Article, provided
                        after calculated to the obligations of the <span>SECOND PARTY</span> to the <span>FIRST PARTY</span> and/or other internal agencies from the
                        <span>FIRST PARTY</span> and/or from Client Party.
                    </li>
                    <li>by no later than 1 (one) month since the date of Termination of Employment.</li>
                    <li>In the event of the <span>SECOND PARTY</span> failed to perform the obligation during the period stipulated by the paragraph (6) of this
                        Article, either as a whole or in parts, therefore the <span>FIRST PARTY</span> may request an invoice through mass media and/or to
                        submit the resolution through legally means and/or to debit directly from the <span>SECOND PARTY</span> account.
                    </li>
                </ol>
            </div>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Article 10</div>
                    <div>THE POWERS</div>
                </div>
                <ol type="1">
                    <li>
                        For the interest of the <span>FIRST PARTY</span> and or other party’s interest, hereby the <span>SECOND PARTY</span> authorize the <span>FIRST PARTY</span>
                        as follows:
                        <ol>
                            <li>POWER TO BLOCK AND OR DEBIT THE ACCOUNT
                                <ol>
                                    <li>The <span>FIRST PARTY</span> hereby given the power to occasionally perform deduction, debit, transfer and/or block the
                                        account and/or funds included in the account of the <span>SECOND PARTY</span> in which lay under the authority of the
                                        <span>FIRST PARTY</span> (including other accounts which retractions and transactions legally be in the authority of the
                                        <span>SECOND PARTY</span>), with requirements as follows:
                                        <ol>
                                            <li>The <span>SECOND PARTY</span> still holds undone debts and/or other obligations to the <span>FIRST PARTY</span> ; or</li>
                                            <li>According to the findings by the auditor, findings by the team established by Working Units, and/or
                                                existed evidences, the <span>SECOND PARTY</span> has allegedly performed actions contrary to the prevailing
                                                provisions and have tendency or have already incur damage to the <span>FIRST PARTY</span>.
                                            </li>
                                        </ol>
                                    </li>
                                    <li>and/or transfer the funds from the <span>SECOND PARTY</span> account as stated above, the <span>FIRST PARTY</span> shall pay for
                                        the said funds arising from debit and/or transferrin order to:
                                        <ol>
                                            <li>Pay the debt and/or obligations of the <span>SECOND PARTY</span> to the <span>FIRST PARTY</span>; and/or</li>
                                            <li>related directly during the period of working relation with the <span>FIRST PARTY</span>.</li>
                                        </ol>
                                    </li>
                                </ol>
                            </li>
                            <li>POWER TO REQUEST OR TO GIVE ACCOUNT INFORMATION
                                <ol>
                                    <li>The <span>FIRST PARTY</span> authorized by the <span>SECOND PARTY</span> to appear before the bank or other party whatsoever,
                                        without exception, to perform one or several actions as follows:
                                        <ol>
                                            <li>To request, accept, and sign the receipt regarding accounts on behalf of the <span>SECOND PARTY</span>, with no
                                                exception, including information constituted as Bank Secrecy;
                                            </li>
                                            <li>observe and check every information and account transfer of the <span>SECOND PARTY</span> that is in the
                                                authority of the <span>FIRST PARTY</span> or other parties; and/or
                                            </li>
                                            <li>Disclose all information regarding the account of the said <span>SECOND PARTY</span> account, including
                                                information that listed as Bank Secrecy, to any parties.
                                            </li>
                                        </ol>
                                    </li>
                                    <li>Request or provide information of the account performed when one or several events occurred as follows:
                                        <ol>
                                            <li>The <span>SECOND PARTY</span> still holds debt and/or other undone obligations to the <span>FIRST PARTY</span>; or</li>
                                            <li>According to the findings by the auditor, findings by the team established by Working Units, and/or
                                                existed evidences, the <span>SECOND PARTY</span> has allegedly performed actions contrary to the prevailing
                                                provisions and have tendency or have already incur damage to the <span>FIRST PARTY</span>.
                                            </li>
                                        </ol>
                                    </li>
                                    <li>By the meaning of <span>SECOND PARTY</span> account is all kind of accounts or account that belongs to the SECOND
                                        PARTY with no exception, including but not limited to, savings account, deposit account, clearing account,
                                        holdings, mutual funds, DPLK, Manfaat Pensiun, Jamsostek, and so on.
                                    </li>
                                </ol>
                            </li>
                            <li>POWER OF SET OFF
                                <br>
                                The <span>SECOND PARTY</span> authorize <span>FIRST PARTY</span> to perform set-off and/or obligations of the <span>SECOND PARTY</span> to the
                                <span>FIRST PARTY</span> arising from this Agreement, or due to other agreements with the <span>FIRST PARTY</span> with account
                                receivable of the <span>SECOND PARTY</span> in the <span>FIRST PARTY</span> in a form of, but not limited to savings account, deposit
                                accounts, and/or other accounts belongs to the <span>SECOND PARTY</span> in the authority of the <span>FIRST PARTY</span>, including
                                payments from the Third Party to the <span>SECOND PARTY</span> paid through the <span>FIRST PARTY</span>
                            </li>
                        </ol>
                    </li>
                </ol>
                The powers given by the <span>SECOND PARTY</span> to the <span>FIRST PARTY</span> cannot be repealed, cancelled, and/or revoked unilaterally by the
                <span>SECOND PARTY</span>. <span>THE PARTIES</span> agreed upon the said powers shall not be ceased due to reasons stipulated by the laws or other
                reasons whatsoever. The powers as an integral and inseparable part of this Agreement in which this Agreement might not exist
                without the said powers.
            </div>
            <div class="article-8">
                <div class="article-8-header">
                    <div>Article 11</div>
                    <div>DISPUTE</div>
                </div>
                <ol type="1">
                    <li>
                        In the event of dispute arising due to interpretation and application of this Employment Agreement, <span>THE PARTIES</span> agreed to
                        settle the dispute through consultation.
                    </li>
                    <li>
                        If the consultation did not meet the consensus, therefore <span>THE PARTIES</span> agreed to settle the dispute by legally means.
                    </li>
                    <li>For this Employment Agreement and the consequence arising, <span>THE PARTIES</span> agreed to select domicile at Clerk Office of the
                        District Court Central Jakarta (Kantor Kepaniteraan Pengadilan Negeri Jakarta Pusat).
                    </li>
                </ol>
            </div>
            <br><br><br><br><br><br><br>
                <div class="article-8-header">
                    <div>Article 12</div>
                    <div>CLOSING</div>
                </div>
                <ol type="1">
                    <li>
                        All matters that are not provided or or not adequately covered in this Employment Agreement shall be governed further by the
                        mutual consent of <span>THE PARTIES</span> hereinafter set forth in a form of Letter or Addendum as an integral and inseparable part of
                        this Employment Agreement.
                    </li>
                    <li>
                        This Employment Agreement is made in duplicate in which each copy shall be included with sufficient duty stamp and both are
                        equally legally binding. The first copy shall be given to the <span>FIRST PARTY</span>, and the second copy shall be given to the </span>SECOND
                        PARTY</span>
                    </li>
                    <li>This Employment Agreement come into force and binding to <span>THE PARTIES</span> from the date of signing.</li>
                    <li>The <span>FIRST PARTY</span> and the <span>SECOND PARTY</span> agreed, eventhough the agreement ceased, the following provisions remain
                        prevail:
                        <ol>
                            <li>Articles of Infringement;</li>
                            <li>Articles of Termination of Employment</li>
                            <li>Articles of the Powers;</li>
                            <li>Articles of the Dispute; and</li>
                            <li>Articles of the Closing.</li>
                        </ol>
                    </li>
                </ol>
            </div>
            <div class="content-sign">
                <div class="content-left">
                    <div class="sign-header">FIRST PARTY</div>
                    <div class="sign-name">{{$contract->approver}}<br>{{$contract->approver_position2}}</div>
                </div>
                <div class="content-right">
                    <div class="sign-header">SECOND PARTY</div>
                    <div class="sign-name">{{$contract->name}}<br>{{$contract->position}}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>