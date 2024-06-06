<?php
/**
 * The header for the OnePress theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OnePress
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
	<link rel='stylesheet' id='uncodefont-google-css' href='//fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2Cregular%2Citalic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%7COswald%3A200%2C300%2Cregular%2C500%2C600%2C700&#038;subset=vietnamese%2Ccyrillic-ext%2Cgreek%2Clatin-ext%2Clatin%2Ccyrillic%2Cgreek-ext&#038;ver=2.8.10' type='text/css' media='all' />
</head>

<body <?php body_class(); ?>>
			<div class="top-bar">
			<div class="container">
				<div class="link-left">
					<a href="https://www.lesmillsargentina.com.ar/eclubonline/">E-CLUB</a>&nbsp;|&nbsp;
					<a href="https://www.lesmillsargentina.com.ar/buscar-gimnasios-e-instructores/">GIMNASIOS/INSTRUCTORES</a>&nbsp;&nbsp;
					<a class="social" href="https://www.facebook.com/lesmillsargentina" target="_blank"><i class="fa fa-facebook"></i></a>
		            <a class="social" href="http://instagram.com/lesmillsargentina" target="_blank"><i class="fa fa-instagram"></i></a>
		            <a class="social" href="https://www.youtube.com/user/LesMillsArgentina" target="_blank"><i class="fa fa-youtube"></i></a>
				</div>
				<nav class="site-nav" role="navigation">
					<?php 
					 wp_nav_menu(array('items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s <li class="main-search-item">
							<a href="javascript:;">
								<i class="fa fa-search site-search-toggle"></i>
							</a>
							'.get_search_form().'
						</li></ul>'));
					?>
				</nav>
			</div>				
		</div>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>
<?php do_action( 'onepress_before_site_start' ); ?>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'onepress' ); ?></a>
	<?php
	/**
	 * @since 2.0.0
	 */
	onepress_header();
	?>
