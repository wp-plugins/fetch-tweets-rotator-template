<?php
/* 
	Plugin Name: Fetch Tweets - Rotator Template
	Plugin URI: http://en.michaeluno.jp/fetch-tweets
	Description: Rotates tweets of the Fetch Tweets plugin.
	Author: Michael Uno
	Author URI: http://michaeluno.jp
	Version: 1.0.0
	Requirements: PHP 5.2.4 or above, WordPress 3.3 or above.
	Text Domain: fetch-tweets-rotator-template
*/ 

define( 'FETCHTWEETS_ROTATOR_TEMPLETE_PATH', __FILE__ );

/**
 * Adds the template directory to the passed array.
 * 
 * @remark			use DIRECTORY_SEPARATOR instead of backslash to support various OSes.
 */
function FetchTweets_AddTemplateDirPath_Rotator( $aDirPaths ) {
	
	$aDirPaths[] = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'rotator';
	return $aDirPaths;
	
}
add_filter( 'fetch_tweets_filter_template_directories', 'FetchTweets_AddTemplateDirPath_Rotator' );