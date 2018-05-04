<?php


abstract class Connector {

    private $connection;

    abstract protected function connect( $keys );

    abstract protected function verify();
    
    abstract protected function sendRequest( $url, $options );

    abstract protected function getHtml( $response, $update );

    abstract public function getMessages( $options, $html, $update );
}