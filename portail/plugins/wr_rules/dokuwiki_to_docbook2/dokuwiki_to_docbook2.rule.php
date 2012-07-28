<?php
/**
 * dokuwiki syntax to docbook 4.3
 *
 * @package WikiRenderer
 * @subpackage rules
 * @author Laurent Jouanneau <jouanneau@netcourrier.com>
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

 require_once(WIKIRENDERER_PATH.'rules/dokuwiki_to_docbook.php');
 
 
 
class dokuwiki_to_docbook2  extends dokuwiki_to_docbook  {


    public $textLineContainers = array(
            'WikiXmlTextLine'=>array( 'dkdbk_strong','dkdbk_emphasis','dkdbk_underlined','dkdbk_monospaced',
        'dkdbk_subscript', 'dkdbk_superscript', 'dkdbk_del', 'dkdbk2_link', 'dkdbk_footnote', 'dkdbk_image',
        'dkdbk2_code', 'dkdbk_nowiki_inline',),
            'dkdbk_table_row'=>array( 'dkdbk_strong','dkdbk_emphasis','dkdbk_underlined','dkdbk_monospaced',
        'dkdbk_subscript', 'dkdbk_superscript', 'dkdbk_del', 'dkdbk2_link', 'dkdbk_footnote', 'dkdbk_image',
        'dkdbk2_code', 'dkdbk_nowiki_inline',)
    );

    public $docbookGen = null;

    public function processLink($url, $tagName='') {
        
        if ($tagName == 'image') {
            $filename = $this->config->docbookGen->getImagePath($url);
    
            if($filename === false) {
                throw new Exception('Bad image href: '.$url);
            }
            return array($filename, $filename);
        }

        return array($url, $url);
    }

    public function getSectionId($title) {
        return $this->docbookGen->headerToLink($title);
    }
}


// ===================================== inline tags

class dkdbk2_code extends WikiTag {
    protected $name='code';
    public $beginTag='@@';
    public $endTag='@@';

    public function getContent(){
        $match = $this->wikiContentArr[0];
        
        $tag='<code>';
        $endtag ='</code>';
        if(strlen($match) > 2 && $match[1] == '@') {
            $code = substr($match,2);
            $tag=$endtag='';
            $type= $match[0];
            if($type=='A') {
                $tag='<tag class="attribute">';
                $endtag='</tag>';
            }
            else if($type=='E'){
                $tag='<tag class="element">';
                $endtag='</tag>';
            }
            else if(isset($this->code_types[$type])) {
                $tag = '<'.$this->code_types[$type].'>';
                $endtag ='</'.$this->code_types[$type].'>';
            }
            else {
                $code = $match;
                $tag='<code>';
                $endtag ='</code>';
            }
        }
        else {
            $code = $match;
            $tag='<code>';
            $endtag ='</code>';
        }
        return $tag.htmlspecialchars($code, ENT_NOQUOTES).$endtag;
    }
    protected $code_types = array(
        'A'=>'attribute', //tag class="attribute"
        'C'=>'classname',
        'T'=>'constant',
        'c'=>'command',
        'E'=>'element', //tag class="element"
        'e'=>'envar',
        'F'=>'filename', // class="devicefile|directory"
        'f'=>'function',
        'I'=>'interfacename',
        'K'=>'keycode',
        'L'=>'literal',
        'M'=>'methodname',
        'P'=>'property',
        'R'=>'returnvalue',
        'V'=>'varname',
    );
    public function isOtherTagAllowed() {
        return false;
    }
}


class dkdbk2_link extends WikiTagXml {
    protected $name='ulink';
    public $beginTag='[[';
    public $endTag=']]';
    protected $attribute=array('href','$$');
    public $separators=array('|');

    public function getContent(){
        $cntattr=count($this->attribute);
        $cnt=($this->separatorCount + 1 > $cntattr?$cntattr:$this->separatorCount+1);

        $href = $this->wikiContentArr[0];

        $urlType=0;
        $url = $this->config->docbookGen->getLinkUrl($href, $urlType, $title);

        if($cnt == 1 ){
            if(!$urlType)
                return '<link linkterm="'.htmlspecialchars($url).'">'.htmlspecialchars($title, ENT_NOQUOTES).'</link>';
            else
                return '<ulink url="'.htmlspecialchars($url).'">'.htmlspecialchars(($title!=''?$title:$href), ENT_NOQUOTES).'</ulink>';
        }else{
            if(!$urlType)
                return '<link linkterm="'.htmlspecialchars($url).'">'.$this->contents[1].'</link>';
            else
                return '<ulink url="'.htmlspecialchars($url).'">'.$this->contents[1].'</ulink>';
        }
    }
}
