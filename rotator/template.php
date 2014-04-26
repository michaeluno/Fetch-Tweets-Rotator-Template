<?php

/*
 * Available variables passed from the caller script
 * - $aTweets : the fetched tweet arrays.
 * - $aArgs	: the passed arguments such as item count etc.'
 * - $aOptions : the plugin options saved in the database.
 * */
 
 
/*
 * 1. Set up options and arguments - merges with default values.
 */
$oRotator = new FetchTweets_Template_Rotator( $aArgs, isset( $aOptions['template_rotator'] ) ? $aOptions['template_rotator'] : array() );
echo $oRotator->getOutput( $aTweets );
return;
// $aTemplateOptions = getRotatorTemplateOptions( isset( $aOptions['template_rotator'] ) ? $aOptions['template_rotator'] : array() );
// $aArgs = getRotatorTemplateArguments( $aArgs, $aTemplateOptions );

// MISC local variables
// $sIDAttribute = 'fetch_tweets_rotator_' . uniqid();
// $sGMTOffset = ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
// $fIsSSL = is_ssl();


// $aArgs = getFetchTweetsTemplateArguments_HashTagColud( $aArgs, $aTemplateOptions );
// FetchTweets_Debug::logArray( $aArgs );

// test.
// $sWidth = '100%';
// $sHeight = '100%';
// $sMargins = '0';
// $sPaddings = '0';
// $aArgs['background_color'] = 'transparent';
// $sMarginForImage = '';

// Finalize the template option values.


// Set up local variables.
// $sFontSize = $aArgs['font_size'] ? 'font-size:' . $aArgs['font_size'] . '; ' : '';
// $sWidth = $aArgs['max_width'] ? "max-width: " . $aArgs['max_width'] . $aArgs['max_width_unit'] . "; " : '';
// $sHeight =  $aArgs['max_height'] ? "max-height: " . $aArgs['max_height'] . $aArgs['max_height_unit'] . "; " : '';
// $sMarginTop = empty( $aArgs['margin_top'] ) ? 0 : $aArgs['margin_top'] . $aArgs['margin_top_unit'];
// $sMarginRight = empty( $aArgs['margin_right'] ) ? 0 : $aArgs['margin_right'] . $aArgs['margin_right_unit'];
// $sMarginBottom = empty( $aArgs['margin_bottom'] ) ? 0 : $aArgs['margin_bottom'] . $aArgs['margin_bottom_unit'];
// $sMarginLeft = empty( $aArgs['margin_left'] ) ? 0 : $aArgs['margin_left'] . $aArgs['margin_left_unit'];
// $sPaddingTop = empty( $aArgs['padding_top'] ) ? 0 : $aArgs['padding_top'] . $aArgs['padding_top_unit'];
// $sPaddingRight = empty( $aArgs['padding_right'] ) ? 0 : $aArgs['padding_right'] . $aArgs['padding_right_unit'];
// $sPaddingBottom = empty( $aArgs['padding_bottom'] ) ? 0 : $aArgs['padding_bottom'] . $aArgs['padding_bottom_unit'];
// $sPaddingLeft = empty( $aArgs['padding_left'] ) ? 0 : $aArgs['padding_left'] . $aArgs['padding_left_unit'];
// $sMargins = ( $sMarginTop ? "margin-top: {$sMarginTop}; " : "" ) . ( $sMarginRight ? "margin-right: {$sMarginRight}; " : "" ) . ( $sMarginBottom ? "margin-bottom: {$sMarginBottom}; " : "" ) . ( $sMarginLeft ? "margin-left: {$sMarginLeft}; " : "" );
// $sPaddings = ( $sPaddingTop ? "padding-top: {$sPaddingTop}; " : "" ) . ( $sPaddingRight ? "padding-right: {$sPaddingRight}; " : "" ) . ( $sPaddingBottom ? "padding-bottom: {$sPaddingBottom}; " : "" ) . ( $sPaddingLeft ? "padding-left: {$sPaddingLeft}; " : "" );
// $sMarginForImage = $aArgs['visibilities']['avatar'] ? ( ( $aArgs['avatar_position'] == 'left' ? "margin-left: " : "margin-right: " ) . ( ( int ) $aArgs['avatar_size'] ) . "px" ) : "";
// $_iMarginForImageContainer = round( ( int ) $aArgs['avatar_size']  / 100 * 2, 2 ) . 'em;';
// $sMarginsForImageContainer = $aArgs['visibilities']['avatar'] 
	// ? ( $aArgs['avatar_position'] == 'left' ? "margin-right: " : "margin-left: " ) . $_iMarginForImageContainer . ' margin-bottom: ' . $_iMarginForImageContainer
	// : '';
	



// test
$aArgs['avatar_size'] = 120;
?>

<div class="fetch-tweets-rotator" id="<?php echo $sIDAttribute; ?>" style="<?php echo $sWidth; ?><?php echo $sHeight; ?>background-color: <?php echo $aArgs['background_color']; ?>; <?php echo $sMargins; ?> <?php echo $sPaddings; ?> <?php echo $sFontSize; ?>">
	
	<?php foreach ( $aTweets as $_aDetail ) : ?>
	<?php 
		// If the necessary key is set,
		if ( ! isset( $_aDetail['user'] ) ) continue;
		
		// Check if it's a retweet.
		$_fIsRetweet = isset( $_aDetail['retweeted_status']['text'] );
		if ( $_fIsRetweet && ! $aArgs['include_rts'] ) continue;
		$aTweet = $_fIsRetweet ? $_aDetail['retweeted_status'] : $_aDetail;
		$sRetweetClassSelector = $_fIsRetweet ? 'fetch-tweets-rotator-retweet' : '';
	?>
		
		<?php for( $i = 0; $i < $aArgs['items_per_slide']; $i++  ) : ?>
		<div class='fetch-tweets-rotator-items'> 
		
			<div class='fetch-tweets-rotator-item <?php echo $sRetweetClassSelector; ?>' >

				<?php if ( $aArgs['avatar_size'] > 0  && $aArgs['visibilities']['avatar'] ) : 
					$sAvatarURL = getTwitterProfileImageURLBySize( $fIsSSL ? $aTweet['user']['profile_image_url_https'] : $aTweet['user']['profile_image_url'], $aArgs['avatar_size'] );
				?>
				<div class='fetch-tweets-rotator-profile-image' style="max-width:<?php echo $aArgs['avatar_size'];?>px; float:<?php echo $aArgs['avatar_position']; ?>; clear:<?php echo $aArgs['avatar_position']; ?>; <?php echo $sMarginsForImageContainer; ?>" >
					<a href='https://twitter.com/<?php echo $aTweet['user']['screen_name']; ?>' target='_blank'>
						<img src='<?php echo $sAvatarURL ?>' style="max-width:<?php echo $aArgs['avatar_size'];?>px;" />
					</a>
				</div>
				<?php endif; ?>
				<div class='fetch-tweets-rotator-main' style='<?php echo $sMarginForImage;?>;'>
					<div class='fetch-tweets-rotator-heading'>
					
						<?php if ( $aArgs['visibilities']['user_name'] ) : ?>
						<span class='fetch-tweets-rotator-user-name'>
							<strong>
								<a href='https://twitter.com/<?php echo $aTweet['user']['screen_name']; ?>' target='_blank'>
									<?php echo $aTweet['user']['name']; ?>
								</a>
							</strong>
						</span>
						<?php endif; ?>
						
						<?php if ( $aArgs['visibilities']['time'] ) : ?>
						<span class='fetch-tweets-rotator-tweet-created-at'>
							<a href='https://twitter.com/<?php echo $aTweet['user']['screen_name']; ?>/status/<?php echo $aTweet['id_str'] ;?>' target='_blank'>
								<?php echo human_time_diff( $aTweet['created_at'], current_time('timestamp') - $sGMTOffset ) . ' ' . __( 'ago', 'fetch-tweets-rotator' ); ?>
							</a>			
						</span>
						<?php endif; ?>
						
					</div>
					<div class='fetch-tweets-rotator-body'>
						<p class='fetch-tweets-rotator-text'><?php echo trim( $aTweet['text'] ); ?>				
							<?php if ( isset( $_aDetail['retweeted_status']['text'] ) ) : ?>
							<span class='fetch-tweets-rotator-retweet-credit'>
								<?php echo _e( 'Retweeted by', 'fetch-tweets-rotator' ) . ' '; ?>
								<a href='https://twitter.com/<?php echo $_aDetail['user']['screen_name']; ?>' target='_blank'>
									<?php echo $_aDetail['user']['name']; ?>
								</a>
							</span>
							<?php endif; ?>
						</p>

						<?php if ( $aArgs['intent_buttons'] ) : ?>
							<?php if ( $aArgs['intent_button_script'] ) : ?>
							<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
							<?php endif; ?>
							<ul class='fetch-tweets-rotator-intent-buttons'>
								<li class='fetch-tweets-rotator-intent-reply'>
									<a href='https://twitter.com/intent/tweet?in_reply_to=<?php echo $_aDetail['id_str']; ?>' rel='nofollow' target='_blank' title='<?php _e( 'Reply', 'fetch-tweets-rotator' ); ?>'>
										<?php if ( $aArgs['intent_buttons'] == 1 || $aArgs['intent_buttons'] == 2 ) : ?>
										<span class='fetch-tweets-rotator-intent-icon' style='background-image: url("<?php echo FetchTweets_Commons::getPluginURL( 'asset/image/reply_48x16.png' ); ?>");' ></span>
										<?php endif; ?>
										<?php if ( $aArgs['intent_buttons'] == 1 || $aArgs['intent_buttons'] == 3 ) : ?>
										<span class='fetch-tweets-rotator-intent-buttons-text'><?php _e( 'Reply', 'fetch-tweets-rotator' ); ?></span>
										<?php endif; ?>
									</a>
								</li>
								<li class='fetch-tweets-rotator-intent-retweet'>
									<a href='https://twitter.com/intent/retweet?tweet_id=<?php echo $_aDetail['id_str'];?>' rel='nofollow' target='_blank' title='<?php _e( 'Retweet', 'fetch-tweets-rotator' ); ?>'>
										<?php if ( $aArgs['intent_buttons'] == 1 || $aArgs['intent_buttons'] == 2 ) : ?>
										<span class='fetch-tweets-rotator-intent-icon' style='background-image: url("<?php echo FetchTweets_Commons::getPluginURL( 'asset/image/retweet_48x16.png' ); ?>");' ></span>
										<?php endif; ?>
										<?php if ( $aArgs['intent_buttons'] == 1 || $aArgs['intent_buttons'] == 3 ) : ?>
										<span class='fetch-tweets-rotator-intent-buttons-text'><?php _e( 'Retweet', 'fetch-tweets-rotator' ); ?></span>
										<?php endif; ?>
									</a>
								</li>
								<li class='fetch-tweets-rotator-intent-favorite'>
									<a href='https://twitter.com/intent/favorite?tweet_id=<?php echo $_aDetail['id_str'];?>' rel='nofollow' target='_blank' title='<?php _e( 'Favorite', 'fetch-tweets-rotator' ); ?>'>
										<?php if ( $aArgs['intent_buttons'] == 1 || $aArgs['intent_buttons'] == 2 ) : ?>
										<span class='fetch-tweets-rotator-intent-icon' style='background-image: url("<?php echo FetchTweets_Commons::getPluginURL( 'asset/image/favorite_48x16.png' ); ?>");' ></span>
										<?php endif; ?>
										<?php if ( $aArgs['intent_buttons'] == 1 || $aArgs['intent_buttons'] == 3 ) : ?>
										<span class='fetch-tweets-rotator-intent-buttons-text'><?php _e( 'Favorite', 'fetch-tweets-rotator' ); ?></span>
										<?php endif; ?>
									</a>
								</li>		

							</ul>
						<?php endif; ?>
					</div>
								
				</div>
			</div><!-- end .fetch-tweets-rotator-item -->
		</div><!-- end .fetch-tweets-rotator-items -->
		<?php endfor; ?>
	<?php endforeach; ?>	
</div><!-- end .fetch-tweets-rotator -->
<script type="text/javascript">		
	jQuery( document).ready( function(){ jQuery( '#<?php echo $sIDAttribute; ?>' ).jshowoff(
		{ 
			changeSpeed: 1500,
			speed: 5000, 
			links: false,
			controls: false,
			effect: 'slideLeft',	// 'fade' or 'none'
		}
	); } );
</script>
