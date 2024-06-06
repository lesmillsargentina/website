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

get_header();
wp_enqueue_style('bodycontrol-integration', get_stylesheet_directory_uri() . '/bodycontrol-integration/css/main.css');
wp_enqueue_script('config', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/config.js');
wp_enqueue_script('base', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/base.js', array('config', 'jquery'));
wp_enqueue_script('eventos_inscripcion', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/eventosInscripcion.js', array('jquery', 'base'));
wp_enqueue_script('jquery-ui-autocomplete');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
$token = hash('ripemd160', $_GET['pId'] . $_GET['eId'] . $_GET['amnt'] . 'lMillsBody#33EPaypal');
if ($token !== $_GET['t']) die('Error, link invalido.');

$server = "https://bodysystemscontrol.com.ar";
//$server = "http://local.bodysystemscontrol.com.ar:81";
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

					<div class="container">

        <div class="row justify-content-center">

            <div class="col-sm-8" style="float:none; margin: 0 auto;">

                <h1>Abonar Evento LesMills Argentina</h1>

                <p><?= $_GET['desc'] ?> - USD $<?= $_GET['amnt'] ?></p>
                <p>Aguarde.... redireccionando al sitio de pago o visite el siguiente <a href="<?= $server ?>/paymentNotification/paypalEvento?eId=<?= $_GET['eId'] ?>&pId=<?= $_GET['pId'] ?>&amnt=<?= $_GET['amnt'] ?>&t=<?= $token ?>">enlace</a></p>


                <script>
                    location.href = "<?= $server ?>/paymentNotification/paypalEvento?eId=<?= $_GET['eId'] ?>&pId=<?= $_GET['pId'] ?>&amnt=<?= $_GET['amnt'] ?>&t=<?= $_GET['t'] ?>"
                </script>

            </div>

        </div>

        <br><br>

    </div>

				</main>
			</div>

            <?php if ( $layout != 'no-sidebar' ) { ?>
                <?php get_sidebar(); ?>
            <?php } ?>

		</div>
	</div>

<?php get_footer(); ?>