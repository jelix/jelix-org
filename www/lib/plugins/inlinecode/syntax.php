<?php
/**
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Laurent Jouanneau
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 */
class syntax_plugin_inlinecode extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2008-12-16',
            'name'   => 'InlineCode Plugin',
            'desc'   => 'To specify code inside a paragraph. Syntax is @@some code@@.',
            'url'    => '',
        );
    }

    function getType(){ return 'substition';}

    function getPType(){ return 'normal';}

    function getAllowedTypes() {
        return array('disabled' );
    }

    function getSort(){ return 150; }

    function connectTo($mode) {
      $this->Lexer->addSpecialPattern('@@(?:.@)?[^@]+@@',$mode,'plugin_inlinecode'); //
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        if($state == DOKU_LEXER_SPECIAL) {
            $type = '';
            if($match{3} == '@') {
                $code = substr($match,4,-2);
                $tag=$endtag='';
                $type= $match{2};
                if($type=='V') {
                    $tag='<var>';
                    $endtag='</var>';
                }
                else if($type=='K'){
                    $tag='<kbd>';
                    $endtag='</kbd>';
                }
                else if(isset($this->code_types[$type])) {
                    $tag = '<code class="'.$this->code_types[$type].'">';
                    $endtag ='</code>';
                }
                else {
                    $tag='<code>';
                    $code = substr($match,2,-2);
                    $endtag ='</code>';
                }
            }
            else {
                $code = substr($match,2,-2);
                $tag='<code>';
                $endtag ='</code>';
            }

            return array($state, $code, $tag, $endtag);
        }
        return false;
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
    

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {

      if($mode == 'xhtml'){
        if($data[0] == DOKU_LEXER_SPECIAL) {
            $renderer->doc .= $data[2].$renderer->_xmlEntities($data[1]).$data[3];
        }
        return true;
      }
      return false;
    }

}
