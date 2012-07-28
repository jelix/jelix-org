<?php
/**
 * @package   www.jelix.org
 * @author    Laurent Jouanneau, Andreas Gohr <andi@splitbrain.org>
 * @copyright 2006-2012 Laurent Jouanneau, Andreas Gohr
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
 */

require_once(LIB_PATH.'dokuwiki/inc/utf8.php');

class dokuUtils {

    public $datadir='';
    public $start='start';
    public $pages;



    public $currentPageId='';
    public $currentNs='';

    public $wikiBaseUrl='http://jelix.org/articles/';
    public $websiteUrl='http://jelix.org/';

    public function __construct() {
        $this->datadir = realpath(LIB_PATH.'../www/data/').'/';
    }


    function setCurrentPage($page_id) {
        $this->currentPageId = $page_id;
        $this->currentNs = $this->getNS($this->currentPageId);
    }

    function getLinkUrl($href, &$urlType) {
        if(preg_match("/^[a-zA-Z]+\:\/\//", $href)) {
            $urlType=1;
            return $href;
        }
        $urlType = 0;
        if (strpos($href,'#')) {
            list($id,$hash) = explode('#',$href,2);
            $hash = $this->cleanID($hash);
        } else {
            $id=$href;
            $hash = '';
        }

        $id = $this->resolve_id($id);

        $url = str_replace(':','-',$id);
        if($hash)
            $url.='-'.$hash;
        return $url;
    }

    function resolve_pageid(&$page,&$exists){

        $exists = false;

        $page = $this->resolve_id($page);

        // if ends with colon or slash we have a namespace link
        $lastchar = substr($page,-1);
        if($lastchar == ':' ||  $lastchar == '/'){
            if($this->page_exists($page.$this->start)){
                // start page inside namespace
                $page = $page.$this->start;
                $exists = true;
            }elseif($this->page_exists($page.$this->noNS($this->cleanID($page)))){
                // page named like the NS inside the NS
                $page = $page.$this->noNS($this->cleanID($page));
                $exists = true;
            }elseif($this->page_exists($page)){
                // page like namespace exists
                $page = $page;
                $exists = true;
            }else{
                // fall back to default
                $page = $page.$this->start;
            }
        }else{
            if(@file_exists($this->wikiFN($page))){
                $exists = true;
            }
        }

        // now make sure we have a clean page
        $page = $this->cleanID($page);
    }

    function resolve_id($id){

        $id = str_replace('/',':',$id);

        // if the id starts with a dot we need to handle the
        // relative stuff
        if($id{0} == '.'){
            // normalize initial dots without a colon
            $id = preg_replace('/^(\.+)(?=[^:\.])/','\1:',$id);
            // prepend the current namespace
            $id = $this->currentNs.':'.$id;

            // cleanup relatives
            $result = array();
            $pathA  = explode(':', $id);
            if (!$pathA[0]) $result[] = '';
            foreach ($pathA AS $dir) {
                if ($dir == '..') {
                    if (end($result) == '..') {
                        $result[] = '..';
                    } elseif (!array_pop($result)) {
                        $result[] = '..';
                    }
                } elseif ($dir && $dir != '.') {
                    $result[] = $dir;
                }
            }
            if (!end($pathA)) $result[] = '';
            $id = implode(':', $result);
        }elseif(strpos($id,':') === false){
            //if link contains no namespace. add current namespace (if any)
            $id = $this->currentNs.':'.$id;
        }
        return $id;
    }

    function cleanID($raw_id){
        static $cache = array();

        if (isset($cache[$raw_id])) {
            return $cache[$raw_id];
        }

        $id = utf8_strtolower(trim($raw_id));
        $id = strtr($id,';/','::');
        $id = utf8_deaccent($id,-1);
        $id = utf8_stripspecials($id,'-','\*');
        $id = preg_replace('#\\-+#','-',$id);
        $id = preg_replace('#:+#',':',$id);
        $id = trim($id,':._-');
        $id = preg_replace('#:[:\._\-]+#',':',$id);

        $cache[$raw_id] = $id;
        return $id;
    }

    function page_exists($id) {
        return @file_exists($this->wikiFN($id));
    }


    function wikiFN($id){
        static $cache=array();

        if (isset($cache[$id])) {
            return $cache[$id];
        }

        $id = $this->cleanID($id);
        $id = str_replace(':','/',$id);

        $fn = $this->datadir.'pages/'.utf8_encodeFN($id).'.txt';

        $cache[$raw_id] = $fn;
        return $fn;
    }

    function noNS($id) {
        $pos = strrpos($id, ':');
        if ($pos!==false) {
            return substr($id, $pos+1);
        } else {
            return $id;
        }
    }

    function getNS($id){
        $pos = strrpos($id,':');
        if($pos!==false){
            return substr($id,0,$pos);
        }
        return false;
    }


}
