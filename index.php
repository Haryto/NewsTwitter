<html>
<head>
	<link href="css/styles.css" rel="stylesheet">
</head>

<body>

<?php

require 'config/config.php';
require 'TwitterConnector.php';

$twitter = new TwitterConnector( CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET );

$options = array( 'screen_name' => $userName, 'count' => $countTwits, 'trim_user' => false );
$html = $twitter->getMessages( $options, true );

echo $html;

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/scripts.js"></script>

</body>

</html>