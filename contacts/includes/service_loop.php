<?php

 //Services sql query loop table
 $services_sql = "SELECT * FROM services WHERE contactId = '$contactId';";
 $services_result = mysqli_query($conn, $services_sql);
 $servicesRowCount = mysqli_num_rows($services_result);

 echo "<table id='tbl_services". $contactId ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
 echo "<caption><a href='../services/add.php?src=contacts&contactId=". $contactId ."' title='Add Messaging Services' data-toggle='tooltip'><span><i class='fas fa-plus'></i>Services</span></a></caption>";
 echo "<a href='#' title='Show/Hide Services'style='position: relative; left: 50px;' onclick='myFunction(tbl_services". $contactId .")'><span><i class='fas fa-chevron-down'></i>&nbsp Services (". $servicesRowCount .")&nbsp</span></a>";
 echo "<thead>";
 echo "<tr>";
 echo "<th></th>";
 echo "<th>Service Name</th>";
 echo "<th>User Account</th>";
 echo "<th>Website</th>";
 echo "<th>Notes</th>";
 echo "<th>Created</th>";
 echo "</tr>";
 echo "</thead>";
 echo "<tbody>";

 while ($row = mysqli_fetch_assoc($services_result))
 {
 if($primaryServiceId == $row['id']) {
 $service_primary = "<a href='../services/remove_primary.php?src=contacts&id=".$row['id']."'><span><i style='color:green'class='fas fa-star'></i></span></a>";
 }else{
 $service_primary = "<a href='primary.php?serviceId=".$row['id']."&contactId=".$contactId."'><span><i style='color:green'class='far fa-star'></i></span></a>";
 }
 echo "<tr>";
 echo "<td class='fitwidth'>" . "$service_primary" . "</td>";
 echo "<td class='fitwidth'>" . "$row[serviceName]" . "</td>";
 echo "<td class='fitwidth'>" . "$row[userAccount]" . "</td>";
 echo "<td class='fitwidth'>" . "$row[website]" . "</td>";
 echo "<td class='fitwidth'>" . "$row[notes]" . "</td>";
 echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
 echo "<td class='fitwidth'>";
 echo "<a href='../services/edit.php?src=contacts&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
 echo "<a href='../services/delete.php?src=contacts&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
 echo "</td>";
 echo "</tr>";
 }//end of Services loop
 //end of the table from the Services loop
 echo "</tbody>";
 echo "</table>";

?>