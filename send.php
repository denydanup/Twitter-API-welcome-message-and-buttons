<?php
require 'vendor/autoload.php';
require 'settings.php';
use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
$content = $connection->get("account/verify_credentials");

if (isset($_SESSION['twitter_access_token']) && $_SESSION['twitter_access_token'])
{ // we have an access token
    $isLoggedIn = true;
}
elseif (isset($_GET['oauth_verifier']) && isset($_GET['oauth_token']) && isset($_SESSION['oauth_token']) && $_GET['oauth_token'] == $_SESSION['oauth_token'])
{ // coming from twitter callback url
    $access_token = $connection->oauth("oauth/access_token", array(
        "oauth_verifier" => $_GET['oauth_verifier']
    ));
    $_SESSION['twitter_access_token'] = $access_token;
    $isLoggedIn = true;
}
else
{ // not authorized with our app, show login button
    // connect to twitter with our app creds
    $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);

    // get a request token from twitter
    $request_token = $connection->oauth('oauth/request_token', array(
        'oauth_callback' => OAUTH_CALLBACK
    ));

    // save twitter token info to the session
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    // user is logged in
    $isLoggedIn = false;
}

if ($isLoggedIn) // logged in
{ 
    // get token info from session
    $oauthToken = $_SESSION['twitter_access_token']['oauth_token'];
    $oauthTokenSecret = $_SESSION['twitter_access_token']['oauth_token_secret'];

    // setup connection
    $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $oauthToken, $oauthTokenSecret);

    // user twitter connection to get user info
    $user = $connection->get("account/verify_credentials", ['include_email' => 'true']);

    if (property_exists($user, 'errors'))
    { // errors, clear session so user has to re-authorize with our app
        $_SESSION = array();
        header('Refresh:0');
    }
    else // display user info in browser
    { 
echo '
<form method="POST">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Add new message</h4>
		  </div>
		  <div class="modal-body">
			<div class="form-group has-success">
			  <label class="control-label" for="inputSuccess1">Welcome Message</label>
			  <input type="text" class="form-control" name="welcome_message" id="inputSuccess1">
			</div>
			<hr>
			<div class="row">
			  <div class="col-md-6">
				<div class="form-group">
				  <input type="text" name="label_1" class="form-control" placeholder="Button 1" />
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="form-group">
				  <input type="text" name="description_1" class="form-control" placeholder="description" />
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="form-group">
				  <input type="text" name="label_2" class="form-control" placeholder="Button 2" />
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="form-group">
				  <input type="text" name="description_2" class="form-control" placeholder="description" />
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="form-group">
				  <input type="text" name="label_3" class="form-control" placeholder="Button 3" />
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="form-group">
				  <input type="text" name="description_3" class="form-control" placeholder="description" />
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="form-group">
				  <input type="text" name="label_4" class="form-control" placeholder="Button 4" />
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="form-group">
				  <input type="text" name="description_4" class="form-control" placeholder="description" />
				</div>
			  </div>
			</div>
			</div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-primary" name="send" value="Save changes">
		  </div>
		</div>
	  </div>
	</div>
</form>	
	
';

if($_POST['send']){
	$data = [
	   "welcome_message" => [
			 "name" => "simple_welcome-message 01", 
			 "message_data" => [
				"text" => $_POST['welcome_message'], 
				"quick_reply" => [
				   "type" => "options", 
				   "options" => [
					  [
						 "label" => $_POST['label_1'], 
						 "description" => $_POST['description_1'], 
						 "metadata" => "external_id_1" 
					  ], 
					  [
							"label" => $_POST['label_2'], 
							"description" => $_POST['description_2'], 
							"metadata" => "external_id_2" 
					  ], 
					  [
							   "label" => $_POST['label_3'], 
							   "description" => $_POST['description_3'], 
							   "metadata" => "external_id_3" 
					  ], 
					  [
								  "label" => $_POST['label_4'], 
								  "description" => $_POST['description_4'], 
								  "metadata" => "external_id_4" 
					  ] 
				   ] 
				] 
			 ] 
		  ] 
	];

        $list_rules = $connection->get('direct_messages/welcome_messages/rules/list'); // Returns a list of Welcome Message Rules.
		$id_delete_rules = $list_rules->welcome_message_rules[0]->id; // ID Welcome Message Rules 
		$delete = $connection->delete("direct_messages/welcome_messages/rules/destroy", ["id" => $id_delete_rules]); // Delete existing rules

        $set_message = $connection->post('direct_messages/welcome_messages/new', $data, true); // Set a new welcome message
        $message_id = $set_message->welcome_message->id; // The id for the new welcome message
				
        $add_roul = ["welcome_message_rule" => ["welcome_message_id" => "{$message_id}"]]; // Add a new id to the rule
        $set_roul = $connection->post('direct_messages/welcome_messages/rules/new', $add_roul, true); // set a new id for the rule
		
		echo '<div class="alert alert-success" role="alert">
<b>The welcome message and Buttons have been successfully added !</b>
</div><br>';
    }
}
}
else
{
    echo "login first";
}
?>
