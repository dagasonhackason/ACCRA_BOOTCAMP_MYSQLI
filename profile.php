<?php 
    /*
       ============================================================================================================

       =============================== CREATED WITH ALL THE ❤ LOVE ❤ IN THE WORLD ================================

       ============================================================================================================


              .8.              ,o888888o.        ,o888888o.    8 888888888o.            .8.           8 888888888o       ,o888888o.         ,o888888o.     8888888 8888888888     ,o888888o.             .8.                   ,8.       ,8.          8 888888888o
             .888.            8888     `88.     8888     `88.  8 8888    `88.          .888.          8 8888    `88.  . 8888     `88.    . 8888     `88.         8 8888          8888     `88.          .888.                 ,888.     ,888.         8 8888    `88.
            :88888.        ,8 8888       `8. ,8 8888       `8. 8 8888     `88         :88888.         8 8888     `88 ,8 8888       `8b  ,8 8888       `8b        8 8888       ,8 8888       `8.        :88888.               .`8888.   .`8888.        8 8888     `88
           . `88888.       88 8888           88 8888           8 8888     ,88        . `88888.        8 8888     ,88 88 8888        `8b 88 8888        `8b       8 8888       88 8888                 . `88888.             ,8.`8888. ,8.`8888.       8 8888     ,88
          .8. `88888.      88 8888           88 8888           8 8888.   ,88'       .8. `88888.       8 8888.   ,88' 88 8888         88 88 8888         88       8 8888       88 8888                .8. `88888.           ,8'8.`8888,8^8.`8888.      8 8888.   ,88'
         .8`8. `88888.     88 8888           88 8888           8 888888888P'       .8`8. `88888.      8 8888888888   88 8888         88 88 8888         88       8 8888       88 8888               .8`8. `88888.         ,8' `8.`8888' `8.`8888.     8 888888888P'
        .8' `8. `88888.    88 8888           88 8888           8 8888`8b          .8' `8. `88888.     8 8888    `88. 88 8888        ,8P 88 8888        ,8P       8 8888       88 8888              .8' `8. `88888.       ,8'   `8.`88'   `8.`8888.    8 8888
       .8'   `8. `88888.   `8 8888       .8' `8 8888       .8' 8 8888 `8b.       .8'   `8. `88888.    8 8888      88 `8 8888       ,8P  `8 8888       ,8P        8 8888       `8 8888       .8'   .8'   `8. `88888.     ,8'     `8.`'     `8.`8888.   8 8888
      .888888888. `88888.     8888     ,88'     8888     ,88'  8 8888   `8b.    .888888888. `88888.   8 8888    ,88'  ` 8888     ,88'    ` 8888     ,88'         8 8888          8888     ,88'   .888888888. `88888.   ,8'       `8        `8.`8888.  8 8888
     .8'       `8. `88888.     `8888888P'        `8888888P'    8 8888     `88. .8'       `8. `88888.  8 888888888P       `8888888P'         `8888888P'           8 8888           `8888888P'    .8'       `8. `88888. ,8'         `         `8.`8888. 8 8888


       *************************************************************************************************************
       *                                                                                                           *
       *                        Content:    PHP                                                                    *
       *                        Website:    http://www.dagasonhackason.com/                                        *
       *                                                                                                           *
       *************************************************************************************************************
    */
	
	//session
	session_start();
	include ("scripts/mysqli_connect.inc.php");
		
	//NOW WE CHECK IF THE USER DOESN'T ALREADY EXIST
	if( isset($_COOKIE["id"]) && $_COOKIE["id"] != "EXPIRED" ){
		if( loginCOOKIE_CHECK() == TRUE )
		{
			$sUSER_REDIR = $_COOKIE["username"];
			echo '<script type="text/javascript">window.location = "' . $sUSER_REDIR . '";</script>';
		}
		else if( loginCOOKIE_CHECK() == FALSE )
		{
			$sLOGIN_LOG_ID 	= @$_COOKIE["login_log_id"];	
			
			include ("scripts/mysqli_connect.inc.php");
			$db_Connection  = mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
			
			$date			= time();
			$sql            = mysqli_query( $db_Connection, "UPDATE users_login_log_table
															 SET time_logged_out='$date' 
															 WHERE id='$sLOGIN_LOG_ID'
							");
							
			setcookie( "id", "EXPIRED", time()-1209600 );
			setcookie( "username", "EXPIRED", time()-1209600 );
			setcookie( "username_validate", "EXPIRED", time()-1209600 );
			setcookie( "auth_key", "EXPIRED", time()-1209600 );
			setcookie( "auth_key_validate", "EXPIRED", time()-1209600 );
			setcookie( "login_log_id", "EXPIRED", time()-1209600 );
			setcookie( "is_activated", "EXPIRED", time()-1209600 );
			setcookie( "email", "EXPIRED", time()-1209600 );
			setcookie( "full_name", "EXPIRED", time()-1209600 );
			setcookie( "gender", "EXPIRED", time()-1209600 );
			setcookie( "reg_date", "EXPIRED", time()-1209600 );
			
			$errorEncode = urlencode("WARNING :: IMPERSONATED COOKIE DETECTED AND DESTROYED !!!");
			//echo "<script type='text/javascript'>window.location = 'login.php?isError=true&sMSG=" . $errorEncode . "';</script>";
		}
	}
	else if( isset($_SESSION["id"]) ) {
		if( loginSESSION_CHECK() == TRUE )
		{
			$sUSER_REDIR = $_SESSION["id"];
			echo '<script type="text/javascript">window.location = "' . $sUSER_REDIR . '";</script>';
		}
		else if( loginSESSION_CHECK() == FALSE )
		{
											
			$sLOGIN_LOG_ID 	= @$_SESSION["login_log_id"];	
			
			include ("scripts/mysqli_connect.inc.php");
			$db_Connection  = mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
			
			$date			= time();
			$sql            = mysqli_query( $db_Connection, "UPDATE users_login_log_table
															 SET time_logged_out='$date' 
															 WHERE id='$sLOGIN_LOG_ID'
							");
							
			session_destroy();
			
			$errorEncode = urlencode("WARNING :: IMPERSONATED SESSION DETECTED AND DESTROYED !!!");
			//echo "<script type='text/javascript'>window.location = 'login.php?isError=true&sMSG=" . $errorEncode . "';</script>";
		}
	}

	function loginCOOKIE_CHECK()
	{
		if(isset($_COOKIE["id"]))
		{		
			//VARIABLES
			$sID            		= @$_COOKIE["id"];
			$sUSER          		= @$_COOKIE["username"];
			$sUSER_VALIDATE 		= @$_COOKIE["username_validate"];
			$sAUTH_KEY      		= @$_COOKIE["auth_key"];
			$sAUTH_KEY_VALIDATE 	= @$_COOKIE["auth_key_validate"];
			$sLOGIN_LOG_ID 			= @$_COOKIE["login_log_id"];
			$sFULL_NAME 			= @$_COOKIE["full_name"];
			$sEMAIL 				= @$_COOKIE["email"];
			$sGENDER 				= @$_COOKIE["gender"];
			$sIS_ACTIVATED			= @$_COOKIE["is_activated"];
			$sREG_DATE 				= @$_COOKIE["reg_date"];
			
			include ("scripts/mysqli_connect.inc.php");
			$db_Connection  		= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
		
			$sql            = mysqli_query( $db_Connection, "SELECT * 
										   FROM users_login_log_table 
										   WHERE id='$sLOGIN_LOG_ID' 
										   AND auth_key='$sAUTH_KEY' 
										   LIMIT 1
							"); //query our database for the login

			//CHECK FOR LOGINS EXISTENCE
			$userCount      = mysqli_num_rows( $sql ); 

			if ($userCount == 1)
			{
				while( $row = mysqli_fetch_array( $sql ) )
				{
					$db_AUTH_KEY_FUNC             	= $row['auth_key'];
					$db_AUTH_KEY_VALIDATE_FUNC      = $row['auth_key_validate'];
					$db_ID_FUNC                     = $row['id'];
					

					if( $sAUTH_KEY == $db_AUTH_KEY_FUNC && $sAUTH_KEY_VALIDATE == $db_AUTH_KEY_VALIDATE_FUNC && $sID == $db_ID_FUNC )
						$loginCONDITION            = TRUE;
					else
						$loginCONDITION            = FALSE;

					if( $loginCONDITION == TRUE )
					{
						return TRUE;
					}
					else if( $loginCONDITION == FALSE )
					{
						return FALSE;
					}
				}
			}
		}
	}

	function loginSESSION_CHECK()
	{
		if(isset($_SESSION["id"]))
		{
			//VARIABLES
			$sID        			= @$_SESSION["id"];
			$sUSER      			= @$_SESSION["username"];
			$sUSER_VALIDATE 		= @$_SESSION["username_validate"];
			$sAUTH_KEY    			= @$_SESSION["auth_key"];
			$sAUTH_KEY_VALIDATE 	= @$_SESSION["auth_key_validate"];
			$sLOGIN_LOG_ID 			= @$_SESSION["login_log_id"];
			$sFULL_NAME 			= @$_SESSION["full_name"];
			$sEMAIL 				= @$_SESSION["email"];
			$sGENDER 				= @$_SESSION["gender"];
			$sIS_ACTIVATED			= @$_SESSION["is_activated"];
			$sREG_DATE 				= @$_SESSION["reg_date"];
			
			include ("scripts/mysqli_connect.inc.php");
			$db_Connection  		= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
		
			$sql            = mysqli_query( $db_Connection, "SELECT * 
										   FROM users_login_log_table 
										   WHERE id='$sLOGIN_LOG_ID' 
										   AND auth_key='$sAUTH_KEY' 
										   LIMIT 1
							"); //query our database for the login

			//CHECK FOR LOGINS EXISTENCE
			$userCount      = mysqli_num_rows( $sql ); 

			if ($userCount == 1)
			{
				while( $row = mysqli_fetch_array( $sql ) )
				{
					$db_AUTH_KEY_FUNC               = $row['auth_key'];
					$db_AUTH_KEY_VALIDATE_FUNC      = $row['auth_key_validate'];
					$db_ID_FUNC                     = $row['id'];

					if( $sAUTH_KEY == $db_AUTH_KEY_FUNC && $sAUTH_KEY_VALIDATE == $db_AUTH_KEY_VALIDATE_FUNC && $sID == $db_ID_FUNC )
						$loginCONDITION            = TRUE;
					else
						$loginCONDITION            = FALSE;

					if( $loginCONDITION == TRUE )
					{
						return TRUE;
					}
					else if( $loginCONDITION == FALSE )
					{
						return FALSE;
					}
				}
			}
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN" "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<!-- Meta Information TAGS Example -->
		<meta name="author" content="Dagason Hackason">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Page Title For Title Bar -->
		<title>Profile PAGE</title>
				
		<!-- Bootstrap CSS LINK -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
			
		<!-- Font Awesome ICONS CSS LINK -->
		<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
			
		<!-- Page Icon -->
		<link rel="shortcut icon" href="images/site-logo.png">
		
		<!-- Personal Extra External CSS LINK -->
		<link href="css/main-style.css" rel="stylesheet">
		
		<!-- Internal Stylesheet Example -->
		<style type="text/css" >
			.navbar {
				margin-bottom: 0;
				border-radius: 0;
			}
			
			/*lets Prevent Navigation bar from scrolling with the page*/
			#navigation {
				position: fixed;
				width: 100%;
				z-index: 99999;
			}
			
			footer .social-icons .fa {
				width: 40px;
				height: 40px;
				padding-top: 14px;
				text-align: center;
				color: #FFF;
				font-size: 14px;
			}
			
			.social-icons .fa-facebook, .social-icons .fa-facebook-square {
				background-color: #3C599F;
			}
			.social-icons .fa {
				width: 30px;
				height: 30px;
				padding-top: 9px;
				text-align: center;
				color: #FFF;
				font-size: 14px;
				-webkit-transition: all 0.3s ease-in-out;
				-moz-transition: all 0.3s ease-in-out;
				-ms-transition: all 0.3s ease-in-out;
				-o-transition: all 0.3s ease-in-out;
				transition: all 0.3s ease-in-out;
			}
			
			.social-icons.icon-circle .fa {
				border-radius: 50%;
			}
			
			.social-icons .fa-twitter, .social-icons .fa-twitter-square {
				background-color: #32CCFE;
			}
			
			.social-icons .fa-instagram, .social-icons .fa-instagram-square {
				background-color: #BB1000;
			}
			
			.social-icons .fa-github, .social-icons .fa-github-square {
				background-color: #444444;
			}
			
			.social-icons .fa-globe, .social-icons .fa-globe-square {
				background-color: #e5e200;
			}
			
			.footer-links li a {
				font-size: 13px;
				text-transform: uppercase;
				font-weight: 500;
				color: #ffffff;
			}
			
			.space40 {
				margin-left: -40px;
				margin-bottom: 10px;
				position: relative;
				display: inline;
				text-align: center;
			}

			footer {
				background-color: #222;
				border-color: #080808;
			}
			
			p.copy {
				color: #555555;
			}
		</style>
	</head>

	<body id="ProfilePage">
		<nav class="navbar navbar-inverse" id="navigation">
		  <div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.php" style="position: relative; top: -5px;" ><img src="images/site-logo.png" width="30" height="30" style="position: relative; display: inline;"/>&nbsp;&nbsp;Accra Bootcamp&nbsp;&nbsp;</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="active"><a href="index.php">HOME <span class="sr-only">(current)</span></a></li>
				<li><a href="login.php">LOGIN </a></li>
				<li><a href="register.php">REGISTER </a></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown Menu <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="#">About</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Something else here</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">Separated link</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">One more separated link</a></li>
				  </ul>
				</li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		
		<!-- Profile -->
		<div class="container" ><br /><br /><br /><br /><br /><br />
			<div class="profile-div" >
				<div class="main-div" >
					<div class="holder-top">
						<center>
							<!-- Your Profile Picture Here -->
							<img src="images/site-logo-greyscale.png" alt="Logo Picture" style="width: 160px; height: 160px; position: relative; display: block; margin-bottom: 20px; border-radius: 50%; border: 1px 1px 1px #000000;"/>
						</center>
						
						<?php 
							$getIncomingRequestedUser	= @$_GET["u"];
							if($getIncomingRequestedUser == $sUSER)
							{
								
								echo"									
									<h1>Full Name: " . $sFULL_NAME . "</h1><br />
									<h2>Username: " . $sUSER . "</h2><br />
									<h3>Email: " . $sEMAIL . "</h3><br />
									<h4>Gender: " . $sGENDER . "</h4><br />
									<p>Date You Registered: " . date("d", $sREG_DATE) . " / " . date("m", $sREG_DATE) . " / " . date("y", $sREG_DATE) . "</p><br />
								";
							}
							else 
							{
											
								include ("scripts/mysqli_connect.inc.php");
								$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
							
								$dbQuery			= mysqli_query( $db_Connection, "SELECT * 
																   FROM users_table 
																   WHERE username='$getIncomingRequestedUser' 
																   LIMIT 1
													") or print("									
															<div class='alert alert-danger alert-dismissible' role='alert' style='position: relative; display: none;' >
																<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button>
																Error Querying the Database!
															</div>
														  ");
													
								while( $rowResult = mysqli_fetch_assoc($dbQuery) )
								{
									$sUSER          		= $rowResult["username"];
									$sFULL_NAME 			= $rowResult["full_name"];
									$sEMAIL 				= $rowResult["email"];
									$sGENDER 				= $rowResult["gender"];
									$sIS_ACTIVATED			= $rowResult["is_activated"];
									$sREG_DATE 				= $rowResult["reg_date"];
									
									echo"									
										<h1 class='text-success' ></h1>Username: " . $sUSER . "<br /><br />
										<h2>Full Name: " . $sFULL_NAME . "</h2><br />
										<h3>Email: " . $sEMAIL . "</h3><br />
										<h4>Gender: " . $sGENDER . "</h4><br />
										<p>Date You Registered: " . date("d", $sREG_DATE) . " / " . date("m", $sREG_DATE) . " / " . date("y", $sREG_DATE) . "</p><br />
									";
								}
								
								if( empty($dbQuery) )
								{
									echo"									
										<div class='alert alert-danger alert-dismissible' role='alert' style='position: relative; display: none;' >
											<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button>
											The Requested User Doesn't Exist!
										</div>
									";
								}
							}
						?>
						
						<div id="Profile">
							<br />
							
							<button type="submit" class="btn btn-danger" id="btn_logout" name="btn_logout" onclick="javascript: callLogout();" ><i class="fa fa-power-off" style="position: relative; display: inline; float: left; margin-bottom: -31px; left: 15px; z-index: 10; font-size: 14px; bottom: -18px;"></i> LOGOUT</button><br /><br />
							
							<p class="botto-text"> Example <b>Profile Landing Page</b> <code>code</code> using the <b>Bootstrap Framework</b> with <code>PHP</code></p>
						</div>
					</div>
				</div>
			</div>
		</div>
			
		<div style="height: 50px"></div>
		
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<div style="height: 30px"></div>
						<ul class="list-inline social-icons icon-circle space20">
							<li class="facebook" style="list-style: none;" ><a target="_blank" href="http://www.facebook.com/DagasonHackason"><i class="fa fa-facebook"></i></a></li>
							<li class="twitter" style="list-style: none;" ><a target="_blank" href="http://www.twitter.com/DagasonHackason"><i class="fa fa-twitter"></i></a></li>
							<li class="website" style="list-style: none;" ><a target="_blank" href="http://www.dagasonhackason.com/"><i class="fa fa-globe"></i></a></li>
							<li class="github" style="list-style: none;" ><a target="_blank" href="http://www.github.com/DagasonHackason"><i class="fa fa-github"></i></a></li>
							<li class="instagram" style="list-style: none;" ><a target="_blank" href="http://www.instagram.com/DagasonHackason"><i class="fa fa-instagram"></i></a></li>
						</ul>
						<ul class="footer-links space40">
							<li style="position: relative; display: inline; list-style: none;" ><a href="#">&nbsp;&nbsp;FAQ&nbsp;&nbsp;</a></li>
							<li style="position: relative; display: inline; list-style: none;" ><a href="#" data-toggle="modal">&nbsp;&nbsp;Legality&nbsp;&nbsp;</a></li>
							<li style="position: relative; display: inline; list-style: none;" ><a href="#">&nbsp;&nbsp;Terms&nbsp;&nbsp;</a></li>
							<li style="position: relative; display: inline; list-style: none;" ><a href="#" data-toggle="modal">&nbsp;&nbsp;Policy&nbsp;&nbsp;</a></li>
						</ul><br />
						<p class="copy"> Designed by <a target="_blank" href="http://www.dagasonhackason.com/"><b>Dagason Hackason</b></a> &copy; 2018</p>
						<div style="height: 30px"></div>
					</div>
				</div>
			</div>
		</footer>
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/javascript" ></script>
		
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js" type="text/javascript" ></script>
			
		<!-- Personal Extra External JavaScript File -->
		<script src="js/main-script.js" type="text/javascript" ></script>
	</body>
</html>