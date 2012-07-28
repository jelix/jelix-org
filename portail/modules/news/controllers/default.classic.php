<?php
/**
 * @package		www.jelix.org
 * @subpackage   news
 * @author    Laurent Jouanneau
 * @copyright 2007-2012 Laurent Jouanneau
 * @link     http://jelix.org
 * @licence  http://www.gnu.org/licenses/gpl.html GNU General Public Licence, see LICENCE file
 */

class defaultCtrl extends jController {
    /**
    *
    */
    function index() {
        $lang = $GLOBALS['gJConfig']->locale;
        if ($lang == 'fr_FR')
            $link_lang = array('news~default:index',array('lang'=>'en_EN'));
        else
            $link_lang = array('news~default:index',array('lang'=>'fr_FR'));
        
        $rep = $this->getResponse('html');
        $rep->addMetaDescription(jLocale::get('news.description'));
        $rep->body->assign('page_title',jLocale::get('news.page_title'));
        $rep->body->assignZone('MAIN','news~listnews', array('lang'=>$lang));
        $rep->body->assign('heading','news');
        $rep->body->assign('link_lang', $link_lang);

        $rsslink = htmlspecialchars(jUrl::get('news~default:rss',array('lang'=>$lang),1));
        $rsstitle = htmlspecialchars(jLocale::get('news.link.title.rss'));
        $rep->addHeadContent('<link rel="alternate" type="application/rss+xml" title="'.$rsstitle.'" href="'.$rsslink.'" />');
        $rep->body->assign('MAINFOOTER','<a href="'.$rsslink.'" title="'.$rsstitle.'"><img src="/lib/tpl/default/images/button-rss.png" width="80" height="15" alt="'.$rsstitle.'" /></a>');

        return $rep;
    }

    function article() {
        $lang = $GLOBALS['gJConfig']->locale;

        $url = $this->param('newsid');
        if($url == null){
            $rep = new jResponseRedirect();
            $rep->action = 'news~index';
            return $rep;
        }

        if ($lang == 'fr_FR')
            $link_lang = array('news~default:index',array('lang'=>'en_EN'));
        else
            $link_lang = array('news~default:index',array('lang'=>'fr_FR'));

        $rep = $this->getResponse('html');
        $rep->addMetaDescription(jLocale::get('news.description'));
        $rep->body->assign('page_title',jLocale::get('news.page_title'));
        $rep->body->assignZone('MAIN','news~news', array('urlid'=>$url,'lang'=>$lang));
        $rep->body->assign('heading','news');
        $rep->body->assign('link_lang', $link_lang);
        $rep->body->assign('MAINFOOTER','<a href="'.jUrl::get('news~default:index',array('lang'=>$lang)).'">'.jLocale::get('news.all').'</a>');
        return $rep;
    }

    function rss(){
        $rep = $this->getResponse('rss2.0');
        if($GLOBALS['gJConfig']->locale == 'fr_FR') {
            $rep->infos->title = 'Actualité de Jelix';
            $rep->infos->webSiteUrl= 'http://jelix.org/fr/';
            $rep->infos->copyright = 'Copyright 2006-2011 Jelix Team';
            $rep->infos->description = 'Actualité sur le framework PHP5 Jelix';
        }else{
            $rep->infos->title = 'Jelix news';
            $rep->infos->webSiteUrl= 'http://jelix.org/en/';
            $rep->infos->copyright = 'Copyright 2006-2011 Jelix Team';
            $rep->infos->description = 'News about the php5 framework Jelix';
        }

        $newsdao = jDao::get('news');
        $first = $newsdao->getFirstByLang($GLOBALS['gJConfig']->locale);

        $rep->infos->updated = $first->date_create;
        $rep->infos->published = $first->date_create;
        $rep->infos->ttl=60;

        $list = $newsdao->findAllByLang($GLOBALS['gJConfig']->locale);
        foreach($list as $news){
            $url = 'http://'.$_SERVER['HTTP_HOST'].jUrl::get('news~default:article', array('newsid'=>$news->url, 'lang'=>$GLOBALS['gJConfig']->locale));
            $item = $rep->createItem($news->title,$url, $news->date_create);
            $item->published = $news->date_create;
            $item->authorName = $news->author;
            $wiki = new jWiki();
            if($news->abstract =='')
                $item->content = $wiki->render($news->content);
            else
                $item->content = $wiki->render($news->abstract);
            $item->contentType='html';
            $item->idIsPermalink = false;
            $rep->addItem($item);
        }
        return $rep;
    }

}
?>
