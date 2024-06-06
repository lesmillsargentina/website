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

                <h1>Contrato de Licencia LesMills Argentina</h1>

                <p>Usted ya posee una suscripción activa. El último pago se efectuó el día <?= $_GET['lastp'] ?></p>

                <p>El siguiente pago será el día <?= $_GET['nextp'] ?></p>



            </div>

        </div>

        <br><br>

    </div>

    <style>
        .p-cust {
            margin: 15px 0;
        }

        #checkout-btn {
            width: auto;
            padding: 5px 15px;
        }

        .expiration-date input {
            width: 45%;
            display: inline-block;
            float: left;
        }

        .expiration-date .date-separator {
            display: inline-block;
            float: left;
            margin: 5px 8px;
        }
    </style>

				</main>
			</div>

            <?php if ( $layout != 'no-sidebar' ) { ?>
                <?php get_sidebar(); ?>
            <?php } ?>

		</div>
	</div>

<?php get_footer(); ?>