<?php
header("Cache-Control: no-cache, no-store, must-revalidate");

header("Content-Type: application/vnd.ms-excel");

header("Content-Disposition: attachment; filename=attendance.xls");
?>

<?php if (isset($hasil)) {?>

    <h1><?=$title?></h1>

    <br />



    <table border="1">	

        <tr>

            <th>No</th>

            <th>Branch</th>

            <th>Employee</th>

            <th>Date</th>

            <th>Day</th>

            <th>Time In</th>

            <th>Time Out</th>

            <th>Total Time</th>

            <th>Late Point</th>

            <th>Year</th>

            <th>Month</th>		

        </tr>

    <?php
    $no = 1;

    foreach ($hasil as $row) {
        ?>		



            <tr>					

                <td><?=$no++?></td>

                <td><?=$row['branch_name']?></td>

                <td><?=$row['user_name']?></td>

                <td><?=date('j F Y', strtotime($row['at_date']))?></td>

                <td><?=date('l', strtotime($row['at_date']))?></td>

                <td><?=$row['at_time_in']?></td>

                <td><?=$row['at_time_out']?></td>

                <td><?=$row['at_total_time']?></td>

                <td><?=$row['at_late_point']?></td>

                <td><?=date('Y', strtotime($row['at_date']))?></td>

                <td><?=date('F', strtotime($row['at_date']))?></td>

            </tr>								



    <?php }?> 

    </table>

    </div>

    <?php
} else {

    echo "No data or You don't have privileges to access this data";
}
?>