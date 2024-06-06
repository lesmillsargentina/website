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
wp_enqueue_script('eventos_inscripcion', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/eventosInscripcion.js?v=3', array('jquery', 'base'));

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
                    <!--more--><input type="hidden" id="configInitEnrollmentScript" value="true" />

                    <?php
                    echo '<input id="configActivationId" type="hidden" value="' . ((isset($_GET["activationId"]) && $_GET["activationId"] != "") ? $_GET["activationId"] : "") . '"/>';
                    ?>


                    <?php
                    echo '<input id="configToken" type="hidden" value="' . ((isset($_GET["token"]) && $_GET["token"] != "") ? $_GET["token"] : "") . '"/>';
                    ?>

                    <input type="hidden" id="configWebLink" value="<?php echo get_permalink() ?>?activationId=@@ACTIVATION_ID@@&token=@@TOKEN@@" />
					<div class="content">
                                                <div class="inForm" method="get">
                                                    <div class="eventTitle"><strong>
                                                            <?php echo isset($_GET["eventTitle"]) ? $_GET["eventTitle"] : "" ?>
                                                        </strong></div>

                                                    <div id="stepInit" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">

                                                                <?php
                                                                echo '<input id="eventId" name="eventId" type="hidden" value="' . (isset($_GET["eventId"]) ? $_GET["eventId"] : "") . '"/>'
                                                                ?>

                                                                <div class="fleft middle firstMiddle">
                                                                    <div>
                                                                        <div>
                                                                            <div><select id="idNumberType"></select></div>
                                                                            <div><input id="idNumber" placeholder="Ingrese número" type="text" class="idNumberInput" /></div>
                                                                        </div>
                                                                        <div id="idNumberError" class="error" style="display:none"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="fleft middle text-right">
                                                                    <div class="captcha_wrapper" id="captchaContainer">
                                                                        <div class="g-recaptcha" data-sitekey="6LeHUjwUAAAAANVIlsoVgNbUERFf1hUuM-oyAJKP"></div>
                                                                    </div>
                                                                    <div id="captchaError" class="error" style="display:none">*El código de seguridad no es
                                                                        válido, escriba nuevamente.
                                                                    </div>
                                                                </div>

                                                                <div id="termConditionsContainer">
                                                                    
                                                                    <span><input id="termConditions" type="checkbox" /> He leído y acepto los <a href="https://www.lesmillsargentina.com.ar/concesion-temporaria-licencia-body-systems/">términos y condiciones de usos de los programas de entrenamiento Les Mills</a></span>
                                                                    Declaro estar en conocimiento de que para realizar un Entrenamiento de Programas Les Mills es necesario tener 18 años cumplidos y contar con experiencia previa en la enseñanza de clases colectivas. De no cumplir con este requisito, el interesado debe realizar primero el FiT, que es un seminario de Introducción. (Ver fechas previstas en la solapa de cursos de nuestra página <a href="https://www.lesmillsargentina.com.ar/calendario-entrenamientos/">https://www.lesmillsargentina.com.ar/calendario-entrenamientos/</a>) La Empresa se reserva el derecho de admisión y permanencia en cualquier evento. En caso que alguna participación sea denegada, se le reembolsara el dinero a la persona inscripta. Es necesaria la autorización previa de un gimnasio licenciado para participar de cualquier Módulo de Entrenamiento. Los datos que se completen en estos campos tienen carácter de declaración jurada. De no poder validar el vínculo con el Gimnasio, queda a criterio de La Empresa la decisión de permitir la participación en el evento de la persona inscripta y el eventual reembolso del pago. Si el interesado quiere participar de un Módulo de Entrenamiento por voluntad propia, es fundamental comunicarse previamente con la Empresa al menos una semana antes del evento que sea de su interés. Los pagos fuera de término, pueden sufrir recargos. La Empresa no se responsabiliza por la falta de materiales didácticos, cuando las inscripciones y pagos no son realizados antes del cierre de inscripción al evento. Las fechas de los eventos pueden sufrir modificaciones y eventuales cancelaciones. La entrega anticipada de un certificado médico avalando el Apto Físico del participante, es de carácter OBLIGATORIO, desvinculando a los organizadores de la responsabilidad por eventuales problemas ocurridos durante su participación en el evento. Si el participante no pudiera participar del evento por cualquier motivo personal o de salud, tendrá 90 días corridos para participar de un nuevo evento, sin posibilidad de reclamo una vez vencido el mencionado plazo. En caso de cancelación y/o anulación de la compra, los gastos correspondientes al kit digital y plataforma de capacitación serán absorbidos por comprador.
                                                                    Acepto la <a href="https://www.lesmillsargentina.com.ar/politica-de-privacidad-2/">política de privacidad de datos personales</a>.

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix buttonPosition"><a href="#" class="button right" id="continueInit">Continuar</a>
                                                        </div>

                                                    </div>
                                                    <p class="nodisplay">
                                                        <!-- end of stepInit -->
                                                    </p>


                                                    <div id="stepConfirmName" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">
                                                                <input id="confirmNameEventId" name="eventId" type="hidden" value="" />
                                                                <input id="confirmNamePersonId" name="personId" type="hidden" />
                                                                <input id="confirmNameToken" type="hidden" />

                                                                <div>
                                                                    ¿Confirma usted que es <b id="confirmNameName"></b> ?
                                                                </div>
                                                                <div>
                                                                    El email registrado es <b id="confirmPersonMail"></b>
                                                                </div>
                                                                <div>
                                                                    Por favor mantenga sus datos actualizados poniendose en contacto con <a href="mailto:instructores@lesmillsarg.com">instructores@lesmillsarg.com</a>
                                                                </div>
                                                                <div>
                                                                    <span style='color:#ff0000'>
                                                                        ATENCIÓN: antes de finalizar la inscripción, corroborá que tu casilla de correo sea correcta, ya que es la cuenta que será relacionada a la plataforma digital de descargas!
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="clearfix buttonPosition">
                                                            <a href="#" class="button right" id="cancelStepConfirmName">Cancelar</a><a href="#" class="button right" id="continueStepConfirmName">Continuar</a>
                                                        </div>

                                                    </div>
                                                    <p class="nodisplay">
                                                        <!-- end of stepConfirmName -->
                                                    </p>


                                                    <div id="stepRegister" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div>
                                                                <input id="registerEventId" name="eventId" type="hidden" value="" />
                                                                <input id="registerToken" type="hidden" />

                                                                <div class="pad-bot">
                                                                    Su dni no está registrado, por favor complete sus datos:
                                                                </div>


                                                                <div class="row">
                                                                    <div class="col-12 col-md-3">
                                                                        <input placeholder="Nombre *" class="medium" name="name" id="registerName" type="text" />

                                                                        <div id="registerNameError" class="error" style="display:none"></div>
                                                                    </div>
                                                                    <div class="col-12 col-md-3">
                                                                        <input class="medium" placeholder="Apellido *" name="lastname" id="registerLastName" type="text" />

                                                                        <div id="registerLastNameError" class="error" style="display:none"></div>
                                                                    </div>
                                                                    <div class="col-12 col-md-3">

                                                                        <input id="registerIdNumberText" type="text" class="idNumberInput" disabled="disabled" />
                                                                        <input id="registerIdNumber" type="hidden" />
                                                                        <input id="registerIdNumberTypeId" type="hidden" />

                                                                    </div>
                                                                    <div class="col-12 col-md-3">
                                                                        <input placeholder="Email *" id="registerEmail1" type="text" />

                                                                        <div id="registerEmail1Error" class="error" style="display:none"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-3">
                                                                        <input placeholder="Celular *" class="small" id="registerMobile" type="text" />

                                                                        <div id="registerMobileError" class="error" style="display:none"></div>
                                                                    </div>
                                                                    <div class="col-12 col-md-3">
                                                                        <div class="region-container">
                                                                            <div class="search">
                                                                                <a href="#" class="icon" title="Buscar"></a>
                                                                                <input placeholder="Pais, Estado, Ciudad, Localidad *" id="registerRegionSearch" type="text" />
                                                                                <input id="registerRegionSearchCheck" type="hidden">
                                                                                <input id="registerCountry" type="hidden">
                                                                                <input id="registerState" type="hidden">
                                                                                <input id="registerCity" type="hidden">
                                                                                <input id="registerLocality" type="hidden">
                                                                            </div>
                                                                            <div id="registerRegionError" class="error" style="display:none"></div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-3">
                                                                        <input placeholder="Dirección *" name="registerAddress" id="registerAddress" type="text" />

                                                                        <div id="registerAddressError" class="error" style="display:none"></div>
                                                                    </div>
                                                                </div>

                                                                <!-- COMIENZO CAMPOS DEPRECADOS-->
                                                                <div style="display:none">
                                                                    <div>
                                                                        <label for="name">Género</label>

                                                                        <div class="radioContainer">
                                                                            <input id="registerGenderFemale" value="F" class="registerGender" type="radio" checked="checked" name="registerGender" />
                                                                            Femenino
                                                                            <input id="registerGenderMasc" value="M" class="registerGender" type="radio" name="registerGender" /> Masculino
                                                                        </div>
                                                                    </div>

                                                                    <div>
                                                                        <label>CUIT</label>
                                                                        <input class="small" id="registerCUIT" type="text" />

                                                                        <div id="registerCUITError" class="error" style="display:none"></div>
                                                                    </div>

                                                                    <div>
                                                                        <label for="birthDate">Fecha de nacimiento *</label>
                                                                        <input class="isDatePicker small" id="registerBirthDate" type="text" />

                                                                        <div id="registerBirthDateError" class="error" style="display:none"></div>
                                                                    </div>

                                                                    <div>
                                                                        <label for="nationality">Nacionalidad *</label>
                                                                        <input class="small" id="registerNationality" type="text" />

                                                                        <div id="registerNationalityError" class="error" style="display:none"></div>
                                                                    </div>


                                                                    <div>
                                                                        <label for="registerPostalCode">Código Postal
                                                                            *</label>
                                                                        <input name="registerPostalCode" id="registerPostalCode" type="text" />

                                                                        <div id="registerPostalCodeError" class="error" style="display:none"></div>
                                                                    </div>
                                                                    <div>
                                                                        <label for="telephone">Tel. particular</label>
                                                                        <input class="small" id="registerPhoneNumber1" type="text" />
                                                                    </div>
                                                                    <div>
                                                                        <label for="CommercialTelephone">Tel.
                                                                            comercial</label>
                                                                        <input class="small" id="registerPhoneNumber2" type="text" />
                                                                    </div>
                                                                    <div>
                                                                        <label for="mobile">Nextel</label>
                                                                        <input class="small" id="registerNextel" type="text" />
                                                                    </div>
                                                                    <div>
                                                                        <label for="mobile">Skype</label>
                                                                        <input class="small" id="registerSkype" type="text" />
                                                                    </div>
                                                                    <div>
                                                                        <label for="mobile">Fax</label>
                                                                        <input class="small" id="registerFaxNumber" type="text" />
                                                                    </div>

                                                                    <div>
                                                                        <label for="email">Email Alternativo</label>
                                                                        <input id="registerEmail2" type="text" />

                                                                        <div id="registerEmail2Error" class="error" style="display:none"></div>
                                                                    </div>
                                                                    <div>
                                                                        <label for="email">Web</label>
                                                                        <input id="registerWeb" type="text" class="small" />
                                                                    </div>
                                                                    <div>
                                                                        <label for="email">Facebook</label>
                                                                        <input class="small" id="registerFacebook" type="text" />
                                                                    </div>
                                                                    <div>
                                                                        <label for="email">Twitter</label>
                                                                        <input class="small" id="registerTwitter" type="text" />
                                                                    </div>
                                                                </div>
                                                                <!-- FIN CAMPOS DEPRECADOS-->


                                                            </div>
                                                        </div>
                                                        <div class="clearfix buttonPosition">
                                                            <a href="#" class="button right" id="continueStepRegister">Continuar</a>
                                                            <a href="#" class="button right secondary" id="cancelStepRegister">Cancelar</a>
                                                        </div>

                                                    </div>
                                                    <p class="nodisplay">
                                                        <!-- end of stepConfirmName -->
                                                    </p>

                                                    <div id="stepConfirmGymName" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">
                                                                <input id="confirmGymNameParticipantId" type="hidden" />
                                                                <input id="confirmGymNameToken" type="hidden" />

                                                                <div>
                                                                    Ingrese los datos del gimnasio por el que usted se está
                                                                    registrando
                                                                </div>
                                                                <div>
                                                                    <input placeholder="Nombre del gimnasio" class="medium" name="name" id="confirmGymNameName" type="text" />

                                                                    <div>
                                                                        <input class="medium" name="name" id="confirmGymNameIsAutonomo" onchange="confirmGymNameIsAutonomoChange()" type="checkbox" />
                                                                        <span>Soy Autónomo</span>
                                                                    </div>
                                                                    <div id="confirmGymNameNameError" class="error" style="display:none"></div>
                                                                </div>
                                                                <div>
                                                                    <input placeholder="Nombre del responsable" class="medium" name="name" id="confirmGymNameResponsible" type="text" />

                                                                    <div id="confirmGymNameResponsibleError" class="error" style="display:none"></div>
                                                                </div>
                                                                <div>
                                                                    <input placeholder="Teléfono del responsable" class="medium" name="name" id="confirmGymNamePhone" type="text" />

                                                                    <div id="confirmGymNamePhoneError" class="error" style="display:none"></div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="clearfix buttonPosition">
                                                            <a href="#" class="button right" id="continueStepConfirmGymName">Continuar</a>
                                                        </div>

                                                    </div>
                                                    <!-- end of stepConfirmGymName -->


                                                    <div id="stepAlreadyEnrolled" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">
                                                                <div>
                                                                    Usted ya estaba inscripto en este evento.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="nodisplay">
                                                        <!-- end of stepAlreadyEnrolled -->
                                                    </p>

                                                    <div id="stepValidateEmail" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <input id="validateEmailEventId" type="hidden" />
                                                            <input id="validateEmailPersonId" type="hidden" />
                                                            <input id="validateEmailToken" type="hidden" />

                                                            <div>
                                                                Su dirección de correo electrónico no ha sido activada para
                                                                las inscripciones online. <br />
                                                                Por favor ingrese su dirección de correo y haga click en
                                                                continuar.<br />
                                                                Usted recibirá un email con un link para activar la cuenta.
                                                            </div>
                                                            <div>
                                                                <input placeholder="Email" class="medium" id="validateEmailEmail" type="text" />

                                                                <div id="validateEmailEmailError" class="error" style="display:none"></div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix buttonPosition">
                                                            <a href="#" class="button right" id="continueStepValidateEmail">Continuar</a>
                                                        </div>
                                                    </div>
                                                    <!-- end of stepValidateEmail -->

                                                    <div id="stepShowCheckMailBox" class="filter enrollmentStep messageStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">
                                                                <div>
                                                                    Hemos enviado un email a su casilla de correo: <b id="checkMailBoxMail"></b>.
                                                                </div>
                                                                <div>
                                                                    Por favor abra su correo y haga click en el link que se
                                                                    encuentra allí para activar la inscripción ON LINE.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end of stepShowCheckMailBox-->

                                                    <div id="stepShowActivationCodeUsed" class="filter enrollmentStep messageStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">
                                                                <div>
                                                                    Usted ya utilizó este código de activación.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end of stepShowActivationCodeUsed-->


                                                    <div id="stepNoValidParticipant" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">
                                                                <div>
                                                                    Usted no posee las condiciones necesarias para
                                                                    inscribirse en el Evento vía web. Porfavor comuníquese
                                                                    con nosotros.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="nodisplay">
                                                        <!-- end of stepAlreadyEnrolled -->
                                                    </p>

                                                    <div id="stepConfirmPrograms" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">
                                                                <input id="confirmProgramsParticipantId" name="personId" type="hidden" />
                                                                <input id="confirmProgramsToken" type="hidden" />

                                                                <div class="programsContainer">
                                                                    <h3 class="program-selection">Seleccione los programas a inscribirse<span>Cod</span></h3>

                                                                    <div id="stepConfirmProgamsSelections">
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="BP" /><span id="code_BP" class="programCode"></span><img alt="BODYPUMP" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-pump.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="BA" /><span id="code_BA" class="programCode"></span><img alt="BODYATTACK" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-attack.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="BC" /><span id="code_BC" class="programCode"></span><img alt="BODYCOMBAT" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-combat.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="BV" /><span id="code_BV" class="programCode"></span><img alt="BODYVIVE" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-vive.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="BB" /><span id="code_BB" class="programCode"></span><img alt="BODYBALANCE" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-balance.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="RPM" /><span id="code_RPM" class="programCode"></span><img alt="RPM" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-rpm.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="BJ" /><span id="code_BJ" class="programCode"></span><img alt="BODYJAM" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-jam.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="SH" /><span id="code_SH" class="programCode"></span><img alt="SH'BAM" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-shbam.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="BS" /><span id="code_BS" class="programCode"></span><img alt="BODYSTEP" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-step.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection" value="CX" /><span id="code_CX" class="programCode"></span><img alt="CXWORX" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-cxworx.jpg" ?>">
                                                                        </div>
                                                                        <div><input type="checkbox" name="programSelection[]" class="programSelection pjSelection" value="PJ" /><span id="code_PJ" class="programCode"></span><img alt="POWERJUMP" src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/PJ_white_98x36.png" ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="program-legend">
                                                                El valor será calculado según la cantidad de programas actualizados.
                                                                Si no aparece alguno de tus programas, por favor entra en contacto con <a href="mailto:instructores@lesmillsarg.com?Subject=Actualización%20de%20datos" target="_top">instructores@lesmillsarg.com</a> para habilitarlos.
                                                                </div>
                                                            </div>
                                                            <!-- end of fieldsContainer-->
                                                            <div class="value">
                                                                <span>Total: $ </span>
                                                                <span id="confirmProgramsValue"></span>
                                                            </div>
                                                        </div>
                                                        <!-- end of filterFields-->
                                                        <div class="clearfix buttonPosition">
                                                            <a href="#" class="button right" id="continueStepConfirmPrograms">Continuar</a>
                                                        </div>
                                                    </div>
                                                    <!-- end of continueStepConfirmPrograms-->

                                                    <div id="stepShowConfirmation" class="filter enrollmentStep" style="display:none;">
                                                        <div class="filterFields clearfix">
                                                            <div class="left fieldsContainer">
                                                                <div class="confirmEmailContainer" style="">Hemos enviado un
                                                                    email a su casilla: <b class="confirmEmail"></b> por
                                                                    favor verifica su recepción, y no olvides revisar en la bandeja de correo no deseado. En caso de no recibir el
                                                                    correo escriba a <a href="mailto:instructores@lesmillsarg.com">instructores@lesmillsarg.com</a> para
                                                                    actualizar sus datos.
                                                                    <br />
                                                                    <span style="color:red">
                                                                        ATENCIÓN: antes de finalizar la inscripción, corroborá que tu casilla de correo sea correcta, ya que es la cuenta que será relacionada a la plataforma digital de descargas!
                                                                    </span>
                                                                </div>
                                                                <div class="confirmed">Completaste el <span class="paymentMethodsFirstStep" style="color:red">1er paso</span>
                                                                    <span class="paymentMethodsFirstStep">del</span> proceso
                                                                    de inscripción al evento: <span class="eventTitle"></span>
                                                                </div>

                                                                <div class="confirmed">
                                                                    El <span style="color:red">2do paso</span> es
                                                                    realizar el pago de <b id="showConfirmationValue">##########</b> haciendo click en el botòn de pago abajo.
                                                                </div>

                                                                <div class="confirmed">
                                                                    <div>El <span style="color:red">3er paso</span>
                                                                        una vez acreditado el pago, te llegará el acceso al contenido por mail.
                                                                        Cualquier duda o consulta, entra en contacto con <a href="mailto:instructores@lesmillsarg.com">instructores@lesmillsarg.com</a>

                                                                        <br />
                                                                        <br />
                                                                        <div id="mercadoPagoSection">
                                                                            <div class="clearfix buttonPosition">
                                                                                <a id="mercadoPagoPoint" href="" class="button left">Pagar con Mercado Pago</a>
                                                                            </div>
                                                                        </div>

                                                                        <div id="paypalSection" style="width:150px;">

                                                                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                                                                <input type="hidden" name="cmd" value="_xclick">
                                                                                <input type="hidden" name="business" value="crisperez@bodysystems.org">
                                                                                <input type="hidden" name="lc" value="US">
                                                                                <input type="hidden" id="paypalDescription" name="item_name" value="">
                                                                                <input type="hidden" id="paypalValue" name="amount" value="Bodycontrol">
                                                                                <input type="hidden" name="currency_code" value="USD">
                                                                                <input type="hidden" name="notify_url" value="http://bodysystemscontrol.com.ar/paymentNotification/paypalIpn">
                                                                                <input type="hidden" name="return" value="http://lesmillsargentina.com.ar/pago-confirmado/">
                                                                                <input type="hidden" name="button_subtype" value="services">
                                                                                <input type="hidden" id="refPaypal" name="custom" value="">
                                                                                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
                                                                                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                                                                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                                                            </form>

                                                                        </div>



                                                                        <div class="paymentMethodsTitle">
                                                                        </div>
                                                                        <div class="paymentMethods">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="nodisplay">
                                                                <!-- end of stepShowConfirmation -->
                                                        </div>
                                                        <!-- end of in -->
                                                    </div>

                                                    <!-- WAITING STRATEGY -->
                                                    <div id="waiting-strategy" style="display:none">
                                                        <span class="bg"></span><span class="loader"></span>
                                                    </div>
                                                    <!-- WAITING STRATEGY -->

                                                    <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'cordillera') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
                                                </div>
                                            </div>
				</main>
			</div>

            <?php if ( $layout != 'no-sidebar' ) { ?>
                <?php get_sidebar(); ?>
            <?php } ?>

		</div>
	</div>

<?php get_footer(); ?>