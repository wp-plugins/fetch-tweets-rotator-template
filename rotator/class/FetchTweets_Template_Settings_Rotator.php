<?php
/**
 * Adds a setting tab in the Fetch Tweets admin pages. 
 * 
 * If you are modifying the template to create your own, modify this extended class.
 * The setting arrays follows the specifications of Admin Page Framework v3. 
 * 
 * @package		Fetch Tweets
 * @subpackage	Rotator Template
 * @see			http://wordpress.org/plugins/admin-page-framework/
 */
class FetchTweets_Template_Settings_Rotator extends FetchTweets_Template_Settings {

	/*
	 * Modify these properties.
	 * */
	protected $sParentPageSlug  = 'fetch_tweets_templates';	// in the url, the ... part of ?page=... 
	protected $sParentTabSlug   = 'rotator';	// in the url, the ... part of &tab=...
	protected $sTemplateName    = 'Rotator';	// the template name
	protected $sSectionID       = 'template_rotator';
	
	
	public function  __construct( $sTemplateDirPath='' ) {
		
		parent::__construct( $sTemplateDirPath );
		
		// If not checked, it causes a PHP warning at the plugin deactivation.
		if ( defined( 'FETCHTWEETS_ROTATOR_TEMPLETE_PATH' ) ) {
			$_sPluginBaseName = plugin_basename( FETCHTWEETS_ROTATOR_TEMPLETE_PATH ); 
			add_filter( "plugin_action_links_{$_sPluginBaseName}", array( $this, '_replyToInsertPluginLink' ) );		
		}
		
	}
		public function _replyToInsertPluginLink( $aLinks ) {
				
			if ( ! class_exists( 'FetchTweets_Commons' ) ) {
				return $aLinks;
			}
			
			$_sSettingPageURL = admin_url( 
				'edit.php?post_type=' . FetchTweets_Commons::PostTypeSlug 
				. '&page=' . $this->sParentPageSlug
				. '&tab=' . $this->sParentTabSlug
			);

			array_unshift( $aLinks, "<a href='{$_sSettingPageURL}'>" . __( 'Settings', 'fetch-tweets' ) . "</a>" ); 
			return $aLinks; 
			
		}	
			
	/*
	 * Modify these methods. 
	 * This defines form sections. Set the section ID and the description here.
	 * The array structure follows the rule of Admin Page Framework. ( https://github.com/michaeluno/admin-page-framework )
	 * */
	public function addSettingSections( $aSections ) {
			
		$aSections[ $this->sSectionID ] = array(
			'section_id'	=> $this->sSectionID,
			'page_slug'		=> $this->sParentPageSlug,
			'tab_slug'		=> $this->sParentTabSlug,
			'title'			=> $this->sTemplateName,
			'description'	=> sprintf( __( 'Options for the %1$s template.', 'fetch-tweets-rotator-template' ), $this->sTemplateName ) . ' ' 
				. __( 'These will be the default values and be overridden by the arguments passed directly by the widgets, the shortcode, or the PHP function.', 'fetch-tweets-rotator-template' ),
		);
		return $aSections;
	
	}
	
	/*
	 * This defines form fields. Return the field arrays. 
	 * The array structure follows the rule of Admin Page Framework. ( https://github.com/michaeluno/admin-page-framework )
	 * */
	public function addSettingFields( $aFields ) {
		
		if ( ! class_exists( 'FetchTweets_Commons' ) ) return $aFields;	// if the main class does not exist, do nothing.
				
		$aFields[ $this->sSectionID ] = array();

		$aFields[ $this->sSectionID ][ 'items_per_slide' ] = array(	// font size
			'field_id' => 'items_per_slide',
			'section_id' => $this->sSectionID,
			'title' => __( 'Number of Items per Slide', 'fetch-tweets-rotator-template' ),
			'type' => 'number',
			'default'	=>	1,

		);
		$aFields[ $this->sSectionID ][ 'speed' ] = array(	// font size
			'field_id' => 'speed',
			'section_id' => $this->sSectionID,
			'title' => __( 'Transition Speed', 'fetch-tweets-rotator-template' ),
			'type' => 'number',
			'after_label' => ' ' . __( 'milliseconds', 'fetch-tweets-rotator-template' ),
			'description'	=>	__( 'The duration that each item completes the transition.', 'fetch-tweets-rotator-template' ),
			'default'	=>	1000,

		);		
		$aFields[ $this->sSectionID ][ 'pause_duration' ] = array(	// font size
			'field_id' => 'pause_duration',
			'section_id' => $this->sSectionID,
			'title' => __( 'Pause Duration', 'fetch-tweets-rotator-template' ),
			'type' => 'number',
			'after_label' => ' ' . __( 'milliseconds', 'fetch-tweets-rotator-template' ),
			'description'	=>	__( 'The duration that each item is displayed.', 'fetch-tweets-rotator-template' ),
			'default'	=>	4000,
		);					
		$aFields[ $this->sSectionID ][ 'adaptiveHeightSpeed' ] = array(	// font size
			'field_id' => 'adaptiveHeightSpeed',
			'section_id' => $this->sSectionID,
			'title' => __( 'Height Adjustment Speed', 'fetch-tweets-rotator-template' ),
			'type' => 'number',
			'after_label' => ' ' . __( 'milliseconds', 'fetch-tweets-rotator-template' ),
			'description'	=>	__( 'The duration to adjust the height after/during the transition.', 'fetch-tweets-rotator-template' ),
			'default'	=>	1000,
		);			
		$aFields[ $this->sSectionID ][ 'randomStart' ] = array(	// font size
			'field_id' => 'randomStart',
			'section_id' => $this->sSectionID,
			'title' => __( 'Shuffle', 'fetch-tweets-rotator-template' ),
			'type' => 'radio',
			'label'	=>	array(
				'true'	=>	__( 'On', 'fetch-tweets-rotator-template' ),
				'false'	=>	__( 'Off', 'fetch-tweets-rotator-template' ),
			),
			'default'	=>	'false',

		);			
		
		// $aFields[ $this->sSectionID ][ 'transition_mode' ] = array(	// font size
			// 'field_id' => 'transition_mode',
			// 'section_id' => $this->sSectionID,
			// 'title' => __( 'Transition Mode', 'fetch-tweets-rotator-template' ),
			// 'type' => 'radio',
			// 'label'	=>	array(
				// 'fade'	=>	__( 'Fade', 'fetch-tweets-rotator-template' ),
				// 'horizontal'	=>	__( 'Horizontal', 'fetch-tweets-rotator-template' ),
				// 'vertical'	=>	__( 'Vertical', 'fetch-tweets-rotator-template' ),
			// ),
			// 'default'	=>	'fade',
		// );			
		$aFields[ $this->sSectionID ][ 'font_size' ] = array(	// font size
			'field_id' => 'font_size',
			'section_id' => $this->sSectionID,
			'title' => __( 'Font Size', 'fetch-tweets-rotator-template' ),
			'type' => 'size',
			'units' => array(
				'px' => 'px',
				'em' => 'em',
			),
			'default' => array(
				'size'	=> 1.5,
				'unit'	=> 'em',
			),			
			'attributes'	=>	array(
				'min'	=>	1,
				'step'	=>	0.1,
			),

		);		
		
		$aFields[ $this->sSectionID ]['avatar_size'] = array(
			'field_id' => 'avatar_size',
			'section_id' => $this->sSectionID,
			'title' => __( 'Profile Image Size', 'fetch-tweets' ),
			'description' => __( 'The avatar size in pixel. Set 0 for no avatar.', 'fetch-tweets' ) . ' ' . __( 'Default', 'fetch-tweets' ) . ': 48',
			'type' => 'number',
			'default' => 48, 
			'attributes'	=>	array(
				'size'	=>	 10,
			),
		);	
		$aFields[ $this->sSectionID ]['avatar_position'] = array(
			'field_id' => 'avatar_position',
			'section_id' => $this->sSectionID,
			'title' => __( 'Profile Image Position', 'fetch-tweets' ),
			'type' => 'radio',
			'label' => array(
				'left' => __( 'Left', 'fetch-tweets' ),
				'right' => __( 'Right', 'fetch-tweets' ),
			),
			'default' => 'left', 
		);			
		

		$aFields[ $this->sSectionID ]['max_width'] = array(
			'field_id' => 'max_width',
			'section_id' => $this->sSectionID,
			'title' => __( 'Max Width', 'fetch-tweets' ),
			'description' => __( 'The max width of the output.', 'fetch-tweets-rotator-template' ) . ' ' . __( 'Default', 'fetch-tweets' ) . ': 100%',
			'type' => 'size',
			'units' => array(
				'%' => '%',
				'px' => 'px',
				'em' => 'em',
			),
			'default' => array(
				'size'	=> 100,
				'unit'	=> '%',
			),
			'delimiter' => '<br />',
		);
		$aFields[ $this->sSectionID ]['max_height'] = array(
			'field_id' => 'max_height',
			'section_id' => $this->sSectionID,
			'title' => __( 'Max Height', 'fetch-tweets' ),
			'description' => __( 'The max height of the output.', 'fetch-tweets-rotator-template' ) . ' ' . __( 'Default', 'fetch-tweets' ) . ': 100%',
			'type' => 'size',
			'units' => array(
				'%' => '%',
				'px' => 'px',
				'em' => 'em',
			),
			'default' => array(
				'size'	=> 100,
				'unit'	=> '%',
			),
			'delimiter' => '<br />',
		);		
		$aFields[ $this->sSectionID ]['margins'] = array(
			'field_id' => 'margins',
			'section_id' => $this->sSectionID,
			'title' => __( 'Margins', 'fetch-tweets' ),
			'description' => __( 'The margins of the output element. Leave them empty not to set any margin.', 'fetch-tweets' ),
			'type' => 'size',
			'units' => array( '%' => '%', 'px' => 'px', 'em' => 'em', ),
			'delimiter' => '<br />',
			'label'	=>	__( 'Top', 'fetch-tweets' ),
			'attributes'	=>	array(
				'step'	=>	0.1
			),
			array(
				'label'	=>	__( 'Right', 'fetch-tweets' ),
			),
			array(
				'label'	=>	__( 'Bottom', 'fetch-tweets' ),
			),
			array(
				'label'	=>	__( 'Left', 'fetch-tweets' ),
			),
		);		
		$aFields[ $this->sSectionID ]['paddings'] = array(
			'field_id' => 'paddings',
			'section_id' => $this->sSectionID,
			'title' => __( 'Paddings', 'fetch-tweets' ),
			'description' => __( 'The paddings of the output element. Leave them empty not to set any padding.', 'fetch-tweets' ),
			'type' => 'size',
			'units' => array( '%' => '%', 'px' => 'px', 'em' => 'em', ),
			'delimiter' => '<br />',
			'label'	=>	__( 'Top', 'fetch-tweets' ),
			'attributes'	=>	array(
				'step'	=>	0.1
			),			
			array(
				'label'	=>	__( 'Right', 'fetch-tweets' ),
			),
			array(
				'label'	=>	__( 'Bottom', 'fetch-tweets' ),
			),
			array(
				'label'	=>	__( 'Left', 'fetch-tweets' ),
			),			
		);		
						
		$aFields[ $this->sSectionID ]['background_color'] = array(
			'field_id' => 'background_color',
			'section_id' => $this->sSectionID,
			'title' => __( 'Background Color', 'fetch-tweets' ),
			'type' => 'color',
			'default' => 'transparent',
		);		
		$aFields[ $this->sSectionID ]['intent_buttons'] = array(
			'field_id' => 'intent_buttons',
			'section_id' => $this->sSectionID,
			'title' => __( 'Intent Buttons', 'fetch-tweets' ),
			'description' => __( 'These are for Favourite, Reply, and Retweet buttons.', 'fetch-tweets' ),
			'type' => 'radio',
			'label' => array(  
				1 => __( 'Both icons and text', 'fetch-tweets' ),
				2 => __( 'Only icons', 'fetch-tweets' ),
				3 => __( 'Only text', 'fetch-tweets' ),
			),
			'default' => 2,
		);
		$aFields[ $this->sSectionID ]['intent_script'] = array(
			'field_id' => 'intent_script',
			'section_id' => $this->sSectionID,
			'title' => __( 'Intent Button Script', 'fetch-tweets' ),
			'type' => 'checkbox',
			'label' => __( 'Insert the intent button script that enables a pop-up window for Favorite, Reply, and Retweet.', 'fetch-tweets' ),
			'default' => 1,
		);
		$aFields[ $this->sSectionID ]['visibilities'] = array(
			'field_id' => 'visibilities',
			'section_id' => $this->sSectionID,
			'title' => __( 'Visibility', 'fetch-tweets' ),
			'type' => 'checkbox',
			'label' => array(
				'avatar'			=> __( 'Profile Image', 'fetch-tweets' ),
				'user_name'			=> __( 'User Name', 'fetch-tweets' ),
				'time'				=> __( 'Time', 'fetch-tweets' ),
				'intent_buttons'	=> __( 'Intent Buttons', 'fetch-tweets' ),
			),
			'default' => array(
				'avatar'			=> true,
				'user_name'			=> true,
				'time'				=> true,
				'intent_buttons'	=> true,
			),
		);		
		
		$aFields[ $this->sSectionID ][ 'rotator_submit' ] = array(  // single button
			'field_id' => 'rotator_submit',
			'section_id' => $this->sSectionID,
			'type' => 'submit',
			'before_field' => "<div class='right-button'>",
			'after_field' => "</div>",
			'label_min_width' => 0,
			'value'	=>	__( 'Save Changes', 'fetch-tweets-rotator-template' ),
			'label' =>	__( 'Save Changes', 'fetch-tweets-rotator-template' ),
			'attributes'	=>	array(
				'class'	=>	'button button-primary',
			)
		);
		return $aFields;		
		
	}
	
	public function validateSettings( $aInput, $aOldInput ) {

		return $aInput;
		
	}
	
}