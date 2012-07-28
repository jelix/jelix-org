<?php
/**
 *  Plugin to display freenode iframe
 *
 *  @license    GPL 2 ( http://www.gnu.org/licenses/gpl.html )
 *  @author     laurent jouanneau
 */
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
class syntax_plugin_freenode extends DokuWiki_Syntax_Plugin {
 
  function getInfo( ) {
    return array(
      'author' => 'Laurent Jouanneau',
      'email'  => '',
      'date'   => '2011-01-27',
      'name'   => 'freenode',
      'desc'   => 'Freenode Plugin',
      'url'    => '',
    );
  }
 
  function getType( ) { 
		return 'substition'; 
	}

  function getSort( ) {
    return 317;
  }
 
  function connectTo($mode) {       
    $this->Lexer->addSpecialPattern( '<freenode.*?>', $mode, 'plugin_freenode' ); 
  }
 
  function handle( $match, $state, $pos, &$handler ) {
    $tagcontent = substr( $match, 10, -1 );
    $return = array(
        "params" =>"",
        "width" =>400,
        "height"=>300
    );
    if (preg_match( '/params="([^"]+)"/', $tagcontent, $match_params) && $match_params[1] !="") {
        $return["params"] = $match_params[1];
        $tagcontent = str_replace($match_params[1],"",$tagcontent);
    }

    if(preg_match('/(^|\s)(\d+)x(\d+)(\s|$)/',$tagcontent,$match)){
        $return['width']  = $match[2];
        $return['height'] = $match[3];
    }
    
    return $return;
  }
 
  function render( $mode, &$renderer, $data ) {
    if($mode == 'xhtml'){
      $renderer->doc .= '<iframe src="http://webchat.freenode.net?'.htmlspecialchars($data['params']).'"';
      $renderer->doc .= ' width="'.intval($data['width']).'" height="'.intval($data['height']).'"></iframe>';
      return true;
    } else {
      return false;
    }
  }   
}

