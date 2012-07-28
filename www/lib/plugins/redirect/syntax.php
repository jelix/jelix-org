<?php
/**
 * redirect Plugin: to do a redirection
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
class syntax_plugin_redirect extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2008-06-01',
            'name'   => 'Redirect Plugin',
            'desc'   => '',
            'url'    => '',
        );
    }

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }

    /**
     * What about paragraphs?
     */
    function getPType(){
        return 'block';
    }

    /**
     * Where to sort in?
     */ 
    function getSort(){
        return 155;
    }

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~REDIRECT>[^~]*~~',$mode,'plugin_redirect');
    }


    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        $match = trim(substr($match,11,-2));

        return array($match);
    }

    /**
     * Create output
     */
    function render($format, &$renderer, $data) {
        global $ID;
        if($format == 'xhtml'){
            $file = metaFN($ID, '.redirect');
            if($file!='') {
                if($data[0] !='') {
                    file_put_contents($file, $data[0]);
                    $renderer->doc .= '<p>Page moved to '.$data[0].'  </p>';
                } else {
                    if(@file_exists($file)) {
                        unlink($file);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
