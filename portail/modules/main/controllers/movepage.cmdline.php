<?php
/**
 * @package   www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2006-2012 Laurent Jouanneau
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
*/

class movepageCtrl extends jControllerCmdLine {

    /**
    * Options to the command line
    *  'method_name' => array('-option_name' => true/false)
    * true means that a value should be provided for the option on the command line
    */
    protected $allowed_options = array(
            'index' => array(),
            'dup' => array('-c'=>true, '--with-history'=>false),
            'converttogtw' => array('-c'=>true),
    );

    /**
     * Parameters for the command line
     * 'method_name' => array('parameter_name' => true/false)
     * false means that the parameter is optionnal. All parameters which follow an optional parameter
     * is optional
     */
    protected $allowed_parameters = array(
            'index' => array('old_id'=>true, 'new_id'=>true),
            'dup' => array('old_id'=>true, 'new_id'=>true),
            'converttogtw'=> array('book_id'=>true, 'lang'=>true, 'target'=>true)
    );

    /**
    *
    */
    function index() {
        $rep = $this->getResponse();
        $pager = jClasses::create('movePage');
        $pager->move ($this->param('old_id'), $this->param('new_id'));
        return $rep;
    }


    function dup() {
        $rep = $this->getResponse();
        $pager = jClasses::create('copyPage');

        $correspondance = array();
        $correspondancefic = $this->option('-c');
        if ($correspondancefic) {
            if (!file_exists($correspondancefic))
                throw new Exception('given file doesn t exist');
            $list = file($correspondancefic);
            foreach ($list as $line) {
                $r = explode(" ",$line, 2);
                if (count($r) == 2)
                    $correspondance[$r[0]] = trim(substr($r[1],0,-1));
            }
        }
        $pager->copy($this->param('old_id'), $this->param('new_id'), $correspondance, $this->option('--with-history'));
        return $rep;
    }

    function converttogtw() {
        $rep = $this->getResponse();

        $GLOBALS['gJConfig']->locale = $this->param('lang');
        $rep->addContent("start convertion : ".$this->param('book_id')."\n");

        $correspondance = array();
        $correspondancefic = $this->option('-c');
        if ($correspondancefic) {
            if (!file_exists($correspondancefic))
                throw new Exception('given convert file doesn t exist');
            $list = file($correspondancefic);
            foreach ($list as $line) {
                $r = explode(" ",$line, 2);
                if (count($r) == 2)
                    $correspondance[$r[0]] = trim(substr($r[1],0,-1));
            }
        }

        
        $dao = jDao::get('books');
        $book = $dao->get($this->param('book_id'));

        if(!$book) {
            throw new Exception("unknow book");
        }

        $book->hierarchy = unserialize($book->hierarchy);
        $book->authors = unserialize($book->authors);
        $book->copyright_years = unserialize($book->copyright_years);
        $book->copyright_holders = unserialize($book->copyright_holders);

        $gen = jClasses::create('convertor');
        $gen->generate($book->book_id, $book->title, $book->hierarchy, $this->param('target'), $correspondance);

        $rep->addContent("convertion end.\n");

        return $rep;
    }
}
