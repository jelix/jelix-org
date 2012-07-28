<?php
/**
 * @package   www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2006-2012 Laurent Jouanneau
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
 */

require_once(LIB_PATH.'dokuwiki/inc/utf8.php');

class movePage {

    protected $doku;


    // 'old_id'=>'new_id'
    protected $listPages = array();

    public function __construct() {
        $this->doku = jClasses::create('main~dokuUtils');
    }


    public function move($old_page_id, $new_page_id) {

        $old_path = str_replace(':','/', $old_page_id);
        $new_path = str_replace(':','/', $new_page_id);

        $old_page_path = $this->doku->datadir.'pages/'.$old_path;
        $new_page_path = $this->doku->datadir.'pages/'.$new_path;

        if(is_dir($old_page_path)) {
            jFile::createDir($new_page_path);
            jFile::createDir($this->doku->datadir.'meta/'.$new_path);
        }

        // copie de la page principale
        copy($old_page_path.'.txt',$new_page_path.'.txt');
        file_put_contents($old_page_path.'.txt', '~~REDIRECT>'.$new_page_id."~~\n");
        file_put_contents($this->doku->datadir.'meta/'.$old_path.'.redirect', $new_page_id);

        // virer le fichier meta/x.indexed
        unlink($this->doku->datadir.'meta/'.$old_path.'.indexed');
        // bouger le fichier meta/x.changes
        rename($this->doku->datadir.'meta/'.$old_path.'.changes',
                $this->doku->datadir.'meta/'.$new_path.'.changes');
        // bouger le fichier meta/x.meta
        rename($this->doku->datadir.'meta/'.$old_path.'.meta',
                $this->doku->datadir.'meta/'.$new_path.'.meta');

        // bouger les fichiers attic
        $old_path_att = str_replace(':','/', $this->doku->getNS($old_page_id));
        $new_path_att = str_replace(':','/', $this->doku->getNS($new_page_id));
        $this->moveAttic($old_path_att, $this->doku->noNS($old_page_id), $new_path_att, $this->doku->noNS($new_page_id));

        $this->listPages = array($old_page_id=>$new_page_id, $old_page_id.':'=>$new_page_id.':');

        // deplacer tout les fichiers concernés
        if(is_dir($old_page_path))
            $this->moveDir($old_path, $old_page_id, $new_path, $new_page_id);
var_export($this->listPages);
        // parcourir tous les fichiers pages du wiki, et remplacer les liens
        // pointant vers les anciens remplacements
        $this->updatePages($this->doku->datadir.'pages/');

        //parcourir tout les fichier metas et mettre à jours les liens dans 
         // metas['current']['relation']['references']
        $this->updateMetas($this->doku->datadir.'meta/');

    }

    protected function moveDir($old_dir_path, $old_dir_id, $new_dir_path, $new_dir_id) {

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
                    file_put_contents($dirContent->getPathName(), '~~REDIRECT>'.$new_dir_id.':'.$id."~~\n");
                    file_put_contents($this->doku->datadir.'meta/'.$old_dir_path.'/'.$id.'.redirect', $new_dir_id.':'.$id);

                    // virer le fichier meta/x.indexed
                    unlink($this->doku->datadir.'meta/'.$old_dir_path.'/'.$id.'.indexed');
                    // bouger le fichier meta/x.changes
                    rename($this->doku->datadir.'meta/'.$old_dir_path.'/'.$id.'.changes',
                           $this->doku->datadir.'meta/'.$new_dir_path.'/'.$id.'.changes');
                    // bouger le fichier meta/x.meta
                    rename($this->doku->datadir.'meta/'.$old_dir_path.'/'.$id.'.meta',
                         $this->doku->datadir.'meta/'.$new_dir_path.'/'.$id.'.meta');

                    // bouger les fichiers attic correspondants
                    $this->moveAttic($old_dir_path, $id, $new_dir_path, $id);
                }
            } else{
                if(!$dirContent->isDot() && $dirContent->isDir()){
                    $name = $dirContent->getFilename();
                    mkdir($new_pages_path.$name);
                    mkdir($this->doku->datadir.'meta/'.$new_dir_path.'/'.$name);
                    $this->moveDir($old_dir_path.'/'.$name, $old_dir_id.':'.$name, $new_dir_path.'/'.$name, $new_dir_id.':'.$name);
                    rmdir($dirContent->getPathName());
                    rmdir($this->doku->datadir.'meta/'.$old_dir_path.'/'.$name);
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
                    $this->doku->setCurrentPage($baseid.$id);
                    $wiki = new jWiki('dokuwiki_url_change');
                    $wiki->getConfig()->listPages = $this->listPages;
                    $wiki->getConfig()->doku = $this->doku;
                    $oldcontent=file_get_contents($dirContent->getPathName());
                    $newcontent= $wiki->render($oldcontent);
                    if($oldcontent != $newcontent)
                        file_put_contents($dirContent->getPathName(), $newcontent);
                }
            } else{
                if(!$dirContent->isDot() && $dirContent->isDir()){
                    $this->updatePages($dirContent->getPathName(), $baseid.$dirContent->getFilename());
                }
            }
        }
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
                    $this->doku->setCurrentPage($baseid.$id);
                    $meta = unserialize(file_get_contents($dirContent->getPathName()));

                    $haschanged = false;
                    foreach($meta['current']['relation']['references'] as $page=>$k) {
                        $page = $this->doku->resolve_id($page);
                        if(isset($this->listPages[$page])) {
                            $haschanged = true;
                            unset($meta['current']['relation']['references'][$page]);
                            $meta['current']['relation']['references'][$this->listPages[$page]] = true;
                        }
                    }

                    if($haschanged) {
//echo "       changed\n";
                        file_put_contents($dirContent->getPathName(), serialize($meta));
                    }
                }
            } else{
                if(!$dirContent->isDot() && $dirContent->isDir()){
                    $this->updateMetas($dirContent->getPathName(), $baseid.$dirContent->getFilename());
                }
            }
        }
    }


    protected function moveAttic($old_dir_path, $old_file_id, $new_dir_path, $new_file_id) {
        jFile::createDir($this->doku->datadir.'attic/'.$new_dir_path);

        $dir = new DirectoryIterator($this->doku->datadir.'attic/'.$old_dir_path);
        foreach($dir as $dirContent){
            if($dirContent->isFile()){
                $name = $dirContent->getFilename();
                if( preg_match('/^'.preg_quote($old_file_id).'\.(\d+)\.txt\.gz$/',$name, $m) ) {
                    $newfile = $new_file_id.'.'.$m[1].'.txt.gz';
                    rename($dirContent->getPathName(), $this->doku->datadir.'attic/'.$new_dir_path.'/'.$newfile);
                }
            }
        }
    }

}
