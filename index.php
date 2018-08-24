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
	<title>Accra Bootcamp - Home</title>
    
	<!-- Bootstrap CSS LINK -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
	<!-- Font Awesome ICONS CSS LINK -->
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
	
	<!-- Page Icon -->
	<link rel="shortcut icon" href="images/site-logo.png">
	
	<!-- Internal Stylesheet -->
    <style type="text/css" >
		.navbar {
			margin-bottom: 0;
			border-radius: 0;
		}
		  
		  #mid-banner {
			background-image: url("images/long-banner.jpg"); 
			background-repeat: no-repeat; 
			background-position: 0px -126px; 
			background-size: cover; 
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
  <body>
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

    <!-- JUMBOTRON -->
    <div class="jumbotron text-center" id="mid-banner" >
      <div class="container">
        <h1 style="color: #333333; margin-top: 50px;" >Welcome To Accra Bootcamp</h1>
        <p style="color: #FFFFFF; text-shadow: 0px 0px 7px #000000;" >Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p>
        <a href="#" class="btn btn-primary" style=" margin-bottom: 30px;" >Read More</a>
      </div>
    </div>

    <!-- TYPOGRAPHY -->
    <div class="container">
      <h1 class="page-header">Hello, world! <small>Secondary text</small></h1>
      <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua.</p>
      <p><mark>Lorem ipsum dolor sit amet</mark>, consectetur adipisicing elit, sed do eiusmod
      tempor <del>incididunt ut labore</del> et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation <u>ullamco laboris nisi</u> ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
      non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

      <hr>

      <!-- ALIGNMENT & TRANSFORMATION-->
      <p class="text-left text-lowercase">Left aligned text.</p>
      <p class="text-center text-uppercase">Center aligned text.</p>
      <p class="text-right text-capitalize">Right aligned text.</p>
      <p class="text-justify">Justified text.</p>
      <p class="text-nowrap">No wrap text.</p>

      <!-- QUICK FLOATS -->
      <div class="pull-right">Div floated to right </div>
      <div class="pull-left">Div floated to left &amp;&nbsp;&apos;&nbsp;&times;&nbsp;&minus;&nbsp;&lt;&nbsp;&gt;&nbsp;&copy;</div>

      <!-- CLEAR FLOAT -->
      <div class="clearfix"></div>

      <hr>

      <!-- BLOCKQUOTE -->
      <blockquote class="blockquote-reverse">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
         <footer>Quote by <cite title="Dagason Hackason">Dagason Hackason</cite></footer>
      </blockquote>

      <hr>

      <!-- LISTS -->
      <ul class="list-unstyled">
        <li>Item One</li>
        <li>Item Two</li>
        <li>Item Three</li>
        <li>Item Four</li>
      </ul>

      <ul class="list-inline">
        <li>Item One</li>
        <li>Item Two</li>
        <li>Item Three</li>
        <li>Item Four</li>
      </ul>

      <!-- CODE -->
      <code>&lt;h1&gt;Heading Text&lt;/h1&gt;</code>
      <br>
      Change directory with<kbd>cd</kbd>
      <br>
      To edit settings, press <kbd><kbd>ctrl</kbd> + <kbd>,</kbd></kbd>

      <hr>

      <!-- CONTEXTUAL COLORS -->
      <p class="text-primary">Hello World</p>
      <p class="text-success">Hello World</p>
      <p class="text-info">Hello World</p>
      <p class="text-warning">Hello World</p>
      <p class="text-danger">Hello World</p>
      <p class="text-muted">Hello World</p>

      <!-- CONTEXTUAL BACKGROUND COLORS -->
      <p class="bg-primary">Hello World</p>
      <p class="bg-success">Hello World</p>
      <p class="bg-info">Hello World</p>
      <p class="bg-warning">Hello World</p>
      <p class="bg-danger">Hello World</p>
      <p class="bg-muted">Hello World</p>
    </div>

    <hr>

    <!-- BUTTONS -->
    <div class="container">
      <button class="btn btn-default">Button</button>
      <a href="#" class="btn btn-default" role="button">Link</a>
      <input type="submit" class="btn btn-default" value="Submit">
      <br>
      <!-- CONTEXTUAL BUTTONS -->
      <button class="btn btn-default">Default</button>
      <button class="btn btn-primary">Primary</button>
      <button class="btn btn-success">Success</button>
      <button class="btn btn-info">Info</button>
      <button class="btn btn-warning">Warnig</button>
      <button class="btn btn-danger">Delete</button>
      <button class="btn btn-link">Link</button>
      <br>
      <!-- BUTTON SIZES -->
      <button class="btn btn-default btn-lg">Default</button>
      <button class="btn btn-default">Default</button>
      <button class="btn btn-primary btn-sm">Default</button>
      <button class="btn btn-default btn-xs" disabled="disabled">Default</button>
    </div>

    <hr>

    <!-- FORMS -->
    <div class="container">
	
		<!-- REGISTER FORM EXAMPLE -->
		<form id="Register" method="POST" action="destination-to-sumbit-form-to.php" >
			<div class="form-group">
				<label>Username: </label>
				<input type="text" class="form-control" placeholder="Username...." id="username" name="username" />
			</div>
			
			<div class="form-group">
				<label>Email: </label>
				<input type="email" class="form-control" placeholder="Add Email" id="email" name="email" />
			</div>
			
			<div class="form-group">
				<label>Full Name: </label>
				<input type="text" class="form-control" placeholder="Add Name" id="full_name" name="full_name" />
			</div>

			<div class="form-group">
				<label>Message</label>
				<textarea class="form-control" placeholder="Add Message" id="message" name="message" ></textarea>
			</div>

			<div class="form-group">
				<label>Select Gender: </label>
				<select class="form-control" id="gender" name="gender" >
					<option value="MALE" >Male</option>
					<option value="FEMALE" selected>Female</option>
				</select>
			</div>

			<div class="form-group">
				<label>Upload File</label>
				<input type="file">
				<p class="help-block">Only png and jpg allowed</p>
			</div>

			<div class="checkbox">
				<label>
					<input type="checkbox" id="checkbox" name="checkbox"> Check me out
				</label>
			</div>
			
			<input type="hidden" id="number_of_tries" name="number_of_tries" value="1" />

			<button type="submit" class="btn btn-primary" id="btn_register" >REGISTER</button>
			<button type="reset" class="btn btn-danger" id="btn_cancel">RESET FORM</button>
        </form><br />
		
		<!-- INLINE FORM -->
		<form id="Login_inline" class="form-inline" method="POST" action="login.php" >
			<div class="form-group">
			   <input type="username" class="form-control" placeholder="Username" id="username2" name="username2" />
			</div>
			<div class="form-group">
			   <input type="password" class="form-control" placeholder="Password" id="password" name="password" />
			</div>
			<div class="checkbox">
			   <input type="checkbox" id="is_remembered" name="is_remembered"> Remember me
			</div>
			
			<button type="submit" class="btn btn-default">LOGIN</button>
	   </form>

        <hr>
     </div>
   </div>

   <hr>

   <!-- TABLES -->
    <div class="container">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Age</th>
        </tr>
        <tr class="danger">
          <td>Jill</td>
          <td>Smith</td>
          <td>50</td>
        </tr>
        <tr>
          <td>Eve</td>
          <td>Jackson</td>
          <td>24</td>
        </tr>
        <tr class="success">
          <td>John</td>
          <td>Doe</td>
          <td>34</td>
        </tr>
        <tr>
          <td>Stephanie</td>
          <td>Landon</td>
          <td>47</td>
        </tr>
        <tr>
          <td>Mike</td>
          <td>Johnson</td>
          <td>19</td>
        </tr>
      </table>
    </div>

    <hr>

    <!-- LIST GROUP -->
    <div class="container">
      <ul class="list-group">
        <li class="list-group-item">Item One</li>
        <li class="list-group-item">Item Two</li>
        <li class="list-group-item">Item Three</li>
        <li class="list-group-item">Item Four</li>
      </ul>

      <div class="list-group">
          <a href="#" class="list-group-item active">Item One</a>
          <a href="#" class="list-group-item">Item Two</a>
          <a href="#" class="list-group-item list-group-item-success">Item Three</a>
          <a href="#" class="list-group-item disabled">Item Four</a>
        </div>
    </div>

    <div class="container">
      <!-- PANELS -->
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Panel title</h3>
        </div>
        <div class="panel-body">
          Panel content
        </div>
        <div class="panel-footer">Panel Footer</div>
      </div>

      <hr>

      <!-- WELLS -->
      <div class="well"> Hello World</div>
      <div class="well well-lg"> Hello World</div>
      <div class="well well-sm"> Hello World</div>

      <hr>

      <!-- ALERTS -->
      <div class="alert alert-success" role="alert">A success alert</div>
      <div class="alert alert-info" role="alert">An info alert</div>
      <div class="alert alert-warning" role="alert">A warning alert</div>
      <div class="alert alert-danger" role="alert">A danger alert</div>

      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        You can close this alert
      </div>

      <!-- PROGRESS BARS -->
      <div class="progress">
        <div class="progress-bar progress-bar-success progress-bar-striped active" style="width:50%;">
          50%
        </div>
      </div>

      <hr>
      <!-- LABELS -->
      <span class="label label-default">Default</span>
      <h1>Hello <span class="label label-primary">Primary</span></h1>
      <span class="label label-success">Success</span>
      <span class="label label-info">Info</span>
      <span class="label label-warning">Warning</span>
      <span class="label label-danger">Danger</span>

      <!-- BADGES -->
      <a href="#">Inbox <span class="badge">50</span></a>

      <button class="btn btn-primary" type="button">
        Messages <span class="badge">2</span>
      </button>
    </div>

    <!-- IMAGES -->
    <div class="container">
      <img class="thumbnail" src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350%C3%97150&w=350&h=150">
      <img class="img-rounded" src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350%C3%97150&w=350&h=150"><br><br>
      <img class="img-circle" src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350%C3%97150&w=350&h=150">
    </div>

    <hr>

    <!-- GRIDS -->
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-3">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et </p>
        </div>
        <div class="col-md-3">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et </p>
        </div>
        <div class="col-md-3">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et </p>
        </div>
        <div class="col-md-3">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-6">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div class="col-md-6">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et </p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
        </div>
        <div class="col-md-1">
          <h3>Box</h3>
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
