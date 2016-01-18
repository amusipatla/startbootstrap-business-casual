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
$firstnameErr = $lastnameErr = $emailErr = "";
$lastname =  $firstname = $email = "";

$firstname1Err = $lastname1Err = $email1Err = $dateErr = $timeErr = "";
$lastname1 =  $firstname1 = $email1 = $date = $time = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


	if(!empty($_POST['preferred'])){
		// Validate user name
		if(empty($_POST["firstname"])){
			$firstnameErr = 'Please enter your name.';
		}else{
			$firstname = filterName($_POST["firstname"]);
			if($firstname == FALSE){
				$firstnameErr = 'Please enter a valid name.';
			}
		}

		if(empty($_POST["lastname"])){
			$lastnameErr = 'Please enter your name.';
		}else{
			$lastname = filterName($_POST["lastname"]);
			if($lastname == FALSE){
				$lastnameErr = 'Please enter a valid name.';
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

		$thanks='<html><body>';
		$thanks.='<h1> Hi, ' . $_POST["firstname"] . '</h1>';
		$thanks.='<br> <h3> Thanks for signing up as a preferred member of Tech Treats!</h3>';
		$thanks.='<br> <p>As a preferred member, you get certain benefits, like discounts on baked goods, and a free cupcake every month!</p>';
		$thanks.='<p>We hope to see you soon!</p>';
		$thanks.='<br><br><h3>Your friends at Tech Treats Bakery</h3>';
		$thanks.='</body></html>';

		$subject='Welcome to Tech Treats!';

		// Check input errors before sending email
		if(empty($firstnameErr) && empty($emailErr) && empty($lastnameErr)){
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

	if(!empty($_POST['reserve'])){
		// Validate user name
		if(empty($_POST["firstname1"])){
			$firstname1Err = 'Please enter your name.';
		}else{
			$firstname1 = filterName($_POST["firstname1"]);
			if($firstname1 == FALSE){
				$firstname1Err = 'Please enter a valid name.';
			}
		}

		if(empty($_POST["lastname1"])){
			$lastname1Err = 'Please enter your name.';
		}else{
			$lastname1 = filterName($_POST["lastname1"]);
			if($lastname1 == FALSE){
				$lastname1Err = 'Please enter a valid name.';
			}
		}

		// Validate email address
		if(empty($_POST["email1"])){
			$email1Err = 'Please enter your email address.';
		}else{
			$email1 = filterEmail($_POST["email1"]);
			if($email1 == FALSE){
				$email1Err = 'Please enter a valid email address.';
			}

		}

		$temp= $_POST["reservation-date"];
		$tempday= strtotime($temp);

		$day= date("w", $tempday);
		echo $day;
		if(empty($temp)){
			$dateErr= 'Please choose a date.';
		}
		if($day== 0 or $day== 5 or $day== 6){
			$dateErr= 'We are not open that day.';
		}

		switch(substr($temp, 5, 2)){
			case "01":
				$date= "January ";
				break;
			case "02":
				$date= "February ";
				break;
			case "03":
				$date= "March ";
				break;
			case "04":
				$date= "April ";
				break;
			case "05":
				$date= "May ";
				break;
			case "06":
				$date= "June ";
				break;
			case "07":
				$date= "July ";
				break;
			case "08":
				$date= "August ";
				break;
			case "09":
				$date= "September ";
				break;
			case "10":
				$date= "October ";
				break;
			case "11":
				$date= "November ";
				break;
			case "12":
				$date= "December ";
				break;
		}

		$date .= substr($temp, 8);
		$date .= ', ';
		$date .= substr($temp, 0, 4);

		$temp = $_POST['reservation-time'];
		if(empty($temp)){
			$timeErr= 'Please choose a time.';
		}

		if((substr($temp,0,2)== 17 or substr($temp, 0, 2)== 18) && $day== 4){
			$timeErr= 'We are not open that late on Thursdays.';
		}

		switch(substr($temp, 0, 2)){
			case "10":
				$time='10';
				$time.=substr($temp, 2);
				$time.=' AM';
				break;
			case "11":
				$time='11';
				$time.=substr($temp, 2);
				$time.=' AM';
				break;
			case "12":
				$time='12';
				$time.=substr($temp, 2);
				$time.=' PM';
				break;
			case "13":
				$time='1';
				$time.=substr($temp, 2);
				$time.=' PM';
				break;
			case "14":
				$time='2';
				$time.=substr($temp, 2);
				$time.=' PM';
				break;
			case "15":
				$time='3';
				$time.=substr($temp, 2);
				$time.=' PM';
				break;
			case "16":
				$time='4';
				$time.=substr($temp, 2);
				$time.=' PM';
				break;
			case "17":
				$time='5';
				$time.=substr($temp, 2);
				$time.=' PM';
				break;
			case "18":
				$time='6';
				$time.=substr($temp, 2);
				$time.=' PM';
				break;
		}

		$thanks='<html><body>';
		$thanks.='<h1> Hi, ' . $_POST["firstname1"] . '</h1>';
		$thanks.='<br> <h3> Thanks for making a reservation at Tech Treats!</h3>';
		$thanks.='<br> <p> Your reservation is on ' . $date . ' at ' . $time . '.</p>';
		$thanks.='<p>We hope to see you soon!</p>';
		$thanks.='<br><br><h3>Your friends at Tech Treats Bakery</h3>';
		$thanks.='</body></html>';

		$subject='Welcome to Tech Treats!';

		// Check input errors before sending email
		if(empty($firstname1Err) && empty($email1Err) && empty($lastname1Err) && empty($dateErr) && empty($timeErr)){
			// Recipient email address
			$to =  $email1;

			// Create email headers

			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type:text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '. $email1 . "\r\n" .
			'Reply-To: '. $email1 . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

      require_once ("PHPMailerAutoload.php");
      $mail = new PHPMailer(); // create a new object
      $mail->IsSMTP(); // enable SMTP
      $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
      $mail->SMTPAuth = true; // authentication enabled
      $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465; // or 587
      $mail->IsHTML(true);
      $mail->Username = "techtreatsbakery@gmail.com";
      $mail->Password = "techtreat";
      $mail->SetFrom("Tech Treats Bakery");
      $mail->Subject = $subject;
      $mail->Body = $thanks;
      $mail->AddAddress($to);

       if(!$mail->Send()) {
          echo "Mailer Error: " . $mail->ErrorInfo;
       } else {
          echo "Message has been sent";
       }
		   // Sending email
			// if(mail($to, $subject, $thanks, $headers)){
			// 	echo '<p class="success">Your message has been sent successfully!</p>';
			// }else{
			// 	echo '<p class="error">Unable to send email. Please try again!</p>';
			// }
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
    <div class="address-bar">100 Technology Drive | Edison, NJ 08837 | 732.456.2600</div>

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
			<div class="col-lg-6">
				<div class="box">
					<hr>
                    <h2 class="intro-text text-center">Make a
                        <strong>Reservation</strong>
                    </h2>
                    <hr>
                    <p>Want to dine in? Making a reservation will guarantee we have a table for you! Keep in mind we are only open Mondays to Thursdays at 10 am- 6pm. </p>
                    <form action="reserve.php" method="post">
						<div class="row">
							<div class="form-group col-lg-4">
								<label for="inputFirstName1">First name:</label>
								<input type="text" name="firstname1" id="inputFirstName1" class="form-control" value="<?php echo $firstname1; ?>">
								<span class="error"><?php echo $firstname1Err; ?></span>
							</div>
							<div class="form-group col-lg-4">
								<label for="inputLastName1">Last name:</label>
								<input type="text" name="lastname1" id="inputLastName1" class="form-control" value="<?php echo $lastname1; ?>">
								<span class="error"><?php echo $lastname1Err; ?></span>
							</div>
							<div class="form-group col-lg-4">
								<label for="inputEmail1">Email:</label>
								<input type="email" name="email1" id="inputEmail1" class="form-control" value="<?php echo $email1; ?>">
								<span class="error"><?php echo $email1Err; ?></span>
							</div>
							<div class="form-group col-md-4">
								<label for="inputDate">Date:</label>
								<input type= "date" name="reservation-date" min=<?php echo date("Y-m-d") ?>  max= <?php echo date("Y-m-d", strtotime("+28 day", time())) ?> class="form-control" list = "dates">
								<span class="error"><?php echo $dateErr; ?></span>
									<datalist id="dates">
									  <?php
										for($x = 0; $x <28; $x++){
										  if (date("l", time()+($x*86400)) != "Sunday" && date("l", time()+($x*86400)) != "Saturday" && date("l", time()+($x*86400)) != "Friday") {
											echo "<option>" . date("Y-m-d", time()+($x*86400) ) . "</option>";
										  }
										}

									  ?>

									</datalist>
							</div>
							<div class="form-group col-md-4">
								<label for="inputTime">Time:</label>
								<input type= "time" name="reservation-time" min="10:00" max="18:00">
								<span class="error"><?php echo $timeErr; ?></span>
							</div>
							<div class="form-group col-lg-12">
                                <button type="submit" name="reserve" class="btn btn-default" value="Submit">Submit</button>
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
                    <p>As a preferred member, you can get more benefits!</p>

                    <!-- Begin MailChimp Signup Form -->
                    <link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
                    <style type="text/css">
                    	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
                    	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
                    	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
                    </style>
                    <div id="mc_embed_signup">
                    <form action="//marstechsolutions.us12.list-manage.com/subscribe/post?u=1e893e09e320ac6e20d132b74&amp;id=c425a7beff" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <div id="mc_embed_signup_scroll">
                    	<h2>Subscribe to our mailing list</h2>
                    <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
                    <div class="mc-field-group">
                    	<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
                    </label>
                    	<input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL">
                    </div>
                    <div class="mc-field-group">
                    	<label for="mce-FNAME">First Name </label>
                    	<input type="text" value="" name="FNAME" class="form-control" id="mce-FNAME">
                    </div>
                    <div class="mc-field-group">
                    	<label for="mce-LNAME">Last Name </label>
                    	<input type="text" value="" name="LNAME" class="form-control" id="mce-LNAME">
                    </div>
                    	<div id="mce-responses" class="clear">
                    		<div class="response" id="mce-error-response" style="display:none"></div>
                    		<div class="response" id="mce-success-response" style="display:none"></div>
                    	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_1e893e09e320ac6e20d132b74_c425a7beff" tabindex="-1" value=""></div>
                        <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                        </div>
                    </form>
                    </div>

                    <!--End mc_embed_signup-->

					<form action="reserve.php" method="post">
						<div class="row">
							<div class="form-group col-lg-4">
								<label for="inputFirstName">First name:</label>
								<input type="text" name="firstname" id="inputFirstName" class="form-control" value="<?php echo $firstname; ?>">
								<span class="error"><?php echo $firstnameErr; ?></span>
							</div>
							<div class="form-group col-lg-4">
								<label for="inputLastName">Last name:</label>
								<input type="text" name="lastname" id="inputLastName" class="form-control" value="<?php echo $lastname; ?>">
								<span class="error"><?php echo $lastnameErr; ?></span>
							</div>
							<div class="form-group col-lg-4">
								<label for="inputEmail">Email:</label>
								<input type="email" name="email" id="inputEmail" class="form-control" value="<?php echo $email; ?>">
								<span class="error"><?php echo $emailErr; ?></span>
							</div>
							<div class="form-group col-lg-12">
                                <button type="submit" name="preferred" class="btn btn-default" value="Submit">Submit</button>
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
