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

/**
 * An asset loader.
 * 
 */
class FetchTweets_Template_Rotator_Resource {
    
    /**
     * Stores output element arguments.
     * 
     * This data will be passed as an array to the script. The output class will store their settings in this array.
     * The JavaScript script will parse these settings and enables bxSlider.
     * 
     * @since       1.0.5
     */
    static public $aElementArguments = array();

    /**
     * Sets up hooks.
     */
    public function __construct() {
        
        // Registration
        add_action( 'wp_enqueue_scripts', array( $this, 'replyToRegisterRerouces' ) );
        
        // Slider Arguments
        add_action( 'wp_footer', array( $this, 'replyToProcessArguments' ) );
        
    }
    
    /**
     * Registers template scripts and styles
     */
    public function replyToRegisterRerouces() {
        
        // Scripts
        $_sMin = defined( 'WP_DEBUG' ) && WP_DEBUG ? '.min' : '';
        wp_register_script( 
            'fetch-tweets-rotator-template-bxslider',   // handle
            FetchTweets_Template_Rotator_Registry::getPluginURL( 
                "rotator/asset/bxslider/jquery.bxslider{$_sMin}.js", FETCHTWEETS_ROTATOR_TEMPLETE_PATH 
            ),   // src
            array( 'jquery' ),
            FetchTweets_Template_Rotator_Registry::Version,
            true    // in footer
        );
        wp_register_script( 
            'fetch-tweets-rotator-template-slider-enabler',   // handle
            FetchTweets_Template_Rotator_Registry::getPluginURL( 
                'rotator/asset/js/fetch-tweets-rotator-template-slider-enabler.js' 
            ),   // src
            array( 'fetch-tweets-rotator-template-bxslider' ),
            FetchTweets_Template_Rotator_Registry::Version,
            true    // in footer
        );
        wp_enqueue_script( 'fetch-tweets-rotator-template-bxslider' );
        wp_enqueue_script( 'fetch-tweets-rotator-template-slider-enabler' );        
                
        // Styles - registration and enqueue
        wp_register_style( 
            'fetch-tweets-rotator-template-bxslider-style', 
            FetchTweets_Template_Rotator_Registry::getPluginURL( 'rotator/asset/bxslider/jquery.bxslider.css' )
        );
        wp_enqueue_style( 'fetch-tweets-rotator-template-bxslider-style' );
        
    }

    /**
     * Explicitly add scripts in the footer.
     */
    public function replyToProcessArguments() {
        
        if ( ! class_exists( 'FetchTweets_Template_Rotator' ) ) {
            return;
        }
        if ( ! FetchTweets_Template_Rotator::$bOutput ) {
            return;
        }

        wp_localize_script( 
            'fetch-tweets-rotator-template-slider-enabler',   // handle
            'fetch_tweets_rotator_template',    // object name
            self::$aElementArguments    // data
        );
        
    }

}