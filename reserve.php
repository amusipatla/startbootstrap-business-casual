<?php
// Functions to filter user inputs
function filterName($field){
    // Sanitize user name
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    
    // Validate user name
    if(filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+/")))){
        return $field;
    }else{
        return FALSE;
    }
}    
function filterEmail($field){
    // Sanitize e-mail address
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    
    // Validate e-mail address
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
        return $field;
    }else{
        return FALSE;
    }
}
function filterString($field){
    // Sanitize string
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    if(!empty($field)){
        return $field;
    }else{
        return FALSE;
    }
}
 
// Define variables and initialize with empty values
$nameErr = $emailErr = $messageErr = "";
$name = $email = $subject = $message = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate user name
    if(empty($_POST["name"])){
        $nameErr = 'Please enter your name.';
    }else{
        $name = filterName($_POST["name"]);
        if($name == FALSE){
            $nameErr = 'Please enter a valid name.';
        }
    }
    
    // Validate email address
    if(empty($_POST["email"])){
        $emailErr = 'Please enter your email address.';     
    }else{
        $email = filterEmail($_POST["email"]);
        if($email == FALSE){
            $emailErr = 'Please enter a valid email address.';
        }
    }
    
    // Validate user comment
    if(empty($_POST["message"])){
        $messageErr = 'Please enter your comment.';     
    }else{
        $message = filterString($_POST["message"]);
        if($message == FALSE){
            $messageErr = 'Please enter a valid comment.';
        }
    }
	
	$thanks='<html><body>';
	$thanks.='<h1> Hi, ' . $_POST["name"] . '</h1>';
	$thanks.='<br> <h3> Thanks for signing up as a preferred member of Tech Treats!</h3>';
	$thanks.='<br> <p>As a preferred member, you get certain benefits, like discounts on baked goods, and a free cupcake every month!</p>';
	$thanks.='<p>We hope to see you soon!</p>';
	$thanks.='<br><br><h3>Your friends at Tech Treats Bakery</h3>';
	$thanks.='</body></html>';
	
	$subject='Welcome to Tech Treats!';

    // Check input errors before sending email
    if(empty($nameErr) && empty($emailErr) && empty($messageErr)){
        // Recipient email address
        $to =  $email;
        
        // Create email headers
		
        $headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '. $email . "\r\n" .
        'Reply-To: '. $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
	   // Sending email
        if(mail($to, $subject, $thanks, $headers)){
            echo '<p class="success">Your message has been sent successfully!</p>';
        }else{
            echo '<p class="error">Unable to send email. Please try again!</p>';
        }
    }
}
?>

<!DOCTYPE html>
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

</head>

<body>

	<div class="brand">Tech Treats</div>
    <div class="address-bar">100 Technology Drive | Edison, NJ 08820 | 732.456.2600</div>

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
                <a class="navbar-brand" href="index.html">Business Casual</a>
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
			<div class="col-lg-6">
				<div class="box">
					<hr>
                    <h2 class="intro-text text-center">Make a
                        <strong>Reservation</strong>
                    </h2>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat, vitae, distinctio, possimus repudiandae cupiditate ipsum excepturi dicta neque eaque voluptates tempora veniam esse earum sapiente optio deleniti consequuntur eos voluptatem.</p>
                    <form role="form">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>Name</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Email Address</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control">
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-12">
                                <label>Message</label>
                                <textarea class="form-control" rows="6"></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="hidden" name="save" value="contact">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
            <div class="col-lg-6">
                <div class="box">
                    <hr>
                    <h2 class="intro-text text-center">Become a
                        <strong>Preferred Member</strong>
                    </h2>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat, vitae, distinctio, possimus repudiandae cupiditate ipsum excepturi dicta neque eaque voluptates tempora veniam esse earum sapiente optio deleniti consequuntur eos voluptatem.</p>
					<form action="reserve.php" method="post">
						<div class="row">
							<div class="form-ground col-lg-4">
								<label for="inputName">Name:</label>
								<input type="text" name="name" id="inputName" class="form-control" value="<?php echo $name; ?>">
								<span class="error"><?php echo $nameErr; ?></span>
							</div>
							<div class="form-ground col-lg-4">
								<label for="inputEmail">Email:</label>
								<input type="text" name="email" id="inputEmail" class="form-control" value="<?php echo $email; ?>">
								<span class="error"><?php echo $emailErr; ?></span>
							</div>
							<div class="form-ground col-lg-12">
								<label for="inputComment">Message:</label>
								<textarea class="form-control" name="message" id="inputComment" rows="6" <?php echo $message; ?>></textarea>
								<span class="error"><?php echo $messageErr; ?></span>
							</div>	
							<div class="form-group col-lg-12">
                                <button type="submit" class="btn btn-default" value="Submit">Submit</button>
                            </div>
						</div>
					</form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Your Website 2014</p>
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
