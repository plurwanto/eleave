
<form id="formInput" class="form form-horizontal">
    <div class="modal-content">
        <div class="modal-header" style="padding: 10px; background-color: #333942; color: #fff; border-bottom: unset;">
            <button class="close" style="filter: brightness(0) invert(1); opacity: 1;" data-dismiss="modal"></button>
            <h4 class="modal-title">Add Employee</h4>
        </div>
        <div class="modal-body" style="padding: 0; background-color: #F5F5F5;">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box" style="border: 1px solid #BDBDBD; border-top: unset; background-color: #fff; margin-bottom: 0; max-height: 65vh; overflow-y: auto;">
                        <div class="portlet-body">
                            <div style="color: #0584D3 !important; font-weight: bold; border-bottom: 1px solid #BDBDBD; padding-bottom: 10px;">
                                <i class="fa fa-user"></i>
                                Personal Information
                                <span style="color:#F44336">*</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Citizenship
                                        </div>
                                    </div>
                                    <div class="col-md-8" style="color: #414040!important">
                                        <div class="mt-radio-inline" style="height: 31px; vertical-align: middle; display: table-cell; padding: 0">
                                            <label class="mt-radio" style="font-size: 12px; margin-bottom: 0">
                                                <input autocomplete="off" type="radio" onclick="checkCitizenship(this);" class="form-control" name="citizenship" value="local" checked > Local
                                                <span></span>
                                            </label>
                                            <label class="mt-radio" style="font-size: 12px; margin-bottom: 0">
                                                <input autocomplete="off" type="radio" onclick="checkCitizenship(this);" class="form-control" name="citizenship" value="expatriate" > Expatriate
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="expatriate-only" style="display:none">
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                ID / Passport Number
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input autocomplete="off" type="text"  name="passport" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Passport Expired Date
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input autocomplete="off"  name="passport_date" value="{{$employee->employee->mem_ktp_no}}" placeholder="Enter Expire Date" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="local-only">
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                ID Number
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input autocomplete="off" name="id_card" value="{{$employee->employee->mem_ktp_no}}" placeholder="Enter ID Card" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Name
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="name" placeholder="Enter Name" type="text" class="form-control name" value="{{$employee->employee->mem_name}}" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Email
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="email1" placeholder="Enter Email" type="text" class="form-control email" value="{{$employee->employee->mem_email}}" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            No. Handphone
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="mobile1" placeholder="Enter Mobile" type="text" class="form-control hp" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" value="{{$employee->employee->mem_mobile}}">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Gender
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate" style="color: #414040!important">
                                        <div class="mt-radio-inline" style="height: 31px; vertical-align: middle; display: table-cell; padding: 0">
                                            <label class="mt-radio" style="font-size: 12px; margin-bottom: 0">
                                                @if($employee->employee->mem_gender =='L')
                                                <input autocomplete="off" type="radio" name="gender"  value="L" checked="checked" >
                                                @else
                                                <input autocomplete="off" type="radio" name="gender"  value="L" >
                                                @endif
                                                Male
                                                <span></span>
                                            </label>
                                            <label class="mt-radio" style="font-size: 12px; margin-bottom: 0">
                                                @if($employee->employee->mem_gender =='P')
                                                <input autocomplete="off" type="radio" name="gender"  value="P" checked="checked" >
                                                @else
                                                <input autocomplete="off" type="radio" name="gender"  value="P" >
                                                @endif
                                                Female
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Place of Birth
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="pob" placeholder="Enter Place Of Birth" type="text" class="form-control hp" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" value="{{$employee->employee->mem_dob_city}}">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Date of Birth
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                    <input autocomplete="off" name="dob" id="dob" placeholder="Enter Date of Birth" type="text" class="form-control date-picker" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" value="{{$employee->employee->mem_join_date}}" name="join_date" id="join_date" autocomplete="off"
                                            data-date-format="dd/mm/yyyy">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Religion
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                    <select autocomplete="off" name="religion" autocomplete="off" class="form-control" >
                                    <option value="">-- Choose a religion --</option>
                                    @php
                                    for($i = 0; $i < count($religion->result); $i++){
                                        if($employee->employee->religi_id == $religion->result[$i]->religi_id){
                                            echo '<option value="'.$religion->result[$i]->religi_id.'" selected>'.$religion->result[$i]->religi_name.'</option>';
                                        }else{
                                            echo '<option value="'.$religion->result[$i]->religi_id.'">'.$religion->result[$i]->religi_name.'</option>';
                                        }
                                    }
                                    @endphp
                                </select>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Marital Status
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <select autocomplete="off" name="marital" id="marital"  onchange="family_cond()" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                        <option value="">-- Choose a Marital --</option>
                                        @php
                                        for($i = 0; $i < count($marital->result); $i++){
                                            if($employee->employee->mem_marital_id == $marital->result[$i]->mem_marital_id){
                                                echo '<option value="'.$marital->result[$i]->mem_marital_id.'" selected>'.$marital->result[$i]->mem_marital_name.'</option>';
                                            }else{
                                                echo '<option value="'.$marital->result[$i]->mem_marital_id.'">'.$marital->result[$i]->mem_marital_name.'</option>';
                                            }
                                        }
                                        @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Nationality
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <select autocomplete="off" name="nationality" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
                                        <option value="">-- Choose a nationality --</option>
                                        @php
                                        for($i = 0; $i < count($nationality->result); $i++){
                                            echo '<option value="'.$nationality->result[$i]->nat_id.'">'.$nationality->result[$i]->nat_name.'</option>';
                                            }
                                        @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Address
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <textarea name="address" placeholder="Enter Address" class="form-control address" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; min-height: 30px; overflow:hidden; resize: none;" onkeyup="setHeight.call(this);">{{$employee->employee->mem_address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Join Date
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="join_date" id="join_date" type="text" class="form-control date-picker" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" value="{{$employee->employee->mem_join_date}}" autocomplete="off"
                                            data-date-format="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                            <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
                                <i class="fa fa-address-card"></i>
                                Emergency Contact
                                <span style="color:#F44336">*</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Name
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="emgName" placeholder="Enter Emergency Name" type="text" class="form-control emergencyName" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Relationship
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <select autocomplete="off" name="emgRelationship" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                            <option value="">-- Choose a Relationship --</option>
                                            <option value="1">Parents</option>
                                            <option value="2">Brotherhood</option>
                                            <option value="3">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Contact Number
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="emgMobile" placeholder="Enter Emergency Phone" type="text" class="form-control emergencyContact" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                    </div>
                                </div>
                            </div>

                            <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
                                <i class="fa fa-credit-card"></i>
                                Banking Information
                                <span style="color:#F44336">*</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Bank
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <select autocomplete="off" name="name_bank1" id="name_bank1" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                            <option value="">-- Choose a Bank --</option>
                                            @php
                                            for($i = 0; $i < count($bank->result); $i++){
                                                echo '<option value="'.$bank->result[$i]->bank_id.'">'.$bank->result[$i]->bank_name.'</option>';
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Account Number
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="ac_bank1" id="ac_bank1" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" placeholder="Enter Account Number">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Account Name
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="an_bank1" id="an_bank1" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" placeholder="Enter Account Name">
                                    </div>
                                </div>
                            </div>
                            <div style="display:none" id="bank2">
                                <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
                                    <i class="fa fa-credit-card"></i>
                                    Banking Information (Secondary)
                                    <span style="color:#F44336">*</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Bank
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <select autocomplete="off" name="name_bank2" id="name_bank2" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                                <option value="">-- Choose a Bank --</option>
                                                @php
                                                for($i = 0; $i < count($bank->result); $i++){
                                                    echo '<option value="'.$bank->result[$i]->bank_id.'">'.$bank->result[$i]->bank_name.'</option>';
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Swift Code
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input autocomplete="off" name="swift" id="swift" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" placeholder="Enter Account Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Account Number
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input autocomplete="off" name="ac_bank2" id="ac_bank2" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" placeholder="Enter Account Number">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Account Name
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input autocomplete="off" name="an_bank2" id="an_bank2" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" placeholder="Enter Account Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
                                <i class="fa fa-credit-card"></i>
                                Tax and Account
                                <span style="color:#F44336">*</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Insurance
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <select autocomplete="off" name="insurance" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                            <option value="">-- Choose a Insurance --</option>
                                            @for($i = 0; $i < count($insurance->result); $i++)
                                            <option value="{{$insurance->result[$i]->insr_id}}">{{$insurance->result[$i]->insr_name}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Tax Remark
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <select autocomplete="off" name="tax_remark" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                            <option value="">-- Choose a Remark --</option>
                                            @for($i = 0; $i < count($tax_remark->result); $i++)
                                            <option value="{{$tax_remark->result[$i]->tr_id}}">{{$tax_remark->result[$i]->tr_name}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Tax Number
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="tax_number" placeholder="Enter Tax Number" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" placeholder="Enter Tax Number">
                                    </div>
                                </div>
                                <div class="col-md-8 validate">
                                    <select autocomplete="off" name="user_level" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                        <option value="">-- Choose a user level --</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            TIN No
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="tin" placeholder="Enter Tax Number" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" placeholder="Enter TIN">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            PHIC No
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="phic" placeholder="Enter PHIC" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            SSS No
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="sss" placeholder="Enter SSS" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            HDMF No
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="hdmf" placeholder="Enter HDMF" type="text" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                    </div>
                                </div>
                            </div>

                            <div id="family" style="display:none">
                                <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
                                    <i class="fa fa-address-card"></i>
                                    Spouse
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Name
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input autocomplete="off" name="name_spouse" placeholder="Enter Name" type="text" class="form-control emergencyName" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Date Of Birth
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input autocomplete="off" name="dob_spouse" placeholder="Enter Date" type="text" class="form-control date-picker
                                            " style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" autocomplete="off"
                                                data-date-format="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Gender
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <select autocomplete="off" name="gender_spouse" autocomplete="off" class="form-control">
                                                <option value="">-- Choose a Gender --</option>
                                                <option value="L">Male</option>
                                                <option value="P">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="div_Child">
                                    <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
                                        <i class="fa fa-address-card"></i>
                                        Child 1
                                    </div>
                                    <div id="errorChild"></div>
                                    <div class="row">
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Name
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                                <input autocomplete="off" name="name_child1" id="name_child1" placeholder="Enter Name" type="text" class="form-control emergencyName" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Date Of Birth
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                                <input autocomplete="off" name="dob_child1" id="dob_child1" placeholder="Enter Date" type="text" class="form-control  date-picker" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" autocomplete="off"
                                                    data-date-format="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Gender
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                                <select autocomplete="off" name="gender_child1" id="gender_child1" autocomplete="off" class="form-control">
                                                    <option value="">-- Choose a Gender --</option>
                                                    <option value="L">Male</option>
                                                    <option value="P">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="actionChild_1" style="padding: 10px 15px">
                                            <a id="add_1" dataid="1" class="btn btn-primary" onclick="addFunctionChild(this);">
                                                <font style="color:white">Add New</font>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="border-top: unset">
        <input type="hidden" name="form_type" value="2">
        <input autocomplete="off" name="mem_id" type="hidden" value="{{$id}}">
            <button class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn green" id="btnSubmit">Save</button>
        </div>
    </div>
</form>


<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'components-select2.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'form-validation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'components-select2.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'form-validation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript">
        $(document).ready(function () {
            family_cond();
            $('#formInput').validate({
                rules: {
                    emgName: {
                        required: true
                    },
                    emgRelationship: {
                        required: true
                    },
                    emgMobile: {
                        required: true,
                        number: true
                    },
                    join_date: {
                        required: true
                    },
                    tax_number: {
                        number: true
                    },
                    mobile1: {
                        number: true
                    },
                    name: {
                        required: true
                    },
                    gender: {
                        required: true
                    },
                    dob: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    email1: {
                        required: true,
                        email: true,

                        remote:"{{ URL::asset(env('APP_URL').'/hris/employee/others/check-email-exising') }}"
                    },
                    name_bank1: {
                        required: true
                    },
                    ac_bank1: {
                        number: true,
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-bank-exising') }}"
                    },
                    an_bank1: {
                        required: true
                    },
                    ac_bank2: {
                        number: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-bank-exising') }}"
                    },
                    swift: {
                        required: true
                    },
                    citizenship: {
                        required: true
                    },
                    nationality: {
                        required: true
                    },
                    tax_remark: {
                        required: true
                    },
                    marital: {
                        required: true
                    },
                    marital: {
                        required: true
                    },
                    passport: {
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-passport') }}"
                    },
                    passport_date: {
                        required: true
                    },
                    id_card: {
                        number: true,
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-ktp') }}"
                   },
                    file: {
                        accept: "image/jpeg, image/pjpeg"
                    },
                    tin: {
                        required: true
                    },
                    phic: {
                        required: true
                    },
                    sss: {
                        required: true
                    },
                    hdmf: {
                        required: true
                    },
                },
                messages: {
                    email1: {
                        remote: "Email existing"
                    },
                    ac_bank1: {
                        remote: "Bank existing"
                    },
                    ac_bank2: {
                        remote: "Bank existing"
                    },
                    file: {
                        remote: "Please enter a value with JPEG Format"
                    },

                },
                highlight: function (element) {
                    $(element).closest('.validate').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.validate').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
        //submit Detail Contract
        $(document).on("submit", "#formInput", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInput')[0];
            // Create an FormData object
            var data = new FormData(form);
            // If you want to add an extra field for the FormData
            data.append("CustomField", "This is some extra data, testing");
            // disabled the submit button
            $("#btnSubmit").prop("disabled", true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
            $.ajax({
                type: "POST",
                async: true,
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/doadd') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                        $('#modalAction').modal('hide');
                        toastr.success('Add successfully');
                        setTimeout(function () {
                            location . reload();
                        }, 1000);
                    } else {
                        $('#modalAction').modal('hide');
                        toastr.error("Failed", "Your action is failed :)",{timeOut: 2000});
                    }
                },
                error: function (e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
            event.stopImmediatePropagation();
            return false;
        });

        function addFunctionChild(e) {
        dataid = $(e).attr('dataid');
        name_child = $('#name_child' + dataid).val();

        if (name_child == '' || dataid == 3) {
            var msg = '<div class="alert alert-danger alert-dismissable">Fields can not be empty</div>';
            $("#errorChild").html(msg);
            $('#errorChild').alert();
            $('#errorChild').fadeTo(2000, 500).slideUp(500, function () {
                $('#errorChild').hide();

            });
        } else {
            newdataid = parseInt(dataid) + 1;
            $('#actionChild_' + dataid).hide();




htm =`
<div id="row_${newdataid}">
    <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
        <i class="fa fa-address-card"></i>
        Child ${newdataid}
    </div>
    <div id="errorChild"></div>
    <div class="row">
        <div class="col-md-12" style="padding: 10px 15px">
            <div class="col-md-4">
                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                    Name
                </div>
            </div>
            <div class="col-md-8 validate">
                <input autocomplete="off" name="name_child${newdataid}" id="name_child${newdataid}" placeholder="Enter Name" type="text" class="form-control emergencyName" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;">
            </div>
        </div>
        <div class="col-md-12" style="padding: 10px 15px">
            <div class="col-md-4">
                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                    Date Of Birth
                </div>
            </div>
            <div class="col-md-8 validate">
                <input autocomplete="off" name="dob_child${newdataid}" id="dob_child${newdataid}" placeholder="Enter Date" type="text" class="form-control  date-picker" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" autocomplete="off"
                    data-date-format="dd/mm/yyyy">
            </div>
        </div>
        <div class="col-md-12" style="padding: 10px 15px">
            <div class="col-md-4">
                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                    Gender
                </div>
            </div>
            <div class="col-md-8 validate">
                <select autocomplete="off" name="gender_child${newdataid}" id="gender_child${newdataid}" autocomplete="off" class="form-control">
                    <option value="">-- Choose a Gender --</option>
                    <option value="L">Male</option>
                    <option value="P">Female</option>
                </select>
            </div>
        </div>
        <div class="col-md-12" id="actionChild_${newdataid}" style="margin-top:10px;">
            <a id="add_${newdataid}" dataid="${newdataid}" class="btn btn-primary" onclick="addFunctionChild(this);">
                <font style="color:white">Add New</font>
            </a>
            &nbsp;
            <a id="delete_${newdataid}" dataid="${newdataid}" class="btn btn-danger" onclick="deleteFunctionChild(this);">
                <i class="fa fa-minus" style="color:white"></i>
            </a>
        </div>

    </div>
</div>`;












            $('#div_Child').append(htm);
            $('#count_child').val(newdataid);
        }

    }

    function deleteFunctionChild(e) {
        dataid = $(e).attr('dataid');
        $('#actionChild_' + dataid).remove();
        newdataid = parseInt(dataid) - 1;
        $('#row_' + dataid).remove();
        $('#actionChild_' + newdataid).show();
        $('#count_child').val(newdataid);
    }


        function addFunctionbank(e) {
        dataid = $(e).attr('dataid');
        name_bank = $('#name_bank' + dataid).val();

        if (name_bank == ''|| dataid == 2) {
            var msg = '<div class="alert alert-danger alert-dismissable">Fields can not be empty</div>';
            $("#errorbank").html(msg);
            $('#errorbank').alert();
            $('#errorbank').fadeTo(2000, 500).slideUp(500, function () {
                $('#errorbank').hide();

            });
        } else {
            newdataid = parseInt(dataid) + 1;
            $('#actionbank_' + dataid).hide();
            htm ='  <div class="row" id="rowbank' + newdataid + '">'+
                            '<div class="col-md-4 form-group validate">'+
                                        '<select autocomplete="off" name="name_bank' + newdataid + '" id="name_bank' + newdataid + '" autocomplete="off" class="form-control">'+
                                            '<option value="">-- Choose a Bank --</option>'+
                                            '@for($i = 0; $i < count($bank->result); $i++)'+
                                            '<option value="{{$bank->result[$i]->bank_id}}">{{$bank->result[$i]->bank_name}}</option>'+
                                            '@endfor'+
                                        '</select>'+
                            '</div>'+
                            '<div class="col-md-4 form-group validate" style="margin-left:15px">'+
                                '<input autocomplete="off" type="text" name="ac_bank' + newdataid + '" id="ac_bank' + newdataid + '" autocomplete="off" class="form-control">'+
                            '</div>'+
                            '<div class="col-md-4 form-group validate" style="margin-left:15px">'+
                                '<input autocomplete="off" type="text"  name="an_bank' + newdataid + '" id="an_bank' + newdataid + '" autocomplete="off" class="form-control">'+
                            '</div>'+
                        '</div>'+
                        '<div class="row" id="actionbank_' + newdataid + '" style="margin-top:5px">'+
                            '<div class="col-xs-6">'+
                                '<div class="form-group validate">'+
                                    '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctionbank(this);">'+
                                        '<font style="color:white">Add New</font>'+
                                    '</a>'+
                                    '&nbsp;'+
                                    '<a id="delete_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-danger" onclick="deleteFunctionbank(this);">' +
                                        '<i class="fa fa-minus" style="color:white"></i>' +
                                    '</a>' +
                                '</div>'+
                            '</div>'+
                        '</div>';

            $('#div_bank').append(htm);
            $('#count_bank').val(newdataid);
        }

    }

    function deleteFunctionbank(e) {
        dataid = $(e).attr('dataid');
        $('#actionbank_' + dataid).remove();
        newdataid = parseInt(dataid) - 1;
        $('#rowbank' + dataid).remove();
        $('#actionbank_' + newdataid).show();
        $('#count_bank').val(newdataid);
    }


    function family_cond() {
        var marital = document.getElementById("marital").value;

        if(marital == 'S'){
            $('#family').hide();

        }else{
            $('#family').show();

        }
    }

    $(function() {
        $( ".date-picker" ).datepicker();
    });



function setHeight() {
    this.style.height = '1px';
    this.style.height = this.scrollHeight + 'px';
}

function checkCitizenship(citizenship) {
    if (citizenship.value == "local") {
        document.getElementsByClassName('local-only')[0].style.display = "block";
        document.getElementsByClassName('expatriate-only')[0].style.display = "none";
        document.getElementById("bank2").style.display = "none";
    } else if (citizenship.value == "expatriate") {
        document.getElementsByClassName('local-only')[0].style.display = "none";
        document.getElementsByClassName('expatriate-only')[0].style.display = "block";
        document.getElementById("bank2").style.display = "block";

    }

}

function onFocus(input, type, flag){

    if(type == "radio"){
        input.parentNode.style.color = "#414040";
    } else{
        input.style.color = "#414040";
        input.style.borderColor = "#0584D3";
    }

    if(flag == "compare"){
        onHighlight(input);
    }
}

function onHighlight(input){
    var className = '';
    if(input.classList.contains('name')){
        className = 'recruitment-name';
    } else if(input.classList.contains('email')){
        className = 'recruitment-email';
    } else if(input.classList.contains('hp')){
        className = 'recruitment-hp';
    } else if(input.classList.contains('gender')){
        className = 'recruitment-gender';
    } else if(input.classList.contains('birthplace')){
        className = 'recruitment-birthplace';
    } else if(input.classList.contains('birth')){
        className = 'recruitment-birth';
    } else if(input.classList.contains('religion')){
        className = 'recruitment-religion';
    } else if(input.classList.contains('marital')){
        className = 'recruitment-marital';
    } else if(input.classList.contains('nationality')){
        className = 'recruitment-nationality';
    } else if(input.classList.contains('address')){
        className = 'recruitment-address';
    } else if(input.classList.contains('emergencyName')){
        className = 'recruitment-emergencyName';
    } else if(input.classList.contains('emergencyRelationship')){
        className = 'recruitment-emergencyRelationship';
    } else if(input.classList.contains('emergencyContact')){
        className = 'recruitment-emergencyContact';
    } else {
        className = '';
    }

    if (className != ''){
        document.getElementsByClassName(className)[0].style.color = "#414040";
        document.getElementsByClassName(className)[0].style.borderColor = "#0584D3";
        document.getElementsByClassName(className)[1].style.color = "#414040";
        document.getElementsByClassName(className)[1].style.borderColor = "#0584D3";
    }
}

function onBlur(input, type, flag){

    if(type == "radio"){
        input.parentNode.style.color = "#BDBDBD";
    } else{
        input.style.color = "#BDBDBD";
        input.style.borderColor = "#BDBDBD";
    }

    if(flag == "compare"){
        onRemoveHighlight(input);
    }
}

function onRemoveHighlight(input){
    var className = '';
    if(input.classList.contains('name')){
        className = 'recruitment-name';
    } else if(input.classList.contains('email')){
        className = 'recruitment-email';
    } else if(input.classList.contains('hp')){
        className = 'recruitment-hp';
    } else if(input.classList.contains('gender')){
        className = 'recruitment-gender';
    } else if(input.classList.contains('birthplace')){
        className = 'recruitment-birthplace';
    } else if(input.classList.contains('birth')){
        className = 'recruitment-birth';
    } else if(input.classList.contains('religion')){
        className = 'recruitment-religion';
    } else if(input.classList.contains('marital')){
        className = 'recruitment-marital';
    } else if(input.classList.contains('nationality')){
        className = 'recruitment-nationality';
    } else if(input.classList.contains('address')){
        className = 'recruitment-address';
    } else if(input.classList.contains('emergencyName')){
        className = 'recruitment-emergencyName';
    } else if(input.classList.contains('emergencyRelationship')){
        className = 'recruitment-emergencyRelationship';
    } else if(input.classList.contains('emergencyContact')){
        className = 'recruitment-emergencyContact';
    } else {
        className = '';
    }

    if(className != ''){
        document.getElementsByClassName(className)[0].style.color = "#BDBDBD";
        document.getElementsByClassName(className)[0].style.borderColor = "#BDBDBD";
        document.getElementsByClassName(className)[1].style.color = "#BDBDBD";
        document.getElementsByClassName(className)[1].style.borderColor = "#BDBDBD";
    }
}

</script>
