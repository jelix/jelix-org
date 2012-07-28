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

class convertor {

    protected $doku;
    
    protected $bookId;

    public $linkToReplace = array();

    public function __construct() {
        $this->doku = jClasses::create('main~dokuUtils');
    }

    public function setBookId($book_id) {
        $this->bookId = $book_id;
        $this->doku->setCurrentPage($book_id);
    }

    /**
    *
    */
    public $sectionId = array();

    protected $pages;
    
    protected $targetPath;

    public function generate($book_id, $title, $hierarchy, $targetPath, $linkToReplace = array()) {
        $this->setBookId($book_id);
        $this->targetPath = rtrim($targetPath, '/').'/';
        $this->linkToReplace = $linkToReplace;

        $dao = jDao::get('book_pages');
        $this->pages = array();
        foreach($dao->findByBook($book_id) as $page) {
            $this->pages[$page->id]=$page;
echo "page: ".$page->id."\n";
        }

        $item = array('', $book_id, $title, array());
        $this->_renderItem($item);
        
        foreach($hierarchy as $k=>$item) {
            if ($k ==0 && $item[0] == 'foreword') {
                $item[0]='section';
                $item[3]=array();
            } else if($item[0] == 'foreword') {
                continue;
            }
            $this->_renderItem($item);
        }
    }

    protected $currentTargetDir;
    
   protected function _renderItem($item) {
        list($tag, $pageid, $title, $children) = $item;
        if ($title == '')
            $title = $pageid;

        if ($pageid == $this->bookId) {
            $targetFile = 'index.gtw';
        }
        else {
            if (strpos($pageid, $this->bookId) !==0) {
                echo "ERROR: the page $pageid is not inside book ".$this->bookId."\n";
                return;
            }
            
            $targetFile = str_replace(':','/',substr($pageid, strlen($this->bookId)+1)).'.gtw';
        }
        $this->currentTargetDir = dirname($targetFile).'/';
        
        $this->doku->setCurrentPage($pageid);

        $file = $this->doku->datadir.'pages/'.str_replace(':','/',$pageid).'.txt';

        if (is_file($file)) {
            $content = file_get_contents($file);
            $wiki = new jWiki('dokuwiki_to_gitiwiki');
            $wiki->getConfig()->doku = $this->doku;
            $wiki->getConfig()->convertor = $this;
            $newcontent =  $wiki->render($content);
            echo 'store '.$this->targetPath.$targetFile."\n";
            jFile::write($this->targetPath.$targetFile, $newcontent);
        } else {
            echo 'ERROR: unknow file for '.$pageid."\n";
        }

        // loop over children
        if(count($children)){
            foreach($children as $k=>$i) {
                $this->_renderItem($i);
            }
        }
    }

    function getLinkUrl($href, &$urlType, &$title) {
echo "--- url: $href\n";
        $urlType = 0;
        if(preg_match("/^[a-zA-Z]+\:\/\//", $href)) {
            $urlType=1;
echo "      external url\n";
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
echo "      resolve: $id  hash=$hash  curdir=".$this->currentTargetDir."\n";

        if(isset($this->pages[$id]) && strpos($id, $this->bookId) === 0) {
            $url = str_replace(':','/',substr($id, strlen($this->bookId)+1));
            if($hash)
                $url.='#'.$hash;

            if ($this->currentTargetDir == './') {
                echo 'generate url '.$url."\n";
                return $url;
            }

            if (strpos( $url.'/', $this->currentTargetDir) === 0) {
                $relativeUrl = substr($url, strlen($this->currentTargetDir));
                echo 'generate url '.$relativeUrl."  (from ".$url.")\n";
                return $relativeUrl;
            }
            echo 'generate url //'.$url."\n";
            return '//'.$url;
        } else {
echo "      not a url to the wiki\n";
            $urlType=1;
            return $this->doku->wikiBaseUrl.str_replace(':','/', $id).($hash?'#'.$hash:'');
        }
    }

    public function getImageUrl($href) {

        if(preg_match("/^[a-zA-Z]+\:\/\//", $href)) {
            if(!jHttp::readURL($href,$ssl,$host,$port,$path,$user,$pass))
                return $href;

            if ($host == 'jelix.org' || $host == 'www.jelix.org') {
                if (preg_match('/^\\/design/', $path)) {
                    if (file_exists(JELIX_APP_PATH.'..'.$path)) {
                        $imageFile = JELIX_APP_PATH.'..'.$path;
                    }
                    else {
                        return $href;
                    }
                }
                else if (preg_match('/^\\/images/', $path)) {
                    if (file_exists(JELIX_APP_WWW_PATH.$path)) {
                        $imageFile =  JELIX_APP_WWW_PATH.$path;
                    }
                    else {
                        return $href;
                    }
                }
                else
                    return $href;
            }
            else
                return $href;
        }
        else {
            $id = $this->doku->resolve_id($href);
            $imageFile = $this->doku->datadir.'media/'.str_replace(':','/',$id);
        }

        $imageFileName = basename($imageFile);
        $targetpath = $this->targetPath.$this->currentTargetDir.$imageFileName;
        jFile::createDir(dirname($targetpath));

echo "copy image $imageFile to ".$targetpath."\n";
        copy($imageFile, $targetpath);

        return $imageFileName;
    }
}
