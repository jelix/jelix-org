<?php
/*
  This is an example of how a local.php coul look like.
  Simply copy the options you want to change from dokuwiki.php
  to this file and change them
 */
if(!defined('DOKU_LANG')) define('DOKU_LANG', 'en');

define('DOKU_LIB', realpath(dirname(__FILE__).'/../lib/').'/');
define('DOKU_PLUGIN',DOKU_LIB.'plugins/');
define('DOKU_SCRIPT','articles');


/* Basic Settings */
$conf['title']       = 'Jelix';        //what to show in the title
$conf['start']       = 'accueil';           //name of start page
$conf['lang']        = 'en';              //your language
$conf['template']    = 'jelix';         //see lib/tpl directory
$conf['savedir']     = realpath(dirname(__FILE__).'/../data').'/';          //where to store all the files
$conf['basedir']     = '/';                //absolute dir from serveroot - blank for autodetection
$conf['dmode']       = 0775;              //set directory creation mode
$conf['fmode']       = 0664;              //set file creation mode

define('DOKU_TPLINC',DOKU_LIB.'tpl/'.$conf['template'].'/');
define('DOKU_TPLINC_DEF',DOKU_LIB.'tpl/default/');



/* Authentication Options - read http://www.splitbrain.org/dokuwiki/wiki:acl */
$conf['useacl']      = 1;                //Use Access Control Lists to restrict access?
$conf['openregister']= 1;                //Should users to be allowed to register?
$conf['autopasswd']  = 1;                //autogenerate passwords and email them to user
$conf['authtype']    = 'plain';          //which authentication backend should be used
$conf['passcrypt']   = 'md5';           //Used crypt method (smd5,md5,sha1,ssha,crypt,mysql,my411)
$conf['defaultgroup']= 'user';           //Default groups new Users are added to
$conf['superuser']   = 'laurent';    //The admin can be user or @group
$conf['manager']     = 'laurent,bbalizlife,bibo';
$conf['mailfrom']    = 'webmaster@jelix.org';

//Set target to use when creating links - leave empty for same window
$conf['target']['wiki']      = '';
$conf['target']['interwiki'] = '';
$conf['target']['extern']    = '';
$conf['target']['media']     = '';
$conf['target']['windows']   = '';

$conf['userewrite']  = 2;                //this makes nice URLs: 0: off 1: .htaccess 2: internal
$conf['useslash']    = 1;                //use slash instead of colon? only when rewrite is on
$conf['sepchar']     = '-';

$conf['recent']      = 40;                //how many entries to show in recent
$conf['recent_days'] = 100;                //How many days of recent changes to keep. (days)
$conf['htmlok']      = 0;
