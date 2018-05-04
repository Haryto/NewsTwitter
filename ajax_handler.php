<?php

require 'connection.php';

if ( isset( $_POST['latestId'] ) && is_numeric( $_POST['latestId'] ) && $_POST['action'] === 'updateTweets' ) {

	$latestId = $_POST['latestId'];

	try {
		$last_tweets = $connection->get( 'statuses/user_timeline', array( 'screen_name' => $user_name, 'since_id' => $latestId, 'trim_user' => false ) );
		if ( !isset( $last_tweets->errors ) ) 	
			echo wrapTweets( $last_tweets, true );
		else {
			logError( print_r( $last_tweets, true ) );
		}
	}
	catch( Abraham\TwitterOAuth\TwitterOAuthException $e ) {
		logError( 'Выброшено исключение: ' .  $e->getMessage() . "\n" );
	}
}
elseif ( isset( $_POST['timestamp'] ) && is_numeric( $_POST['timestamp'] ) && $_POST['action'] === 'updateDate' ) {
	echo twitter_time( $_POST['timestamp'], true );
}