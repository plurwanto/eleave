@php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename='Template Iuran BPJS Kesehatan.xls'");
header("Cache-Control: max-age=0");
@endphp

<style>
    .gen {
        mso-number-format:"\@";/*force text*/
    }
</style>
<table border="1">
    <thead>
        <td>No</td>
        <td>Client ID <font color="red">*</font></td>
        <td>Client Name</td>
        <td>Contract No</td>
        <td>NPP <font color="red">*</font></td>
        <td>Nama</td>
        <td>No BPJS <font color="red">*</font></td>
        <td>NIK/KITAS/KITAP</td>
        <td>Gaji Pokok</td>
        <td>Total <font color="red">*</font></td>
        <td>Total Additional</td>
    </thead>
    <tbody>
        @php
        $a = 1;
            for($i = 0; $i < count($member->result); $i++){
                echo '<tr>';
                echo '<td>'.$a.'</td>';
                echo '<td>'.$member->result[$i]->cus_id.'</td>';
                echo '<td>'.$member->result[$i]->cus_name.'</td>';
                echo '<td>'.$member->result[$i]->cont_no_new.'</td>';
                echo '<td>'.$member->result[$i]->mem_nip.'</td>';
                echo '<td>'.$member->result[$i]->mem_name.'</td>';
                echo '<td  class="gen">'.$member->result[$i]->mem_bpjs_kes.'</td>';
                echo '<td  class="gen">'.$member->result[$i]->mem_ktp_no.'</td>';
                echo '<td>'.$member->result[$i]->cont_basic_salary.'</td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '</tr>';
                $a++;

            }
        @endphp
        </tr>
    </tbody>
</table>
