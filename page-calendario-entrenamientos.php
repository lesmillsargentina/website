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
wp_enqueue_script('calendario', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/calendario.js', array('jquery', 'base'));
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

                                        <div class="none">
                                            <input id="configInitEventsScript" type="hidden" value="true"/>
                                            <input id="configShowLesMillsModules" type="hidden" value="true"/>
                                            <input id="configShowLesMillsWorkshops" type="hidden" value="false"/>
                                            <input id="configShowLesMillsCourse" type="hidden" value="false"/>
                                            <input id="configShowEverlast" type="hidden" value="true"/>
                                            <input id="configShowCore360" type="hidden" value="false"/>
                                        </div>
                                        <!-- configs -->
                                        <div class="staticContent calendario"></div>
                                        <div class="content calendario row"></div>
                                        <div id="templates" style="display:none">

                                                <div class="col-12 col-md-3 tableContent lesMillsModule calendarioItem text-center">
                                                	<div class="calendarioItemBg">
                                                        <img class="alignnone size-full eventImage" alt="" src=""/>
                                                        <strong class="eventTitle"></strong>
                                                        <br class="brNote"/>
                                                        <span class="note"></span>
                                                        <br/>Lugar&nbsp;
                                                        <span class="gymName"></span>&nbsp;-&nbsp;
                                                        <span class="gymAddress"></span>
                                                        <span class="gymLocation"></span>.
                                                        <div class="eventTime">
                                                            Horario: de 
                                                            <span class="startTime"></span>Hs a 
                                                            <span class="endTime"></span>Hs
                                                        </div>  
                                                        <!-- <a class="inscripcion scheduleLink" href="" target="_blank">CRONOGRAMA</a> -->
                                                        <a class="inscripcion enrollmentLink" href="">INSCRIPCIÓN</a>
                                                        <div class="closedEnrollmentInfoBox">Inscripción ON LINE <b> cerrada </b>.<br>Para + info, hacé <a href="https://api.whatsapp.com/send/?phone=5491134423984"><strong>CLIC AQUÍ</strong></a></div>
                                                    </div>     
                                                </div>

                                        </div>
                                        <!-- end of templates -->

                                        <!-- WAITING STRATEGY -->
                                        <div id="waiting-strategy" style="display:none">
                                            <span class="loader"></span><br/>
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