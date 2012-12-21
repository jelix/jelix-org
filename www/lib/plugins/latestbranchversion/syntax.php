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

class syntax_plugin_latestbranchversion extends DokuWiki_Syntax_Plugin {


    static $versions = array();

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2012-12-21',
            'name'   => 'LatestBranchVersion Plugin',
            'desc'   => 'display the last version of Jelix in the given branch. Syntax: <version 1.3>',
            'url'    => '',
        );
    }

    function getType(){ return 'substition';}

    function getPType(){ return 'normal';}

    function getAllowedTypes() {
        return array('disabled' );
    }

    function getSort(){ return 140; }

    function connectTo($mode) {
      $this->Lexer->addSpecialPattern('<version\s+([^>]+)>',$mode,'plugin_latestbranchversion'); //
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        if($state == DOKU_LEXER_SPECIAL) {
            if (isset(self::$versions[$match])) {
                return array($state, self::$versions[$match]);
            }
            
            
            if (preg_match("/^\d+(\.\d+)*$/", $match)) {
                $path = __DIR__.'/../../api/releases/'.$match.'/latest-stable-version';
                if (file_exists($path)) {
                    $version = file_get_contents();
                    self::$versions[$match] = $version;
                    return array($state, self::$versions[$match]);
                }
            }
            return array($state, $match);
        }
        return false;
    }

    

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
      if($mode == 'xhtml'){
        if($data[0] == DOKU_LEXER_SPECIAL) {
            $renderer->doc .= $data[1];
        }
        return true;
      }
      return false;
    }
}
