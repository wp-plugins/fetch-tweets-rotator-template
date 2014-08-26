<?php
/**
 * Handles outputs of the Rotate template of Fetch Tweets.
 * 
 */
if ( ! class_exists( 'FetchTweets_Template_Rotator' ) ) :
class FetchTweets_Template_Rotator extends FetchTweets_Template_Rotator_Base {

	/**
	 * Returns the output of tweets.
	 */
	public function getOutput( array $aTweets ) {
		
		$_aArgs                 = $this->_aArgs;
		$_aAttributes_Wrapper   = array(
			'class'	=>	$this->_sBaseClassSelector . '_wrapper',
			'style'	=>	$this->_generateStyleAttribute(
				array(
					'max-width'			=>	$this->_getSize( $_aArgs['max_width'] ),
					'max-height'		=>	$this->_getSize( $_aArgs['max_height'] ),
					'background-color'	=>	$_aArgs['background_color'],
					'font-size'			=>	$this->_getSize( $_aArgs['font_size'] ),
					'margin'			=>	$this->_getTRBL( $_aArgs['margins'][ 0 ], $_aArgs['margins'][ 1 ], $_aArgs['margins'][ 2 ], $_aArgs['margins'][ 3 ] ),					
				)
			),
		);

		$_aAttributes = array(
			'class'	=>	$this->_sBaseClassSelector, 
			'id'	=>	$this->_sIDAttribute,
		);
		
		add_action( 'wp_footer', array( $this, '_replyToInsertScript' ) );
		return "<div " . $this->_generateAttributes( $_aAttributes_Wrapper ) . "/>" . PHP_EOL
				. "<div " . $this->_generateAttributes( $_aAttributes ) . "/>" . PHP_EOL
					. $this->_getTweets( $aTweets, $_aArgs ). PHP_EOL
				. "</div>" . PHP_EOL
			. "</div>" . PHP_EOL;
		
	}
				
		private function _getTweets( array $aTweets, array $aArgs ) {
			
			$_aOutput = array();
			foreach( $aTweets as $_aTweet ) {
				
				if ( ! isset( $_aTweet['user'] ) ) { continue; }
				
				// Check if it's a retweet.
				$_fIsRetweet = isset( $_aTweet['retweeted_status']['text'] );
				if ( $_fIsRetweet && ! $aArgs['include_rts'] ) continue;	// if disabled skip.
				
				$_aTweet = $_fIsRetweet ? $_aTweet['retweeted_status'] : $_aTweet;
				
				// Insert a tweet into the output array.
				$_aOutput[] = $this->_getTweet( $_aTweet, $aArgs, $_fIsRetweet );
				
			}
			
			// Shuffle
			if ( $aArgs['randomStart'] ) {
				shuffle( $_aOutput );
			}
			
			// Items per slide
			$_iCountTweets  = count( $_aOutput );	// how many tweets 
			$_iDivisions    = ceil( $_iCountTweets / $aArgs['items_per_slide'] );	// how many divided sections are necessary
			$_aDividedTweets = array();
			for ( $i = 1; $i <= $_iDivisions; $i++ ) {
						
				$_aAttributes = array(
					'class'	=>	$this->_sBaseClassSelector . '-items',
					'style'	=>	$this->_generateStyleAttribute(
						array(
							'display'   =>	1 === $i ? 'block' : 'none',
                            'padding'   =>	'0',
                            // 'width'     =>  '100%',
						)
					),
				);
				$_aDividedTweets[] = "<div " . $this->_generateAttributes( $_aAttributes ) . ">" . PHP_EOL
						. $this->_getTweetsByNumberOfItems( $_aOutput, $aArgs['items_per_slide'] ) . PHP_EOL
					. "</div>";
			}
			
			return implode( PHP_EOL, $_aDividedTweets );
			
		}
			
			/**
			 * Returns a set of tweet outputs by the given number.
			 */
			private function _getTweetsByNumberOfItems( & $aTweets, $iItems ) {

				$_aOutput = array();
				for( $i=1; $i <= $iItems; $i++ ) {
					$_aOutput[] = array_shift( $aTweets );
				}
				return implode( PHP_EOL, $_aOutput );
				
			}
			
			/**
			 * Returns an individual tweet output.
			 */
			private function _getTweet( array $aTweet, array $aArgs, $fIsRetweet ) {
				
				$_sRetweetClassSelector = $fIsRetweet ? " {$this->_sBaseClassSelector}-retweet" : '';				
				$_aAttributes = array(
					'class'	=>	$this->_sBaseClassSelector . "-item" . $_sRetweetClassSelector,
					'style'	=>	$this->_generateStyleAttribute(	
                        array( 
                            // this padding will be removed and set to the parent wrapper container of the bxSlider script
                            'padding'   =>	$this->_getTRBL( $aArgs['paddings'][ 0 ], $aArgs['paddings'][ 1 ], $aArgs['paddings'][ 2 ], $aArgs['paddings'][ 3 ] ),
                        )
					),
				);
				return "<div " . $this->_generateAttributes( $_aAttributes ) . " />" . PHP_EOL
						. $this->_getTweetContent( $aTweet, $aArgs, $fIsRetweet ) . PHP_EOL
					. "</div>" . PHP_EOL;
				
			}
			
	
			private function _getTweetContent( array $aTweet, array $aArgs, $fIsRetweet ) {
				
				$_aOutput = array();		
				// $_aOutput[] = $this->_getAvatar( $aTweet, $aArgs );
				$_aOutput[] = $this->_getMain( $aTweet, $aArgs, $fIsRetweet );
				return implode( PHP_EOL, $_aOutput );
				
			}
			
			
			private function _getAvatar( array $aTweet, array $aArgs ) {
				
				if ( ! $aArgs['visibilities']['avatar'] ) { return ''; }
				if ( $aArgs['avatar_size'] <= 0 ) { return ''; }
				
				
				$_iMarginForImageContainer          = round( ( int ) $aArgs['avatar_size'] / 120 , 3 );
				$_iMarginForImageContainer_Bottom   = round( $_iMarginForImageContainer / 3 , 2 );
				$_aAttributes = array(
					'class'	=>	$this->_sBaseClassSelector . '-profile-image',
					'style'	=>	$this->_generateStyleAttribute(	
						array(
							"max-width"		=>	$aArgs['avatar_size'] . 'px',
							"max-height"	=>	$aArgs['avatar_size'] . 'px',
							"float"			=> 	$aArgs['avatar_position'],
							"clear"			=>	$aArgs['avatar_position'],
							"margin"		=>	$aArgs['visibilities']['avatar'] 
								? $this->_getTRBL( 
									array( 'size' => '0.2', 'unit' => 'em' ), // top
									array( 'size' => 'left' === $aArgs['avatar_position'] ? $_iMarginForImageContainer : 0, 'unit' => 'em' ),  	// right
									array( 'size' => $_iMarginForImageContainer_Bottom, 'unit' => 'em' ),	// bottom	
									array( 'size' => 'left' === $aArgs['avatar_position'] ? 0 : $_iMarginForImageContainer, 'unit' => 'em' )		// left
								)
								// ? ( $aArgs['avatar_position'] == 'left' ? "margin-right: " : "margin-left: " ) . $_iMarginForImageContainer . ' margin-bottom: ' . $_iMarginForImageContainer
								: '',
						)
					),				
				);

                $_sIMGURLDefault = getTwitterProfileImageURLBySize( $this->_fIsSSL ? $aTweet['user']['profile_image_url_https'] : $aTweet['user']['profile_image_url'], 100 );  
                $_sIMGURL        = getTwitterProfileImageURLBySize( $this->_fIsSSL ? $aTweet['user']['profile_image_url_https'] : $aTweet['user']['profile_image_url'], $aArgs['avatar_size'] );        
				$_aIMGAttributes = array(
                    'class'     =>  'avatar-' . $aTweet['user']['screen_name'],
                    'src'       =>  esc_url( $_sIMGURL ),
                    // Some avatars don't have the sized images and if the image does not load, the rotator script fails to load.
                    // So load the default avarar regardless of the size.
					'style'	=>	$this->_generateStyleAttribute(	
						array(
							'max-width'         => $aArgs['avatar_size'] . 'px',
							'border-radius'     => '5px',                     
						)
					),
                    'onerror'   =>  'this.onerror=null;this.src="' . esc_url( $_sIMGURLDefault ) . '";',    // substitute
				);
				return "<div " . $this->_generateAttributes( $_aAttributes ) . ">" . PHP_EOL
						. "<a target='_blank' href='" . esc_url( "https://twitter.com/{$aTweet['user']['screen_name']}", 'https' ) . "'>" . PHP_EOL
							. "<img " . $this->_generateAttributes( $_aIMGAttributes ) . "/>" . PHP_EOL
						. "</a>" . PHP_EOL
					. "</div>" . PHP_EOL
                ; 

			}			
		
			private function _getMain( array $aTweet, array $aArgs, $fIsRetweet ) {
				
				$_aInlineStyle = array();
				if ( $aArgs['visibilities']['avatar'] && $aArgs['avatar_size'] > 0 ) {
					// $_aInlineStyle[ 'margin-' . $aArgs['avatar_position'] ] = $aArgs['avatar_size'] . "px" ;					
					
				}
				
				return "<div " . $this->_generateAttributes(
						array(
							'class'	=>	$this->_sBaseClassSelector . '-main',
							'style'	=>	$this->_generateStyleAttribute( $_aInlineStyle ),
						)
					) . ">" . PHP_EOL
						. $this->_getAvatar( $aTweet, $aArgs ) . PHP_EOL
						. $this->_getHeading( $aTweet, $aArgs ) . PHP_EOL
						. $this->_getBody( $aTweet, $aArgs, $fIsRetweet ) . PHP_EOL
					. "</div>" . PHP_EOL;
				
			}
			
			private function _getHeading( array $aTweet, array $aArgs ) {
				
				return "<div class='{$this->_sBaseClassSelector}-heading'>"	. PHP_EOL
						. $this->_getUserName( $aTweet, $aArgs ) . PHP_EOL
						. $this->_getTime( $aTweet, $aArgs ) . PHP_EOL
					. "</div>" . PHP_EOL;
					
			}
				private function _getUserName( $aTweet, $aArgs ) {
		
					if ( ! $aArgs['visibilities']['user_name'] ) return '';
					
					return "<span class='{$this->_sBaseClassSelector}-user-name'>" . PHP_EOL
							. "<strong>" . PHP_EOL
								. "<a target='_blank' href='" . esc_url( "https://twitter.com/{$aTweet['user']['screen_name']}" ) . "'>" . PHP_EOL
									. $aTweet['user']['name'] . PHP_EOL
								. "</a>" . PHP_EOL
							. "</strong>" . PHP_EOL
						. "</span>" . PHP_EOL;
							
				}
				private function _getTime( $aTweet, $aArgs ) {
					
					if ( ! $aArgs['visibilities']['time'] ) return '';
					return "<span class='{$this->_sBaseClassSelector}-tweet-created-at'>"	
							. "<a " . $this->_generateAttributes(
								array(
									'target'    => '_blank',
									'href'      => esc_url( 'https://twitter.com/' . $aTweet['user']['screen_name'] . '/status/' . $aTweet['id_str'] ),
								)
							) . ">"
								. human_time_diff( $aTweet['created_at'], current_time('timestamp') - $this->_sGMTOffset ) . ' ' . __( 'ago', 'fetch-tweets' )
							. "</a>"
						. "</span>";
					
					
				}				
			private function _getBody( array $aTweet, array $aArgs, $fIsRetweet ) {
				
				return "<div class='{$this->_sBaseClassSelector}-body'>" . PHP_EOL
						. $this->_getText( $aTweet, $aArgs, $fIsRetweet ) . PHP_EOL
						. $this->_getIntentButtons( $aTweet, $aArgs ) . PHP_EOL
					. "</div>" . PHP_EOL;
		
			}
			private function _getText( array $aTweet, array $aArgs, $fIsRetweet ) {
				
				return "<p class='{$this->_sBaseClassSelector}-text'>" . PHP_EOL
						. trim( $aTweet['text'] ) . PHP_EOL
						. $this->_getRetweetInfo( $aTweet, $aArgs, $fIsRetweet ) . PHP_EOL
					. "</p>" . PHP_EOL;
		
			}
				private function _getRetweetInfo( array $aTweet, array $aArgs, $fIsRetweet ) {
					
					if ( ! $fIsRetweet ) return '';
					
					return "<span class='{$this->_sBaseClassSelector}-retweet-credit'>" . PHP_EOL
							. __( 'Retweeted by', 'fetch-tweets' ) . PHP_EOL
							. "<a target='_blank' href='" . esc_url( "https://twitter.com/{$_aDetail['user']['screen_name']}" ) . "'>" . PHP_EOL
								. $_aDetail['user']['name'] . PHP_EOL
							. "</a>" . PHP_EOL
						. "</span>" . PHP_EOL;
					
				}
			private function _getIntentButtons( array $aTweet, array $aArgs ) {
				
				if ( ! $aArgs['visibilities']['intent_buttons'] ) return '';
				$_aOutput= array();
				if ( $aArgs['intent_script'] ) {
					$_aOutput[] = '<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>';
				}
				foreach( array( 'reply', 'retweet', 'favorite' ) as $__sIntent ) {
					$_aOutput[] = $this->_getIntentButton( $__sIntent, $aTweet, $aArgs );				
				}
				return "<ul class='{$this->_sBaseClassSelector}-intent-buttons'>"
						. implode( PHP_EOL, $_aOutput )
					. "</ul>";
	
			}
			
			private function _getIntentButton( $sIntent, array $aTweet, array $aArgs ) {
				
				$_sOutput = '';
				if ( $aArgs['intent_buttons'] == 1 || $aArgs['intent_buttons'] == 2 ) {
					$_sOutput = "<span class='{$this->_sBaseClassSelector}-intent-icon' style='background-image: url(" . FetchTweets_Commons::getPluginURL( "asset/image/{$sIntent}_48x16.png" ) . ");' ></span>";
				}
				if ( $aArgs['intent_buttons'] == 1 || $aArgs['intent_buttons'] == 3 ) {
					$_sOutput = "<span class='{$this->_sBaseClassSelector}-intent-buttons-text'>" . __( ucfirst( $sIntent ), 'fetch-tweets' ) . "</span>";
				}
				switch ( $sIntent ) {
					default:
					case 'reply' :
						$_sActionURL = "https://twitter.com/intent/tweet?in_reply_to={$aTweet['id_str']}";
					break;
					case 'retweet' :
						$_sActionURL = "https://twitter.com/intent/retweet?tweet_id={$aTweet['id_str']}";
					break;
					case 'favorite' :
						$_sActionURL = "https://twitter.com/intent/favorite?tweet_id={$aTweet['id_str']}";
					break;					
				}
				return "<li class='{$this->_sBaseClassSelector}-intent-{$sIntent}'>"
					. "<a href='" . esc_url( $_sActionURL ) . "' ref='nofollow' target='_blank' title='" . esc_attr( __( ucfirst( $sIntent ), 'fetch-tweets' ) ) . "'>"
						. $_sOutput 
					. "</a>"
				. "</li>";
				
			}
	public function _replyToInsertScript() {
		echo $this->_getScript( $this->_sIDAttribute, $this->_aArgs ) . PHP_EOL;
	}
	private function _getScript( $sIDAttribute, $aArgs ) {

		return "
			<script type='text/javascript'>		
				jQuery( document ).ready( function(){ 

					jQuery( '#{$sIDAttribute}' ).bxSlider( {
						mode: '{$aArgs['transition_mode']}',		// 'horizontal', 'vertical', 'fade'
						// captions: true,
						// ticker: false,
						// video: true,
						preloadImages: 'all',
						adaptiveHeight: true,
						speed: {$aArgs['speed']}, 	// the speed that each item is switched (the speed of fade)
						pause: {$aArgs['pause_duration']},	// the time duration that each item is displayed
						adaptiveHeightSpeed: {$aArgs['adaptiveHeightSpeed']},
						pager: false,
						auto: true,
						nextSelector: '#pronext',
						prevSelector: '#proprev',
						randomStart: " . ( $aArgs['randomStart'] ? 'true' : 'false' ) . ",
  						autoHover: true,
                        onSliderLoad: function ( oCurrentIndex ) {
                        },                                               
                        onSliderBefore: function ( oSlideElement, oOldIndex, oNewIndex ) {
                        },                             
					});
				});
			</script>"; 
	}
	
}
endif;