<?php
/**
 *  Rotates tweets fetched with the Fetch Tweets plugin.
 *  
 *  @package          Fetch Tweets - Rotator Template
 *  @copyright        Copyright (c) 2014-2015, Michael Uno
 *  @authorurl        http://michaeluno.jp
 *  @license          http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *  
 */

if ( ! defined( 'FETCHTWEETS_ROTATOR_TEMPLETE_PATH' ) ) { 
    return; 
}

/**
 * Include classes
 */
$_sDirName = dirname( __FILE__ );
include( $_sDirName . '/class/FetchTweets_Template_Rotator_Base.php' );
include( $_sDirName . '/class/FetchTweets_Template_Rotator.php' );
include( $_sDirName . '/class/FetchTweets_Template_Rotator_Resource.php' );

/**
 * Load resources
 */
new FetchTweets_Template_Rotator_Resource;