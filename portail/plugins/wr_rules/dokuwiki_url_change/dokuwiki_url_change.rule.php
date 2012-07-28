<?php
/**
 * rename url of page id in a dokuwiki document
 *
 * @package WikiRenderer
 * @subpackage rules
 * @author Laurent Jouanneau <ljouanneau@gmail.com>
 * @copyright 2008 Laurent Jouanneau
 * @link http://wikirenderer.berlios.de
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public 2.1
 * License as published by the Free Software Foundation.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 */

class dokuwiki_url_change  extends WikiRendererConfig  {

    public $defaultTextLineContainer = 'WikiTextLine';

    public $textLineContainers = array(
            'WikiTextLine'=>array( 'dkurlchg_strong','dkurlchg_emphasis','dkurlchg_underlined','dkurlchg_monospaced',
        'dkurlchg_subscript', 'dkurlchg_superscript', 'dkurlchg_del', 
        'dkurlchg_link', 'dkurlchg_footnote', 'dkurlchg_image',
        'dkurlchg_nowiki_inline',)
    );

    /**
    * liste des balises de type bloc reconnus par WikiRenderer.
    */
    public $bloctags = array( 'dkurlchg_pre','dkurlchg_syntaxhighlight', 'dkurlchg_file',
            'dkurlchg_nowiki', 'dkurlchg_html', 'dkurlchg_php', 'dkurlchg_para',
            'dkurlchg_macro'
    );

    public $simpletags = array();

    public $escapeChar = '';

    public $sectionLevel = array();

    public $doku = null;

    public $listPages = array();

    public $linkToReplace = array();
}


class WikiTagDk extends WikiTag {
   public function getContent(){ return $this->beginTag.$this->contents[0].$this->endTag;}
}

// ===================================== inline tags

class dkurlchg_strong extends WikiTagDk {
    protected $name='emphasis';
    public $beginTag='**';
    public $endTag='**';
}

class dkurlchg_emphasis extends WikiTagDk {
    protected $name='emphasis';
    public $beginTag='//';
    public $endTag='//';
}

class dkurlchg_underlined extends WikiTagDk {
    protected $name='underlined';
    public $beginTag='__';
    public $endTag='__';
}

class dkurlchg_monospaced extends WikiTagDk {
    protected $name='code';
    public $beginTag='\'\'';
    public $endTag='\'\'';
}


class dkurlchg_subscript extends WikiTagDk {
    protected $name='subscript';
    public $beginTag='<sub>';
    public $endTag='</sub>';
}

class dkurlchg_superscript extends WikiTagDk {
    protected $name='superscript';
    public $beginTag='<sup>';
    public $endTag='</sup>';
}

class dkurlchg_del extends WikiTagDk {
    protected $name='del';
    public $beginTag='<del>';
    public $endTag='</del>';
}

class dkurlchg_link extends WikiTagDk {
    protected $name='link';
    public $beginTag='[[';
    public $endTag=']]';
    protected $attribute=array('href','$$');
    public $separators=array('|');

    public function getContent(){
        $cntattr=count($this->attribute);
        $cnt=($this->separatorCount + 1 > $cntattr?$cntattr:$this->separatorCount+1);

        $href = $this->wikiContentArr[0];
echo "     url: $href";
        if(!preg_match("/^[a-zA-Z]+\:\/\//", $href)) {
            if (strpos($href,'#')) {
                list($id,$hash) = explode('#',$href,2);
                $hash = '#'.$this->config->doku->cleanID($hash);
            } else {
                $id=$href;
                $hash = '';
            }

            $id = $this->config->doku->resolve_id($id);
echo "  (res=$id) ";
            if(isset($this->config->listPages[$id])) {
                $href=$this->config->listPages[$id].$hash;
echo "\t\t=>  $href";
            }
        }
echo "\n";
        if($cnt == 1 ){
            return '[['.$href.']]';
        }else{
            return '[['.$href.'|'.$this->wikiContentArr[1].']]';
        }
    }
}

class dkurlchg_footnote extends WikiTagDk {
    protected $name='footnote';
    public $beginTag='((';
    public $endTag='))';
}


class dkurlchg_nowiki_inline extends WikiTagDk {
    protected $name='nowiki';
    public $beginTag='<nowiki>';
    public $endTag='</nowiki>';
}


class dkurlchg_image extends WikiTagDk {
    protected $name='image';
    public $beginTag='{{';
    public $endTag='}}';
    protected $attribute=array('fileref','title');
    public $separators=array('|');

    public function getContent(){
        if($this->separatorCount == 0)
            return '{{'.$this->wikiContentArr[0].'}}';
        else
            return '{{'.$this->wikiContentArr[0].'|'.$this->wikiContentArr[1].'}}';
    }

}



// ===================================== blocs

/**
 * traite les signes de type paragraphe
 */
class dkurlchg_para extends WikiRendererBloc {
    public $type='para';
    protected $_openTag='';
    protected $_closeTag='';

    public function detect($string){
        if($string=='') return false;
        if(preg_match("/^\s?[^\<\~].*$/",$string, $m)) {
            $this->_detectMatch=array($string.'FFFFF',$string);
            return true;
        }
        return false;
    }
}


class dkurlchg_syntaxhighlight extends WikiRendererBloc {

    public $type='syntaxhighlight';
    protected $_openTag='<code>';
    protected $_closeTag='</code>';
    protected $isOpen = false;
    protected $dktag='code';

   public function open(){
      $this->isOpen = true;
      return '';
   }

   public function close(){
      $this->isOpen=false;
      return '';
   }

    public function getRenderedLine(){
        return $this->_detectMatch;
    }

    public function detect($string){
        if($this->isOpen){
            if(preg_match('/(.*)<\/'.$this->dktag.'>\s*$/',$string,$m)){
                $this->_detectMatch=$string;
                $this->isOpen=false;
            }else{
                $this->_detectMatch=$string;
            }
            return true;

        }else{
            if(preg_match('/^\s*<'.$this->dktag.'( \w+)?>(.*)$/',$string,$m)){
                if(preg_match('/(.*)<\/'.$this->dktag.'>\s*$/',$string,$m)){
                    $this->_closeNow = true;
                }
                else {
                    $this->_closeNow = false;
                }
                $this->_detectMatch=$string;
                return true;
            }else{
                return false;
            }
        }
    }
}

class dkurlchg_file extends dkurlchg_syntaxhighlight {
    public $type='file';
    protected $_openTag='<file>';
    protected $_closeTag='</file>';
    protected $dktag='file';
}

class dkurlchg_nowiki extends dkurlchg_syntaxhighlight {
    public $type='nowiki';
    protected $_openTag='<nowiki>';
    protected $_closeTag='</nowiki>';
    protected $dktag='nowiki';
}

class dkurlchg_pre extends WikiRendererBloc {
    public $type='pre';
    protected $_openTag='';
    protected $_closeTag='';

    public function getRenderedLine(){
        return $this->_detectMatch;
    }

    public function detect($string){
        if($string=='') return false;
        if(preg_match("/^\s{2,}[^\s\*\-\=\|\^>;<=~].*/",$string)) {
            $this->_detectMatch=$string;
            return true;
        }
        return false;
    }
}


class dkurlchg_html  extends dkurlchg_syntaxhighlight {
    public $type='html';
    protected $_openTag='<html>';
    protected $_closeTag='</html>';
    protected $dktag='html';
}


class dkurlchg_php extends dkurlchg_syntaxhighlight {
    public $type='php';
    protected $_openTag='<php>';
    protected $_closeTag='</php>';
    protected $dktag='php';
}

class dkurlchg_macro extends WikiRendererBloc {
    public $type='macro';
    protected $regexp='/^(\s*~~[^~]*~~\s*)$/';
    protected $_closeNow=true;

    public function getRenderedLine(){
        if (preg_match("/^~~LANG:([^~]+)~~$/",$this->_detectMatch[1], $m)) {
            $langs = split(' *, *',trim($m[1]));
            $data = '';
            $config = $this->engine->getConfig();
            foreach ($langs as $langdesc){
                if(preg_match('/^(\w+)@(.+)$/', $langdesc, $m)) {
                    $id = $config->doku->resolve_id($m[2]);
                    if(isset($config->listPages[$id])) {
                        $id = $config->listPages[$id];
                        $langdesc = $m[1].'@'.$id;
                    }
                    else {
                        foreach ($config->linkToReplace as $oldurl=>$newurl) {
                            if (strpos($id, $oldurl) === 0) {
                                $langdesc = $m[1].'@'.$newurl . substr($id, strlen($oldurl));
                                break;
                            }
                        }
                    }
                }
                $data.=','.$langdesc;
            }
            return '~~LANG:'.substr($data,1).'~~';
        }
        return $this->_detectMatch[1];
    }
}



