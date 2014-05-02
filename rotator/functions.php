<?php
/**
 * Proper way to enqueue scripts and styles
 */
function enqueueFetchTweetsRotatorTemplateAssets() {
	
	if ( ! defined( 'FETCHTWEETS_ROTATOR_TEMPLETE_PATH' ) ) return;
	wp_enqueue_script( 'fetch-tweets-rotator-template-bxslider', plugins_url( 'rotator/asset/bxslider/jquery.bxslider.min.js', FETCHTWEETS_ROTATOR_TEMPLETE_PATH ), array(), '', true );
	wp_enqueue_style( 'fetch-tweets-rotator-template-bxslider-style', plugins_url( 'rotator/asset/bxslider/jquery.bxslider.css', FETCHTWEETS_ROTATOR_TEMPLETE_PATH ) );

}
add_action( 'wp_enqueue_scripts', 'enqueueFetchTweetsRotatorTemplateAssets' );

/**
 * Include output handler classes.
 */
include_once( dirname( __FILE__ ) . '/class/FetchTweets_Template_Rotator_Base.php' );
include_once( dirname( __FILE__ ) . '/class/FetchTweets_Template_Rotator.php' );
