<?php
/* 
	Plugin Name:    Fetch Tweets - Rotator Template
	Plugin URI:     http://en.michaeluno.jp/fetch-tweets
	Description:    Rotates tweets of the Fetch Tweets plugin.
	Author:         Michael Uno
	Author URI:     http://michaeluno.jp
	Version:        1.0.4
	Requirements:   PHP 5.2.4 or above, WordPress 3.3 or above.
	Text Domain:    fetch-tweets-rotator-template
*/ 

define( 'FETCHTWEETS_ROTATOR_TEMPLETE_PATH', __FILE__ );

/**
 * Adds the template directory to the passed array.
 * 
 * @remark  use DIRECTORY_SEPARATOR instead of forward slash.
 */
function FetchTweets_AddTemplateDirPath_Rotator( $aDirPaths ) {
	
	$aDirPaths[] = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'rotator';
	return $aDirPaths;
	
}
add_filter( 'fetch_tweets_filter_template_directories', 'FetchTweets_AddTemplateDirPath_Rotator' );

/**
 * Make sure to deactivate the template 
 * @deprecated
 */
function FetchTweets_RotatorTemplate_Deactivation() {
    
	unset( $GLOBALS['oFetchTweets_Option']->aOptions['arrTemplates'][ $strDirSlug ] );	// the option array only stores active templates.
	$GLOBALS['oFetchTweets_Option']->saveOptions();	
	
}
// register_deactivation_hook( __FILE__, 'FetchTweets_RotatorTemplate_Deactivation' );