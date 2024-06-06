<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */



error_log("===========EMPIEZA==============");
error_log(print_r($_SERVER['HTTP_USER_AGENT'], true));
error_log(print_r($_GET, true));
if (strpos($_SERVER['HTTP_USER_AGENT'], "MercadoPago WebHook") !== false) {
    //error_log("Sleep 5s al webhook de MP!");
    //sleep(5);
    error_log("Webhook die!");
    die("Ok");
}
$fitco = "";
if (isset($_GET['fitco'])) {
    $fitco = "&fitco={$_GET['fitco']}";
}
if (isset($_GET['m1'])) {
    $fitco = "&m1={$_GET['m1']}";
}
if (strpos($_SERVER['HTTP_USER_AGENT'], "MercadoPago") !== false && isset($_GET['data_id']) && isset($_GET['type'])) {
    wp_remote_get("http://www.bodysystemscontrol.com.ar/paymentNotification/mercadoPagoIpn?data_id={$_GET['data_id']}&type={$_GET['type']}{$fitco}");
    //wp_remote_get("http://staging.bodysystemscontrol.com.ar/paymentNotification/mercadoPagoIpn?data_id={$_GET['data_id']}&type={$_GET['type']}{$fitco}");
    //wp_remote_get("http://local.bodysystemscontrol.com.ar:81/paymentNotification/mercadoPagoIpn?data_id={$_GET['data_id']}&type={$_GET['type']}{$fitco}");
    error_log("ejecuta a: {$_GET['data_id']}");
    error_log("==========FIN===============");
    die('Ok');
} else if (strpos($_SERVER['HTTP_USER_AGENT'], "MercadoPago") !== false && isset($_GET['id']) && isset($_GET['topic'])) {
    wp_remote_get("http://www.bodysystemscontrol.com.ar/paymentNotification/mercadoPagoIpn?data_id={$_GET['id']}&type={$_GET['topic']}{$fitco}");
    //wp_remote_get("http://staging.bodysystemscontrol.com.ar/paymentNotification/mercadoPagoIpn?data_id={$_GET['id']}&type={$_GET['topic']}{$fitco}");
    //wp_remote_get("http://local.bodysystemscontrol.com.ar:81/paymentNotification/mercadoPagoIpn?data_id={$_GET['id']}&type={$_GET['topic']}{$fitco}");
    error_log("ejecuta b: {$_GET['id']}");
    error_log("============FIN=============");
    die('Ok');
} else {
    error_log("No es MP");
}
get_header();
wp_enqueue_style('bodycontrol-integration', get_stylesheet_directory_uri() . '/bodycontrol-integration/css/main.css');
wp_enqueue_script('config', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/config.js');
wp_enqueue_script('base', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/base.js', array('config', 'jquery'));
wp_enqueue_script('eventos_inscripcion', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/eventosInscripcion.js', array('jquery', 'base'));

wp_enqueue_script('jquery-ui-autocomplete');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
$layout = onepress_get_layout();

/**
 * @since 2.0.0
 * @see onepress_display_page_title
 */
do_action( 'onepress_page_before_content' );

?>
	<div id="content" class="site-content">
        <?php onepress_breadcrumb(); ?>
		<div id="content-inside" class="container <?php echo esc_attr( $layout ); ?>">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<script src='https://www.google.com/recaptcha/api.js'></script>
                    <div class="container">
                        <h1>Pago Confirmado</h1>
                    </div>
				</main>
			</div>

            <?php if ( $layout != 'no-sidebar' ) { ?>
                <?php get_sidebar(); ?>
            <?php } ?>

		</div>
	</div>

<?php get_footer(); ?>