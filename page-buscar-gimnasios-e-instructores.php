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
wp_enqueue_script('buscar_gimnasios', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/buscarGimnasios.js', array('jquery', 'base'));

wp_enqueue_style('jquery-ui-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
wp_enqueue_script('jquery-ui-autocomplete');
wp_enqueue_script('tablesorter', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/lib/jquery.tablesorter.min.js', array('jquery'));
wp_enqueue_style('tablesorter', get_stylesheet_directory_uri() . '/bodycontrol-integration/css/tablesorter/tablesorter.css', array('jquery-ui-style'));
wp_enqueue_script('fixheadertable', get_stylesheet_directory_uri() . '/bodycontrol-integration/js/lib/jquery.fixheadertable.min.js', array('jquery'));
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
  <hr>
    <div class="row">
      <div class="<?php echo $column_class_one; ?>">
        <section class="blog-main text-center" role="main">
          <article class="post-entry text-left">
            <div class="entry-main">
              <div class="entry-content">
                <input id="configInitSearchGymsScript" value="true" type="hidden"/>
                <div class="in">
                  <div class="filter">
                    <div class="filterFields clearfix" id="formSearch">
                    <div class="row">
                    	<div class="col-12 col-md-6">
                        <div>
                          <input placeholder="Nombre" class="nameInput" id="searchName" type="text" name="name"/>
                        </div>                        
                        <div class="search"><a href="#" class="icon" title="Buscar"></a>
                          <input id="operationalAddressSearch" type="text" name="operationalAddressSearch" placeholder="Pais, Provincia, Ciudad, Localidad o Barrio" style="width:100%"/>
                          <input id="operationalAddressSearchCheck" type="hidden" name="operationalAddressSearchCheck"/>
                          <input id="operationalAddressCountry" type="hidden" name="operationalAddressCountry"/>
                          <input id="operationalAddressState" type="hidden" name="operationalAddressState"/>
                          <input id="operationalAddressCity" type="hidden" name="operationalAddressCity"/>
                          <input id="operationalAddressLocality" type="hidden" name="operationalAddressLocality"/>
                        </div>
                        <div class="error" id="operationalAddressSearchError" style="display: none;">*El campo no es válido, elija una opción del combo. </div>
                          <div>
                          	Buscar: 
                            <input id="searchCriteriaGyms" name="serchType" type="radio" class="criteriaInput" value="gyms" checked="checked" style="height:auto!important;margin-left:10px;position:relative;bottom:-2px">
                            <span>Gimnasios</span>
                            <input id="searchCriteriaInstructors" name="serchType" type="radio" class="criteriaInput" value="instructors" style="height:auto!important;margin-left:10px;position:relative;bottom:-2px"/>
                            <span>Instructores</span> 
                          </div> 
                          <div class="region-container">
                        <div id="eclubShowAccessContainer" class="advancedSearch"><a id="eclubShowAccess" href="#" style="margin-left:2px;display:inline-block">Usuarios e-club</a> </div>
                        <div id="eclubFields" style="display:none">
                            <div class="row">
                              <div class="col-12 col-md-6">
                                  <input id="userName" type="text" class="nameInput" placeholder="Usuario de Eclub"/>
                                  <div id="userNameError" class="error" style="display:none"></div>                              
                              </div>
                              <div class="col-12 col-md-6">
                                  <input id="password" type="password" class="nameInput" placeholder="Contraseña de Eclub"/>
                                  <div id="passwordError" class="error" style="display:none"></div>                              
                              </div>	
                            </div>
                            <div> <a id="eclubLogin" class="button right" href="#">Ingresar</a> </div>
                        </div>
                        <div id="eclubLogguedIn" class="advancedSearch" style="display:none"> <a href="#">Está logueado como gimnasio</a>
                          <input type="hidden" id="token" value=""/>
                          <input type="hidden" id="activePrograms" value=""/>
                          <input type="hidden" id="gymId" value=""/>
                        </div>
                      </div>                       
                        </div>
                        <div class="col-12 col-md-6">
                        	<div class="programsContainer" style="width:100%">
                            <h4 style="margin:0 0 10px;padding:0 0 5px;border-bottom:1px solid #ddd">Seleccione por programa</h4>
                      <table>
                        <tbody>
                          <tr>
                            <td colspan="2"><input id="selectAllCheckbox" type="checkbox" name="selectAllCheckbox" onchange="selectAllPrograms()"/>Seleccionar/Deseleccionar Todos </td>
                          </tr>
                          <tr>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="BP"/>
                              <img
                                                                        alt="BODYPUMP"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-pump.jpg" ?>"/></td>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="BA"/>
                              <img
                                                                        alt="BODYATTACK"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-attack.jpg" ?>"/></td>
                          </tr>
                          <tr>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="BC"/>
                              <img
                                                                        alt="BODYCOMBAT"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-combat.jpg" ?>"/></td>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="CX"/>
                              <img
                                                                        alt="CXWORX"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-cxworx.jpg" ?>"/> 
                              <!--input class="programSelection" type="checkbox" name="programSelection[]" value="BV" /><img alt="BODYVIVE" src="../wp-content/themes/responsive/images/prog-vive.jpg" /--></td>
                          </tr>
                          <tr>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="BB"/>
                              <img
                                                                        alt="BODYBALANCE"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-balance.jpg" ?>"/></td>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="RPM"/>
                              <img
                                                                        alt="RPM"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-rpm.jpg" ?>"/></td>
                          </tr>
                          <tr>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="BJ"/>
                              <img
                                                                        alt="BODYJAM"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-jam.jpg" ?>"/></td>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="SH"/>
                              <img
                                                                        alt="SH'BAM"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-shbam.jpg" ?>"/></td>
                          </tr>
                          <tr>
                            <td><input class="programSelection" type="checkbox"
                                                                           name="programSelection[]" value="BS"/>
                              <img
                                                                        alt="BODYSTEP"
                                                                        src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/prog-step.jpg" ?>"/></td>
                            <td><input class="programSelection pjSelection"
                                                                           type="checkbox" name="programSelection[]"
                                                                           value="PJ"/>
                              <img alt="POWERJUMP"
                                                                         src="<?php echo get_stylesheet_directory_uri() . "/bodycontrol-integration/images/PJ_white_98x36.png" ?>"/></td>
                          </tr>
                          <!--tr>
                                                            <td colspan="2"></td>
                                                            </tr-->
                        </tbody>
                      </table>
                    </div>
                        </div>
                    </div>

                    </div>
                  </div>
                  <div class="clearfix buttonPosition"><a id="search" href="#">Buscar</a></div>
                </div>
                <!-- end of filter -->
                <div class="clearfix gridContainer">
                  <h4 class="totalGym" style="margin:0;padding:10px 0;font-size:24px;background:#fff;color:#555;border-bottom:1px solid #ccc"><span>Total de </span><span id="totalLabel">gimnasios</span><span>: </span><span id="count"></span> </h4>
                  <table class="nested-grid gridTable tablesorter" id="gymsGrid" cellspacing="0" cellpadding="0">
                    <thead>
                      <tr class="titles">
                        <th class="sorter-false"></th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th class="phoneColumn">Teléfono</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <div class="left leyend">
                    <div> <a class="programCertified" href="#" title="Certificado"></a> <span>Certificado</span> </div>
                    <div> <a class="programAIMa" href="#" title="Advance Instructor Module"></a> <span>Advance Instructor</span> </div>
                    <div> <a class="programAIMb" href="#" title="Advance Instructor Module B"></a> <span>Advance Plus</span> </div>
                    <div> <a class="programAIMbplus" href="#" title="Elite"></a><a class="programAIMbplus" href="#" title="Elite"></a> <span>Elite</span> </div>
                  </div>
                  <!-- end of leyend --> 
                </div>
                <!-- end of in --> 
                
                <!-- templates -->
                <div id="templates" style="display: none;">
                  <table>
                    <tbody>
                      <tr class="gymTr">
                        <td class="arrow" data-gym-index=""></td>
                        <td class="gymName"></td>
                        <td class="gymLocation"></td>
                        <td class="gymPhone phoneColumn"></td>
                      </tr>
                      <tr class="gymDetailTr itemDetailRow inner-grid tablesorter-childRow">
                        <td colspan="4"><div class="itemDetailCol">
                            <div class="subtitle emailContainer">Email:<span class="data gymEMail"></span></div>
                            <div class="subtitle webContainer">Web: <span class="data gymWeb"></span></div>
                            <div class="subtitle">
                              <p class="left">Programas: </p>
                              <span class="itemDetailCol itemPrograms"></span> </div>
                          </div></td>
                      </tr>
                    </tbody>
                  </table>
                  <div id="imageTemplate">
                    <div class="programItem">
                        <img class="programImage" src=""/>
                        <a class="programCertified" href="#" title="Certificado"></a>
                        <a class="programAIMa" href="#" title="Advance Instructor Module"></a>
                        <a class="programAIMb" href="#" title="Advance Instructor Module B"></a>
                        <a class="programAIMbplus" href="#" title="Elite"></a>
                    </div>
                  </div>
                </div>
                
                <!-- end of templates --> 
                
                <!-- WAITING STRATEGY -->
                <div id="waiting-strategy" style="display:none"> <span class="loader"></span> <span class="bg"></span> </div>
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