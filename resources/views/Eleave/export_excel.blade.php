<?php if (isset($data)) {?>
    <h1><?=$title?></h1>

    <br />

    <table border="1">	

        <tr>

            <th>No</th>

            <th>Branch</th>

            <th>Employee</th>

            <th>Status</th>

            <th>Employee Ref No</th>

            <th>Finger Print ID</th>

            <th>Email</th>

            <th>Department</th>
            <th>Position</th>

            <th>Date of Birth</th>

            <th>Gender</th>

            <th>Type</th>

            <th>Join Date</th>

            <th>Last Contract Start Date</th>

            <th>Active Until</th>

            <th>Approver</th>

            <th>HR</th>

            <th>Approver 1</th>

            <th>Approver 2</th>

            <th>Approver 3</th>

            <th>Address</th>

            <th>Phone</th>

        </tr>

        <?php
        $no = 1;

        foreach ($data as $row) {
            ?>			

            <tr>					

                <td><?=$no++?></td>

                <td><?=$row['branch_name']?></td>

                <td><?=$row['user_name']?></td>

                <td><?=$row['user_status']?></td>

                <td><?=$row['user_nik']?></td>

                <td><?=$row['user_finger_print_id'] != "" ? "'" . $row['user_finger_print_id'] : ""?></td>

                <td><?=$row['user_email']?></td>

                <td><?=$row['department_name']?></td>
                <td><?=$row['user_position']?></td>

                <td><?=$row['user_dob'] != "0000-00-00" ? date('j F Y', strtotime($row['user_dob'])) : ""?></td>

                <td><?=$row['user_gender']?></td>

                <td><?=$row['user_type']?></td>

                <td><?=$row['user_join_date'] != "0000-00-00" ? date('j F Y', strtotime($row['user_join_date'])) : ""?></td>

                <td><?=$row['user_last_contract_start_date'] != "0000-00-00" ? date('j F Y', strtotime($row['user_last_contract_start_date'])) : ""?></td>

                <td><?=$row['user_active_until'] != "0000-00-00" ? date('j F Y', strtotime($row['user_active_until'])) : ""?></td>

                <td><?=$row['approver']?></td>

                <td><?=$row['hr']?></td>

                <td><?=$row['app1']?></td>

                <td><?=$row['app2']?></td>

                <td><?=$row['app3']?></td>	

                <td><?=$row['user_address']?></td>

                <td><?="'" . $row['user_phone']?></td>

            </tr>								



        <?php }?> 

    </table>

    </div>

    <?php
} else {

    echo "No data or You don't have privileges to access this data";
}
?>