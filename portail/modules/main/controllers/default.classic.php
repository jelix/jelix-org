<?php
/**
 * @package   www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2006-2012 Laurent Jouanneau
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
 */

class defaultCtrl extends jController {
	/**
	 * plugins to manage the behavior of the controller
	 */
	public $pluginParams = array( '*' => array('auth.required'=>false )	);
    function index() {
        $rep = $this->getResponse('html');
		$lang = $GLOBALS['gJConfig']->locale;
        $rsslink = jUrl::get('news~default:rss',array('lang'=>$lang),1);
        $rsstitle = htmlspecialchars(jLocale::get('news~news.link.title.rss'));
        $rep->addHeadContent('<link rel="alternate" type="application/rss+xml" title="'.$rsstitle.'" href="'.$rsslink.'" />');

        $rep->body->assign('page_title','');

        $tpl = new jTpl();
        $tpl->assignZone('news','news~lastestnews', array('lang'=>$GLOBALS['gJConfig']->locale));

        $rep->body->assign('MAIN', $tpl->fetch('index'));
		if ($lang == 'en_EN')
			$rep->body->assign('link_lang', array('main~indexfr', array()));
		else {
			$rep->body->assign('link_lang', array('main~indexen', array()));
		}
		$rep->body->assign('homepage',true);
        return $rep;
    }

    function indexen() {
        $rep = $this->index();
		$rep->body->assign('link_lang', array('main~indexfr', array()));
		return $rep;
    }
    function indexfr() {
        $rep = $this->index();
		$rep->body->assign('link_lang', array('main~indexen', array()));
		return $rep;
    }

}
?>
