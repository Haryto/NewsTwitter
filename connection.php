<?php

include 'helpers.php';

define( 'CONSUMER_KEY', 'oUb0QpOVL42iY8HziGNCAZhnG' );
define( 'CONSUMER_SECRET', 'cbjcWDsMlkzX07PoIf8wEbgJBiUNgO073xtnCbGtrnLPeGqwvi' );
define( 'OAUTH_TOKEN', '991697977956847616-1EWKim71EImkV3NTbq7uGiTSV3REOyI' );
define( 'OAUTH_SECRET', 'gFfyGMUIT7z0wsgGsclfYMWIFYkVa7GNG6LGnHRdAHxk7' );

$user_name = 'AKulbii';
//$user_name = 'BarackObama';
$count_twits = 25;

require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET );