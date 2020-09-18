<?php

//note sql query loop table
$note_sql = "SELECT * FROM notes WHERE venueId = '$venuesId';";
$note_result = mysqli_query($conn, $note_sql);
$noteRowCount = mysqli_num_rows($note_result);

echo "<table id='tbl_note". $venuesId ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
echo "<caption><a href='../notes/add.php?venueId=". $venuesId ."' title='Add note' data-toggle='tooltip'><span><i class='fas fa-plus'></i>note</span></a></caption>";
echo "<a href='#' title='Show/Hide Notes'style='position: relative; left: 50px;' onclick='myFunction(tbl_note". $venuesId .")'><span><i class='fas fa-chevron-down'></i>&nbsp Notes (". $noteRowCount .")&nbsp</span></a>";
echo "<thead>";
echo "<tr>";
echo "<th></th>";
echo "<th>Author</th>";
echo "<th>Topic</th>";
echo "<th>Notes</th>";
echo "<th>Created</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($note_result))
{
if($primaryNoteId == $row['id']) {
$note_primary = "<a href='../notes/remove_primary.php?src=venues&id=".$row['id']."'><span><i style='color:green'class='fas fa-star'></i></span></a>";
}else{
$note_primary = "<a href='primary.php?noteId=".$row['id']."&venueId=".$venuesId."'><span><i style='color:green'class='far fa-star'></i></span></a>";
}
echo "<tr>";
echo "<td class='fitwidth'>" . "$note_primary" . "</td>";
echo "<td class='fitwidth'>" . "$row[author]" . "</td>";
echo "<td class='fitwidth'>" . "$row[topic]" . "</td>";
echo "<td class='fitwidth'>" . "$row[note]" . "</td>";
echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
echo "<td class='fitwidth'>";
echo "<a href='../notes/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
echo "<a href='../notes/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
echo "</td>";
echo "</tr>";
}//end of note loop
//end of the table from the note loop
echo "</tbody>";
echo "</table>";

?>