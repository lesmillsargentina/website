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
wp_enqueue_script('eclub', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/eclub.js', array('jquery', 'base'));
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
                <div class="row">
                    <div class="<?php echo $column_class_one; ?>">
                        <section class="blog-main text-center" role="main">
                            <article class="post-entry text-left">
                                <div class="entry-main">
                                    <div class="entry-content">

                                        <input type="hidden" id="configInitEclubScript" value="true"/>
                                        <?php
                                        echo '<input type="hidden" id="configToken" value="' . (isset($_GET["token"]) && $_GET["token"] != "") ? $_GET["token"] : "" . '" />';
                                        ?>

                                        <div class="content">
                                            <div class="in">
                                                <div id="stepInit" class="filter eclubStep" style="display:none;">
													<div class="container">
														<div class="row">
															<div class="col-12 col-md-6 no-pad-left">
																<h3>Bienvenidos al E-Club - Herramientas de Marketing</h3>
																<p>
																Para crear eventos de lanzamiento emocionantes o una
                                                                nueva unidad de negocio, Les Mills Argentina entrega
                                                                todos los materiales de marketing necesarios para atraer
                                                                nuevos clientes e inspirar a los ya existentes.
                                                                Descargá desde aqui, toda la gráfica de los programas
                                                                que tu gimnasio utiliza, y hacé de tus clases una
                                                                experiencia memorable.																	
																</p>
																<div class="filterFields clearfix">
																	<div class="left fieldsContainer">
																		<div>
																			<input id="userName" name="userName" type="text"
																				   class="" placeholder="Usuario"/>

																			<div id="userNameError" class="error"
																				 style="display:none"></div>
																		</div>

																		<div>
																			<input id="password" name="password" type="password"
																				   class="" placeholder="Contraseña"/>

																			<div id="passwordError" class="error"
																				 style="display:none"></div>
																		</div>
																	</div>
																</div>
																<div class="clearfix buttonPosition"><a href="#"
																										class="button"
																										id="continueInit">Continuar</a>
																</div>																
															</div>
															<div class="col-12 col-md-6 image-right">
																<img src="http://www.lesmillsargentina.com.ar/redesign/img/generico.jpg" alt="Eclub">
															</div>	
														</div>
													</div>


                                                </div>
												<br><br>
                                                <!-- end of stepInit -->


                                                <div id="stepEclub" class="filter eclubStep" style="display:none;">
                                                    <input type="hidden" id="token" value=""/>
                                                    <input type="hidden" id="activePrograms" value=""/>
                                                    <input type="hidden" id="gymId" value=""/>

                                                    <div class="grayBg programs lolo"><h4>PROGRAMAS</h4>

                                                        <div><a href="#" class="ALL" data-program-code="ALL">Les Mills
                                                                Argentina</a><a href="#" class="BA"
                                                                                data-program-code="BA">BODYATTACK®</a><a
                                                                href="#" class="BB"
                                                                data-program-code="BB">BODYBALANCE®</a><a href="#"
                                                                                                          class="BC"
                                                                                                          data-program-code="BC">BODYCOMBAT®</a><a
                                                                href="#" class="BJ"
                                                                data-program-code="BJ">BODYJAM®</a><a href="#"
                                                                                                      class="BP"
                                                                                                      data-program-code="BP">BODYPUMP®</a><a
                                                                href="#" class="BS" data-program-code="BS">BODYSTEP®</a><!--a href="#" class="BV" data-program-code="BV">BODYVIVE®</a--><a
                                                                href="#" class="RPM" data-program-code="RPM">RPM®</a><a
                                                                href="#" class="SH" data-program-code="SH">SH’BAM®</a><a
                                                                href="#" class="CX" data-program-code="CX">CXWORX®</a><a
                                                                href="#" class="PJ"
                                                                data-program-code="PJ">POWERJUMP®</a></div>
                                                    </div>

                                                    <div id="albums">
                                                        <?php
                                                        $CONFIG_THUMBS_DIRECTORY = get_stylesheet_directory_uri() . "/bodycontrol-integration/upload/eclub/";

                                                        $eclub = simplexml_load_file(get_stylesheet_directory() . '/bodycontrol-integration/upload/eclubConfiguration.xml');

                                                        foreach ($eclub->program as $program) {
                                                            echo '<div class="' . $program['code'] . ' programAlbum">';
                                                            foreach ($program->category as $category) {
                                                                echo '<h4>' . $category['name'] . '</h4>';
                                                                echo '<div class="grayBg">';
                                                                foreach ($category->image as $image) {
                                                                    echo '<div class="eclublink">';
                                                                    echo '<a href="#" class="eclubimage" data-imageserver="' . $image->imageserver . '" data-program-code="' . $program['code'] . '">';
                                                                    echo '<img src="' . $CONFIG_THUMBS_DIRECTORY . $program['code'] . '/' . $image->web . '" class="alignnone size-full wp-image-407" />';
                                                                    echo '<div>' . $image->leyend . '</div>';
                                                                    echo '</a></div>'; /* END of  eclubimage and eclublink */
                                                                } /* END OF IMAGE */
                                                                echo '</div>'; /*END OF grayBg*/
                                                            } /* END OF CATEGORY */
                                                            echo '</div>'; /*END OF programAlbum*/
                                                        } /* END OF PROGRAM */
                                                        ?>
                                                    </div>
                                                    <!-- end of albums -->
                                                </div>
                                                <!-- end of stepEclub -->

                                            </div>
                                            <!-- end of in -->
                                        </div>

                                        <!-- WAITING STRATEGY -->
                                        <div id="waiting-strategy" style="display:none">
                                            <span class="loader"></span><br>
                                            <span class="bg"></span>
                                        </div>
                                        <!-- WAITING STRATEGY -->

                                        <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'cordillera') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </article>
                            <div class="comments-area text-left">
                                <?php
                                echo '<div class="comment-wrapper">';
                                comments_template();
                                echo '</div>';
                                ?>
                            </div>
                        </section>
                    </div>
                    <?php if ($cordillera_sidebar == "left" || $cordillera_sidebar == "both") { ?>
                        <div class="<?php echo $column_class_two; ?>">
                            <aside class="blog-side left text-left">
                                <div class="widget-area">
                                    <?php get_sidebar("pageleft"); ?>
                                </div>
                            </aside>
                        </div>
                    <?php } ?>
                    <?php if ($cordillera_sidebar == "right" || $cordillera_sidebar == "both") { ?>
                        <div class="<?php echo $column_class_three; ?>">
                            <aside class="blog-side right text-left">
                                <div class="widget-area">

                                    <?php get_sidebar("pageright"); ?>
                                </div>
                            </aside>
                        </div>
                    <?php } ?>

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
