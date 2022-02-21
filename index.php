<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<title>Twitter API</title>
<?php
require 'vendor/autoload.php';
require 'settings.php';
use Abraham\TwitterOAuth\TwitterOAuth;


	if ( isset( $_SESSION['twitter_access_token'] ) && $_SESSION['twitter_access_token'] ) { // we have an access token
		$isLoggedIn = true;	
	} elseif ( isset( $_GET['oauth_verifier'] ) && isset( $_GET['oauth_token'] ) && isset( $_SESSION['oauth_token'] ) && $_GET['oauth_token'] == $_SESSION['oauth_token'] ) { // coming from twitter callback url
		// setup connection to twitter with request token
		$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );
		$content = $connection->get("account/verify_credentials");
		  
		// get an access token
		$access_token = $connection->oauth( "oauth/access_token", array( "oauth_verifier" => $_GET['oauth_verifier'] ) );

		// save access token to the session
		$_SESSION['twitter_access_token'] = $access_token;

		// user is logged in
		$isLoggedIn = true;
	} else { // not authorized with our app, show login button
		// connect to twitter with our app creds
		$connection = new TwitterOAuth( $CONSUMER_KEY, $CONSUMER_SECRET );

		// get a request token from twitter
		$request_token = $connection->oauth( 'oauth/request_token', array( 'oauth_callback' => OAUTH_CALLBACK ) );

		// save twitter token info to the session
		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		// user is logged in
		$isLoggedIn = false;
	}

	if ( $isLoggedIn ) { // logged in
		// get token info from session
		$oauthToken = $_SESSION['twitter_access_token']['oauth_token'];
		$oauthTokenSecret = $_SESSION['twitter_access_token']['oauth_token_secret'];

		// setup connection
		$connection = new TwitterOAuth( $CONSUMER_KEY, $CONSUMER_SECRET, $oauthToken, $oauthTokenSecret );

		// user twitter connection to get user info
		$user = $connection->get( "account/verify_credentials", ['include_email' => 'true'] );

		if ( property_exists( $user, 'errors' ) ) { // errors, clear session so user has to re-authorize with our app
	    	$_SESSION = array();
	    	header( 'Refresh:0' );
	    } else { // display user info in browser
		require 'profile.php';
	    }
	} else {  // not logged in, get and display the login with twitter link
		$url = $connection->url( 'oauth/authorize', array( 'oauth_token' => $request_token['oauth_token'] ) );
		echo '<br><center><a href="'.$url.'" type="button" class="btn btn-primary">Login With Twitter</a></center>'; 
	}
	?>