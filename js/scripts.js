var latestTweetId = false;
var max_twits = 25;

function updateDates() {
    var tweetDates = $( '.tweetdate' );
    $.each( tweetDates, function( index, value ) {
		var timestamp = value.dataset.date;
		if ( index > max_twits - 1 ) {
			$( value ).addClass( 'old' );
			setTimeout( function() {
				$( value ).parent().remove();
			}, 500);
		}
		else {
			$.ajax( {
				method: 'POST',
				url: 'ajax_handler.php',
				data: { timestamp: timestamp,
						action: 'updateDate' }
			} )
			.done( function( response ) {
				value.textContent = response;
			} );
		}
	} );
}

function checkTweets( action = 'updateTweets' ) {
    var latestTweet = $( '.twitter-bubble' )[0];
    if ( latestTweet ) {
        latestTweetId = latestTweet.dataset.tweetId;
    }
    $.ajax( {
		method: 'POST',
		url: 'ajax_handler.php',
		data: { latestId: latestTweetId,
				action: action }  
	} )
	.done( function( html ) {
		setTimeout( function() {
			//checkTweets();
		}, 2500 );
		if ( html !== '' ) {
			$( '.twitter-widget' ).prepend( html );
			setTimeout( function() {
				$( '.twitter-bubble' ).removeClass( 'new' );
			}, 100 );
		}
	} );
}

window.onload = function() {
	checkTweets( 'loadTweets' );
}

setInterval( function() {
	updateDates();
}, 1000);
