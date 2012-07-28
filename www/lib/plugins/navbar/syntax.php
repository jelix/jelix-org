<?php
/**
 *  navigation bar
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Laurent Jouanneau
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 */
class syntax_plugin_navbar extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2008-05-09',
            'name'   => 'Navbar Plugin',
            'desc'   => 'Displays a navigation bar',
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
        $this->Lexer->addSpecialPattern('~~NAVBAR:.*?~~',$mode,'plugin_navbar');
    }


    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        $params = explode("|",substr($match,9,-2));
        $data = array();
        foreach($params as $param) {
            if(preg_match("/^\s*(next|prev)\s*=\s*([\w\:]+)(\((.*)\))?/", $param, $m)) {
                if(isset($m[4]))
                    $data [$m[1]] = array($m[2], $m[4]);
                else
                    $data [$m[1]] = array($m[2]);
            }
        }
        return $data;
    }

    /**
     * Create output
     */
    function render($format, &$renderer, $data) {
        global $ID;
        if($format == 'xhtml'){
            $renderer->doc .= '<ul class="navbar">'."\n";
            if(isset($data['prev'])) {
                $renderer->doc .= '<li class="navbar-prev">'.$this->getLang('prev').' ';
                $renderer->internallink($data['prev'][0], $data['prev'][1]);
                $renderer->doc .= "</li>\n";
            }
            if(isset($data['next'])) {
                $renderer->doc .= '<li class="navbar-next">';
                $label = null;
                if(isset($data['next'][1]))
                    $label = $data['next'][1];
                else
                    $renderer->doc .=  $this->getLang('next').' ';
                $renderer->internallink($data['next'][0], $label );
                $renderer->doc .= "</li>\n";
            }
            $renderer->doc .= "</ul>";
            return true;
        }
        return false;
    }

}