<?php
if ( ! class_exists( 'FetchTweets_Template_Settings' ) ) { return; }
$_sDirName = dirname( __FILE__ );
include( $_sDirName . '/class/FetchTweets_Template_Settings_Rotator.php' );
new FetchTweets_Template_Settings_Rotator( $_sDirName );    