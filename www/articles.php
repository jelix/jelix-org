<?php
/**
 * DokuWiki mainscript
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 */

// update message version
$updateVersion = 36.1;

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

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');

if (isset($_SERVER['HTTP_X_DOKUWIKI_DO'])){
    $ACT = trim(strtolower($_SERVER['HTTP_X_DOKUWIKI_DO']));
} elseif (!empty($_REQUEST['idx'])) {
    $ACT = 'index';
} elseif (isset($_REQUEST['do'])) {
    $ACT = $_REQUEST['do'];
} else {
    $ACT = 'show';
}

// load and initialize the core system
require_once(DOKU_INC.'inc/init.php');

//import variables
$_REQUEST['id'] = str_replace("\xC2\xAD",'',$_REQUEST['id']); //soft-hyphen
$QUERY = trim($_REQUEST['id']);
$ID    = getID();

if($ACT == 'show' && !isset($_GET['noredirect']) && $_SERVER["REQUEST_METHOD"] =='GET') {
    $file = metaFN($ID, '.redirect');
    if(@file_exists($file) && ($redirect = file_get_contents($file)) != '') {
        $url = '/articles/'.str_replace(':','/', $redirect);
        header("HTTP/1.0 301 Redirect");
        header('Location: '.$url);
        exit();
    }
}

// deprecated 2011-01-14
$NS    = getNS($ID);

$REV   = $_REQUEST['rev'];
$IDX   = $_REQUEST['idx'];
$DATE  = $_REQUEST['date'];
$RANGE = $_REQUEST['range'];
$HIGH  = $_REQUEST['s'];
if(empty($HIGH)) $HIGH = getGoogleQuery();

if (isset($_POST['wikitext'])) {
    $TEXT  = cleanText($_POST['wikitext']);
}
$PRE   = cleanText(substr($_POST['prefix'], 0, -1));
$SUF   = cleanText($_POST['suffix']);
$SUM   = $_REQUEST['summary'];

//sanitize revision
$REV = preg_replace('/[^0-9]/','',$REV);

//make infos about the selected page available
$INFO = pageinfo();

//export minimal infos to JS, plugins can add more
$JSINFO['id']        = $ID;
$JSINFO['namespace'] = (string) $INFO['namespace'];


// handle debugging
if($conf['allowdebug'] && $ACT == 'debug'){
    html_debug();
    exit;
}

//send 404 for missing pages if configured or ID has special meaning to bots
if(!$INFO['exists'] &&
  ($conf['send404'] || preg_match('/^(robots\.txt|sitemap\.xml(\.gz)?|favicon\.ico|crossdomain\.xml)$/',$ID)) &&
  ($ACT == 'show' || (!is_array($ACT) && substr($ACT,0,7) == 'export_')) ){
    header('HTTP/1.0 404 Not Found');
}

//prepare breadcrumbs (initialize a static var)
if ($conf['breadcrumbs']) breadcrumbs();

// check upstream
checkUpdateMessages();

$tmp = array(); // No event data
trigger_event('DOKUWIKI_STARTED',$tmp);

//close session
session_write_close();

//do the work
act_dispatch($ACT);

$tmp = array(); // No event data
trigger_event('DOKUWIKI_DONE', $tmp);

//  xdebug_dump_function_profile(1);
