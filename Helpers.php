<?php

class Helpers {

    /**
     * Wrap tweets in HTML
     *
     * @param stdObject $last_tweets Tweets to wrap
     * @param boolean $isNew Is it new tweet or start one
     * @return string
     */
    public static function wrapTweets( $last_tweets, $isNew = false ) {
        $html = '';
        foreach( $last_tweets as $tweet ) {
            $html .= '<div class="bubble-wrap">'; 
            $html .= '<div data-tweet-id="' . $tweet->id . '" class="twitter-bubble' . ($isNew ? ' new' : '') . '">';
            if( isset( $last_tweets->errors ) ) {           
                $html .= 'Error :' . $last_tweets->errors[0]->code . ' - ' . $last_tweets->errors[0]->message;
            }
            else {
                $html .= Helpers::makeClickableLinks( $tweet->text );
            }
            $html .= '</div>';
            $date = $tweet->created_at;
            $html .= '<p data-date="' . strtotime( $date ) . '" class="tweetdate">' . Helpers::twitter_time( $date ) . '</p>';
            
            $html .= '</div>';
        }
        return $html;
    }
    //function to convert text url into links.
    public static function makeClickableLinks( $s ) {
    return preg_replace( '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a target="blank" rel="nofollow" href="$1" target="_blank">$1</a>', $s );
    }

    /**
     * Represents time in how it twitter does
     *
     * @param string $a Tweet's publish time
     * @param boolean $update Is it update of old date or date of new tweet
     * @return string
     */
    public static function twitter_time( $a, $update = false ) {
        //get current timestampt
        $b = strtotime( "now", time() + 20 ); 
        //get timestamp when tweet created 
        if ( !$update )
            $c = strtotime( $a );
        else
            $c = $a;
        //get difference
        $d = $b - $c;
        //calculate different time values
        $minute = 60;
        $hour = $minute * 60;
        $day = $hour * 24;
        $week = $day * 7;
            
        if( is_numeric( $d ) && ( $d >= 0 || $d >= -300 ) ) {
            //if less then 3 seconds
            if( $d < 3 ) 
                return "right now";
            //if less then minute
            if( $d < $minute ) 
                return floor( $d ) . " seconds ago";
            //if less then 2 minutes
            if( $d < $minute * 2 )
                return "about 1 minute ago";
            //if less then hour
            if( $d < $hour ) 
                return floor( $d / $minute ) . " minutes ago";
            //if less then 2 hours
            if( $d < $hour * 2 ) 
                return "about 1 hour ago";
            //if less then day
            if( $d < $day ) 
                return floor( $d / $hour ) . " hours ago";
            //if more then day, but less then 2 days
            if( $d > $day && $d < $day * 2 ) 
                return "yesterday";
            //if less then year
            if( $d < $day * 365 ) 
                return floor( $d / $day ) . " days ago";
            //else return more than a year
            return "over a year ago";
        }
    }

    /**
     * Write error in log file
     *
     * @param string $message
     * @return void
     */
    public static function logError( $message ) {
        file_put_contents( 'log_error.txt', date('H:i:s  -  ') . $message, FILE_APPEND);
    }

}