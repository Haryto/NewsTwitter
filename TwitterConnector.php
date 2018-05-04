<?php

require_once 'vendor/autoload.php';
require_once 'Connector.php';
require_once 'Helpers.php';

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterConnector extends Connector {

    private $connection;

    private $verified;

    /**
     * Connect to Twitter API
     *
     * @param array $keys Credentials for OAuth
     * @return TwitterOAuth
     */
    protected function connect( $keys ) {

        $connection = new TwitterOAuth( $keys['consumerKey'], $keys['consumerSecret'], $keys['OAuthToken'], $keys['OAuthSecret'] );
        return $connection;
    }

    /**
     * Send request to Twitter API
     *
     * @param string $url Request url
     * @param array $options Request's options array
     * @return stdObject|string
     */
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

    /**
     * Verifying account to check permissions
     *
     * @return bool
     */
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

    /**
     * Wrapping API request into HTML
     *
     * @param stdObject $messages Messages to wrap
     * @param boolean $update Is it tweets' update or start tweets
     * @return string
     */
    protected function getHtml( $messages, $update ) {
        $html = '';
        $html .= Helpers::wrapTweets( $messages, $update );
        return $html;
    }

    /**
     * Get tweets from user, wrapped in HTML or not
     *
     * @param array $options Request's options array
     * @param boolean $html Is there HTML in return or stdObject
     * @param boolean $update Is it tweets' update or start tweets
     * @return string|strObject
     */
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

    /**
     * Class constructor, connects to Twitter API using credentials from params
     *
     * @param string $consumerKey
     * @param string $consumerSecret
     * @param string $OAuthToken
     * @param string $OAuthSecret
     */
    function __construct( $consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret ) {
        $this->connection = $this->connect(
             array( 'consumerKey' => $consumerKey,
                    'consumerSecret' => $consumerSecret, 
                    'OAuthToken' => $OAuthToken, 
                    'OAuthSecret' => $OAuthSecret ) 
        );
    }
}