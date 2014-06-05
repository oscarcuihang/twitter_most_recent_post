<!DOCTYPE html>
<html>
<head>
	<title>T</title>
</head>

<body>
	<form method="POST" action="/~hcfxd/test/index.php">
		<div>
			Enter Twitter Handle: http://twitter.com/<input type="text" name="twitter_handle" value=""/> <br /><br />
			<input type="submit" name="submit" value="Submit" />
		</div>
	</form>
</body>



<?php
if(isset($_POST['submit']))
{
	$input_name = htmlspecialchars($_POST['twitter_handle']);
	ini_set('display_errors', 1);
	require_once('API.php');
	include("oauth_data.php");
	//for OAuth
	$settings = array(
		'oauth_access_token' => OTA,
		'oauth_access_token_secret' => OATS,
		'consumer_key' => CK,
		'consumer_secret' => CS
	);

	$url ='https://api.twitter.com/1.1/statuses/user_timeline.json';
	$parameter = '?screen_name='.$input_name.'&count=1';
	$twitter = new API($settings);
	$t_data = $twitter -> setparameter($parameter) -> buildOauth($url, "GET") -> performRequest();
	
	//echo $t_data;
	$tweet_data = json_decode($t_data, true);
	//print_r ($tweet_data);
	if ($tweet_data != NULL)
	{
	foreach ($tweet_data as $data)
	{
	
		//print_r ($data); 
		echo "</br>The most recent tweet for ".$input_name;
		?>
		</br> Time:  <?php echo $data["created_at"]; ?>
		</br> Post:  <?php echo$data["text"]; ?>
		</br> From:  <?php echo $data["source"]; ?>
		
		<?php	
	}
	}
	else 
	{ 
		echo "Can't find user".$input_name.". Check your input User Handle.";
	}
	//echo $tweet_data["text"];
	//var_dump($t_data);
	
}		 
?>

</html>