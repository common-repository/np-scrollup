<?php 
/*
Plugin Name: NP ScrollUp
Plugin URI: http://np-foundation.twomini.com/plugin/np-scrollup/
Description: This plugin will enable scroll to top button in your wordpress site with effects and plenty of options. You can change color & other setting from <a href="options-general.php?page=npscrollup-settings.php">Option Panel</a>
Author: Golam Ahmed Pasha
Author URI: https://npfoundation.wordpress.com/
Version: 1.0.1
*/


/* Adding Latest jQuery from Wordpress */
function npscrollup() {
	wp_enqueue_script('jquery');
}
add_action('init', 'npscrollup');

/*Some Set-up*/
define('np_scroll_up', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

wp_enqueue_script('np-custom--main', np_scroll_up.'js/jquery.scrollUp.min.js', array('jquery'));

wp_enqueue_style('np_scroll_up', np_scroll_up.'css/npscrollup.css');
wp_enqueue_style('np_scrollup_font_awesome', np_scroll_up.'css/font-awesome.css');

function np_scroll_up_options_framwrork()  
{  
	add_options_page('Np ScrollUp	Options', 'NP ScrollUp Options', 'manage_options', 'npscrollup-settings','npscrollup_options_framwrork');  
}  
add_action('admin_menu', 'np_scroll_up_options_framwrork');

function np_scroll_up_color_pickr_function( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('js/color-pickr.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

add_action( 'admin_enqueue_scripts', 'np_scroll_up_color_pickr_function' );

// Default options values
$npscrollup_options = array(
	'icon_color' => '#cecece',
	'icon_h_color' => '#ffffff',
	'bg_color' => '#000000',
	'bg_h_color' => '#000000',
	'padding' => '5px 10px 10px 10px',
	'cus_icon_pos' => '20px',
	'font_size' => '35px',	
	'style_four_icon' => 'angle-double-up',
	'icon_position' => 'right',
	'apper_animation' => 'slide',
	'display_opt' => 'hidden',
	'np_icon_broder' => 'false',
	'circle_or_square' => '0px'
);


if ( is_admin() ) : // Load only if we are viewing an admin page

function np_scroll_up_register_settings() {
	// Register settings and call sanitation functions
	register_setting( 'np_scroll_up_options', 'npscrollup_options', 'np_scroll_up_validate_options' );
}

add_action( 'admin_init', 'np_scroll_up_register_settings' );

// Store layouts views in array
$circle_or_square = array(
	'auto_hide_yes' => array(
		'value' => '500px',
		'label' => 'Circle'
	),
	'auto_hide_no' => array(
		'value' => '0px',
		'label' => 'Square'
	),
);

// Store layouts views in array
$icon_position = array(
	'icon_left' => array(
		'value' => 'left',
		'label' => 'Left'
	),
	'icon_right' => array(
		'value' => 'right',
		'label' => 'Right'
	),
);

// Store layouts views in array
$display_opt = array(
	'display_opt_s' => array(
		'value' => 'visible',
		'label' => 'Show'
	),
	'display_opt_h' => array(
		'value' => 'hidden',
		'label' => 'Hide'
	),
);

// Store layouts views in array
$np_icon_broder = array(
	'np_icon_broder_t' => array(
		'value' => 'true',
		'label' => 'Show'
	),
	'np_icon_broder_f' => array(
		'value' => 'false',
		'label' => 'Hide'
	),
);

// Store layouts views in array
$apper_animation = array(
	'appa_slide' => array(
		'value' => 'slide',
		'label' => 'Slide'
	),
	'appa_fade' => array(
		'value' => 'fade',
		'label' => 'Fade'
	),
	'appa_none' => array(
		'value' => 'none',
		'label' => 'None'
	),
);

// Store layouts views in array
$style_four_icon = array(
	'angle' => array(
		'value' => 'angle-up',
		'label' => 'Angle'
	),
	'angle_double' => array(
		'value' => 'angle-double-up',
		'label' => 'Double Angle'
	),
	'caret' => array(
		'value' => 'caret-up',
		'label' => 'Caret'
	),
	'arrow' => array(
		'value' => 'arrow-up',
		'label' => 'Arrow'
	),
	'magnet' => array(
		'value' => 'magnet',
		'label' => 'Magnet'
	),
	'chevron-circle-up' => array(
		'value' => 'chevron-circle-up',
		'label' => 'chevron-circle-up'
	),
	'caret-square-o-up' => array(
		'value' => 'caret-square-o-up',
		'label' => 'caret-square-o-up'
	),
	'eject' => array(
		'value' => 'eject',
		'label' => 'eject'
	),
	'arrow-circle-o-up' => array(
		'value' => 'arrow-circle-o-up',
		'label' => 'arrow-circle-o-up'
	),
	'arrow-circle-up' => array(
		'value' => 'arrow-circle-up',
		'label' => 'arrow-circle-up'
	),
	'hand-o-up ' => array(
		'value' => 'hand-o-up ',
		'label' => 'hand-o-up '
	),
	'long-arrow-up ' => array(
		'value' => 'long-arrow-up ',
		'label' => 'long-arrow-up '
	),
);


// Function to generate options page
function npscrollup_options_framwrork() {
	global $npscrollup_options, $circle_or_square, $style_four_icon, $icon_position, $apper_animation, $display_opt, $np_icon_broder;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap"
	<h2>NP Scroll Up Options</h2>
	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>
	<form method="post" action="options.php">
	<?php $settings = get_option( 'npscrollup_options', $npscrollup_options ); ?>
	<?php settings_fields( 'np_scroll_up_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		<tr valign="top">
			<th scope="row"><label for="icon_color">Icon color</label></th>
			<td>
				<input id="icon_color" type="text" name="npscrollup_options[icon_color]" value="<?php echo stripslashes($settings['icon_color']); ?>" class="my-color-field" /><p class="description">Select  icon color here. You can also add html HEX color code.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="icon_h_color">Icon Hover color</label></th>
			<td>
				<input id="icon_h_color" type="text" name="npscrollup_options[icon_h_color]" value="<?php echo stripslashes($settings['icon_h_color']); ?>" class="my-color-field" /><p class="description">Select  icon hover color here. You can also add html HEX color code.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bg_color">Background color</label></th>
			<td>
				<input id="bg_color" type="text" name="npscrollup_options[bg_color]" value="<?php echo stripslashes($settings['bg_color']); ?>" class="my-color-field" /><p class="description">Select  background color here. You can also add html HEX color code.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bg_h_color">Background Hover color</label></th>
			<td>
				<input id="bg_h_color" type="text" name="npscrollup_options[bg_h_color]" value="<?php echo stripslashes($settings['bg_h_color']); ?>" class="my-color-field" /><p class="description">Select  background hover color here. You can also add html HEX color code.</p>
			</td>
		</tr
		<tr valign="top">
			<th scope="row"><label for="padding">Padding</label></th>
			<td>
				<input id="padding" type="text" name="npscrollup_options[padding]" value="<?php echo stripslashes($settings['padding']); ?>" /><p class="description">Padding measurement respectively top, right, bottom and left. For example: 5px 10px 10px 10px</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="font_size">Icon Size</label></th>
			<td>
				<input id="font_size" type="text" name="npscrollup_options[font_size]" value="<?php echo stripslashes($settings['font_size']); ?>" /><p class="description">Change  icon size. For example: 20px</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="background_color">Icon Frame</label></th>
			<td>
				<?php foreach( $circle_or_square as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="npscrollup_options[circle_or_square]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['circle_or_square'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
				<?php endforeach; ?>
				<p class="description">Select  icon frame. Default frame is square. If you select circle your icon structure wil be round.</p>
			</td>
		</tr>		
	<tr valign="top">
			<th scope="row"><label for="background_color_two">Icon Style</label></th>
			<td>
				<?php foreach( $style_four_icon as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="npscrollup_options[style_four_icon]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['style_four_icon'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><i id="np_icon" class="fa fa-<?php echo $activate['value']; ?>"></i></label>
				<?php endforeach; ?>
				<p class="description">Select  icon style. There are 11 styles of icons. Select one of them according to your choice.  You may have to change padding measurement according to your choice.</p>
			</td>
		</tr>		
		<tr valign="top">
			<th scope="row"><label for="background_color_two">Icon Position</label></th>
			<td>
				<?php foreach( $icon_position as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="npscrollup_options[icon_position]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['icon_position'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
				<?php endforeach; ?>
				<strong>Custom Icon Position</strong>
				<input id="cus_icon_pos" type="text" name="npscrollup_options[cus_icon_pos]" value="<?php echo stripslashes($settings['cus_icon_pos']); ?>" />
				<p class="description">Select  icon position. If you select icon position as left, the  icon  will appear at the left side of the bottom of your screen. If  you select icon position as right, the  icon will appear at the right side of the bottom of your screen. You can also change the postion of your  by inputing measurement in pixels.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="background_color_two">Appreance Animation</label></th>
			<td>
				<?php foreach( $apper_animation as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="npscrollup_options[apper_animation]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['apper_animation'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
				<?php endforeach; ?>
				<p class="description">Select  Appreance Animation. There are 2 types of animations. One of them is Slide Animation and the other one is Fade Animation. If you don't want any appreance animation, select None.</p>
			</td>
		</tr>		
		<tr valign="top">
			<th scope="row"><label for="background_color_3">Scroll To Top Text </label></th>
			<td>
				<?php foreach( $display_opt as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="npscrollup_options[display_opt]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['display_opt'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
				<?php endforeach; ?>
				<p class="description">Select show or hide. If you select show, scroll to top text will be showed or if you select hide, scroll to top text will be hidden.</p>
			</td>
		</tr>		
		<tr valign="top">
			<th scope="row"><label for="scroll_up_border">Scroll Up Icon Border </label></th>
			<td>
				<?php foreach( $np_icon_broder as $activate ) : ?>
				<input type="radio" id="<?php echo $activate['value']; ?>" name="npscrollup_options[np_icon_broder]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['np_icon_broder'], $activate['value'] ); ?> />
				<label for="<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
				<?php endforeach; ?>
				<p class="description">Select show or hide. If you select show, border will be visible or if you select hide, border will be hidden.</p>
			</td>
		</tr>		
	</table>
	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
	</form>
	</div>
	<?php
}

function np_scroll_up_validate_options( $input ) {
	global $npscrollup_options, $circle_or_square, $style_four_icon, $icon_position, $apper_animation, $display_opt, $np_icon_broder;

	$settings = get_option( 'npscrollup_options', $npscrollup_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS

	$input['icon_color'] = wp_filter_post_kses( $input['icon_color'] );
	$input['icon_h_color'] = wp_filter_post_kses( $input['icon_h_color'] );
	$input['bg_color'] = wp_filter_post_kses( $input['bg_color'] );
	$input['bg_h_color'] = wp_filter_post_kses( $input['bg_h_color'] );
	$input['padding'] = wp_filter_post_kses( $input['padding'] );
	$input['cus_icon_pos'] = wp_filter_post_kses( $input['cus_icon_pos'] );
	$input['font_size'] = wp_filter_post_kses( $input['font_size'] );

	
	// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $circle_or_square ) )
		$input['layout_only'] = $prev;	
		
		// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $style_four_icon ) )
		$input['layout_only'] = $prev;	
		
		// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $icon_position ) )
		$input['layout_only'] = $prev;	
		
		// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $apper_animation ) )
		$input['layout_only'] = $prev;	
		
		// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $display_opt ) )
		$input['layout_only'] = $prev;	
		
		// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $np_icon_broder ) )
		$input['layout_only'] = $prev;	
	
	return $input;
}

endif;  // EndIf is_admin()

function np_custom_scrollup_active() {?>
<?php global $npscrollup_options; $npscrollup_settings = get_option( 'npscrollup_options', $npscrollup_options ); ?>
<style>
	#np_main_icon{
						padding: <?php echo $npscrollup_settings['padding']; ?>;
						background: <?php echo $npscrollup_settings['bg_color']; ?> none repeat scroll 0% 0%;
						
						font-size: <?php echo $npscrollup_settings['font_size']; ?>;
						border-radius: <?php echo $npscrollup_settings['circle_or_square']; ?>;
						font-weight: 900;
						
						<?php  if( $npscrollup_settings['np_icon_broder']=='true'){?>
						border: 2px solid <?php echo $npscrollup_settings['icon_color']; ?>;
						<?php } ?>	
	}
	#npscroll_text{
			background: <?php echo $npscrollup_settings['bg_color']; ?> none repeat scroll 0% 0%;
			padding:5px;
			border:transparent
	}
  #scrollUp:hover	#npscroll_text,#scrollUp:hover  #np_main_icon{
			background: <?php echo $npscrollup_settings['bg_h_color']; ?> none repeat scroll 0% 0%;
	}
	
	#scrollUp{<?php echo $npscrollup_settings['icon_position']; ?>: <?php echo $npscrollup_settings['cus_icon_pos']; ?>;
						color: <?php echo $npscrollup_settings['icon_color']; ?>;
	}
	#scrollUp:hover{color: <?php echo $npscrollup_settings['icon_h_color']; ?>;border:transparent}
	#np_main_icon:hover{
						background: <?php echo $npscrollup_settings['bg_h_color']; ?>  none repeat scroll 0% 0%;
						<?php  if( $npscrollup_settings['np_icon_broder']=='true'){?>
						border: 2px solid <?php echo $npscrollup_settings['icon_h_color']; ?>;
						<?php } ?>	
	}
	#np_linker{color:<?php echo $npscrollup_settings['bg_color']; ?>}					
	#npscroll_text_contaner_before{visibility:<?php echo $npscrollup_settings['display_opt']; ?>}					
	#np_linker:hover{color:<?php echo $npscrollup_settings['icon_h_color']; ?>}					
	
	/*Wide Mobile Layout:480px*/
	@media only screen and (min-width:480px)and (max-width:767px){
	
	#scrollUp{width:initial;}
		#np_main_icon{font-size:30px;}
		
	}
	/*Mobile Layout:320px*/
@media only screen and (max-width:767px){
	
		#scrollUp{<?php echo $npscrollup_settings['icon_position']; ?>: 10px;width:initial;bottom:35px;}
		#np_main_icon{font-size:25px;padding:8px 10px;}
	
}
</style>

<script type="text/javascript">
	/* scrollUp Minimum setup */
		jQuery(function () {
			jQuery.scrollUp({
			scrollName: 'scrollUp',
				animation: '<?php echo $npscrollup_settings['apper_animation']; ?>', // Fade, slide, none
				scrollText: ' <div id="npscroll_up_main_container"><i id="np_main_icon" class="fa fa-<?php echo $npscrollup_settings['style_four_icon']; ?>"> </i><div id="npscroll_text_contaner_before"><div id="npscroll_text_contaner">  <i id="np_linker" class="fa fa-ellipsis-v"></i><br /><span id="npscroll_text">Scroll To Top</span> </div></div></div>', // Text for element
				});
		});

		 jQuery(document).ready(function(){
		jQuery("#np_main_icon").mouseover(function(){
		jQuery("#npscroll_text_contaner").slideDown(400);
		});
		jQuery("#np_main_icon").mouseout(function(){
		jQuery("#npscroll_text_contaner").slideUp(400);
		});
		});
		
		
		
</script>
<?php
}
add_action('wp_head', 'np_custom_scrollup_active');

// Add settings link on plugin page
function your_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=npscrollup-settings.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'your_plugin_settings_link' );


?>