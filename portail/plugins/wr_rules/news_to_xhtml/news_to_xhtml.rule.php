<?php
/**
 * wikirenderer3 (wr3) syntax to xhtml
 *
 * @package WikiRenderer
 * @subpackage rules
 * @author Laurent Jouanneau <jouanneau@netcourrier.com>
 * @copyright 2003-2006 Laurent Jouanneau
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

require_once (LIB_PATH.'wikirenderer/rules/wr3_to_xhtml.php');

class news_to_xhtml  extends wr3_to_xhtml  {

  public $textLineContainers = array(
      'WikiHtmlTextLine' => array( 'wr3xhtml_strong','wr3xhtml_em','wr3xhtml_code','wr3xhtml_q',
    'wr3xhtml_cite','wr3xhtml_acronym','newsxhtml_link', 'wr3xhtml_image',
    'wr3xhtml_anchor', 'wr3xhtml_footnote'));

}

class newsxhtml_link extends wr3xhtml_link {

    public function getContent(){
        $cntattr=count($this->attribute);
        $cnt=($this->separatorCount + 1 > $cntattr?$cntattr:$this->separatorCount+1);
        if($cnt == 1 ){
            $contents = $this->wikiContentArr[0];
            $href=$contents;
            if(strpos($href,'javascript:')!==false) // for security reason
                $href='#';
            else if(preg_match('/^ticket:(\d+)$/', $href,$m)) {
                $href='http://developer.jelix.org/ticket/'.$m[1];
                $contents='ticket '.$m[1];
            }
            if(strlen($contents) > 40)
                $contents=substr($contents,0,40).'(..)';
            return '<a href="'.htmlspecialchars($href).'">'.htmlspecialchars($contents).'</a>';
        }else{
            if(strpos($this->wikiContentArr[1],'javascript:')!==false) // for security reason
                $this->wikiContentArr[1]='#';
            else if(preg_match('/^ticket:(\d+)$/', $this->wikiContentArr[1],$m)) {
                $this->wikiContentArr[1]='http://developer.jelix.org/ticket/'.$m[1];
            }
            return parent::getContent();
        }
    }
}
