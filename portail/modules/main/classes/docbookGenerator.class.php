<?php
/**
 * @package   www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2006-2012 Laurent Jouanneau
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
 */

require_once(LIB_PATH.'dokuwiki/inc/utf8.php');
require_once(LIB_PATH.'dokuwiki/inc/pageutils.php');

class docbookGenerator {

    protected $doku;

    public function __construct() {
        $this->doku = jClasses::create('main~dokuUtils');
    }

    public function setBookId($book_id) {
        $this->doku->setCurrentPage($book_id);
    }

    public function getLegalNotice($book_id) {
        $this->setBookId($book_id);
        $file = $this->doku->datadir.'pages/'.str_replace(':','/',$book_id).'.txt';
        $legalnotice = '';
        if(is_file($file)){
            $content = file_get_contents($file);

            $start = strpos($content, '<booklegalnotice>');
            $end = strpos($content, '</booklegalnotice>');
            if($start !== false && $end !== false) {
                $start += strlen('<booklegalnotice>');
                $legalnotice = substr($content, $start, $end-$start);

                $wiki = new jWiki('dokuwiki_to_docbook2');
                $wiki->getConfig()->docbookGen = $this;
                $legalnotice= $wiki->render($legalnotice);
            }

        }

        return $legalnotice;
    }

    /**
    *
    */
    public $sectionId = array();

    protected $pages;

    public function generate($book_id, $hierarchy) {
        $this->setBookId($book_id);

        $dao = jDao::get('book_pages');
        $this->pages=array();
        foreach($dao->findByBook($book_id) as $page) {
            $this->pages[$page->id]=$page;
        }
        $content = '';

        foreach($hierarchy as $k=>$item) {
            if($k ==0 && $item[0] == 'foreword') {
                $item[0]='section';
                $item[3]=array();
            } else if($item[0] == 'foreword') {
                continue;
            }
            $content .= $this->_renderItem($item, '    ');
        }

        return $content;
    }

   protected function _renderItem($item, $indent) {
        $title = ($item[2]?$item[2]:$item[1]);
        $tag = $item[0];
        $this->doku->setCurrentPage($item[1]);

        $c = $indent.'<'.$tag. ' id="'.str_replace(':','-',$item[1]).'"><title>'. htmlspecialchars($title).'</title>'."\n";

        // here insert content of the item
        $file = $this->doku->datadir.'pages/'.str_replace(':','/',$item[1]).'.txt';
        if(is_file($file)){
            $content = file_get_contents($file);
            $wiki = new jWiki('dokuwiki_to_docbook2');
            $wiki->getConfig()->docbookGen = $this;
            $c.= $wiki->render($content);
        } else {
            $c.='<para>no content.</para>';
        }

        // loop over children
        if(count($item[3])){
            foreach($item[3] as $k=>$i) {
                $c.= $this->_renderItem($i, $indent.'    ');
            }
        }
        $c.=$indent.'</'.$tag. '>'."\n";

        return $c;
    }

    function getLinkUrl($href, &$urlType, &$title) {
        $urlType = 0;
        if(preg_match("/^[a-zA-Z]+\:\/\//", $href)) {
            $urlType=1;
            return $href;
        }

        if (strpos($href,'#')) {
            list($id,$hash) = explode('#',$href,2);
            $hash = $this->doku->cleanID($hash);
        } else {
            $id=$href;
            $hash = '';
        }

        $this->doku->resolve_pageid($id, $exists);

        $title = $this->doku->noNS($id);
        if(isset($this->pages[$id])) {
            $url = str_replace(':','-',$id);
            if($hash)
                $url.='-'.$hash;
            return $url;
        } else {
            $urlType=1;
            return $this->doku->wikiBaseUrl.str_replace(':','/', $id).($hash?'#'.$hash:'');
        }
    }

    public function getImagePath($href) {
        if(preg_match("/^[a-zA-Z]+\:\/\//", $href)) {

            if(!jHttp::readURL($href,$ssl,$host,$port,$path,$user,$pass))
                return false;
            $url= parse_url($href);
            if ($host == 'jelix.org' || $host == 'www.jelix.org') {
                if (preg_match('/^\\/design/', $path)) {
                    if (file_exists(JELIX_APP_PATH.'..'.$path)) {
                        return JELIX_APP_PATH.'..'.$path;
                    }
                    else {
                        return false;
                    }
                }
                else if (preg_match('/^\\/images/', $path)) {
                    if (file_exists(JELIX_APP_WWW_PATH.$path)) {
                        return JELIX_APP_WWW_PATH.$path;
                    }
                    else {
                        return false;
                    }
                }
            }


            $http = new jHttp($host, $port);
            if(!$http->get($path)) {
                return false;
	    }
            $filename = strtr($path,'?&=#','----');

            $content = $http->getContent();
            jFile::createDir(dirname(JELIX_APP_VAR_PATH.'books/'.$filename));
            file_put_contents(JELIX_APP_VAR_PATH.'books/'.$filename, $content);

            if(substr($filename, 0,1) == '/')
                $filename = substr($filename, 1);

            return $filename;
        } else {
            $id = $this->doku->resolve_id($href);
            return $this->doku->datadir.'media/'.str_replace(':','/',$id);
        }
    }

    protected $headers = array();

    public function headerToLink($title) {
        $title = str_replace(':','',$this->doku->cleanID($title));
        $title = ltrim($title,'0123456789._-');
        if(empty($title)) $title='section';

        $title= str_replace(':','-',$this->doku->currentPageId).'-'.$title;

        $num = '';
        while(in_array($title.$num,$this->headers)){
            ($num) ? $num++ : $num = 1;
        }
        $title = $title.$num;
        $this->headers[] = $title;

        return $title;
    }


}
