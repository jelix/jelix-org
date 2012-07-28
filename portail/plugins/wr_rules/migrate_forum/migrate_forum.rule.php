<?php
/**
 * classic wikirenderer syntax to Wikirenderer 3 syntax
 *
 * @package WikiRenderer
 * @subpackage rules
 * @author Laurent Jouanneau
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

require_once(LIB_PATH.'wikirenderer/rules/classicwr_to_wr3.php');

class migrate_forum  extends classicwr_to_wr3 {
   public $bloctags = array('cwrwr3_title', 'cwrwr3_list', 'cwrwr3_pre','cwrwr3_hr',
                         'cwrwr3_blockquote','cwrwr3_definition','cwrwr3_table', 'cwrwr3_p');

   public $simpletags = array();
}



class cwrwr3_pre3 extends WikiRendererBloc {

   public $type='pre';
   protected $regexp="/^(\s.*)/";
   protected $_openTag="<code>";
   protected $_closeTag="</code>";

   public function getRenderedLine(){
      return $this->_detectMatch[1];
   }
}


/**
 * traite les signes de types pre (pour afficher du code..)
 */
class cwrwr3_pre2 extends WikiRendererBloc {

    public $type='pre';
    protected $_openTag='<code>';
    protected $_closeTag='</code>';
    protected $isOpen = false;


   public function open(){
      $this->isOpen = true;
      return $this->_openTag;
   }

   public function close(){
      $this->isOpen=false;
      return $this->_closeTag;
   }

    public function getRenderedLine(){
        return $this->_detectMatch;
    }

    public function detect($string){
        if($this->isOpen){
            if(preg_match('/(.*)<\/code>\s*$/',$string,$m)){
                $this->_detectMatch=$m[1];
                $this->isOpen=false;
            }else{
                $this->_detectMatch=$string;
            }
            return true;

        }else{
            if(preg_match('/^\s*<code>(.*)/',$string,$m)){
                if(preg_match('/(.*)<\/code>\s*$/',$m[1],$m2)){
                    $this->_closeNow = true;
                    $this->_detectMatch=$m2[1];
                }
                else {
                    $this->_closeNow = false;
                    $this->_detectMatch=$m[1];
                }
                return true;
            }else{
                return false;
            }
        }
    }
}
