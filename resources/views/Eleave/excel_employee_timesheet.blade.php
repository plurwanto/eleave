<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=employee_timesheet_summary.xls");
?>

<?php if (isset($hasil)) {?>

    <h1><?=$title?></h1>
    <br />

    <table border="1">	
        <thead>
            <tr style="background-color: #B6B6B4">
                <th>No</th>
                <th>Branch</th>
                <th>Employee</th>
                <th>Type</th>

                <th>Submit Date</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Total Time</th>
                <th>Location</th>
                <th>Activity</th>
                <th>Status</th>
                <th>Year</th>
                <th>Month</th>
            </tr>
        </thead>
        <?php
        $no = 0;
        $temp_no = "";
        foreach ($hasil as $row) {
            $ts_id = $row['ts_id'];
            if ($temp_no == $ts_id) {
                ?>	
                <tbody>
                    <tr <?=$bgcolor;?>>					
                        <td><?=$no?></td>
                        <td><?=$row['branch_name']?></td>
                        <td><?=$row['user_name']?></td>
                        <td><?=$row['ts_type']?></td>

                        <td><?=$row['ts_submit_date']?></td>
                        <td><?=$row['ts_date']?></td>
                        <td><?=$row['ts_time_in']?></td>
                        <td><?=$row['ts_time_out']?></td>
                        <td><?=$row['ts_total_time']?></td>
                        <td><?=$row['ts_location']?></td>
                        <td><?=$row['ts_activity']?></td>
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
                        <td><?=$row['ts_type']?></td>

                        <td><?=$row['ts_submit_date']?></td>
                        <td><?=$row['ts_date']?></td>
                        <td><?=$row['ts_time_in']?></td>
                        <td><?=$row['ts_time_out']?></td>
                        <td><?=$row['ts_total_time']?></td>
                        <td><?=$row['ts_location']?></td>
                        <td><?=$row['ts_activity']?></td>
                        <td><?=$row['status']?></td>
                        <td><?=$row['year']?></td>
                        <td><?=$row['month']?></td>					
                    </tr>								
                </tbody>
                <?php
                $temp_no = $ts_id;
            }
        }
    } else {
        echo "No data or You don't have privileges to access this data";
    }
    ?>
</table>

</div>
