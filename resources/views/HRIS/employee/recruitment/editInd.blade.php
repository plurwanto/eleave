<form id="formInputEdit" class="form form-horizontal">
    <div class="modal-content">
        <div class="modal-header" style="padding: 10px; background-color: #333942; color: #fff; border-bottom: unset;">
            <button class="close" style="filter: brightness(0) invert(1); opacity: 1;" data-dismiss="modal"></button>
            <h4 class="modal-title">Add Employee</h4>
        </div>
        <div class="modal-body" style="padding: 0; background-color: #F5F5F5;">
            <div class="row">
                <div class="col-md-6">
                    <div style="background-color: #fff; width: 100%; display: inline-block;vertical-align:top; border-left: 1px solid #BDBDBD;">
                        <div style="float: right; background-color: #E91E63; text-transform: uppercase; color: #fff; width: 150px; border-radius: 3px !important;border-bottom-left-radius: 10px !important; text-align: center; padding: 5px;">
                            hris
                        </div>
                    </div>
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
                                                @if($employee2->employee->mem_citizenship =='local')
                                                <input type="radio" class="form-control" name="citizenship" id="citizenship"  value="local" checked="checked" onclick="checkCitizenship(this);">
                                                @else
                                                <input type="radio" class="form-control" name="citizenship" id="citizenship"  value="local" onclick="checkCitizenship(this);">
                                                @endif
                                                Local
                                                <span></span>
                                            </label>
                                            <label class="mt-radio" style="font-size: 12px; margin-bottom: 0">
                                                @if($employee2->employee->mem_citizenship =='expatriate')
                                                <input type="radio" class="form-control" name="citizenship" id="citizenship"  value="expatriate" checked="checked" onclick="checkCitizenship(this);">
                                                @else
                                                <input type="radio" class="form-control" name="citizenship" id="citizenship"  value="expatriate" onclick="checkCitizenship(this);">
                                                @endif
                                                Expatriate
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
                                            <input name="passport" type="text" value="{{$employee2->employee->mem_passport}}" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Passport Expired Date
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <input name="passport_date" type="text" value="{{$employee2->employee->mem_exp_passport}}" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
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
                                            <input name="id_card" type="text" value="{{$employee2->employee->mem_ktp_no}}" class="form-control" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
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
                                        <input name="name" type="text" value="{{$employee2->employee->mem_name}}" class="form-control name" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Email
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input name="email1" type="text" value="{{$employee2->employee->mem_email}}" class="form-control email" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            No. Handphone
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input name="mobile1" type="text" value="{{$employee2->employee->mem_mobile}}" class="form-control hp" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Gender
                                        </div>
                                    </div>
                                    <div class="col-md-8" style="color: #414040!important">
                                        <div class="mt-radio-inline" style="height: 31px; vertical-align: middle; display: table-cell; padding: 0">
                                            <label class="mt-radio" style="font-size: 12px; margin-bottom: 0">
                                                @if($employee2->employee->mem_gender =='L')
                                                <input type="radio" name="gender"  value="L" checked="checked" >
                                                @else
                                                <input type="radio" name="gender"  value="L" >
                                                @endif
                                                Male
                                                <span></span>
                                            </label>
                                            <label class="mt-radio" style="font-size: 12px; margin-bottom: 0">
                                                @if($employee2->employee->mem_gender =='P')
                                                <input type="radio" name="gender"  value="P" checked="checked"  checked >
                                                @else
                                                <input type="radio" name="gender"  value="P"  checked >
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
                                        <input name="pob" value="{{$employee2->employee->mem_dob_city}}" type="text" class="form-control birthplace" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Date of Birth
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div style="display: flex">
                                        <input autocomplete="off" name="dob" id="dob" placeholder="Enter Date of Birth" type="text" class="form-control date-picker" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" value="{{$employee2->employee->mem_dob}}" autocomplete="off"
                                            data-date-format="dd/mm/yyyy">
                                        </div>
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
                                            if($employee2->employee->religi_id == $religion->result[$i]->religi_id){
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
                                        <select name="marital" id="marital" autocomplete="off" class="form-control"  onchange="family_cond()"  >
                                            <option value="">-- Choose a Marital --</option>
                                            @php
                                            for($i = 0; $i < count($marital->result); $i++){
                                                if($employee2->employee->mem_marital_id == $marital->result[$i]->mem_marital_id){
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
                                    <select name="nationality" autocomplete="off" class="form-control"  >
                                        <option value="">-- Choose a nationality --</option>
                                        @php
                                        for($i = 0; $i < count($nationality->result); $i++){
                                                if($employee2->employee->mem_nationality == $nationality->result[$i]->nat_id){
                                                    echo '<option value="'.$nationality->result[$i]->nat_id.'" selected>'.$nationality->result[$i]->nat_name.'</option>';
                                                }else{
                                                    echo '<option value="'.$nationality->result[$i]->nat_id.'">'.$nationality->result[$i]->nat_name.'</option>';
                                                }
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
                                        <textarea name="address" onfocus="onFocus(this,'', 'compare'); setHeight.call(this);" onblur="onBlur(this,'', 'compare');" class="form-control address" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; min-height: 30px; overflow:hidden; resize: none;" onkeyup="setHeight.call(this);">{{$employee2->employee->mem_address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Join Date
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input autocomplete="off" name="join_date" id="join_date" placeholder="Enter Date of Birth" type="text" class="form-control date-picker" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" value="{{$employee->employee->mem_join_date}}" autocomplete="off"
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
                                        <input name="emgName" value="{{$employee2->employee->mem_emergency_name}}" type="text" class="form-control emergencyName" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
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
                                            @php
                                                $relationship =['1','2','3'];
                                                $relationship_name =['Parents','Brotherhood','Other'];
                                                for($i = 0; $i < count($relationship); $i++){
                                                    if($employee2->employee->mem_emergency_relationship == $relationship[$i]){
                                                        echo '<option value="'. $relationship[$i] .'" selected>'. $relationship_name[$i] .'</option>';
                                                    }else{
                                                        echo '<option value="'. $relationship[$i] .'">'. $relationship_name[$i] .'</option>';
                                                    }
                                                }
                                            @endphp
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
                                        <input name="emgMobile" value="{{$employee2->employee->mem_emergency_mobile}}" type="text" class="form-control emergencyContact" style="border: 1px solid #BDBDBD; font-size: 12px; color: #414040; border-radius: 3px !important; height: 31px;" >
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
                                        <input type="text" name="name_spouse"  value="{{$employee2->employee->mem_spouse_name}}" autocomplete="off" class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Date Of Birth
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                        <input type="text" name="dob_spouse"  value="{{$employee2->employee->mem_spouse_dob}}" autocomplete="off" class="form-control date-picker"
                                                placeholder="Enter Date" data-date-format="dd/mm/yyyy" onclick="$('#dob_spouse').datepicker();$('#dob_spouse').datepicker('show');">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 10px 15px">
                                        <div class="col-md-4">
                                            <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                Gender
                                            </div>
                                        </div>
                                        <div class="col-md-8 validate">
                                            <select name="gender_spouse" autocomplete="off" class="form-control">
                                                <option value="">-- Choose a Gender --</option>
                                                @php
                                                    $gender_spouse =['L','P'];
                                                    $gender_spouse_name =['Male','Female'];
                                                    for($i = 0; $i < count($gender_spouse); $i++){
                                                        if($employee2->employee->mem_spouse_gender == $gender_spouse[$i]){
                                                            echo '<option value="'. $gender_spouse[$i] .'" selected>'. $gender_spouse_name[$i] .'</option>';
                                                        }else{
                                                            echo '<option value="'. $gender_spouse[$i] .'">'. $gender_spouse_name[$i] .'</option>';
                                                        }
                                                    }
                                                    @endphp
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
                                            <input type="text" name="name_child1" value="{{$employee2->employee->mem_child1_name}}" id="name_child1" autocomplete="off" class="form-control"
                                                    placeholder="Enter Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Date Of Birth
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                            <input type="text" name="dob_child1" value="{{$employee2->employee->mem_child1_dob}}" autocomplete="off" placeholder="Enter Date" autocomplete="off" class="form-control date-picker"
                                                    data-date-format="dd/mm/yyyy" onclick="$('#dob_child1').datepicker();$('#dob_child1').datepicker('show');">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Gender
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                                <select name="gender_child1" id="gender_child1" autocomplete="off" class="form-control">
                                                    <option value="">-- Choose a Gender --</option>
                                                    @php
                                                    $gender_child1 =['L','P'];
                                                    $gender_child1_name =['Male','Female'];
                                                    for($i = 0; $i < count($gender_child1); $i++){
                                                        if($employee2->employee->mem_child1_gender == $gender_child1[$i]){
                                                            echo '<option value="'. $gender_child1[$i] .'" selected>'. $gender_child1_name[$i] .'</option>';
                                                        }else{
                                                            echo '<option value="'. $gender_child1[$i] .'">'. $gender_child1_name[$i] .'</option>';
                                                        }
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                    </div>




                                    <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
                                        <i class="fa fa-address-card"></i>
                                        Child 2
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
                                            <input type="text" name="name_child1" value="{{$employee2->employee->mem_child2_name}}" id="name_child1" autocomplete="off" class="form-control"
                                                    placeholder="Enter Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Date Of Birth
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                            <input type="text" name="dob_child1" value="{{$employee2->employee->mem_child2_dob}}" autocomplete="off" placeholder="Enter Date" autocomplete="off" class="form-control date-picker"
                                                    data-date-format="dd/mm/yyyy" onclick="$('#dob_child1').datepicker();$('#dob_child1').datepicker('show');">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Gender
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                                <select name="gender_child1" id="gender_child1" autocomplete="off" class="form-control">
                                                    <option value="">-- Choose a Gender --</option>
                                                    @php
                                                    $gender_child2 =['L','P'];
                                                    $gender_child2_name =['Male','Female'];
                                                    for($i = 0; $i < count($gender_child2); $i++){
                                                        if($employee2->employee->mem_child2_gender == $gender_child2[$i]){
                                                            echo '<option value="'. $gender_child2[$i] .'" selected>'. $gender_child2_name[$i] .'</option>';
                                                        }else{
                                                            echo '<option value="'. $gender_child2[$i] .'">'. $gender_child2_name[$i] .'</option>';
                                                        }
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                    </div>







                                    <div style="color: #0584D3 !important; font-weight: bold; border-top: 1px solid #BDBDBD; padding: 10px 0; margin-top: 10px;">
                                        <i class="fa fa-address-card"></i>
                                        Child 3
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
                                            <input type="text" name="name_child1" value="{{$employee2->employee->mem_child3_name}}" id="name_child1" autocomplete="off" class="form-control"
                                                    placeholder="Enter Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Date Of Birth
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                            <input type="text" name="dob_child1" value="{{$employee2->employee->mem_child3_dob}}" autocomplete="off" placeholder="Enter Date" autocomplete="off" class="form-control date-picker"
                                                    data-date-format="dd/mm/yyyy" onclick="$('#dob_child1').datepicker();$('#dob_child1').datepicker('show');">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 10px 15px">
                                            <div class="col-md-4">
                                                <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                                    Gender
                                                </div>
                                            </div>
                                            <div class="col-md-8 validate">
                                                <select name="gender_child1" id="gender_child1" autocomplete="off" class="form-control">
                                                    <option value="">-- Choose a Gender --</option>
                                                    @php
                                                    $gender_child3 =['L','P'];
                                                    $gender_child3_name =['Male','Female'];
                                                    for($i = 0; $i < count($gender_child3); $i++){
                                                        if($employee2->employee->mem_child3_gender == $gender_child3[$i]){
                                                            echo '<option value="'. $gender_child3[$i] .'" selected>'. $gender_child3_name[$i] .'</option>';
                                                        }else{
                                                            echo '<option value="'. $gender_child3[$i] .'">'. $gender_child3_name[$i] .'</option>';
                                                        }
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
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
                                        <select name="insurance" autocomplete="off" class="form-control">
                                            <option value="">-- Choose a Insurance --</option>
                                            @php
                                            for($i = 0; $i < count($insurance->result); $i++){
                                                if($employee2->employee->insr_id == $insurance->result[$i]->insr_id){
                                                    echo '<option value="'.$insurance->result[$i]->insr_id.'" selected>'.$insurance->result[$i]->insr_name.'</option>';
                                                }else{
                                                    echo '<option value="'.$insurance->result[$i]->insr_id.'">'.$insurance->result[$i]->insr_name.'</option>';
                                                }
                                            }
                                        @endphp
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
                                        <select name="tax_remark" autocomplete="off" class="form-control">
                                            <option value="">-- Choose a Remark --</option>
                                            @php
                                            for($i = 0; $i < count($tax_remark->result); $i++){
                                                    if($employee2->employee->tr_id == $tax_remark->result[$i]->tr_id){
                                                        echo '<option value="'.$tax_remark->result[$i]->tr_id.'" selected>'.$tax_remark->result[$i]->tr_name.'</option>';
                                                    }else{
                                                        echo '<option value="'.$tax_remark->result[$i]->tr_id.'">'.$tax_remark->result[$i]->tr_name.'</option>';
                                                    }
                                                }
                                            @endphp
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
                                        <input type="text" name="tax_number"  value="{{$employee2->employee->mem_npwp_no}}" autocomplete="off" class="form-control" placeholder="Enter Tax Number">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            KPJ Number <span style="font-size: 10px;">(optional)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                    <input type="text" name="bpjs_ket"  value="{{$employee2->employee->mem_jamsostek}}" autocomplete="off" class="form-control" placeholder="Enter Number">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Jaminan Pensiun Number <span style="font-size: 10px;">(optional)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input type="text" name="bpjs_pen" value="{{$employee2->employee->mem_bpjs_pen}}" autocomplete="off" class="form-control" placeholder="Enter Number">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            VA BPJS Kesehatan <span style="font-size: 10px;">(optional)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <input type="text" name="bpjs_kes" value="{{$employee2->employee->mem_bpjs_kes}}" autocomplete="off" class="form-control" placeholder="Enter Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="mem_id" id="mem_id" value="{{$id}}">
                    <input type="hidden" name="mem_id_hris" id="mem_id_hris" value="{{$employee2->employee->mem_id}}">

                </div>
                <div class="col-md-6">
                    <div style="background-color: #fff; width: 100%; display: inline-block;vertical-align:top; border-left: 1px solid #BDBDBD;">
                        <div style="float: right; background-color: #4CAF50; text-transform: uppercase; color: #fff; width: 150px; border-radius: 3px !important; border-bottom-left-radius: 10px !important; text-align: center; padding: 5px; border-left: 1px solid #BDBDBD;">
                            recruitment
                        </div>
                    </div>
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
                                        <div class="recruitment-name" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Name
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-name" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-email" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Email
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-email" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_email}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-hp" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            No. Handphone
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-hp" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_mobile}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-gender" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Gender
                                        </div>
                                    </div>
                                    <div class="col-md-8" style="color: #414040!important">
                                        <div class="recruitment-gender" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            @php
                                            if($employee->employee->mem_gender =='L'){
                                                echo 'Male';
                                            }else{
                                                echo 'Female';
                                            }
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-birthplace" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Place of Birth
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-birthplace" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_dob_city}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-birth" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Date of Birth
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-birth" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_join_date}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-religion" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Religion
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-religion" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->religi_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-marital" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Marital Status
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-marital" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_marital_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-nationality" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Nationality
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-nationality" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->co_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-address" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Address
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-address" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_address}}
                                        </div>
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
                                        <div class="recruitment-emergencyName" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Name
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-emergencyName" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_emergency_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-emergencyRelationship" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Relationship
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-emergencyRelationship" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_emergency_relationship}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 10px 15px">
                                    <div class="col-md-4">
                                        <div class="recruitment-emergencyContact" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle;">
                                            Contact Number
                                        </div>
                                    </div>
                                    <div class="col-md-8 validate">
                                        <div class="recruitment-emergencyContact" style="color: #414040; font-size: 12px; height: 31px; display: table-cell; vertical-align: middle; font-weight: 700;">
                                            {{$employee->employee->mem_emergency_mobile}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="background-color: #F5F5F5; border-top: unset">
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

<script type="text/javascript">
        $(document).ready(function () {
            family_cond();

            if($('input[name=citizenship]:checked').val() =='expatriate'){
                $('#id_card').hide();
                $('#passport').show();
                $('#bank2').show();
            }else{
                $('#id_card').show();
                $('#passport').hide();
                $('#bank2').hide();
            }

            $('#formInputEdit').validate({
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
                    tax_number: {
                        number: true
                    },
                    mobile1: {
                        number: true
                    },
                    join_date: {
                        required: true
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
                        remote: {
                        url: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-email-exising-edit') }}",
                        type: "get",
                        data: {
                            mem_id: function() {
                                return $("#mem_id_hris").val();
                                }
                            }
                        }
                    },
                    ac_bank1: {
                        number: true,
                        required: true,
                        remote: {
                        url: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-bank-exising-edit') }}",
                        type: "get",
                        data: {
                            mem_id: function() {
                                return $("#mem_id_hris").val();
                                }
                            }
                        }
                    },
                    ac_bank2: {
                        number: true,
                        remote: {
                        url: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-bank-exising-edit') }}",
                        type: "get",
                        data: {
                            mem_id: function() {
                                return $("#mem_id_hris").val();
                                }
                            }
                        }
                    },
                    an_bank1: {
                        required: true
                    },
                    name_bank1: {
                        required: true
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
                    passport: {
                        required: true,
                        remote: {
                        url: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-passport-edit') }}",
                        type: "get",
                        data: {
                            mem_id: function() {
                                return $("#mem_id_hris").val();
                                }
                            }
                        }
                    },
                    passport_date: {
                        required: true
                    },
                    id_card: {
                        required: true,
                        number: true,
                        remote: {
                        url: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-ktp-edit') }}",
                        type: "get",
                        data: {
                            mem_id: function() {
                                return $("#mem_id_hris").val();
                                }
                            }
                        }
                    },
                    religion: {
                        required: true
                    },
                },
                messages: {
                        id_card: {
                            remote: "Swift existing"
                        },
                        id_card: {
                            remote: "ID Card existing"
                        },
                        passport: {
                            remote: "Passport existing"
                        },
                        email1: {
                            remote: "Email existing"
                        },
                        ac_bank1: {
                        remote: "Bank existing"
                        },
                        ac_bank2: {
                        remote: "Bank existing"
                        }
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
        $(document).on("submit", "#formInputEdit", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInputEdit')[0];
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
                url: "{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/doedit') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                        $('#modalAction').modal('hide');
                                toastr . success('Action successfully');
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
            htm =   '<div id="row_' + newdataid + '" class="row">'+
                        '<div class="col-md-4">'+
                            '<div class="form-group">'+
                                '<input type="text" name="name_child' + newdataid + '" id="name_child' + newdataid + '" class="form-control">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<input type="text" name="dob_child' + newdataid + '" id="dob_child' + newdataid + '" class="form-control date-picker" data-date-format="dd/mm/yyyy">'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<select name="gender_child' + newdataid + '" id="gender_child' + newdataid + '" class="form-control">'+
                                '<option value="">-- Choose a Gender --</option>'+
                                '<option value="L">Male</option>'+
                                '<option value="P">Female</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row" id="actionChild_' + newdataid + '" style="margin-top:5px">'+
                        '<div class="col-xs-6">'+
                            '<div class="form-group">'+
                                '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctionChild(this);">'+
                                    '<font style="color:white">Add New</font>'+
                                '</a>'+
                                '&nbsp;'+
                                '<a id="delete_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-danger" onclick="deleteFunctionChild(this);">' +
                                    '<i class="fa fa-minus" style="color:white"></i>' +
                                '</a>' +
                            '</div>'+
                        '</div>'+
                    '</div>';

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
                            '<div class="col-md-4">'+
                                '<div class="form-group">'+
                                        '<select name="name_bank' + newdataid + '" id="name_bank' + newdataid + '" class="form-control">'+
                                            '<option value="">-- Choose a Bank --</option>'+
                                            '@for($i = 0; $i < count($bank->result); $i++)'+
                                            '<option value="{{$bank->result[$i]->bank_id}}">{{$bank->result[$i]->bank_name}}</option>'+
                                            '@endfor'+
                                        '</select>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-4">'+
                                '<input type="text" name="ac_bank' + newdataid + '" id="ac_bank' + newdataid + '" class="form-control">'+
                            '</div>'+
                            '<div class="col-md-4">'+
                                '<input type="text"  name="an_bank' + newdataid + '" id="an_bank' + newdataid + '" class="form-control">'+
                            '</div>'+
                        '</div>'+
                        '<div class="row" id="actionbank_' + newdataid + '" style="margin-top:5px">'+
                            '<div class="col-xs-6">'+
                                '<div class="form-group">'+
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
        $( "#date-picker" ).datepicker();
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
