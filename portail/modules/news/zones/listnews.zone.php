<?php

/**
 * @package		www.jelix.org
 * @subpackage   news
 * @author    Laurent Jouanneau
 * @copyright 2007-2012 Laurent Jouanneau
 * @link     http://jelix.org
 * @licence  http://www.gnu.org/licenses/gpl.html GNU General Public Licence, see LICENCE file
 */


class listNewsZone extends jZone {

    protected $_tplname='listnews';
    protected $_cacheParams = array ('lang');
    protected $_cacheTimeout = 60;
    protected $_useCache = true;

    protected function _prepareTpl(){
        $dao = jDao::get('news');
        $this->_tpl->assign('listnews',$dao->findAllByLang($this->getParam('lang','en_EN')));
    }
}

?>