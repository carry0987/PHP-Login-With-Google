<?php
// Include configuration file
require_once 'config.php';

// Include User library file
require_once 'User.class.php';

if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL));
}

if(isset($_SESSION['token'])){
	$gClient->setAccessToken($_SESSION['token']);
}

if($gClient->getAccessToken()){
	// Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	
	// Initialize User class
	$user = new User();
	
	// Getting user profile info
	$gpUserData = array();
	$gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:'';
	$gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:'';
	$gpUserData['last_name']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:'';
	$gpUserData['email'] 	  = !empty($gpUserProfile['email'])?$gpUserProfile['email']:'';
	$gpUserData['gender'] 	  = !empty($gpUserProfile['gender'])?$gpUserProfile['gender']:'';
	$gpUserData['locale'] 	  = !empty($gpUserProfile['locale'])?$gpUserProfile['locale']:'';
	$gpUserData['picture'] 	  = !empty($gpUserProfile['picture'])?$gpUserProfile['picture']:'';
	
	// Insert or update user data to the database
    $gpUserData['oauth_provider'] = 'google';
    $userData = $user->checkUser($gpUserData);
	
	// Storing user data in the session
	$_SESSION['userData'] = $userData;
	
	// Render user profile data
    if(!empty($userData)){
        $output	 = '<h2>Google Account Details</h2>';
		$output .= '<div class="ac-data">';
        $output .= '<img src="'.$userData['picture'].'">';
        $output .= '<p><b>Google ID:</b> '.$userData['oauth_uid'].'</p>';
        $output .= '<p><b>Name:</b> '.$userData['first_name'].' '.$userData['last_name'].'</p>';
        $output .= '<p><b>Email:</b> '.$userData['email'].'</p>';
        $output .= '<p><b>Gender:</b> '.$userData['gender'].'</p>';
        $output .= '<p><b>Locale:</b> '.$userData['locale'].'</p>';
        $output .= '<p><b>Logged in with:</b> Google Account</p>';
        $output .= '<p>Logout from <a href="logout.php">Google</a></p>';
		$output .= '</div>';
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
}else{
	// Get login url
	$authUrl = $gClient->createAuthUrl();
	
	// Render google login button
	$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'" class="login-btn">Sign in with Google</a>';
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Login with Google using PHP</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Stylesheet file -->
<link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<div class="container">
	<div class="wrapper">
		<!-- Display login button / Google profile information -->
		<?php echo $output; ?>
	</div>
</div>
</body>
</html>