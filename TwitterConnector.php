<?php

require 'vendor/autoload.php';
require 'Connector.php';
require 'Helpers.php';

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterConnector extends Connector {

    private $connection;

    private $verified;

    protected function connect( $keys ) {

        $connection = new TwitterOAuth( $keys['consumerKey'], $keys['consumerSecret'], $keys['OAuthToken'], $keys['OAuthSecret'] );
        return $connection;
    }

    protected function sendRequest( $url, $options = array() ) {
        $response = '';
        try {
            $response = $this->connection->get( $url, $options );
        }
        catch( Abraham\TwitterOAuth\TwitterOAuthException $e ) {
            Helpers::logError( 'Выброшено исключение: ' .  $e->getMessage() . "\n" );
        }
        return $response;
    }

    protected function verify() {
        if ( !isset( $this->verified ) ) {
            $this->verified = $this->sendRequest( 'account/verify_credentials' );
            if ( !isset( $this->verified->errors ) )
                $this->verified = true;
            else {
                Helpers::logError( print_r( $this->verified, true ) );
                $this->verified = false;
            }
        }
        return $this->verified;
    }

    protected function getHtml( $response, $update ) {
        $html = '';
        $html .= '<div class="twitter-widget">';
        $html .= Helpers::wrapTweets( $response, $update );
        $html .= '</div>';
        return $html;
    }

    public function getMessages( $options = array(), $html = false, $update = false ) {
        $response = '';
        if ( $this->verify() ) {
            if ( empty( $options ) ) {
                //default options
                $options = array( 'screen_name' => 'AKulbii', 'count' => 25, 'trim_user' => false );
            }
            $response = $this->sendRequest( 'statuses/user_timeline', $options );   
        }
        if ( $response !== '' && $html )
            $response = $this->getHtml( $response, $update );
        return $response;
    }

    function __construct( $consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret ) {
        $this->connection = $this->connect(
             array( 'consumerKey' => $consumerKey,
                    'consumerSecret' => $consumerSecret, 
                    'OAuthToken' => $OAuthToken, 
                    'OAuthSecret' => $OAuthSecret ) 
        );
    }
}