<?php
/**
 * DokuWiki mainscript
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 *
 * @global Input $INPUT
 */

// update message version
$updateVersion = 46.2;

//  xdebug_start_profiling();

// HACK LJ >>>>>>>>>
  if (isset($_SERVER['PATH_INFO'])) {
    if (preg_match("!^/(en|fr)/manu(a|e)l\-!", $_SERVER['PATH_INFO'])) {
      header("Location: http://docs.jelix.org".$_SERVER['PATH_INFO'], true, 301);
      exit;
    }
  }

  $lang ='en';
  if(isset($_SERVER['PATH_INFO']) && (!isset($_REQUEST['do']) ||$_REQUEST['do'] != 'search')){
    $_REQUEST['id'] = str_replace('/',':',$_SERVER['PATH_INFO']);
    if($_REQUEST['id']{0} == ':')
      $_REQUEST['id'] = substr($_REQUEST['id'],1);
  }
  if(isset($_REQUEST['id'])){
    if($_REQUEST['id'] == 'fr' || strpos($_REQUEST['id'],'fr:')===0){
       $lang='fr';
    }
  }
  define('DOKU_LANG', $lang);
// <<<<<<<<<< HACK LJ

if(!defined('DOKU_INC')) define('DOKU_INC', dirname(__FILE__).'/');

if(isset($_SERVER['HTTP_X_DOKUWIKI_DO'])) {
    $ACT = trim(strtolower($_SERVER['HTTP_X_DOKUWIKI_DO']));
} elseif(!empty($_REQUEST['idx'])) {
    $ACT = 'index';
} elseif(isset($_REQUEST['do'])) {
    $ACT = $_REQUEST['do'];
} else {
    $ACT = 'show';
}

// load and initialize the core system
require_once(DOKU_INC.'inc/init.php');

//import variables
$INPUT->set('id', str_replace("\xC2\xAD", '', $INPUT->str('id'))); //soft-hyphen
$QUERY          = trim($INPUT->str('id'));
$ID             = getID();

if($ACT == 'show' && !isset($_GET['noredirect']) && $_SERVER["REQUEST_METHOD"] =='GET') {
    $file = metaFN($ID, '.redirect');
    if(@file_exists($file) && ($redirect = file_get_contents($file)) != '') {
        $url = '/articles/'.str_replace(':','/', $redirect);
        header("HTTP/1.0 301 Redirect");
        header('Location: '.$url);
        exit();
    }
}

$REV   = $INPUT->int('rev');
$DATE_AT = $INPUT->str('at');
$IDX   = $INPUT->str('idx');
$DATE  = $INPUT->int('date');
$RANGE = $INPUT->str('range');
$HIGH  = $INPUT->param('s');
if(empty($HIGH)) $HIGH = getGoogleQuery();

if($INPUT->post->has('wikitext')) {
    $TEXT = cleanText($INPUT->post->str('wikitext'));
}
$PRE = cleanText(substr($INPUT->post->str('prefix'), 0, -1));
$SUF = cleanText($INPUT->post->str('suffix'));
$SUM = $INPUT->post->str('summary');


//parse DATE_AT
if($DATE_AT) {
    $date_parse = strtotime($DATE_AT);
    if($date_parse) {
        $DATE_AT = $date_parse;
    } else { // check for UNIX Timestamp
        $date_parse = @date('Ymd',$DATE_AT);
        if(!$date_parse || $date_parse === '19700101') {
            msg(sprintf($lang['unable_to_parse_date'], $DATE_AT));
            $DATE_AT = null;
        }
    }
}

//check for existing $REV related to $DATE_AT
if($DATE_AT) {
    $pagelog = new PageChangeLog($ID);
    $rev_t = $pagelog->getLastRevisionAt($DATE_AT);
    if($rev_t === '') { //current revision
        $REV = null;
        $DATE_AT = null;
    } else if ($rev_t === false) { //page did not exist
        $rev_n = $pagelog->getRelativeRevision($DATE_AT,+1);
        msg(sprintf($lang['page_nonexist_rev'], 
            strftime($conf['dformat'],$DATE_AT),
            wl($ID, array('rev' => $rev_n)),
            strftime($conf['dformat'],$rev_n)));
        $REV = $DATE_AT; //will result in a page not exists message
    } else {
        $REV = $rev_t;
    }
}

//make infos about the selected page available
$INFO = pageinfo();

//export minimal info to JS, plugins can add more
$JSINFO['id']        = $ID;
$JSINFO['namespace'] = (string) $INFO['namespace'];

// handle debugging
if($conf['allowdebug'] && $ACT == 'debug') {
    html_debug();
    exit;
}

//send 404 for missing pages if configured or ID has special meaning to bots
if(!$INFO['exists'] &&
    ($conf['send404'] || preg_match('/^(robots\.txt|sitemap\.xml(\.gz)?|favicon\.ico|crossdomain\.xml)$/', $ID)) &&
    ($ACT == 'show' || (!is_array($ACT) && substr($ACT, 0, 7) == 'export_'))
) {
    header('HTTP/1.0 404 Not Found');
}

//prepare breadcrumbs (initialize a static var)
if($conf['breadcrumbs']) breadcrumbs();

// check upstream
checkUpdateMessages();

$tmp = array(); // No event data
trigger_event('DOKUWIKI_STARTED', $tmp);

//close session
session_write_close();

//do the work (picks up what to do from global env)
act_dispatch();

$tmp = array(); // No event data
trigger_event('DOKUWIKI_DONE', $tmp);

//  xdebug_dump_function_profile(1);
