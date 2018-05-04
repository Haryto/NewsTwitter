<?php

require 'config/config.php';
require 'TwitterConnector.php';

if ( isset( $_POST['latestId'] ) && is_numeric( $_POST['latestId'] ) && $_POST['action'] === 'updateTweets' ) {

	$latestId = $_POST['latestId'];

	$twitter = new TwitterConnector( CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET );

	$options = array( 'screen_name' => $userName, 'since_id' => $latestId, 'trim_user' => false );
	$html = $twitter->getMessages( $options, true, true );

	echo $html;
}
elseif ( isset( $_POST['timestamp'] ) && is_numeric( $_POST['timestamp'] ) && $_POST['action'] === 'updateDate' ) {
	echo Helpers::twitter_time( $_POST['timestamp'], true );
}