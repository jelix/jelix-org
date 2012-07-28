<?php
/**
 * @package   www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2006-2012 Laurent Jouanneau
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
 */

require_once(LIB_PATH.'dokuwiki/inc/utf8.php');

class copyPage {

    protected $doku;

    // 'old_id'=>'new_id'
    protected $listPages = array();

    protected $linkToReplace = array();

    protected $copyHistory = false;

    public function __construct() {
        $this->doku = jClasses::create('main~dokuUtils');
    }


    public function copy($old_page_id, $new_page_id, $linkToReplace = array(), $copyHistory=false) {

	$this->copyHistory = $copyHistory;

        $old_path = str_replace(':','/', $old_page_id);
        $new_path = str_replace(':','/', $new_page_id);

        $old_page_path = $this->doku->datadir.'pages/'.$old_path;
        $new_page_path = $this->doku->datadir.'pages/'.$new_path;

        $this->linkToReplace = $linkToReplace;

        if(is_dir($old_page_path)) {
            jFile::createDir($new_page_path);
            jFile::createDir($this->doku->datadir.'meta/'.$new_path);
        }

        // copie de la page principale
        copy($old_page_path.'.txt',$new_page_path.'.txt');

        // copie le fichier meta/x.changes
        copy($this->doku->datadir.'meta/'.$old_path.'.changes',
                $this->doku->datadir.'meta/'.$new_path.'.changes');
        // copie le fichier meta/x.meta
        copy($this->doku->datadir.'meta/'.$old_path.'.meta',
                $this->doku->datadir.'meta/'.$new_path.'.meta');

        // copier les fichiers attic
	if ($this->copyHistory) {
            $old_path_att = str_replace(':','/', $this->doku->getNS($old_page_id));
            $new_path_att = str_replace(':','/', $this->doku->getNS($new_page_id));
            $this->copyAttic($old_path_att, $this->doku->noNS($old_page_id), $new_path_att, $this->doku->noNS($new_page_id));
	}

        $this->listPages = array($old_page_id=>$new_page_id, $old_page_id.':'=>$new_page_id.':');

        // copier tout les fichiers concernés
        if(is_dir($old_page_path))
            $this->copyDir($old_path, $old_page_id, $new_path, $new_page_id);

        // parcourir tous les fichiers pages du wiki, et remplacer les liens
        // pointant vers les anciens remplacements
        $this->updatePages($new_page_path, $new_page_id);

        $this->changeUrl($new_page_id, $new_page_path.'.txt');

        //parcourir tout les fichier metas et mettre à jours les liens dans 
         // metas['current']['relation']['references']
        $this->updateMetas($this->doku->datadir.'meta/'.$new_path, $new_page_id);

        $this->changeUrlInMeta($new_page_id, $this->doku->datadir.'meta/'.$new_path.'.meta');
    }

    protected function copyDir($old_dir_path, $old_dir_id, $new_dir_path, $new_dir_id) {

        $old_pages_path = $this->doku->datadir.'pages/'.$old_dir_path.'/';
        $new_pages_path = $this->doku->datadir.'pages/'.$new_dir_path.'/';

        $dir = new DirectoryIterator($old_pages_path);
        foreach($dir as $dirContent){
            if($dirContent->isFile()){
                $name = $dirContent->getFilename();
                if( ($p=strrpos($name,'.')) !== false && $p != 0 && substr($name,$p) == '.txt') {
                    $id = substr($name,0, $p);
                    $this->listPages[$old_dir_id.':'.$id]=$new_dir_id.':'.$id;
                    $this->listPages[$old_dir_id.':'.$id.':']=$new_dir_id.':'.$id.':';
                    // bouger le fichier page/x
                    copy($dirContent->getPathName(), $new_pages_path.$name);

                    // bouger le fichier meta/x.changes
                    copy($this->doku->datadir.'meta/'.$old_dir_path.'/'.$id.'.changes',
                           $this->doku->datadir.'meta/'.$new_dir_path.'/'.$id.'.changes');
                    // bouger le fichier meta/x.meta
                    copy($this->doku->datadir.'meta/'.$old_dir_path.'/'.$id.'.meta',
                           $this->doku->datadir.'meta/'.$new_dir_path.'/'.$id.'.meta');

                    // bouger les fichiers attic correspondants
		    if($this->copyHistory)
                        $this->copyAttic($old_dir_path, $id, $new_dir_path, $id);
                }
            } else{
                if(!$dirContent->isDot() && $dirContent->isDir()){
                    $name = $dirContent->getFilename();
                    mkdir($new_pages_path.$name);
                    mkdir($this->doku->datadir.'meta/'.$new_dir_path.'/'.$name);
                    $this->copyDir($old_dir_path.'/'.$name, $old_dir_id.':'.$name, $new_dir_path.'/'.$name, $new_dir_id.':'.$name);
                }
            }
        }
    }

    protected function updatePages($path, $baseid='') {
        if($baseid !='')
            $baseid.=':';
        $dir = new DirectoryIterator($path);
        foreach($dir as $dirContent){
            if($dirContent->isFile()){
                $name = $dirContent->getFilename();
                if( ($p=strrpos($name,'.')) !== false && $p != 0 && substr($name,$p) == '.txt') {
                    $id = substr($name,0, $p);
echo "update page ".$baseid.$id."\n";
                    $this->changeUrl($baseid.$id, $dirContent->getPathName());
                }
            } else{
                if(!$dirContent->isDot() && $dirContent->isDir()){
                    $this->updatePages($dirContent->getPathName(), $baseid.$dirContent->getFilename());
                }
            }
        }
    }

    protected function changeUrl($page_id, $pageFile) {
        $this->doku->setCurrentPage($page_id);
        $wiki = new jWiki('dokuwiki_url_change');
        $wiki->getConfig()->listPages = $this->listPages;
        $wiki->getConfig()->doku = $this->doku;
        $wiki->getConfig()->linkToReplace = $this->linkToReplace;
        $oldcontent = file_get_contents($pageFile);
        $newcontent = $wiki->render($oldcontent);
        if($oldcontent != $newcontent)
            file_put_contents($pageFile, $newcontent);
    }

    protected function updateMetas($path, $baseid='') {
        if($baseid !='')
            $baseid.=':';
        $dir = new DirectoryIterator($path);
        foreach($dir as $dirContent){
            if($dirContent->isFile()){
                $name = $dirContent->getFilename();
                if( ($p=strrpos($name,'.')) !== false && $p != 0 && substr($name,$p) == '.meta') {
                    $id = substr($name,0, $p);
//echo "update meta ".$baseid.$id."\n";
                    $this->changeUrlInMeta($baseid.$id, $dirContent->getPathName());
                }
            } else{
                if(!$dirContent->isDot() && $dirContent->isDir()){
                    $this->updateMetas($dirContent->getPathName(), $baseid.$dirContent->getFilename());
                }
            }
        }
    }

    protected function changeUrlInMeta($page_id, $page_file) {
        $this->doku->setCurrentPage($page_id);
        $meta = unserialize(file_get_contents($page_file));

        $haschanged = false;
        if (isset($meta['current']['relation']['references']) && is_array($meta['current']['relation']['references'])) {
            foreach($meta['current']['relation']['references'] as $page=>$k) {
                $page = $this->doku->resolve_id($page);
                if(isset($this->listPages[$page])) {
                    $haschanged = true;
                    unset($meta['current']['relation']['references'][$page]);
                    $meta['current']['relation']['references'][$this->listPages[$page]] = true;
                }
            }
        }

        if (isset($meta['current']['relative_page_lang']) && is_array($meta['current']['relative_page_lang'])) {
            foreach($meta['current']['relative_page_lang'] as $lang=>$p) {
                foreach($this->linkToReplace as $oldurl=>$newurl) {
                    if (strpos($p, $oldurl) === 0) {
                        $haschanged = true;
                        $meta['current']['relative_page_lang'][$lang] = $newurl . substr($p, strlen($oldurl));
                        break;
                    }
                }
            }
        }

        if($haschanged) {
            file_put_contents($page_file, serialize($meta));
        }
    }

    protected function copyAttic($old_dir_path, $old_file_id, $new_dir_path, $new_file_id) {
        jFile::createDir($this->doku->datadir.'attic/'.$new_dir_path);

        $dir = new DirectoryIterator($this->doku->datadir.'attic/'.$old_dir_path);
        foreach($dir as $dirContent){
            if($dirContent->isFile()){
                $name = $dirContent->getFilename();
                if( preg_match('/^'.preg_quote($old_file_id).'\.(\d+)\.txt\.gz$/',$name, $m) ) {
                    $newfile = $new_file_id.'.'.$m[1].'.txt.gz';
                    copy($dirContent->getPathName(), $this->doku->datadir.'attic/'.$new_dir_path.'/'.$newfile);
                }
            }
        }
    }
}
