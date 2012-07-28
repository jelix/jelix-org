<?php

/**
 * @package		www.jelix.org
 * @subpackage   news
 * @author    Laurent Jouanneau
 * @copyright 2007-2012 Laurent Jouanneau
 * @link     http://jelix.org
 * @licence  http://www.gnu.org/licenses/gpl.html GNU General Public Licence, see LICENCE file
 */


class newsZone extends jZone {

    protected $_tplname='news';
    /*protected $_cacheTimeout = 60;
    protected $_useCache = true;*/

    protected function _prepareTpl(){
        $dao = jDao::get('news');
        $news = $dao->getByUrlId($this->getParam('urlid'));
        if (!$news) {
            jLog::log('News inconnu:'.$this->getParam('urlid'));
        }
        $this->_tpl->assign('news',$news);
    }
}

?>