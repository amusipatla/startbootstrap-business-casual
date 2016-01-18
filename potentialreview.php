<!DOCTYPE html>

<!-- Before you run this code, set up the database and the table in 
the database (called comments with a column for first name, last name,
and message)-->
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tech Treats</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<?php
		$link= mysqli_connect("localhost", "root", "", "demo");
		
		$firstname=$lastname=$comment= "";
		
		//if($link===false){
		//	die("ERROR: Could not connect. " . mysqli_connect_error());
		//}
		//else{
		//	echo "yay connected";
		//}
		
		
			if(!empty($_POST['submit'])){
				echo 'hello';
				$firstname= mysqli_real_escape_string($link, $_POST['firstname']);
				$firstname.=' ';
				$lastname= mysqli_real_escape_string($link, $_POST['lastname']);
				$comment= mysqli_real_escape_string($link, $_POST['comment']);
				
				$sql= "INSERT INTO comments (first_name, last_name, comment) VALUES ('$firstname', '$lastname', '$comment')";
				if(mysqli_query($link, $sql)){
					echo "Records added successfully";
				}
				else{
					echo "ERROR: could not execute $sql" .
					mysqli_error($link);
				}
			}
		
		mysqli_close($link);
	?>

</head>

<body>

    <div class="brand">Tech Treats</div>
    <div class="address-bar"> 100 Technology Drive | Edison, NJ 08837 | 732.456.2600</div>

    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">Tech Treats</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>
					<li>
                        <a href="menu.html">Menu</a>
                    </li>
                    <li>
                        <a href="review.php">Reviews</a>
                    </li>
					<li>
                        <a href="reserve.php">Reservations</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">

        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">Leave a
                        <strong>comment</strong>
                    </h2>
                    <hr>
                </div>
                <form action="potentialreview.php" method="post">
						<div class="row">
							<div class="form-group col-lg-4">
								<label for="inputFirstName">First name:</label>
								<input type="text" name="firstname" id="inputFirstName" class="form-control" value="">
							</div>
							<div class="form-group col-lg-4">
								<label for="inputLastName">Last name:</label>
								<input type="text" name="lastname" id="inputLastName" class="form-control" value="">
							</div>
							<div class="form-group col-lg-8">
								<label for="inputComment">Comment:</label>
								<textarea rows="5" name="comment" id="inputComment" class="form-control" ></textarea>
							</div>
							<div class="form-group col-lg-12">
                                <button type="submit" name="submit" class="btn btn-default" value="submit">Submit</button>
                            </div>
						</div>
					</form>
            </div>
			<div class="box">
				<div class="col-lg-12">
					
					<hr>
                    <h2 class="intro-text text-center">
                        <strong>Comments</strong>
                    </h2>
                    <hr>
				
				
					<?php
					$link= mysqli_connect("localhost", "root", "", "demo");
					
					//if($link===false){
					//	die("ERROR: Could not connect. " . mysqli_connect_error());
					//}
					//else{
					//	echo "yay connected";
					//}
					
					
					
					$sql = "SELECT * FROM comments";
					if($result = mysqli_query($link, $sql)){
						if(mysqli_num_rows($result) > 0){
							echo "<table>";
							while($row = mysqli_fetch_array($result)){
								if(!empty($row['first_name']) and !empty($row['comment'])){
									echo "<tr>";
										echo "<td><h3>" . $row['first_name'] . " </h3></td>";
										echo "<td><h3>" . $row['last_name'] . " says: </h3></td>";
										echo "<td><h2>" . $row['comment'] . "</h2></td>";
									echo "</tr>";
								}
							}
							echo "</table>";
							// Close result set
							mysqli_free_result($result);
						} else{
							echo "No records matching your query were found.";
						}
					} 
					//else{
					//	echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					//}	
					
					mysqli_close($link);
					?>
				</div>
			</div>
        </div>

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Tech Treats 2016</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>