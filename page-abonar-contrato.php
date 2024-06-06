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
define('IVA_COEFFICIENT', 0.21);

$token = hash('ripemd160', $_GET['to'] . $_GET['b'] . $_GET['amnt'] . $_GET['v'] . $_GET['tna'] . 'lMillsBody#33');
if ($token !== $_GET['t']) die('Error, link invalido.');

date_default_timezone_set('America/Argentina/Buenos_Aires');

// calculamos intereses solo como render, no valida nada
$intereses = [5, 10, 20];
$date = new DateTime();

$dateFactura = new DateTime(substr($_GET['v'], 0, 7) . "-" . $intereses[0]);
$dateFacturaVencimiento1 = new DateTime(substr($_GET['v'], 0, 7) . "-" . $intereses[1]);
$dateFacturaVencimiento2 = new DateTime(substr($_GET['v'], 0, 7) . "-" . $intereses[2]);

$fecha1 = $dateFactura->format("d/m/Y");
$fecha2 = $dateFacturaVencimiento1->format("d/m/Y");
$fecha3 = $dateFacturaVencimiento2->format("d/m/Y");

if ($date <= $dateFactura) {
    $dateVencimiento = $dateFactura;
} else if ($date <= $dateFacturaVencimiento1) {
    $dateVencimiento = $dateFacturaVencimiento1;
} else if ($date <= $dateFacturaVencimiento2) {
    $dateVencimiento = $dateFacturaVencimiento2;
} else {
    $dateVencimiento = $date;
}

$server = "https://bodysystemscontrol.com.ar";
//$server = "http://local.bodysystemscontrol.com.ar:81";


/**
 * Calcula el interes del monto de la factura y agrega el IVA
 * @param $intereses Los dias limite de intereses, el primero es 0%, sale de array de config
 * @param $rango emite el valor con interes para la fecha indicada, 1ra o 2da fecha de interes (para mails) - el dia del array de intereses
 */
function getInteres($montoTotal, $rango = false)
{
    $date = new DateTime(date('Y-m-d 00:00:00'));
    $tna = $_GET['tna'];
    $intereses = [5, 10, 20];
    $dateFactura = new DateTime(substr($_GET['v'], 0, 7) . "-" . $intereses[0]);

    $montoTotal = (float)filter_var($montoTotal, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $interesDiario = ($tna / 360);
    if ($rango !== false) {
        $dias = $intereses[$rango] - $intereses[0];
    } else {
        $dias = $date->diff($dateFactura)->days;
    }

    $interesAplicar = $interesDiario * $dias;

    return (((($interesAplicar * $montoTotal) / 100) * (1 + IVA_COEFFICIENT)) + $montoTotal);
}


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

                <h1>Abonar Contrato de Licencia LesMills Argentina</h1>

                <p><?= $_GET['rs'] ?> <br /> <?= $_GET['g'] ?></p>

                <?php if ($date > $dateFactura) { ?>
                    <p><em style="color:red">La factura se encuentra vencida.</em> </p>

                    <?php if ($date <= $dateFacturaVencimiento2) { ?>
                        <p>
                            Vencimiento <?= $fecha1 ?>: $<?= $_GET['amnt'] ?><br />
                            Vencimiento <?= $fecha2 ?>: $<?= number_format(getInteres($_GET['amnt'], 1), 2, ',', '.') ?><br />
                            Vencimiento <?= $fecha3 ?>: $<?= number_format(getInteres($_GET['amnt'], 2), 2, ',', '.') ?><br />

                        </p>
                    <? } else { ?>
                        Total de la factura a la fecha: $<?= number_format(getInteres($_GET['amnt'], false), 2, ',', '.') ?><br />
                    <? } ?>
                    <a href="<?php echo $server ?>/paymentNotification/mercadoPagoContrato?to=<?= $_GET['to'] ?>&billId=<?= $_GET['b'] ?>" class="btn btn-primary btn-block">
                        Abonar Licencia
                    </a>
                <? } else { ?>
                    <?php
                    // pago parcial
                    if ($_GET["su"] == 0) { ?>
                        <a href="<?= $server ?>/paymentNotification/mercadoPagoContrato?to=<?= $_GET['to'] ?>&billId=<?= $_GET['b'] ?>" class="btn btn-primary btn-block">
                            Abonar Licencia $<?= $_GET['amnt'] ?>
                        </a>
                    <? } else { ?>
                        <p>Tu factura vence el <?= $dateVencimiento->format('d/m/Y') ?></p>

                        <a href="<?= $server ?>/paymentNotification/mercadoPagoSus?to=<?= $_GET['to'] ?>&billId=<?= $_GET['b'] ?>" class="btn btn-primary btn-block">
                            Suscribirme y Abonar Licencia $<?= $_GET['amnt'] ?>
                        </a>
                        <br />

                        <p>
                            O podés realizar solo el pago de éste mes haciendo
                            <a href="<?= $server ?>/paymentNotification/mercadoPagoContrato?to=<?= $_GET['to'] ?>&billId=<?= $_GET['b'] ?>" title="<?= $_GET['desc'] ?>" style="color: #000">
                                click aquí
                            </a>.
                        </p>

                        <hr>

                        <p>
                            Vencimiento <?= $fecha1 ?>: $<?= $_GET['amnt'] ?><br />
                            Vencimiento <?= $fecha2 ?>: $<?= number_format(getInteres($_GET['amnt'], 1), 2, ',', '.') ?><br />
                            Vencimiento <?= $fecha3 ?>: $<?= number_format(getInteres($_GET['amnt'], 2), 2, ',', '.') ?><br />

                        </p>
                    <? } ?>

                <? } ?>

            </div>

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