<?php
/**
 * Meta Plugin: Sets relative page in other langs
 */
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_language extends DokuWiki_Syntax_Plugin {

  /**
   * return some info
   */
  function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2008-12-28',
            'name'   => 'Language Plugin',
            'desc'   => '',
            'url'    => '',
        );
  }

  function getType(){ return 'substition'; }
  function getSort(){ return 99; }
  function connectTo($mode) { $this->Lexer->addSpecialPattern('~~LANG:.*?~~',$mode,'plugin_language');}

  /**
   * Handle the match
   */
  function handle($match, $state, $pos, &$handler){
    $match = substr($match,7,-2); //strip ~~META: from start and ~~ from end
    // Syntax is :   LANG@id:page,LANG2@id:page2
    $langs = split(' *, *',trim($match));
    $data = array();
    
    foreach ($langs as $langdesc){
      if(preg_match('/^(\w+)@(.+)$/', $langdesc, $m)) {
        $data[$m[1]] = $m[2];
      }
    }
    return $data;
  }

  /**
   * Create output
   */
  function render($mode, &$renderer, $data){
    if ($mode == 'xthml'){
      return true; // don't output anything
    } elseif ($mode == 'metadata'){
      if(isset($renderer->meta['relative_page_lang']))
        $renderer->meta['relative_page_lang'] = array_merge( $renderer->meta['relative_page_lang'], $data);
      else
        $renderer->meta['relative_page_lang'] = $data;
    }
  }
}