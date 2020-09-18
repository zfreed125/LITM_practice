<?php
    //address loop
   $address_sql = "SELECT * FROM addresses WHERE contactId = '$contactId';";
   $address_result = mysqli_query($conn, $address_sql);
   $addressRowCount = mysqli_num_rows($address_result);

   echo "<table id='tbl_address". $contactId ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
   echo "<caption><a href='../address/add.php?src=contacts&contactId=". $contactId ."' title='Add Address' data-toggle='tooltip'><span><i class='fas fa-plus'></i>Address</span></a></caption>";
   echo "<a href='#' title='Show/Hide Addresses'style='position: relative; left: 50px;' onclick='myFunction(tbl_address". $contactId .")'><span><i class='fas fa-chevron-down'></i>&nbsp Addresses (". $addressRowCount .")&nbsp</span></a>";
   echo "<thead>";
   echo "<tr>";
   echo "<th></th>";
   echo "<th>Street1</th>";
   echo "<th>Street2</th>";
   echo "<th>City</th>";
   echo "<th>State</th>";
   echo "<th>Zip1</th>";
   echo "<th>Country</th>";
   echo "<th>Created</th>";
   echo "</tr>";
   echo "</thead>";
   echo "<tbody>";

   while ($row = mysqli_fetch_assoc($address_result))
   {
   if($primaryAddressId == $row['id']) {
   $address_primary = "<a href='../address/remove_primary.php?src=contacts&id=".$row['id']."'><span><i style='color:green'class='fas fa-star'></i></span></a>";
   }else{
   $address_primary = "<a href='primary.php?addressId=".$row['id']."&contactId=".$contactId."'><span><i style='color:green'class='far fa-star'></i></span></a>";
   }
   echo "<tr>";
   echo "<td class='fitwidth'>" . "$address_primary" . "</td>";
   echo "<td class='fitwidth'>" . "$row[street1]" . "</td>";
   echo "<td class='fitwidth'>" . "$row[street2]" . "</td>";
   echo "<td class='fitwidth'>" . "$row[city]" . "</td>";
   echo "<td class='fitwidth'>" . "$row[shortState]" . "</td>";
   echo "<td class='fitwidth'>" . "$row[zip1]" . "</td>";
   echo "<td class='fitwidth'>" . "$row[country]" . "</td>";
   echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
   echo "<td class='fitwidth'>";
   echo "<a href='../address/edit.php?src=contacts&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
   echo "<a href='../address/delete.php?src=contacts&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
   echo "</td>";
   echo "</tr>";
   }//end of address loop
   //end of the table from the address loop
   echo "</tbody>";
   echo "</table>";
?>