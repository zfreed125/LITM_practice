

    <!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Contacts</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>

    <style type="text/css">

        .wrapper{

            width: 650px;

            margin: 0 auto;

        }

        .page-header h2{

            margin-top: 0;

        }

        table tr td:last-child a{

            margin-right: 15px;

        }
        th,td{


        }

    </style>

    <script type="text/javascript">

        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();

        });

    </script>

</head>

<body>

    <div class="wrapper pull-left">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12">

                    <div class="page-header clearfix">

                        <h2 class="pull-left">Contact List</h2>

                        <a href="create.html" class="btn btn-success pull-right">Add New Contact</a>

                    </div>

                    <?php

                    // Include config file

                    require_once '../config.php';

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                    }


                    // Attempt select query execution

                    $sql = "SELECT * FROM Test1;";

                    if($result = mysqli_query($conn, $sql)){

                        if(mysqli_num_rows($result) > 0){

                            echo "<table class='table table-bordered table-striped'>";

                                echo "<thead>";

                                    echo "<tr>";

                                        echo "<th>#</th>";

                                        echo "<th>First Name</th>";

                                        echo "<th>Last Name</th>";

                                        echo "<th>Email</th>";

                                        echo "<th>Reg Date</th>";

                                    echo "</tr>";

                                echo "</thead>";

                                echo "<tbody>";

                                while($row = mysqli_fetch_array($result)){

                                    echo "<tr>";

                                        echo "<td>" . $row['id'] . "</td>";

                                        echo "<td>" . $row['firstname'] . "</td>";

                                        echo "<td>" . $row['lastname'] . "</td>";

                                        echo "<td>" . $row['email'] . "</td>";

                                        echo "<td>" . $row['reg_date'] . "</td>";

                                        echo "<td>";

                                            echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";

                                            echo "<a href='edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";

                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";

                                        echo "</td>";

                                    echo "</tr>";

                                }

                                echo "</tbody>";

                            echo "</table>";

                            // Free result set

                            mysqli_free_result($result);

                        } else{

                            echo "<p class='lead'><em>No records were found.</em></p>";

                        }

                    } else{

                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);

                    }



                    // Close connection

                    mysqli_close($conn);

                    ?>

                </div>

            </div>

        </div>

    </div>

</body>

</html>