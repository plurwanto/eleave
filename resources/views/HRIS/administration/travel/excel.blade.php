@php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename={$title}.xls");
header("Cache-Control: max-age=0");
@endphp

<style>
    .gen {
        mso-number-format:"\@";/*force text*/
    }
</style>
<table border="1">
<tr>
    <td rowspan="2">Nip</td>
    <td rowspan="2">Name</td>
    <td rowspan="2">Position</td>
    <td rowspan="2">ID Number</td>
    <td rowspan="2">Nationality</td>
    <td rowspan="2">Email</td>
    <td rowspan="2">Mobile</td>
    <td rowspan="2">Address</td>
    <td rowspan="2">Customer</td>
    <td rowspan="2">Site Location</td>
    <td rowspan="2">Marital Status</td>
    <td rowspan="1" colspan="3">Bank</td>
    <td rowspan="2">Place of Birth</td>
    <td rowspan="2">Date of Birth</td>
    <td rowspan="2">Join Date</td>
    <td rowspan="1" colspan="6"><center>Contract</center></td>
    <td rowspan="1" colspan="{{ count($contract->allowanceList) }}"><center>Allowance</center></td>
    <td rowspan="2">Total Allowance</td>
    <td rowspan="2">Basic Sallary</td>
    <td rowspan="2">THP</td>
    <td rowspan="2">Tax Remark</td>
    <td rowspan="2">Insurance</td>
    <td rowspan="1" colspan="3"><center>BPJS</center></td>
</tr>
<tr>
    <td>Name</td>
    <td>Account</td>
    <td>Account Name</td>
    <td>No</td>
    <td>Date</td>
    <td>Start Date</td>
    <td>End Date</td>
    <td>Resign Date</td>
    <td>Status</td>
    @php
        for($a=0; $a < count($contract->allowanceList); $a++){
            echo '<td>'.$contract->allowanceList[$a]->fix_allow_master_name.'</td>';
        }
    @endphp
    <td>Ketenagakerjaan</td>
    <td>Kesehatan</td>
    <td>Pensiun</td>
</tr>
    @php
        for($a=0; $a < count($contract->result); $a++){
            echo '<tr>';
                echo '<td>'.$contract->result[$a]->mem_nip.'</td>';
                echo '<td>'.$contract->result[$a]->mem_name.'</td>';
                echo '<td>'.$contract->result[$a]->cont_position.'</td>';
                echo '<td  class="gen">'.$contract->result[$a]->id_number.'</td>';
                echo '<td>'.$contract->result[$a]->nat_name.'</td>';
                echo '<td>'.$contract->result[$a]->mem_email.'</td>';
                echo '<td  class="gen">'.$contract->result[$a]->mem_mobile.'</td>';
                echo '<td>'.$contract->result[$a]->mem_address.'</td>';
                echo '<td>'.$contract->result[$a]->cus_name.'</td>';
                echo '<td>'.$contract->result[$a]->cont_city_name.'</td>';
                echo '<td>'.$contract->result[$a]->mem_marital_name.'</td>';
                echo '<td>'.$contract->result[$a]->bank_name.'</td>';
                echo '<td  class="gen">'.$contract->result[$a]->mem_bank_ac.'</td>';
                echo '<td>'.$contract->result[$a]->mem_bank_an.'</td>';
                echo '<td>'.$contract->result[$a]->mem_dob_city.'</td>';
                echo '<td>'.$contract->result[$a]->mem_dob.'</td>';
                echo '<td>'.$contract->result[$a]->mem_join_date.'</td>';
                echo '<td>'.$contract->result[$a]->cont_no_new.'</td>';
                echo '<td>'.$contract->result[$a]->cont_date.'</td>';
                echo '<td>'.$contract->result[$a]->cont_start_date.'</td>';
                echo '<td>'.$contract->result[$a]->cont_end_date.'</td>';
                echo '<td>'.$contract->result[$a]->cont_resign_date.'</td>';
                echo '<td>'.$contract->result[$a]->cont_sta_name.'</td>';
                for($y=0; $y < count($contract->allowanceList); $y++){
                    $allow[$y] ='';
                    for($x=0; $x < count($contract->result[$a]->allowance); $x++){
                        if($contract->allowanceList[$y]->fix_allow_master_id == $contract->result[$a]->allowance[$x]->fix_allow_master_id){
                            $allow[$y] = $contract->result[$a]->allowance[$x]->cont_det_tot;
                        }else{
                            $allow[$y] = 0;
                        }
                    }
                    echo '<td>'.$allow[$y].'</td>';
                }
                echo '<td>'.$contract->result[$a]->allowance_tot.'</td>';
                echo '<td>'.$contract->result[$a]->cont_basic_salary.'</td>';
                echo '<td>'.$contract->result[$a]->cont_sta_name.'</td>';
                echo '<td>'.$contract->result[$a]->tr_name.'</td>';
                echo '<td>'.$contract->result[$a]->mem_npwp_no.'</td>';
                echo '<td>'.$contract->result[$a]->mem_jamsostek.'</td>';
                echo '<td>'.$contract->result[$a]->mem_bpjs_kes.'</td>';
                echo '<td>'.$contract->result[$a]->mem_bpjs_pen.'</td>';



            echo '</tr>';
        }
    @endphp
</table>
