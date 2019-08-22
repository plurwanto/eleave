<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=employee_leave_balance.xls");
?>
<?php if (isset($data)) {?>
    <h1><?=$title;?></h1>

    <br />

    <table border="1">	

        <tr>
            <th rowspan="2">No</th>

            <th rowspan="2">Branch</th>

            <th rowspan="2">Employee</th>

            <th rowspan="2">Type</th>

            <th rowspan="2">Gender</th>

            <th rowspan="2">Join Date</th>

            <th rowspan="2">Last Contrract Start Date</th>

            <th rowspan="2">Active Until</th>

            <th colspan="3">Annual</th>

            <th colspan="3">Marriage</th>

            <th colspan="2">Paternity</th>

            <th colspan="2">Maternity</th>

            <th colspan="2">Compassionate</th>

            <th colspan="3">Study</th>

            <th colspan="1">Medical</th>

            <th colspan="1">Unpaid</th>

        </tr>

        <tr>

            <th>Max</th>

            <th>Taken</th>

            <th>Balance</th>

            <th>Max</th>

            <th>Taken</th>

            <th>Balance</th>

            <th>Max/Case</th>

            <th>Taken</th>

            <th>Max/Case</th>

            <th>Taken</th>

            <th>Max/Case</th>

            <th>Taken</th>

            <th>Max</th>

            <th>Taken</th>

            <th>Balance</th>

            <th>Taken</th>

            <th>Taken</th>

        </tr>

        <?php
        $no = 1;
        foreach ($data as $row) {
            ?>					

            <tr>					

                <td><?=$no++?></td>

                <td><?=$row['branch_name']?></td>

                <td><?=$row['user_name']?></td>

                <td><?=$row['user_type']?></td>

                <td><?=$row['user_gender']?></td>

                <td><?=date('d/m/Y', strtotime($row['user_join_date']))?></td>

                <td><?=date('d/m/Y', strtotime($row['user_last_contract_start_date']))?></td>

                <td><?=date('d/m/Y', strtotime($row['user_active_until']))?></td>

                <td><?=$row['max_annual']?></td>
                <td><?=$row['taken_annual']?></td>
                <td><?=$row['balance_annual']?></td>

                <td><?=$row['max_marriage']?></td>
                <td><?=$row['taken_marriage']?></td>
                <td><?=$row['balance_marriage']?></td>

                <td><?=$row['max_paternity']?></td>
                <td><?=$row['taken_paternity']?></td>

                <td><?=$row['max_maternity']?></td>
                <td><?=$row['taken_maternity']?></td>

                <td><?=$row['max_compassionate']?></td>
                <td><?=$row['taken_compassionate']?></td>					

                <td><?=$row['max_study']?></td>
                <td><?=$row['taken_study']?></td>
                <td><?=$row['balance_study']?></td>

                <td><?=$row['taken_medical']?></td>

                <td><?=$row['taken_unpaid']?></td>					

            </tr>								



        <?php }?> 

    </table>

    </div>

    <?php
} else {

    echo "No data or You don't have privileges to access this data";
}
?>