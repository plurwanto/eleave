<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=employee_overtime_summary.xls");
?>

<?php if (isset($hasil)) {?>

    <h1><?=$title?></h1>

    <br />

    <table border="1">	
        <thead>
            <tr style="background-color: #B6B6B4">
                <th rowspan="2">No</th>
                <th rowspan="2">Branch</th>
                <th rowspan="2">Employee</th>
                <th rowspan="2">Date</th>
                <th rowspan="2">Submit Date</th>
                <th colspan="2">Attendance</th>
                <th colspan="2">Overtime</th>
                <th colspan="2">Actual Overtime</th>
                <th rowspan="2">Description</th>
                <th rowspan="2">Reason</th>
                <th rowspan="2">Negative Impact</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Year</th>
                <th rowspan="2">Month</th>
            </tr>
            <tr style="background-color: #B6B6B4">

                <th>In</th>
                <th>Out</th>

                <th>Time (From)</th>
                <th>Time (To)</th>

                <th>Start</th>
                <th>End</th>

            </tr>
        </thead>
        <?php
        $no = 0;
        $temp_no = "";
        foreach ($hasil as $row) {
            $ot_id = $row['ot_id'];
            if ($temp_no == $ot_id) {
                ?>	
                <tbody>
                    <tr <?=$bgcolor;?>>					
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>

                        <td><?=$row['ot_date']?></td>
                        <td><?=$row['ot_submit_date']?></td>
                        <td><?=$row['at_time_in']?></td>
                        <td><?=$row['at_time_out']?></td>

                        <td><?=$row['ot_time_in']?></td>
                        <td><?=$row['ot_time_out']?></td>

                        <td><?=$row['actual_start']?></td>
                        <td><?=$row['actual_end']?></td>

                        <td><?=$row['ot_description']?></td>
                        <td><?=$row['ot_reason']?></td>
                        <td><?=$row['ot_negative_impact']?></td>
                        <td><?=$row['status']?></td>
                        <td><?=$row['year']?></td>
                        <td><?=$row['month']?></td>					
                    </tr>								
                </tbody>
            <?php
            } else {
                $no++;
                $bgcolor = ($no % 2 == 0) ? "bgcolor='#FFFFCC'" : "bgcolor='#FEFCFF'";
                ?> 
                <tbody>
                    <tr <?=$bgcolor;?>>					
                        <td><?=$no?></td>
                        <td><?=$row['branch_name']?></td>
                        <td><?=$row['user_name']?></td>


                        <td><?=$row['ot_date']?></td>
                        <td><?=$row['ot_submit_date']?></td>
                        <td><?=$row['at_time_in']?></td>
                        <td><?=$row['at_time_out']?></td>

                        <td><?=$row['ot_time_in']?></td>
                        <td><?=$row['ot_time_out']?></td>

                        <td><?=$row['actual_start']?></td>
                        <td><?=$row['actual_end']?></td>

                        <td><?=$row['ot_description']?></td>
                        <td><?=$row['ot_reason']?></td>
                        <td><?=$row['ot_negative_impact']?></td>
                        <td><?=$row['status']?></td>
                        <td><?=$row['year']?></td>
                        <td><?=$row['month']?></td>					
                    </tr>								
                </tbody>
                <?php
                $temp_no = $ot_id;
            }
        }
    } else {
        echo "No data or You don't have privileges to access this data";
    }
    ?>
</table>

</div>
