<?php

require 'TwitterConnector.php';

use Dotenv\Dotenv;

$configs = new Dotenv( __DIR__ . '/config', 'config.env' );
$configs->load();
$credentials = new Dotenv( __DIR__ . '/config', 'credentials.env' );
$credentials->load();

$userName = getenv( 'tweet_userName' );
$countTweets = getenv( 'countTweets' );

switch( $_POST['action'] ) {

	//Case of getting new tweets
	case 'updateTweets':
		if ( isset( $_POST['latestId'] ) && is_numeric( $_POST['latestId'] ) ) {
			$latestId = $_POST['latestId'];

			$twitter = new TwitterConnector( getenv( 'CONSUMER_KEY' ), getenv( 'CONSUMER_SECRET' ), getenv( 'OAUTH_TOKEN' ), getenv( 'OAUTH_SECRET' ) );

			$options = array( 'screen_name' => $userName, 'since_id' => $latestId, 'trim_user' => false );
			$html = $twitter->getMessages( $options, true, true );

			echo $html;
		}
		break;
	//Case of loading start tweets
	case 'loadTweets':
		$twitter = new TwitterConnector( getenv( 'CONSUMER_KEY' ), getenv( 'CONSUMER_SECRET' ), getenv( 'OAUTH_TOKEN' ), getenv( 'OAUTH_SECRET' ) );

		$html = "Current user - <span id='username'>$userName</span><br/>
				Current amount of tweets - <span id='countTweets'>$countTweets</span>";

		$options = array( 'screen_name' => $userName, 'count' => $countTweets, 'trim_user' => false );
		$html .= $twitter->getMessages( $options, true );

		echo $html;
		break;
	//Case of updating dates of tweets
	case 'updateDate':
		if ( isset( $_POST['timestamp'] ) && is_numeric( $_POST['timestamp'] ) ) {
			echo Helpers::twitter_time( $_POST['timestamp'], true );
		}
		break;
	default:
		Helpers::logError( 'Unknown POST action' );

}
