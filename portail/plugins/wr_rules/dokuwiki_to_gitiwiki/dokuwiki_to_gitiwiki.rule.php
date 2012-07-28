<?php
/**
 * convert dokuwiki content to dokuwiki syntax for gitiwiki
 *
 * @package WikiRenderer
 * @subpackage rules
 * @author Laurent Jouanneau <ljouanneau@gmail.com>
 * @copyright 2012 Laurent Jouanneau
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
require_once(dirname(__FILE__).'/../dokuwiki_url_change/dokuwiki_url_change.rule.php');

class dokuwiki_to_gitiwiki  extends WikiRendererConfig  {

    public $defaultTextLineContainer = 'WikiTextLine';

    public $textLineContainers = array(
            'WikiTextLine'=>array( 'dkurlchg_strong','dkurlchg_emphasis','dkurlchg_underlined','dkurlchg_monospaced', 'dktogw_code',
        'dkurlchg_subscript', 'dkurlchg_superscript', 'dkurlchg_del', 
        'dktogw_link', 'dkurlchg_footnote', 'dktogw_image',
        'dkurlchg_nowiki_inline',)
    );

    /**
    * liste des balises de type bloc reconnus par WikiRenderer.
    */
    public $bloctags = array( 'dkurlchg_pre','dkurlchg_syntaxhighlight', 'dkurlchg_file',
            'dkurlchg_nowiki', 'dkurlchg_html', 'dkurlchg_php', 'dkurlchg_para',
            'dktogw_macro'
    );

    public $simpletags = array();

    public $escapeChar = '';

    public $sectionLevel = array();

    public $doku = null;

    public $linkToReplace = array();
    
    public $convertor = null;
}


class dktogw_code extends WikiTagDk {
    protected $name='code';
    public $beginTag='@@';
    public $endTag='@@';
}


class dktogw_link extends WikiTagDk {
    protected $name='link';
    public $beginTag='[[';
    public $endTag=']]';
    protected $attribute=array('href','$$');
    public $separators=array('|');

    public function getContent(){
        $cntattr=count($this->attribute);
        $cnt=($this->separatorCount + 1 > $cntattr?$cntattr:$this->separatorCount+1);

        $href = $this->wikiContentArr[0];
        $urlType=0;
        $url = $this->config->convertor->getLinkUrl($href, $urlType, $title);

        if($cnt == 1 ){
            return '[['.$url.']]';
        }else{
            return '[['.$url.'|'.$this->wikiContentArr[1].']]';
        }
    }
}


class dktogw_image extends WikiTagDk {
    protected $name='image';
    public $beginTag='{{';
    public $endTag='}}';
    protected $attribute=array('fileref','title');
    public $separators=array('|');

    public function getContent(){
        $contents = $this->wikiContentArr;
        if(count($contents) == 1) {
            $href = $contents[0];
            $title = '';
        } else {
            $href = $contents[0];
            $title = $contents[1];
        }

        $align='';
        $width='';
        $height='';

        $m = array('','','','','','','','');
        if (preg_match("/^(\s*)([^\s\?]+)(\?(\d+)(x(\d+))?)?(\s*)$/", $href, $m)) {
            /*if($m[1] != '' && $m[7] != ''){
                $align='center';
            } elseif($m[1] != ''){
                $align='right';
            } elseif($m[7] != ''){
                $align='left';
            }
            if($m[3]) {
                $width=$height=$m[4];
                if($m[5])
                   $height=$m[6];
            }*/
            $href= $m[2];
        }

        $href = $this->config->convertor->getImageUrl($href);

        if($this->separatorCount == 0)
            return '{{'.$m[1].$href.$m[3].$m[7].'}}';
        else
            return '{{'.$m[1].$href.$m[3].$m[7].'|'.$this->wikiContentArr[1].'}}';
    }
}


class dktogw_macro extends WikiRendererBloc {
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
                    foreach ($config->convertor->linkToReplace as $oldurl=>$newurl) {
                        if (strpos($id, $oldurl) === 0) {
                            $newid = str_replace(':','/',substr($id, strlen($oldurl)));
                            $langdesc = $m[1].'@'.$newurl . $newid;
                            break;
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