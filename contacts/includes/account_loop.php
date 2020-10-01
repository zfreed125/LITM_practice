<?php
$account_types_sql = "SELECT * FROM account_types;";
$account_types_result = mysqli_query($conn, $account_types_sql);
$account_type_array = array();
while ($row = mysqli_fetch_assoc($account_types_result)) {
    $account_type_array[] = array('id' => $row['id'], 'accountType' => $row['accountType']);
}

//account sql loop table
$account_sql = "SELECT * FROM accounts where contactId = '$contactId';";
$account_result = mysqli_query($conn, $account_sql);
$accountRowCount = mysqli_num_rows($account_result);

echo "<table id='tbl_account". $contactId ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
echo "<caption data-lastname='$row[lastname]'><a href='../accounts/add.php?contactId=". $contactId ."' title='Add Account' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>Account</a></caption>";
echo "<a href='#' title='Show/Hide accounts'style='position: relative; left: 50px;' onclick='myFunction(tbl_account". $contactId .")'><span><i class='fas fa-chevron-down'></i>&nbsp Account Type (". $accountRowCount .")&nbsp</span></a>";
echo "<thead>";
echo "<tr>";
echo "<th>Account Type</th>";
echo "<th>Created</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($account_result))
{
foreach($account_type_array as $item){
if($item['id'] == $row['accountTypeId']){
$accountTypeId = $item['accountType'];
}
}
echo "<tr>";
echo "<td class='fitwidth'>" . "$accountTypeId" . "</td>";
echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
echo "<td class='fitwidth'>";
echo "<a href='../accounts/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
echo "<a href='../accounts/delete.php?src=contacts&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
echo "</td>";
echo "</tr>";
}//end of account loop
//end of the table from the account loop
echo "</tbody>";
echo "</table>";
?>