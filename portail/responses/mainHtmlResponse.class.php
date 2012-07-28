<?php

/**
 * @package     www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2007-2012 Laurent Jouanneau
 * @link     http://jelix.org
 * @licence  http://www.gnu.org/licenses/gpl.html GNU General Public Licence, see LICENCE file
 */

require_once (JELIX_LIB_CORE_PATH.'response/jResponseHtml.class.php');

class mainHtmlResponse extends jResponseHtml {

    // modifications communes aux actions utilisant cette reponse
    protected function doAfterActions(){
        $this->bodyTpl = 'main~main';
        if($GLOBALS['gJConfig']->locale == 'fr_FR'){
            $link = 'fr/';
        }else{
            $link = 'en/';
        }

        $this->title .= ($this->title !=''?' - ':'') . jLocale::get('main~site.title');
        $this->addMetaDescription(jLocale::get('main~site.description'));
        $this->addMetaKeywords(jLocale::get('main~site.keywords'));
        $this->addCssLink('/design/2011/design.css', array('media'=>'all', 'title'=>'Jelix'));
        $this->addCssLink('/design/2011/print.css', array('media'=>'print'));
        $this->addHeadContent('   <link rel="top"   href="/" title="'.htmlspecialchars(jLocale::get('main~site.homepage')).'" />
   <link rel="section"   href="/'.$link.'news/" title="News" />
   <link rel="section"   href="/forums/" title="Forums" />
   <link rel="section"   href="/articles/'.$link.'" title="Wiki" />
   <link rel="icon" type="image/x-icon" href="/favicon.ico" />
   <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
   <meta name="DC.title" content="'.htmlspecialchars($this->title).'" />
   <meta name="DC.description" content="'.htmlspecialchars(jLocale::get('main~site.description')).'" />
   <meta name="robots" content="index,follow,all" />
');

       $this->body->assignIfNone('menu','');
       $this->body->assignIfNone('link_lang',false);
       $this->body->assignIfNone('MAIN','<p></p>');
       $this->body->assignIfNone('page_title','Jelix');
       $this->body->assignIfNone('heading','');
       $this->body->assignIfNone('MAINFOOTER','');
   }
}
?>
