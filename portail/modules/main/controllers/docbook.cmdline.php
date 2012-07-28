<?php
/**
 * @package   www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2006-2012 Laurent Jouanneau
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
*/

class docbookCtrl extends jControllerCmdLine {

    /**
    * Options to the command line
    *  'method_name' => array('-option_name' => true/false)
    * true means that a value should be provided for the option on the command line
    */
    protected $allowed_options = array(
            'index' => array('-lang'=>true, '-draft'=>false)
    );

    /**
     * Parameters for the command line
     * 'method_name' => array('parameter_name' => true/false)
     * false means that the parameter is optionnal. All parameters which follow an optional parameter
     * is optional
     */
    protected $allowed_parameters = array(
            'index' => array('book_id'=>true, 'filename'=>true)
    );
    /**
    *
    */
    function index() {
        $lang = $this->option('-lang');
        if($lang)
            $GLOBALS['gJConfig']->locale=$lang;

        $rep = $this->getResponse();
        $rep->addContent("start docbook generation : ".$this->param('book_id')."\n");

        $dao = jDao::get('books');
        $book = $dao->get($this->param('book_id'));

        if(!$book) {
            throw new Exception("unknow book");
        }

        $book->hierarchy = unserialize($book->hierarchy);
        $book->authors = unserialize($book->authors);
        $book->copyright_years = unserialize($book->copyright_years);
        $book->copyright_holders = unserialize($book->copyright_holders);

        $gen = jClasses::create('docbookGenerator');

        $date = new jDateTime();
        $date->now();

        $tpl = new jTpl();
        $tpl->assign('book', $book);
        $tpl->assign('pubdate', $date->toString(jDateTime::LANG_DFORMAT));
        $tpl->assign('legalnotice',$gen->getLegalNotice($book->book_id));

        if($this->option('-draft')) {
            $tpl->assign('edition',jLocale::get('docbook.draft').' - '.date('d').' '.jLocale::get('docbook.month_'.date('m')).' '.date('Y'));
            $tpl->assign('releaseInfo',jLocale::get('docbook.release.info.draft'));
        }else{
            $tpl->assign('edition',$book->edition.' - '.date('d').' '.jLocale::get('docbook.month_'.date('m')).' '.date('Y'));
            $tpl->assign('releaseInfo',jLocale::get('docbook.release.info.stable'));
        }

        $tpl->assign('content', $gen->generate($book->book_id, $book->hierarchy));

        jFile::write(JELIX_APP_VAR_PATH.'books/'.$this->param('filename'), $tpl->fetch('docbook', 'xml'));

        $rep->addContent("docbook built.\n");

        return $rep;
    }

}
