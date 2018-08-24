<?php
    //lets start our session
    session_start();
	
	include ("scripts/mysqli_connect.inc.php");
	$db_Connection  = mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
			
    $pCFUNC_ARG = strip_tags(@$_GET['IPCFuncArg']) or strip_tags(@$_POST['IPCFuncArg']);
	
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
			echo '<script type="text/javascript">window.location = "' . $sUSER_REDIR . "';</script>";
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
			$db_Connection  = mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
			
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
			$db_Connection  = mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
			
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
<!--
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
-->
<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN" "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
  <head>
    <!-- Meta Information TAGS Example -->
	<meta name="author" content="Dagason Hackason">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<!-- Page Title For Title Bar -->
	<title>Login</title>
    
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
  <body id="LoginForm">
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

	<!-- Login Form -->
    <div class="container"><br /><br /><br /><br /><br /><br />
		<div class="login-form" >
			<div class="main-div" >
				<div class="holder-top">
					<center>
						<!-- Your Logo Picture Here -->
						<img src="images/site-logo-greyscale.png" alt="Logo Picture" style="width: 160px; height: 160px; position: relative; display: block; margin-bottom: 20px;"/>
					</center>
					<h2>Member Login</h2>
					<p>Please enter your username and password.</p>
					<?php 
						$errorDetector				= strip_tags(@$_GET["isError"]);
						$successDetector			= strip_tags(@$_GET["isSuccess"]);
						$errorMessageRaw			= strip_tags(@$_GET["eMSG"]);
						$errorMessageDecode			= urldecode($errorMessageRaw);
						$successMessageRaw			= strip_tags(@$_GET["sMSG"]);
						$successMessageDecode		= urldecode($successMessageRaw);

						function initError($eARG){
							switch($eARG){
								case "eARG1":
									$errorEncode = urlencode("UNIQUE_ID_GEN_ERROR</b>");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG2":
									$errorEncode = urlencode("YOUR PIN_NUMBER MUST BE 4 NUMBERS IN LENGHT !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG3":
									$errorEncode = urlencode("YOUR PIN_NUMBERS DON'T MATCH !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG4":
									$errorEncode = urlencode("PLEASE FILL ALL THE SIGNUP FIELDS !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG5":
									$errorEncode = urlencode("THAT UNIQUE_ID IS ALREADY TAKEN - UNIQUE_ID GEN ERROR !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG6":
									$errorEncode = urlencode("YOUR EMAIL HAS BEEN USED ALREADY !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG7":
									$errorEncode = urlencode("YOUR EMAILS DON'T MATCH !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG8":
									$errorEncode = urlencode("PROBLEM WITH LOGIN INFORMATION ENTERED!!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG9":
									$errorEncode = urlencode("PROBLEM WITH LOGIN INFORMATION ENTERED !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG10":
									$errorEncode = urlencode("PLEASE FILL THE LOGIN FORM COMPLETELY !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG11":
									$errorEncode = urlencode("WARNING :: IMPERSONATED SESSION DETECTED AND DESTROYED !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								case "eARG12":
									$errorEncode = urlencode("UNKNOWN ERROR !!!");
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
								break;
								
								default:
									$errorEncode = urlencode($eARG);
									echo "<script type='text/javascript'>window.location = 'login.php?isError=true&eMSG=" . $errorEncode . "';</script>";
							}
						} 

						function initSuccess($sARG){
							switch($sARG){
								case "sARG1":
									$successEncode = urlencode("YOUR REGISTRATION HAS BEEN SUBMITED AND IS WAITING APPROVAL TO BE ACTIVATED</b>");
									echo "<script type='text/javascript'>window.location = 'login.php?isSuccess=true&sMSG=" . $successEncode . "';</script>";
								break;
								
								default:
									$successEncode = urlencode($sARG);
									echo "<script type='text/javascript'>window.location = 'login.php?isSuccess=true&sMSG=" . $successEncode . "';</script>";
							}
						}
						if($successDetector || $errorDetector){
							if($successDetector == "true")
							{
								echo    "
										<div class='alert alert-success alert-dismissible' role='alert' style='position: relative; display: block;' >
											<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button>
											" . $successMessageDecode . "
										</div>
								";
							}
							
							if($errorDetector == "true")
							{
								echo    "
										<div class='alert alert-danger alert-dismissible' role='alert' style='position: relative; display: block;' >
											<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button>
											" . $errorMessageDecode . "
										</div>
								";
							}
						}
						
						function number_to_word( $num = '' )
						{
							$num   	 	= ( string ) ( ( int ) $num );

							if( ( int ) ( $num ) && ctype_digit( $num ) )
							{
								$words  = array( );

								$num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );

								$list1  = array('','one','two','three','four','five','six','seven',
									'eight','nine','ten','eleven','twelve','thirteen','fourteen',
									'fifteen','sixteen','seventeen','eighteen','nineteen');

								$list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
									'seventy','eighty','ninety','hundred');

								$list3  = array('','thousand','million','billion','trillion',
									'quadrillion','quintillion','sextillion','septillion',
									'octillion','nonillion','decillion','undecillion',
									'duodecillion','tredecillion','quattuordecillion',
									'quindecillion','sexdecillion','septendecillion',
									'octodecillion','novemdecillion','vigintillion');

								$num_length = strlen( $num );
								$levels = ( int ) ( ( $num_length + 2 ) / 3 );
								$max_length = $levels * 3;
								$num    = substr( '00'.$num , -$max_length );
								$num_levels = str_split( $num , 3 );

								foreach( $num_levels as $num_part )
								{
									$levels--;
									$hundreds   = ( int ) ( $num_part / 100 );
									$hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
									$tens       = ( int ) ( $num_part % 100 );
									$singles    = '';

									if( $tens < 20 )
									{
										$tens   = ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
									}
									else
									{
										$tens   = ( int ) ( $tens / 10 );
										$tens   = ' ' . $list2[$tens] . ' ';
										$singles    = ( int ) ( $num_part % 10 );
										$singles    = ' ' . $list1[$singles] . ' ';
									}
									$words[]    = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
								}

								$commas = count( $words );

								if( $commas > 1 )
								{
									$commas = $commas - 1;
								}

								$words  = implode( ', ' , $words );

								$words  = trim( str_replace( ' ,' , ',' , trim( ucwords( $words ) ) ) , ', ' );
								if( $commas )
								{
									$words  = str_replace( ',' , ' and' , $words );
								}

								return $words;
							}
							else if( ! ( ( int ) $num ) )
							{
								return 'Zero';
							}
							return '';
						}
						
						function sendNewLoginAlert($email, $full_name, $new_insert_id) {
							//PUT YOUR CODE TO SEND YOUR EMAIL TO NOTIFY THE USER HIS ACCOUNT HAS BEEN CREATED U CAN EVEN ADD A LINK HE CAN USE TO ACTUVATE HIS ACCOUNT TO THE EMAIL
							//if it was scuccessfull return true if not return false this is just an example so i will force it to return true without doing anything because of time
							return true;
						}
						
						function mysqli_result($res,$row=0,$col=0){ 
							$numrows = mysqli_num_rows($res); 
							if ($numrows && $row <= ($numrows-1) && $row >=0){
								mysqli_data_seek($res,$row);
								$resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
								if (isset($resrow[$col])){
									return $resrow[$col];
								}
							}
							return false;
						}
						
						//GET LOGIN INPUT DATA
						$btn_login                              = strip_tags(@$_POST['btn_login']);
						$username                               = strip_tags(@$_POST['username']);
						$password                               = strip_tags(@$_POST['password']);
						$is_remembered                          = strip_tags(@$_POST['is_remembered']);
						$LogIn                                  = strip_tags(@$_POST['LogIn']);
						$number_of_tries                        = strip_tags(@$_POST['number_of_tries']);
						$LTYPE 									= "BROWSER";
						
						$date                                	= time();

						//CHECKING NUMBER OF ATTEMPS FOR SECURITY REASONS
						if( $LogIn && $username && $password && $number_of_tries <= 20 )
						{
							$number_of_tries++;
							
							if ( $LogIn == "Log-In" )
							{
							
								$password                        			= md5($password);
								$password                        			= sha1($password);
								$password                        			= md5($password);
								$password                        			= sha1($password);
								$password                        			= md5($password);
								
								include ("scripts/mysqli_connect.inc.php");
								$db_Connection  = mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
			
								$check_DB                              		= mysqli_query( $db_Connection,  "SELECT *
																							FROM users_table
																							WHERE username='$username'
																			  ") or initError("eARG25");
								$get_DB                                		= mysqli_fetch_assoc($check_DB);

								$db_Password                           		= $get_DB['password'];
								
								$sql                                   		= mysqli_query( $db_Connection, "SELECT *
																						   FROM users_table
																						   WHERE username='$username'
																						   LIMIT 1
																			  ") or initError("eARG25");

								$userCount                             		= mysqli_num_rows( $sql );

								if ($userCount == 1	)
								{
									while( $row = mysqli_fetch_array( $sql ) ) {
										$password_validate   				= md5($password);
										$db_PASS                   			= $row['password'];
										$db_PASSVALIDATE           			= $row['password_validate'];
										$db_ID                     			= $row['id'];

										//LET'S RUN THE FINAL PASSWORD WITH OUR RECORDS AND SEE IF THEY ARE CORRECT
										if( $password == $db_PASS && $password_validate = $db_PASSVALIDATE )
										{
											$loginCONDITION       			= TRUE;
										}
										else
										{
											$loginCONDITION       			= FALSE;
										}


										if( $loginCONDITION == TRUE )
										{
											//ENCRYPTING THE AUTHENTICATION KEY
											$db_ID_num						= number_to_word($db_ID);
											$getEncryptionOperand  			= md5($db_ID_num);
											$getEncryptionOperand 			= sha1($getEncryptionOperand);
											$getEncryptionOperand 			= md5($getEncryptionOperand);
											$getEncryptionOperand 			= sha1($getEncryptionOperand);
											$getEncryptionOperand 			= md5($getEncryptionOperand);
											
											//ADDING SOME EXCESS STUFF FOR VERICATION PURPOSES
											$getEncryptionOperand_validate 	= md5($getEncryptionOperand);
											
											//LETS FIX ANY AUTO INCREMENT PROBLEMS IN DB TABLE SO IT'S  ALWAYS REMAINS ARITHMETIC BEFORE WE INSERT
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  											= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$setAutoIncrQuery				                        	= mysqli_query( $db_Connection, "ALTER TABLE `users_login_log_table`
																														AUTO_INCREMENT=1
																										") or initError("eARG25");
											
											//CHECK FOR REMEMBER ME WHETHER / TO USE A COOKIE OR A SESSION 
											if($is_remembered) {
												$loginClassification									= "COOKIE";
											}
											else {
												$loginClassification									= "SESSION";
											}						
																										
											//NOW LET'S INSERT THE LOGIN LOG RECORDS IN TO THE DATABASE
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  											= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$query          											= mysqli_query( $db_Connection, "INSERT IGNORE INTO `users_login_log_table` (`id`, `account_id`, `time_logged_in`, `time_logged_out`, `login_type`, `is_reported`, `is_blocked`, `auth_key`, `auth_key_validate`) VALUES
																													   ('', '$db_ID', '$date', '', '$loginClassification', 'N', 'N', '$getEncryptionOperand', '$getEncryptionOperand_validate');
																										") or initError("eARG25");
											
											//LET'S CHECK THE ID WE USED TO INSERT INCASE WE WANT TO WORK WITH THAT ENTRY ANYTIME
											$userJustCreatedID											= mysqli_insert_id($db_Connection);
											
											$get_insert_id					= mysqli_insert_id($db_Connection);
																									
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$username_q						= mysqli_query( $db_Connection, "SELECT username FROM users_table WHERE id='$db_ID'");
											$username						= mysqli_result($username_q, 0);
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$username_validate_q			= mysqli_query( $db_Connection, "SELECT username_validate FROM users_table WHERE id='$db_ID'");
											$username_validate				= mysqli_result($username_validate_q, 0);
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$email_q	    				= mysqli_query( $db_Connection, "SELECT email FROM users_table WHERE id='$db_ID'");
											$email   						= mysqli_result($email_q, 0);
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$get_id                         = mysqli_query( $db_Connection, "SELECT id FROM users_table WHERE id='$db_ID'");
											$id                        		= mysqli_result($get_id, 0);
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$get_full_name                 	= mysqli_query( $db_Connection, "SELECT full_name FROM users_table WHERE id='$db_ID'");
											$full_name                		= mysqli_result($get_full_name, 0);
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$gender_q						= mysqli_query( $db_Connection, "SELECT gender FROM users_table WHERE id='$db_ID'");
											$gender							= mysqli_result($gender_q, 0);
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$is_activated_q                 = mysqli_query( $db_Connection, "SELECT is_activated FROM users_table WHERE id='$db_ID'");
											$is_activated                  	= mysqli_result($is_activated_q, 0);
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$is_deleted_q                 	= mysqli_query( $db_Connection, "SELECT is_deleted FROM users_table WHERE id='$db_ID'");
											$is_deleted                		= mysqli_result($is_deleted_q, 0);
														
											include ("scripts/mysqli_connect.inc.php");
											$db_Connection  				= mysqli_connect( $db_Host, $db_User, $db_Password, $db_Name );
										
											$reg_date_q                 	= mysqli_query( $db_Connection, "SELECT reg_date FROM users_table WHERE id='$db_ID'");
											$reg_date                		= mysqli_result($reg_date_q, 0);
											
											$id_ins                         = $get_insert_id;

											//CHECK FOR REMEMBER ME WHETHER / TO USE A COOKIE OR A SESSION 
											if($is_remembered == "on" ) {
												setcookie( "id", $id, time()+1209600, '/' );
												setcookie( "username", $username, time()+1209600, '/' );
												setcookie( "username_validate", $username_validate, time()+1209600, '/' );
												setcookie( "login_log_id", $get_insert_id, time()+1209600, '/' );
												setcookie( "auth_key", $getEncryptionOperand, time()+1209600, '/' );
												setcookie( "auth_key_validate", $getEncryptionOperand_validate, time()+1209600, '/' );
												setcookie( "is_activated", $is_activated, time()+1209600, '/' );
												setcookie( "email", $email, time()+1209600, '/' );
												setcookie( "full_name", $full_name, time()+1209600, '/' );
												setcookie( "gender", $gender, time()+1209600, '/' );
												setcookie( "reg_date", $reg_date, time()+1209600, '/' );
											}
											else if($is_remembered == "" ) {
												$_SESSION["id"]                	= $id;
												$_SESSION["username"]          	= $username;
												$_SESSION["username_validate"] 	= $username_validate;
												$_SESSION["login_log_id"]      	= $get_insert_id;
												$_SESSION["auth_key"]          	= $getEncryptionOperand;
												$_SESSION["auth_key_validate"] 	= $getEncryptionOperand_validate;
												$_SESSION["is_activated"]      	= $is_activated;
												$_SESSION["email"]             	= $email;
												$_SESSION["full_name"]        	= $full_name;
												$_SESSION["gender"]        		= $gender;
												$_SESSION["reg_date"]        	= $reg_date;
											}
											
											if($query)
											{
												$NewLoginAlertVar 			= sendNewLoginAlert($email, $full_name, $get_insert_id);
												
												if($NewLoginAlertVar)
												{
													//LET'S TAKE OUR SELVES TO THE LANDING PAGE :)
													print("
														<div class='alert alert-success alert-dismissible' role='alert' style='position: relative; display: none;' >
															<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button>
															The Login was successfull!
														</div>
													");
													echo '<script type="text/javascript">window.location = "'.$username.'";</script>';
												}
												else if(!$NewLoginAlertVar)
												{
													initError("eARG8");
												}
											}

										}
										else
										{
											initError("eARG8");
										}
									}
								}
								else
								{
									initError("eARG9");
								}
							
							}
							else
							{
								initError("IMPERSONATED LOGIN");
							}
						}
						else
						{
							if($number_of_tries > 20)
							{
								initError("eARGX");
							}
						}
					?>
					
					<!-- ERROR ALERT DISPLAY REGION -->
					<div class="alert alert-info alert-dismissible" role="alert" style="position: relative; display: none;" >
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
						This is a info message
					</div>
					
					<div class="alert alert-warning alert-dismissible" role="alert" style="position: relative; display: none;" >
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
						This is a warning message
					</div>
					
				</div>
			   
				<form id="Login" method="POST" action="login.php" >
					<div class="form-group">
						<i class="fa fa-user-secret" style="position: relative; display: inline; float: left; margin-bottom: -31px; left: 15px; z-index: 10; font-size: 14px; bottom: -20px;"></i><input type="text" class="form-control" placeholder="Username" id="username" name="username" required="" />
					</div>
					
					<div class="form-group">
						<i class="fa fa-unlock-alt" style="position: relative; display: inline; float: left; margin-bottom: -31px; left: 15px; z-index: 10; font-size: 14px; bottom: -20px;"></i><input type="password" class="form-control" placeholder="Password" id="password" name="password" required="" />
					</div>
					
					<div class="pull-left">
						<a href="#">Forgot Password?</a>
					</div>
					
					<div class="checkbox clearfix" >
						<label>
							<input type="checkbox" id="is_remembered" name="is_remembered"> Remember&nbsp;me
						</label>
					</div>
					
					<input type="hidden" id="LogIn" name="LogIn" value="Log-In" />
					
					<?php
						echo "
							<input type='hidden' id='number_of_tries' name='number_of_tries' value='" . $number_of_tries . "' /><br />
						";
					?>

					<button type="submit" class="btn btn-primary" id="btn_login" name="btn_login"><i class="fa fa-sign-in" style="position: relative; display: inline; float: left; margin-bottom: -31px; left: 15px; z-index: 10; font-size: 14px; bottom: -18px;"></i> LOGIN</button><br /><br />
					
					<p class="botto-text"> Example <b>Login Page</b> <code>code</code> using the <b>Bootstrap Framework</b> with <code>PHP</code></p>
				</form>
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
