<?php
$genre_types_sql = "SELECT * FROM genre_types;";
$genre_types_result = mysqli_query($conn, $genre_types_sql);
$genre_type_array = array();
while ($row = mysqli_fetch_assoc($genre_types_result)) {
$genre_type_array[] = array('id' => $row['id'], 'genreType' => $row['genreType']);
}

 //genre sql loop table
 $genre_sql = "SELECT * FROM genres where venueId = '$row[id]';";
 $genre_result = mysqli_query($conn, $genre_sql);
 $genreRowCount = mysqli_num_rows($genre_result);

 echo "<table id='tbl_genre". $venuesId ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
 echo "<caption><a href='../genres/add.php?venueId=". $venuesId ."' title='Add Genre' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>genre</a></caption>";
 echo "<a href='#' title='Show/Hide Genres'style='position: relative; left: 50px;' onclick='myFunction(tbl_genre". $venuesId .")'><span><i class='fas fa-chevron-down'></i>&nbsp Genre Type (". $genreRowCount .")&nbsp</span></a>";
 echo "<thead>";
 echo "<tr>";
 echo "<th>Genre Type</th>";
 echo "<th>Created</th>";
 echo "</tr>";
 echo "</thead>";
 echo "<tbody>";

 while ($row = mysqli_fetch_assoc($genre_result))
 {
     foreach($genre_type_array as $item){
         if($item['id'] == $row['genreTypeId']){
             $genreTypeId = $item['genreType'];
             }
     }
 echo "<tr>";
 echo "<td class='fitwidth'>" . "$genreTypeId" . "</td>";
 echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
 echo "<td class='fitwidth'>";
 echo "<a href='../genres/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
 echo "<a href='../genres/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
 echo "</td>";
 echo "</tr>";
}//end of genre loop
//end of the table from the genre loop
echo "</tbody>";
echo "</table>";

?>