<?php
header("Cache-Control: no-cache, no-store, must-revalidate");

header("Content-Type: application/vnd.ms-excel");

header("Content-Disposition: attachment; filename=employee_leave_summary.xls");
?>

<?php if (isset($hasil)) {?>

    <h1><?=$title?></h1>

    <br />



    <table border="1">	

        <tr>

            <th>No</th>

            <th>Branch</th>

            <th>Employee</th>

            <th>Type</th>
            
            <th>Document Type</th>

            <th>Submit Date</th>
            
            <th>Start Date</th>

            <th>End Date</th>

            <th>Days</th>
            
            <th>Days Session</th>

            <th style="width: 280px;">Status</th>

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

                <td><?=$row['lv_type']?></td>
                
                <td><?=$row['doc_type']?></td>

                <td><?=$row['lv_submit_date']?></td>
                
                <td><?=$row['lv_start_date']?></td>

                <td><?=$row['lv_end_date']?></td>

                <td><?=$row['days']?></td>
                
                <td><?=$row['half_days']?></td>

                <td><?=$row['status']?></td>

                <td><?=$row['year']?></td>

                <td><?=$row['month']?></td>					

            </tr>								



        <?php }?> 

    </table>

    </div>

    <?php
} else {

    echo "No data or You don't have privileges to access this data";
}
?>