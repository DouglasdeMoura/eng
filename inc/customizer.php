<?php
/**
 * Eng Theme Customizer.
 *
 * @package Eng
 */

function eng_sanitize_setting_id( $setting_id, $prefix = '' ) {
	return $prefix . str_replace( '-', '_', sanitize_title( $setting_id ) );
}

function eng_customize_social_links( $prefix = 'eng' ) {
	
	return [
	'prefix' => $prefix,
	'items' => [
		'Facebook',
		'Twitter',
		'Google+',
		'Instagram',
		'GitHub'
	]];
}
 
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function eng_customize_register( $wp_customize ) {
	$prefix = eng_customize_social_links()['prefix'];
	$section_name = $prefix . '_social';
	$social_settings = eng_customize_social_links()['items'];
	
	$wp_customize->add_section( $section_name, [
		'title' => __('Social links', 'eng'),
		'priority' => 30
	]);
	
	array_map( function( $setting ) use ( $wp_customize, $section_name, $prefix ) {
		$setting_sanitized = eng_sanitize_setting_id( $setting, $prefix );
		$wp_customize->add_setting( $setting_sanitized, [
			'default'   => '',
			'transport' => 'refresh'
		]);
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			$setting_sanitized,
			[
				'label'    => __( $setting, 'eng' ),
				'section'  => $section_name,
				'settings' => $setting_sanitized,
				'type'     => 'url'
			]
		));
	}, $social_settings);
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'eng_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function eng_customize_preview_js() {
	wp_enqueue_script( 'eng_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'eng_customize_preview_js' );
