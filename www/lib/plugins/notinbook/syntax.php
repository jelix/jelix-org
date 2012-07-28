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
class syntax_plugin_notinbook extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2008-05-09',
            'name'   => 'NotInBook Plugin',
            'desc'   => 'To specify contents which should not include in the book',
            'url'    => '',
        );
    }

    function getType(){ return 'container';}

    function getPType(){ return 'block';}

    function getAllowedTypes() {
        return array('formatting','substition','container', 'disabled', 'protected' );
    }

    // must return a number lower than returned by native 'code' mode (200)
    function getSort(){ return 195; }

    function connectTo($mode) {
      $this->Lexer->addEntryPattern('<notinbook>',$mode,'plugin_notinbook');
    }

    function postConnect() {
      $this->Lexer->addExitPattern('</notinbook>', 'plugin_notinbook');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        global $ID;
        if($state == DOKU_LEXER_UNMATCHED)
            return array($state, $match);
        return false;
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {

      if($mode == 'xhtml'){
        if($data[0] == DOKU_LEXER_UNMATCHED)
            $renderer->doc .=  $renderer->_xmlEntities($data[1])."\n";
        return true;
      }
      return false;
    }

}