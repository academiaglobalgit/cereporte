<style type="text/css">

#page-header {
height: 83px;
width: 100%;
background: #fff url("http://agcollege.com.mx/logo_prepa_coppel.png") no-repeat scroll 0px right;
}

</style>
        <script src="ayuda/js/jquery.js"></script>

 <script src="ayuda/js/angular.js"></script>
        <script src="ayuda/js/angular_s.js"></script>
        <script src="ayuda/js/angular_animate.js"></script>
        <script src="ayuda/js/scrollglue.js"></script>
        <script src="ayuda/controllerchat.js"></script>
                <link rel="stylesheet" href="ayuda/css/styleschat.css">
        <script src="ayuda/js/bootstrap.js"></script>

<?php
//date_default_timezone_set("Pacific/Easter");
//apc_clear_cache();


// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//ind3
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Moodle frontpage.
 *
 * @package    core
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

    if (!file_exists('./config.php')) {
        header('Location: install.php');
        die;
    }

    require_once('config.php');
    require_once($CFG->dirroot .'/course/lib.php');
    require_once($CFG->libdir .'/filelib.php');
    require_once($CFG->dirroot.'/user/profile/lib.php');



    require_once "ayuda/datos/configAyuda.php";
                        $id_usuario=$USER->id;
                        //$id_usuario=0;
                        if(is_numeric($id_usuario) && $id_usuario != 0) {
                            $response=0;
                            //$mysql= new Connect();
                            $mysql= new Connect();
                            if($mysql->Connectar()){
                                if($result1=$mysql->Query("SELECT count(id) FROM view_asuntos where id_usuario='".$id_usuario."' and id_corporacion=2 order by id DESC")){
                                                    $datos=mysql_fetch_row($result1);
                                    if((int)$datos[0]>0){ //si exíste asunto no jace nada
                                        
                                    }else{ //si no existe un asunto(chat) se lo agrega
                                        if($result=$mysql->Query("CALL proc_guardar_asunto (".$id_usuario.",0,'asunto','Hola, ¿En que podemos ayudarte?','telefono',2);")){
                                            $mysql->Cerrar();
                                            $response=1;
                                        }
                                    }

                                }else{
                                }
                            }else{
                            }
                        } else{
                        }


    redirect_if_major_upgrade_required();

    
    $urlparams = array();
    if (!empty($CFG->defaulthomepage) && ($CFG->defaulthomepage == HOMEPAGE_MY) && optional_param('redirect', 1, PARAM_BOOL) === 0) {
        $urlparams['redirect'] = 0;
    }
    $PAGE->set_url('/', $urlparams);
    $PAGE->set_course($SITE);

    // Prevent caching of this page to stop confusion when changing page after making AJAX changes
    $PAGE->set_cacheable(false);

    if ($CFG->forcelogin) {
        require_login();
    } else {
        user_accesstime_log();
    }
   
    $hassiteconfig = has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

/// If the site is currently under maintenance, then print a message
    if (!empty($CFG->maintenance_enabled) and !$hassiteconfig) {
        print_maintenance_message();
    }

    if ($hassiteconfig && moodle_needs_upgrading()) {
        redirect($CFG->wwwroot .'/'. $CFG->admin .'/index.php');
    }

  //  if (get_home_page() != HOMEPAGE_SITE) {
  //      // Redirect logged-in users to My Moodle overview if required
  //      if (optional_param('setdefaulthome', false, PARAM_BOOL)) {
  //          set_user_preference('user_home_page_preference', HOMEPAGE_SITE);
  //      } else if (!empty($CFG->defaulthomepage) && ($CFG->defaulthomepage == HOMEPAGE_MY) && optional_param('redirect', 1, PARAM_BOOL) === 1) {
  //          redirect($CFG->wwwroot .'/my/');
  //      } else if (!empty($CFG->defaulthomepage) && ($CFG->defaulthomepage == HOMEPAGE_USER)) {
  //          $PAGE->settingsnav->get('usercurrentsettings')->add(get_string('makethismyhome'), new moodle_url('/', array('setdefaulthome'=>true)), navigation_node::TYPE_SETTING);
  //      }
  //  }

    if (isloggedin()) {
        add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
    }

/// If the hub plugin is installed then we let it take over the homepage here
    if (file_exists($CFG->dirroot.'/local/hub/lib.php') and get_config('local_hub', 'hubenabled')) {
        require_once($CFG->dirroot.'/local/hub/lib.php');
        $hub = new local_hub();
        $continue = $hub->display_homepage();
        //display_homepage() return true if the hub home page is not displayed
        //mostly when search form is not displayed for not logged users
        if (empty($continue)) {
            exit;
        }
    }

    $PAGE->set_pagetype('site-index');
    $PAGE->set_other_editing_capability('moodle/course:manageactivities');
    $PAGE->set_docs_path('');
    $PAGE->set_pagelayout('frontpage');
    $editing = $PAGE->user_is_editing();
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
    echo $OUTPUT->header();


/// Print Section or custom info
    get_all_mods($SITE->id, $mods, $modnames, $modnamesplural, $modnamesused);
    if (!empty($CFG->customfrontpageinclude)) {
        include($CFG->customfrontpageinclude);

    } else if ($SITE->numsections > 0) {

        if (!$section = $DB->get_record('course_sections', array('course'=>$SITE->id, 'section'=>1))) {
            $DB->delete_records('course_sections', array('course'=>$SITE->id, 'section'=>1)); // Just in case
            $section = new stdClass();
            $section->course = $SITE->id;
            $section->section = 1;
            $section->summary = '';
            $section->summaryformat = FORMAT_HTML;
            $section->sequence = '';
            $section->visible = 1;
            $section->id = $DB->insert_record('course_sections', $section);
            rebuild_course_cache($SITE->id, true);
        }

        if (!empty($section->sequence) or !empty($section->summary) or $editing) {
            echo $OUTPUT->box_start('generalbox sitetopic');

            /// If currently moving a file then show the current clipboard
            if (ismoving($SITE->id)) {
                $stractivityclipboard = strip_tags(get_string('activityclipboard', '', $USER->activitycopyname));
                echo '<p><font size="2">';
                echo "$stractivityclipboard&nbsp;&nbsp;(<a href=\"course/mod.php?cancelcopy=true&amp;sesskey=".sesskey()."\">". get_string('cancel') .'</a>)';
                echo '</font></p>';
            }
            
            $context = get_context_instance(CONTEXT_COURSE, SITEID);
            $summarytext = file_rewrite_pluginfile_urls($section->summary, 'pluginfile.php', $context->id, 'course', 'section', $section->id);
            $summaryformatoptions = new stdClass();
            $summaryformatoptions->noclean = true;
            $summaryformatoptions->overflowdiv = true;

            echo format_text($summarytext, $section->summaryformat, $summaryformatoptions);

            if ($editing) {
                $streditsummary = get_string('editsummary');
                echo "<a title=\"$streditsummary\" ".
                     " href=\"course/editsection.php?id=$section->id\"><img src=\"" . $OUTPUT->pix_url('t/edit') . "\" ".
                     " class=\"iconsmall\" alt=\"$streditsummary\" /></a><br /><br />";
            }

            print_section($SITE, $section, $mods, $modnamesused, true);

            if ($editing) {
                print_section_add_menus($SITE, $section->section, $modnames);
            }
            echo $OUTPUT->box_end();
        }
    }
    // Include course AJAX
    if (include_course_ajax($SITE, $modnamesused)) {
        // Add the module chooser
        $renderer = $PAGE->get_renderer('core', 'course');
        echo $renderer->course_modchooser(get_module_metadata($SITE, $modnames), $SITE);
    }

    if (isloggedin() and !isguestuser() and isset($CFG->frontpageloggedin)) {
        $frontpagelayout = $CFG->frontpageloggedin;
    } else {
        $frontpagelayout = $CFG->frontpage;
    }

    foreach (explode(',',$frontpagelayout) as $v) {
        switch ($v) {     /// Display the main part of the front page.
            case FRONTPAGENEWS:
                if ($SITE->newsitems) { // Print forums only when needed
                    require_once($CFG->dirroot .'/mod/forum/lib.php');

                    if (! $newsforum = forum_get_course_forum($SITE->id, 'news')) {
                        print_error('cannotfindorcreateforum', 'forum');
                    }

                    // fetch news forum context for proper filtering to happen
                    $newsforumcm = get_coursemodule_from_instance('forum', $newsforum->id, $SITE->id, false, MUST_EXIST);
                    $newsforumcontext = get_context_instance(CONTEXT_MODULE, $newsforumcm->id, MUST_EXIST);

                    $forumname = format_string($newsforum->name, true, array('context' => $newsforumcontext));
                    echo html_writer::tag('a', get_string('skipa', 'access', textlib::strtolower(strip_tags($forumname))), array('href'=>'#skipsitenews', 'class'=>'skip-block'));

                    if (isloggedin()) {
                        $SESSION->fromdiscussion = $CFG->wwwroot;
                        $subtext = '';
                        if (forum_is_subscribed($USER->id, $newsforum)) {
                            if (!forum_is_forcesubscribed($newsforum)) {
                                $subtext = get_string('unsubscribe', 'forum');
                            }
                        } else {
                            $subtext = get_string('subscribe', 'forum');
                        }
                        echo $OUTPUT->heading($forumname, 2, 'headingblock header');
                        $suburl = new moodle_url('/mod/forum/subscribe.php', array('id' => $newsforum->id, 'sesskey' => sesskey()));
                        echo html_writer::tag('div', html_writer::link($suburl, $subtext), array('class' => 'subscribelink'));
                    } else {
                        echo $OUTPUT->heading($forumname, 2, 'headingblock header');
                    }

                    forum_print_latest_discussions($SITE, $newsforum, $SITE->newsitems, 'plain', 'p.modified DESC');
                    echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipsitenews'));

                }
            break;

            case FRONTPAGECOURSELIST:
                $ncourses = $DB->count_records('course');
                if (isloggedin() and !$hassiteconfig and !isguestuser() and empty($CFG->disablemycourses)) {
                    echo html_writer::tag('a', get_string('skipa', 'access', textlib::strtolower(get_string('mycourses'))), array('href'=>'#skipmycourses', 'class'=>'skip-block'));
                    //echo $OUTPUT->heading(get_string('mycourses'), 2, 'headingblock header');
                    //print_my_moodle();
//--------------------------------------------------------------------MLML
            //if($USER->id == 1787 OR $USER->id == 13213){
            if($USER->id == 1787){
                echo '<iframe id="frame" name="frame" src="'.$CFG->wwwroot .'/V2/prueba_principal.php"  width="100%" height="700" frameborder="0"></iframe>';
            }
            else{
                echo '<iframe id="frame" name="frame" src="'.$CFG->wwwroot .'/V2/prueba_principal.php"  width="100%" height="700" frameborder="0"></iframe>';
                /* echo '<iframe id="frame" name="frame" src="'.$CFG->wwwroot .'/V2/Principal.php"  width="100%" height="700" frameborder="0"></iframe>';*/
            }
    
    // echo '<iframe id="frame" name="frame" src="'.$CFG->wwwroot .'/pagppal.php"  width="100%" height="700" frameborder="0"></iframe>';
    $courses  = enrol_get_my_courses('summary', 'visible DESC,sortorder ASC');
    //$courses2  = enrol_get_my_courses('summary', 'visible DESC,sortorder ASC');
    $_SESSION["ML_cursos"]=$courses;
    //print_r ($courses  );
    echo "\n<script>\nvar cursos=".json_encode($courses  ).";\nvar session=".json_encode($_SESSION).";\nvar user=".json_encode($USER).";\n</script>\n";
	$_SESSION["ayudauserid"]=$USER->id;
    if ($categories = $DB->get_records('user_info_category', null, 'sortorder ASC')) {
		//echo 'ya1';
        foreach ($categories as $category) {
			//echo 'ya2';
            if ($fields = $DB->get_records('user_info_field', array('categoryid'=>$category->id), 'sortorder ASC')) {
				//echo 'ya3';
                foreach ($fields as $field) {
					//echo 'ya4'.$field->name.' - '.$field->datatype.' - '.$field->value."\n";
					//print_r($field);
                     require_once($CFG->dirroot.'/user/profile/field/'.$field->datatype.'/field.class.php');
                     $newfield = 'profile_field_'.$field->datatype;
                     $formfield = new $newfield($field->id, $USER->id);
					 //echo 'ya5';
                     if ($formfield->is_visible() and !$formfield->is_empty()) {
                         echo "\n<script>\nvar perfil_".format_string($formfield->field->name).'="'.$formfield->display_data().'";</script>';
                     }
                }
            }
        }
    }	
//--------------------------------------------------------------------
                    echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipmycourses'));
                } else if ((!$hassiteconfig and !isguestuser()) or ($ncourses <= FRONTPAGECOURSELIMIT)) {
                    // admin should not see list of courses when there are too many of them
                    echo html_writer::tag('a', get_string('skipa', 'access', textlib::strtolower(get_string('availablecourses'))), array('href'=>'#skipavailablecourses', 'class'=>'skip-block'));
                    echo $OUTPUT->heading(get_string('availablecourses'), 2, 'headingblock header');
                    print_courses(0);
                    echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipavailablecourses'));
                } else {
                    echo html_writer::tag('div', get_string('therearecourses', '', $ncourses), array('class' => 'notifyproblem'));
                    print_course_search('', false, 'short');
                }
            break;

            case FRONTPAGECATEGORYNAMES:
                echo html_writer::tag('a', get_string('skipa', 'access', textlib::strtolower(get_string('categories'))), array('href'=>'#skipcategories', 'class'=>'skip-block'));
                echo $OUTPUT->heading(get_string('categories'), 2, 'headingblock header');
                echo $OUTPUT->box_start('generalbox categorybox');
                print_whole_category_list(NULL, NULL, NULL, -1, false);
                echo $OUTPUT->box_end();
                print_course_search('', false, 'short');
                echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipcategories'));
            break;

            case FRONTPAGECATEGORYCOMBO:
                echo html_writer::tag('a', get_string('skipa', 'access', textlib::strtolower(get_string('courses'))), array('href'=>'#skipcourses', 'class'=>'skip-block'));
                echo $OUTPUT->heading(get_string('courses'), 2, 'headingblock header');
                $renderer = $PAGE->get_renderer('core','course');
                // if there are too many courses, budiling course category tree could be slow,
                // users should go to course index page to see the whole list.
                $coursecount = $DB->count_records('course');
                if (empty($CFG->numcoursesincombo)) {
                    // if $CFG->numcoursesincombo hasn't been set, use default value 500
                    $CFG->numcoursesincombo = 500;
                }
                if ($coursecount > $CFG->numcoursesincombo) {
                    $link = new moodle_url('/course/');
                    echo $OUTPUT->notification(get_string('maxnumcoursesincombo', 'moodle', array('link'=>$link->out(), 'maxnumofcourses'=>$CFG->numcoursesincombo, 'numberofcourses'=>$coursecount)));
                } else {
                    echo $renderer->course_category_tree(get_course_category_tree());
                }
                print_course_search('', false, 'short');
                echo html_writer::tag('span', '', array('class'=>'skip-block-to', 'id'=>'skipcourses'));
            break;

            case FRONTPAGETOPICONLY:    // Do nothing!!  :-)
            break;

        }
        echo '<br />';

    }
    echo '

    <div style="z-index:9999; bottom: 5px; right: 25px; position:fixed;" id="divContenido"  ng-app="appChat" ng-controller="ctrlChat" ng-init="GetSeguimientos();" >
                        <div ng-repeat="segui in seguimientos" class="row" > <!--seguimientos chats-->
                            <div class="col-md-12">
                                <div class="panel panel-info" >
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <button ng-if="showSeguimientos[segui.id]" type="button" class="btn btn-default" ng-click=" showSeguimientos[segui.id]=!showSeguimientos[segui.id]; StopAutoUpdate(segui.id);">
                                                 <span class="glyphicon glyphicon-eye-close">-</span>
                                            </button>
                                            <button ng-if="!showSeguimientos[segui.id]" type="button" class="btn btn-default" ng-click="showSeguimientos[segui.id]=!showSeguimientos[segui.id]; SetAutoUpdate(segui.id,$index);">
                                                 <span class="glyphicon glyphicon-eye-open"></span>Abrir
                                            </button>
                                            <strong  >Chat en linea
                                            </strong> 
                                        </h3>
                                    </div>
                                    <div ng-show="showSeguimientos[segui.id]" class="col-md-11" >
                                        <div ng-animate=" \'animate\' " animate-on-change="seguimientos[$index].chat" id="{{\'id_chat\'+segui.id}}" class="col-md-11" style=" height:250px; overflow: scroll; overflow-x: hidden;" scroll-glue>
                                            <div ng-repeat="msg in segui.chat" class="row"> <!-- LINEA DE CHAT por mensaje-->
                                                    <div class="row"> <!-- linea nombre y fecha-->
                                                        <div class="col-md-6" style="color: rgb(32, 93, 176);" >
                                                            <strong ng-bind="msg.nombre">
                                                              Usuario
                                                            </strong>
                                                            :
                                                        </div>
                                                        <div class="col-md-6" style="color: #95a5a6;" >
                                                            <strong  ng-bind="msg.fecha">
                                                                2015-01-02 22:30:04
                                                            </strong>
                                                        </div> 
                                                    </div>
                                                    <div class="row col-md-11 "> <!-- linea nombre y fecha mensaje-->
                                                        <div  ng-bind="msg.mensaje" class="panel panel-info"  style="word-wrap: break-word; width:250px;">
                                                            Donec in augue odio. Sed vel ultrices odio..
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-show="showSeguimientos[segui.id]" class="panel-footer" style="background-color: white;"  >
                                        <form class="form-inline" role="form">
                                            <div class="form-group">
                                             Mensaje:
                                              <input ng-attr-id="{{\'chat_msg\'+segui.id}}" ng-attr-name="{{\'chat_msg\'+segui.id}}" type="text" class="form-control" cols="40" placeholder="Introdusca un mensaje..">
                                               <button type="submit" ng-click="funcSetMensajes[segui.id](segui.id,$index)">Enviar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- row por seguimiento-->
        </div> <!--APP -->';
    echo $OUTPUT->footer();