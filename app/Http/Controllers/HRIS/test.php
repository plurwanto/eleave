<?
public function doUploadPhi(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $current_datetime = date('Y-m-d H:i:s');

        $getMarital = Employee::getMarital();

        $noMarital = 1;
        $noMarital2 = "";
        $codeMarital = "";
        foreach ($getMarital as $row) {
            $noMarital2 .= $noMarital++ . ',';
            $codeMarital .= $row->mem_marital_id . ',';
        }
        $codeMarital = explode(",", substr($codeMarital, 0, -1));
        $noMarital2 = explode(",", substr($noMarital2, 0, -1));

        $getReligion = Employee::getReligion();
        $noReligion = 1;
        $noReligion2 = "";
        $codeReligion = "";
        foreach ($getReligion as $row) {
            $noReligion2 .= $noReligion++ . ',';
            $codeReligion .= $row->religi_id . ',';
        }
        $codeReligion = explode(",", substr($codeReligion, 0, -1));
        $noReligion2 = explode(",", substr($noReligion2, 0, -1));

        $getNationality = Employee::getNationality();
        $noNationality = 1;
        $noNationality2 = "";
        $codeNationality = "";
        foreach ($getNationality as $row) {
            $noNationality2 .= $noNationality++ . ',';
            $codeNationality .= $row->nat_id . ',';
        }
        $codeNationality = explode(",", substr($codeNationality, 0, -1));
        $noNationality2 = explode(",", substr($noNationality2, 0, -1));

        $getInsurance = Employee::getInsurance();
        $noInsurance = 1;
        $noInsurance2 = "";
        $codeInsurance = "";
        foreach ($getInsurance as $row) {
            $noInsurance2 .= $noInsurance++ . ',';
            $codeInsurance .= $row->insr_id . ',';
        }
        $codeInsurance = explode(",", substr($codeInsurance, 0, -1));
        $noInsurance2 = explode(",", substr($noInsurance2, 0, -1));

        $getTaxRemark = Employee::getTaxRemark();
        $noTaxRemark = 1;
        $noTaxRemark2 = "";
        $codeTaxRemark = "";
        foreach ($getTaxRemark as $row) {
            $noTaxRemark2 .= $noTaxRemark++ . ',';
            $codeTaxRemark .= $row->tr_id . ',';
        }
        $codeTaxRemark = explode(",", substr($codeTaxRemark, 0, -1));
        $noTaxRemark2 = explode(",", substr($noTaxRemark2, 0, -1));

        $getBank = Employee::getBank();
        $noBank = 1;
        $noBank2 = "";
        $codeBank = "";
        foreach ($getBank as $row) {
            $noBank2 .= $noBank++ . ',';
            $codeBank .= $row->bank_id . ',';
        }
        $codeBank = explode(",", substr($codeBank, 0, -1));
        $noBank2 = explode(",", substr($noBank2, 0, -1));

        $RetrunError = [];
        $wrongList = [];
        $idEmployee = [];

        if ($request->has('token')) {
            $user_active = User::userActive($request->token);

            if ($user_active) {
                $result_user = User::userByToken($request->token);

                if (!empty($result_user)) {
                    DB::beginTransaction();
                    for ($i = 0; $i < count($request->member); $i++) {

                        $name = $request->member[$i]['name'];
                        $alias_name = $request->member[$i]['alias_name'];
                        $gender = $request->member[$i]['gender'];
                        $join_date = $request->member[$i]['join_date'];
                        $place_of_birth = $request->member[$i]['place_of_birth'];
                        $date_of_birth = $request->member[$i]['date_of_birth'];
                        $marital_status = $request->member[$i]['marital_status'];
                        $religion = $request->member[$i]['religion'];
                        $address = $request->member[$i]['address'];
                        $mobile_1 = $request->member[$i]['mobile_1'];
                        $email = $request->member[$i]['email'];
                        $id_card = $request->member[$i]['id_card'];
                        $nationality = $request->member[$i]['nationality'];
                        $passport = $request->member[$i]['passport'];
                        $date_of_end_passport = $request->member[$i]['date_of_end_passport'];
                        $last_education = $request->member[$i]['last_education'];
                        $bank1_id = $request->member[$i]['bank1_id'];
                        $bank1_account = $request->member[$i]['bank1_account'];
                        $bank1_name = $request->member[$i]['bank1_name'];
                        $spouse_name = $request->member[$i]['spouse_name'];
                        $spouse_date_of_birth = $request->member[$i]['spouse_date_of_birth'];
                        $spouse_gender = $request->member[$i]['spouse_gender'];
                        $child1_name = $request->member[$i]['child1_name'];
                        $child1_date_of_birth = $request->member[$i]['child1_date_of_birth'];
                        $child1_gender = $request->member[$i]['child1_gender'];
                        $child2_name = $request->member[$i]['child2_name'];
                        $child2_date_of_birth = $request->member[$i]['child2_date_of_birth'];
                        $child2_gender = $request->member[$i]['child2_gender'];
                        $child3_name = $request->member[$i]['child3_name'];
                        $child3_date_of_birth = $request->member[$i]['child3_date_of_birth'];
                        $child3_gender = $request->member[$i]['child3_gender'];
                        $tax_remark = $request->member[$i]['tax_remark'];
                        $insurance = $request->member[$i]['insurance'];
                        $citizenship = $request->member[$i]['citizenship'];
                        $tax_number_general = $request->member[$i]['tax_number_general'];
                        $tin = $request->member[$i]['tin'];
                        $phic = $request->member[$i]['phic'];
                        $sss = $request->member[$i]['sss'];
                        $hdmf = $request->member[$i]['hdmf'];
                        $user_level = $request->member[$i]['user_level'];

                        $var = [
                            $name,
                            $gender,
                            $join_date,
                            $date_of_birth,
                            $marital_status,
                            $religion,
                            $address,
                            $mobile_1,
                            $email,
                            $nationality,
                            $bank1_id,
                            $bank1_account,
                            $bank1_name,
                            $tax_remark,
                            $citizenship,
                            $tin,
                            $phic,
                            $sss,
                            $hdmf,
                            $user_level,
                        ];

                        $var_name = [
                            'name',
                            'gender',
                            'join date',
                            'date of birth',
                            'marital status',
                            'religion',
                            'address',
                            'mobile 1',
                            'email',
                            'nationality',
                            'bank1 id',
                            'bank1 account',
                            'bank1 name',
                            'tax remark',
                            'citizenship',
                            'tin',
                            'phic',
                            'sss',
                            'hdmf',
                            'user level'];

                        $RetrunError = [];
                        for ($a = 0; $a < count($var); $a++) {
                            if (($var[$a] == "" || stristr($var[$a], 'E+') == true)) {
                                $RetrunError[] = [
                                    'message' => $var_name[$a] . ' empty or there is an E + character',
                                ];
                            }
                        }
                        if ($citizenship == 2) {
                            if (($passport == "" || stristr($passport, 'E+') == true)) {
                                $RetrunError[] = [
                                    'message' => 'Passport empty or there is an E + character',
                                ];
                            }

                            if (($date_of_end_passport == "" || stristr($date_of_end_passport, 'E+') == true)) {
                                $RetrunError[] = [
                                    'message' => 'Date of end passport empty or there is an E + character',
                                ];
                            }

                            $getPassport = Employee::getPassport($passport);
                            if ($getPassport && $passport != "") {
                                $RetrunError[] = [
                                    'message' => 'Passport number is already exist',
                                ];
                            }
                        } else {
                            if (($id_card == "" || stristr($id_card, 'E+') == true)) {
                                $RetrunError[] = [
                                    'message' => 'ID Card empty or there is an E + character',
                                ];
                            }

                            $getKTP = Employee::getKTP($id_card);
                            if ($getKTP && $id_card != "") {
                                $RetrunError[] = [
                                    'message' => 'KTP number is already exist',
                                ];
                            }
                        }

                        $getEmail = Employee::getEmail($email);
                        if ($getEmail && $email != "") {
                            $RetrunError[] = [
                                'message' => 'Email is already exist',
                            ];
                        }

                        $getBankAc = Employee::getBankAc($bank1_account);
                        if ($getBankAc && $bank1_account != "") {
                            $RetrunError[] = [
                                'message' => 'bank account is already exist',
                            ];
                        }
                        if (!in_array($citizenship, [1, 2])) {
                            $RetrunError[] = [
                                'message' => 'Citizenship wrong code',
                            ];
                        } else {
                            if ($citizenship == 2) {
                                $citizenship = 'expatriate';
                            } else {
                                $citizenship = 'local';
                            }
                        }

                        if (($gender != "" && stristr($gender, 'E+') == false)) {
                            if (!in_array($gender, [1, 2])) {
                                $RetrunError[] = [
                                    'message' => 'Gender wrong code',
                                ];
                            } else {
                                if ($gender == 2) {
                                    $gender = 'L';
                                } else {
                                    $gender = 'P';
                                }
                            }
                        }

                        if (($spouse_gender != "" && stristr($spouse_gender, 'E+') == false)) {
                            if (!in_array($spouse_gender, [1, 2])) {
                                $RetrunError[] = [
                                    'message' => 'spouse gender wrong code',
                                ];
                            } else {
                                if ($spouse_gender == 2) {
                                    $spouse_gender = 'L';
                                } else {
                                    $spouse_gender = 'P';
                                }
                            }

                        }

                        if (($child1_gender != "" && stristr($child1_gender, 'E+') == false)) {
                            if (!in_array($child1_gender, [1, 2])) {
                                $RetrunError[] = [
                                    'message' => 'child1_gender wrong code',
                                ];
                            } else {
                                if ($child1_gender == 2) {
                                    $child1_gender = 'L';
                                } else {
                                    $child1_gender = 'P';
                                }
                            }

                        }

                        if (($child2_gender != "" && stristr($child2_gender, 'E+') == false)) {
                            if (!in_array($child2_gender, [1, 2])) {
                                $RetrunError[] = [
                                    'message' => 'child2 gender wrong code',
                                ];
                            } else {
                                if ($child2_gender == 2) {
                                    $child2_gender = 'L';
                                } else {
                                    $child2_gender = 'P';
                                }
                            }

                        }

                        if (($child3_gender != "" && stristr($child3_gender, 'E+') == false)) {
                            if (!in_array($child3_gender, [1, 2])) {
                                $RetrunError[] = [
                                    'message' => 'child3 gender wrong code',
                                ];
                            } else {
                                if ($child3_gender == 2) {
                                    $child3_gender = 'L';
                                } else {
                                    $child3_gender = 'P';
                                }
                            }

                        }

                        if (($marital_status != "" && stristr($marital_status, 'E+') == false)) {
                            if (!in_array($marital_status, $noMarital2)) {
                                $RetrunError[] = [
                                    'message' => 'Marital wrong code',
                                ];
                            } else {
                                $marital_status = $codeMarital[$marital_status - 1];
                            }
                        }

                        if (($religion != "" && stristr($religion, 'E+') == false)) {
                            if (!in_array($religion, $noReligion2)) {
                                $RetrunError[] = [
                                    'message' => 'Religion wrong code',
                                ];
                            } else {
                                $religion = $codeReligion[$religion - 1];
                            }
                        }

                        if (($nationality != "" && stristr($nationality, 'E+') == false)) {
                            if (!in_array($nationality, $noNationality2)) {
                                $RetrunError[] = [
                                    'message' => 'Nationality wrong code',
                                ];
                            } else {
                                $nationality = $codeNationality[$nationality - 1];
                            }
                        }

                        if (($insurance != "" && stristr($insurance, 'E+') == false)) {
                            if (!in_array($insurance, $noInsurance2)) {
                                $RetrunError[] = [
                                    'message' => 'Insurance wrong code',
                                ];
                            } else {
                                $insurance = $codeInsurance[$insurance - 1];
                            }
                        }

                        if (($tax_remark != "" && stristr($tax_remark, 'E+') == false)) {
                            if (!in_array($tax_remark, $noTaxRemark2)) {
                                $RetrunError[] = [
                                    'message' => 'Tax Remark wrong code',
                                ];
                            } else {
                                $tax_remark = $codeTaxRemark[$tax_remark - 1];
                            }
                        }

                        if (($bank1_id != "" && stristr($bank1_id, 'E+') == false)) {
                            if (!in_array($bank1_id, $noBank2)) {
                                $RetrunError[] = [
                                    'message' => 'Account Bank wrong code',
                                ];
                            } else {
                                $bank1_id = $codeBank[$bank1_id - 1];
                            }
                        }

                        //////// others validasi
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $RetrunError[] = [
                                'message' => 'Invalid email format',
                            ];
                        }

                        if (is_numeric($bank1_account) != true) {
                            $RetrunError[] = [
                                'message' => 'bank 1 account Number Only',
                            ];
                        }

                        if (($join_date != "" && stristr($join_date, 'E+') == false)) {
                            $date = DateTime::createFromFormat('Y-m-d', $join_date);
                            if (!$date) {
                                $RetrunError[] = [
                                    'message' => 'join date invalid format',
                                ];
                            }
                        }

                        if (($date_of_birth != "" && stristr($date_of_birth, 'E+') == false)) {
                            $date = DateTime::createFromFormat('Y-m-d', $date_of_birth);
                            if (!$date) {
                                $RetrunError[] = [
                                    'message' => 'date of birth invalid format',
                                ];
                            }
                        }

                        if (($date_of_end_passport != "" && stristr($date_of_end_passport, 'E+') == false)) {
                            $date = DateTime::createFromFormat('Y-m-d', $date_of_end_passport);
                            if (!$date) {
                                $RetrunError[] = [
                                    'message' => 'date of end passport invalid format',
                                ];
                            }
                        }

                        if (($spouse_date_of_birth != "" && stristr($spouse_date_of_birth, 'E+') == false)) {
                            $date = DateTime::createFromFormat('Y-m-d', $spouse_date_of_birth);
                            if (!$date) {
                                $RetrunError[] = [
                                    'message' => 'spouse date of birth invalid format',
                                ];
                            }
                        }

                        if (($child1_date_of_birth != "" && stristr($child1_date_of_birth, 'E+') == false)) {
                            $date = DateTime::createFromFormat('Y-m-d', $child1_date_of_birth);
                            if (!$date) {
                                $RetrunError[] = [
                                    'message' => 'child 1 date of birth invalid format',
                                ];
                            }
                        }

                        if (($child2_date_of_birth != "" && stristr($child2_date_of_birth, 'E+') == false)) {
                            $date = DateTime::createFromFormat('Y-m-d', $child2_date_of_birth);
                            if (!$date) {
                                $RetrunError[] = [
                                    'message' => 'child 2 date of birth invalid format',
                                ];
                            }
                        }

                        if (($child3_date_of_birth != "" && stristr($child3_date_of_birth, 'E+') == false)) {
                            $date = DateTime::createFromFormat('Y-m-d', $child3_date_of_birth);
                            if (!$date) {
                                $RetrunError[] = [
                                    'message' => 'child 3 date of birth invalid format',
                                ];
                            }
                        }

                        $wrongList[] = [
                            'nama' => $name,
                            'message' => $RetrunError,
                        ];
                        ///tampung list employee array
                        $res = Employee::select('mem_nip')
                            ->where('mem_nip', 'like', 'EL-CV%')
                            ->orderBy('mem_nip', 'desc')
                            ->first();
                        $nip = 'EL-CV' . sprintf("%'.07d", substr($res->mem_nip, 5) + 1);
                        $value = ['mem_name' => $name,
                            'mem_gender' => $gender,
                            'mem_alias' => $alias_name,
                            'mem_dob_city' => $place_of_birth,
                            'mem_dob' => $date_of_birth,
                            'mem_marital_id' => $marital_status,
                            'religi_id' => $religion,
                            'mem_mobile' => $mobile_1,
                            'mem_address' => $address,
                            'mem_email' => $email,
                            'mem_citizenship' => $citizenship,
                            'mem_ktp_no' => $id_card,
                            'mem_passport' => $passport,
                            'mem_exp_passport' => $date_of_end_passport,
                            'mem_last_education' => $last_education,
                            'mem_nationality' => $nationality,
                            'mem_join_date' => $join_date,
                            'insr_id' => $insurance,
                            'tr_id' => $tax_remark,
                            'mem_npwp_no' => $tax_number_general,
                            'mem_bank_name' => $bank1_id,
                            'mem_bank_ac' => $bank1_account,
                            'mem_bank_an' => $bank1_name,
                            'mem_spouse_name' => $spouse_name,
                            'mem_spouse_dob' => $spouse_date_of_birth,
                            'mem_spouse_gender' => $spouse_gender,
                            'mem_child1_name' => $child1_name,
                            'mem_child1_dob' => $child1_date_of_birth,
                            'mem_child1_gender' => $child1_gender,
                            'mem_child2_name' => $child2_name,
                            'mem_child2_dob' => $child2_date_of_birth,
                            'mem_child2_gender' => $child2_gender,
                            'mem_child3_name' => $child3_name,
                            'mem_child3_dob' => $child3_date_of_birth,
                            'mem_child3_gender' => $child3_gender,
                            'mem_jamsostek' => '',
                            'mem_bpjs_kes' => '',
                            'mem_bpjs_pen' => '',
                            'mem_tin_no' => $tin,
                            'mem_phic_no' => $phic,
                            'mem_sss_no' => $sss,
                            'mem_hdmf_no' => $hdmf,
                            'mem_security_level' => $user_level,
                            'mem_name_tha' => '',
                            'mem_address_tha' => '',
                            'homebase' => '',
                            'mem_image' => '',
                            'mem_nip' => $nip,
                            'form_type' => 2,
                        ];
                        $setData = Employee::saveEmployee($value);
                        $idEmployee[] = $setData;

                        $value2 = ['username' => $email,
                            'email' => $email,
                            'acc_id' => $setData,
                            'usertype' => 2,
                            'password' => md5('abc?123'),
                        ];
                        UserAccount::saveUserAccount($value2);

                    }
                    if ($RetrunError) {
                        for ($a = 0; $a < count($idEmployee); $a++) {
                            Employee::deleteEmployee($idEmployee[$a]);
                            UserAccount::deleteUserAccount($idEmployee[$a]);
                        }

                        Mlog::deleteLog();
                        $model = [
                            'type' => 'logupload',
                            'msg' => json_encode($wrongList),
                        ];
                        $wrongListId = Mlog::saveLog($model);
                        $data['wrongListId'] = $wrongListId;
                        $data["result"] = HelperService::_badRequest();
                        return response()->json($data, 200);

                    } else {
                        $data['wrongListId'] = "";
                        $data["result"] = HelperService::_success();
                        return response()->json($data, 200);

                    }

                } else {
                    $data['wrongListId'] = "";
                    $data["result"] = HelperService::_sessionExpired();
                }
            } else {
                $data['wrongListId'] = "";
                $data["result"] = HelperService::_badRequest();
            }
        } else {
            $data['wrongListId'] = "";
            $data["result"] = HelperService::_noToken();
        }

        return response()->json($data, 200);

    }