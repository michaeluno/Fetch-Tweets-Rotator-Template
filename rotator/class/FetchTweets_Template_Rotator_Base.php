<?php
/**
 * The base class of the Rotator template output handler.
 * 
 */
if ( ! class_exists( 'FetchTweets_Template_Rotator_Base' ) ) :
class FetchTweets_Template_Rotator_Base {

	protected $_sBaseClassSelector = 'fetch-tweets-rotator';

	private $_aDefaultTemplateOptions = array(
		'items_per_slide'		=>	1,
		'speed'					=>	1000,
		'transition_mode'		=>	'fade',	// 'horizontal', 'vertical', 'fade'
		'adaptiveHeightSpeed'	=>	1000,	
		'pause_duration'		=>	4000,	
		'randomStart'			=>	false,
		'font_size'				=>	array( 'size' => 1.5, 'unit' => 'em' ),
		'avatar_size'			=> 48,
		'avatar_position'		=> 'right',
		'max_width'				=> array( 'size' => 100, 'unit' => '%' ),
		'max_height'			=> array( 'size' => 400, 'unit' => 'px' ),
		'background_color'		=> 'transparent',
		'intent_buttons'		=> 2,
		'intent_script'			=> 1,
		'visibilities'			=> array(
			'avatar' => true,
			'user_name' => true,
			'time' => false,
			'intent_buttons' => false,
		),
		'margins' 				=> array(
			0 => array( 'size' => '', 'unit' => 'px' ),	// top
			1 => array( 'size' => '', 'unit' => 'px' ),	// right
			2 => array( 'size' => '', 'unit' => 'px' ),	// bottom
			3 => array( 'size' => '', 'unit' => 'px' ),	// left
		),
		'paddings'				=> array(
			0 => array( 'size' => 1, 	'unit' => 'em' ),	// top
			1 => array( 'size' => 1, 	'unit' => 'em' ),	// right
			2 => array( 'size' => 0.8,	'unit' => 'em' ),	// bottom
			3 => array( 'size' => 1, 	'unit' => 'em' ),	// left
		),	
	);	

	public function __construct( array $aArgs, array $aTemplateOption ) {	
		
		$this->_aArgs = $this->_getArgs( $aArgs, $aTemplateOption );
		
		$this->_sIDAttribute = 'fetch_tweets_rotator_' . uniqid();
		$this->_sGMTOffset = ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
		$this->_fIsSSL = is_ssl();
	
	}

	/**
	 * Returns a template option array merged with default values.
	 * 
	 * @param			array			$aTemplateOption			The template option array stored in the database. The main plugins' option object array holds it with the key of the section ID.
	 * @remark			The template option section ID is determined in the setting class with the $sSectionID property.
	 */
	protected function _getArgs( array $aArgs, array $aTemplateOption ) {
		
		return FetchTweets_Utilities::uniteArrays( $aArgs, $aTemplateOption, $this->_aDefaultTemplateOptions );	// unites arrays recursively.	
		
	}
	
	
		protected function _generateStyleAttribute( array $aInlineStyles ) {
			
			$_aOutput = array();
			foreach ( $aInlineStyles as $sProperty => $sValue ) {
				if ( ! $sValue ) continue;
				$_aOutput[] = $sProperty . ': ' . $sValue . ';';
			}
			return implode( ' ', $_aOutput );	
			
		}
		
		/**
		 * Returns the string of top, right, bottom and left values for a style property.
		 * Each parameter array must have 'size' and 'unit' elements.
		 */
		protected function _getTRBL( array $aTop, array $aRight, array $aBottom, array $aLeft ) {
			
			$_aOutput = array();
			foreach( func_get_args() as $_aSide ) {
				$_aSide = $_aSide + array(
					'unit' => 'px',
					'size'	=>	'',
				);
				$_aOutput[] = $_aSide['size']
					?  $_aSide['size'] . $_aSide['unit'] 
					: 0;
				
			}
			return implode( ' ', $_aOutput );
		
		}
		
		/**
		 * Returns the string output from a size array.
		 * 
		 */
		protected function _getSize( array $aSize ) {
			
			$aSize = $aSize + array(
				'size'	=>	'',
				'unit'	=>	'',
			);
			return $aSize['size']
				? $aSize['size'] . $aSize['unit']
				: '';			
			
		}	
	
	/**
	 * Enhances the parent method generateAttributes() by escaping the attribute values.
	 * 
	 * @since			1.0.0
	 */
	protected function _generateAttributes( array $aAttributes ) {
		
		foreach( $aAttributes as $sAttribute => &$asProperty ) {
			if ( is_array( $asProperty ) || is_object( $asProperty ) )
				unset( $aAttributes[ $sAttribute ] );
			if ( is_string( $asProperty ) )
				$asProperty = esc_attr( $asProperty );	 // $aAttributes = array_map( 'esc_attr', $aAttributes );	// this also converts arrays into string value, Array.
		}		
		return $this->__generateAttributes( $aAttributes );
		
	}	
		/**
		 * Generates the string of attributes to be embedded in an HTML tag from an associative array.
		 * 
		 * For example, 
		 * 	array( 'id' => 'my_id', 'name' => 'my_name', 'style' => 'background-color:#fff' )
		 * becomes
		 * 	id="my_id" name="my_name" style="background-color:#fff"
		 * 
		 * This is mostly used by the method to output input fields.
		 * @since			1.0.0
		 */
		private function __generateAttributes( array $aAttributes ) {
			
			$aOutput = array();
			foreach( $aAttributes as $sAttribute => $sProperty ) {
				if ( empty( $sProperty ) && $sProperty !== 0  )	continue;	// drop non-value elements.
				if ( is_array( $sProperty ) || is_object( $sProperty ) ) continue;	// must be resolved as a string.
				$aOutput[] = "{$sAttribute}='{$sProperty}'";
			}
			return implode( ' ', $aOutput );
			
		}	
	
}
endif;