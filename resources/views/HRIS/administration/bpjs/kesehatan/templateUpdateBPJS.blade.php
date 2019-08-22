@php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename='Template Update BPJS.xls'");
header("Cache-Control: max-age=0");
@endphp
<table border="1">
    <thead>
        <td>Member NIP <font color="red">*</font></td>
        <td>Name</td>
        <td>No BPJS Kesehatan <font color="red">*</font></td>
    </thead>
</table>
