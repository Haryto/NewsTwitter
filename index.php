<style>
.twitter-widget {
	/*height: 600px;
	overflow: auto;
	width: 300px;
    margin-left: auto;
    margin-right: auto;*/
}
.bubble-wrap {
	opacity: 1;
	transition: all .5s;
}
.bubble-wrap.old {
	opacity: 0;
}
.twitter-bubble {
	position: relative;
	width: 200px;
	padding: 19px;
	background: #96DDFF;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	color: #474747;
	display: inline-block;
	transition: all 1s;
	max-height: initial;
	overflow: initial;
}

.twitter-bubble.new {
	padding: 0;
	max-height: 0;
	overflow: hidden;
}

.twitter-bubble:after 
{
	content: '';
	position: absolute;
	border-style: solid;
	border-width: 15px 11px 0;
	border-color: #96DDFF transparent;
	display: block;
	width: 0;
	z-index: 1;
	bottom: -15px;
	left: 111px;
}
</style>

<?php

require 'connection.php';

try {
	$verified = $connection->get( 'account/verify_credentials' );
	if ( !isset( $verified->errors ) ) {

		$last_tweets = $connection->get( 'statuses/user_timeline', array( 'screen_name' => $user_name, 'count' => $count_twits, 'trim_user' => false ) );
		
		echo '<div class="twitter-widget">';

		echo wrapTweets( $last_tweets );

		echo '</div>';
	}
	else {
		logError( print_r( $verified, true ) );
	}
}
catch( Abraham\TwitterOAuth\TwitterOAuthException $e ) {
	logError( 'Выброшено исключение: ' .  $e->getMessage() . "\n" );
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/scripts.js"></script>