/**
 *  Rotates tweets fetched with the Fetch Tweets plugin.
 *  
 *  @package          Fetch Tweets - Rotator Template
 *  @copyright        Copyright (c) 2014-2015, Michael Uno
 *  @authorurl        http://michaeluno.jp
 *  @license          http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *  
 */

;(function($){

    $( document ).ready( function(){ 
        
        if ( 'undefined' === typeof fetch_tweets_rotator_template ) {
            return;
        }
    
        $.each( fetch_tweets_rotator_template, function( sElementID, aArguments ) {      

            $( '#' + sElementID ).bxSlider( {
                mode: aArguments['transition_mode'],        // 'horizontal', 'vertical', 'fade'
                // captions: true,
                // ticker: false,
                // video: true,
                preloadImages: 'all',
                adaptiveHeight: true,
                speed: aArguments['speed'],     // the speed that each item is switched (the speed of fade)
                pause: aArguments['pause_duration'],    // the time duration that each item is displayed
                adaptiveHeightSpeed: aArguments['adaptiveHeightSpeed'],
                pager: false,
                auto: true,
                nextSelector: '#pronext',
                prevSelector: '#proprev',
                randomStart: aArguments['randomStart'] ? 'true' : 'false',
                autoHover: true,
                onSliderLoad: function ( oCurrentIndex ) {
                },                                               
                onSliderBefore: function ( oSlideElement, oOldIndex, oNewIndex ) {
                },                             
            });            
            

        }); // each()
        

    }); // ready()


})(jQuery);