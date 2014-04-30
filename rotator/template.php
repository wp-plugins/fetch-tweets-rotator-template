<?php

/*
 * Available variables passed from the caller script
 * - $aTweets : the fetched tweet arrays.
 * - $aArgs	: the passed arguments such as item count etc.'
 * - $aOptions : the plugin options saved in the database.
 * */
 
$oRotator = new FetchTweets_Template_Rotator( $aArgs, isset( $aOptions['template_rotator'] ) ? $aOptions['template_rotator'] : array() );
echo $oRotator->getOutput( $aTweets );
