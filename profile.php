<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<center>
<div class="container">
<div class="row">
<h1>Twitter Profile</h1>
<p>Simply use the welcome message and Buttons</p>
<p><b>Created by <a href="https://twitter.com/@0xHunter">@0xHunter</b></a></p>
<!-- code start -->


<div class="twPc-div">
    <a class="twPc-bg twPc-block"></a>
	<div>
	
		<a href="https://twitter.com/<?php echo $user->screen_name; ?>" class="twPc-avatarLink">
			<img src="<?php echo $user->profile_image_url_https; ?>" class="twPc-avatarImg">
		</a>

		<div class="twPc-divUser">
			<div class="twPc-divName">
				<a href="https://twitter.com/<?php echo $user->screen_name; ?>"><?php echo $user->name; ?></a>
			</div>
			<span>
				<a href="https://twitter.com/<?php echo $user->screen_name; ?>">@<span><?php echo $user->screen_name; ?></span></a>
			</span>
		</div>

		<div class="twPc-divStats">
			<ul class="twPc-Arrange">
				<li class="twPc-ArrangeSizeFit">
					<a href="https://twitter.com/<?php echo $user->screen_name; ?>" title="9.840 Tweet">
						<span class="twPc-StatLabel twPc-block">Tweets</span>
						<span class="twPc-StatValue"><?php echo $user->statuses_count; ?></span>
					</a>
				</li>
				<li class="twPc-ArrangeSizeFit">
					<a href="https://twitter.com/<?php echo $user->screen_name; ?>/following">
						<span class="twPc-StatLabel twPc-block">Following</span>
						<span class="twPc-StatValue"><?php echo $user->friends_count; ?></span>
					</a>
				</li>
				<li class="twPc-ArrangeSizeFit">
					<a href="https://twitter.com/<?php echo $user->screen_name; ?>/followers">
						<span class="twPc-StatLabel twPc-block">Followers</span>
						<span class="twPc-StatValue"><?php echo $user->followers_count; ?></span>
					</a>
				</li>
			</ul>
		</div>
<?php include("send.php"); ?> 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add new message</button>   
<a href="logout.php" type="button" class="btn btn-primary">Logout</a> 
<script>
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>
</div>
</div>
</center>
<style>
.container {
  margin: auto;
  width: 25%;
  height: 55%;
  border: 3px solid green;
}

.twPc-div {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #e1e8ed;
    border-radius: 6px;
    height: 200px;
    max-width: 340px; // orginal twitter width: 290px;
}
.twPc-bg {
    background-image: url("https://wallpaperaccess.com/full/1397755.jpg");
    background-position: 0 50%;
    background-size: 100% auto;
    border-bottom: 1px solid #e1e8ed;
    border-radius: 4px 4px 0 0;
    height: 95px;
    width: 100%;
}
.twPc-block {
    display: block !important;
}
.twPc-button {
    margin: -35px -10px 0;
    text-align: right;
    width: 100%;
}
.twPc-avatarLink {
    background-color: #fff;
    border-radius: 6px;
    display: inline-block !important;
    float: left;
    margin: -30px 5px 0 8px;
    max-width: 100%;
    padding: 1px;
    vertical-align: bottom;
}
.twPc-avatarImg {
    border: 2px solid #fff;
    border-radius: 7px;
    box-sizing: border-box;
    color: #fff;
    height: 72px;
    width: 72px;
}
.twPc-divUser {
    margin: 5px 0 0;
}
.twPc-divName {
    font-size: 18px;
    font-weight: 700;
    line-height: 21px;
}
.twPc-divName a {
    color: inherit !important;
}
.twPc-divStats {
    margin-left: 11px;
    padding: 10px 0;
}
.twPc-Arrange {
    box-sizing: border-box;
    display: table;
    margin: 0;
    min-width: 100%;
    padding: 0;
    table-layout: auto;
}
ul.twPc-Arrange {
    list-style: outside none none;
    margin: 0;
    padding: 0;
}
.twPc-ArrangeSizeFit {
    display: table-cell;
    padding: 0;
    vertical-align: top;
}
.twPc-ArrangeSizeFit a:hover {
    text-decoration: none;
}
.twPc-StatValue {
    display: block;
    font-size: 18px;
    font-weight: 500;
    transition: color 0.15s ease-in-out 0s;
}
.twPc-StatLabel {
    color: #8899a6;
    font-size: 10px;
    letter-spacing: 0.02em;
    overflow: hidden;
    text-transform: uppercase;
    transition: color 0.15s ease-in-out 0s;
}
</style>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://ssl.uh.edu/js/jquery.js"></script>
<script src="https://ssl.uh.edu/js/bootstrap.js"></script>