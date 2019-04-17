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

class syntax_plugin_linkjelix extends DokuWiki_Syntax_Plugin {


    static $versions = array();

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2012-12-28',
            'name'   => 'linkjelix Plugin',
            'desc'   => 'Generate a link to some page dedicated to the given branch. Syntax: ~~jlink apiref 1.3 bla bla~~',
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
        $this->Lexer->addSpecialPattern('~~jlink\s+(?:[^~]+)~~',$mode,'plugin_linkjelix');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        if($state == DOKU_LEXER_SPECIAL) {
            if (preg_match("/^~~jlink\s+([a-z]+)\s+(\d+(\.\d+)*)\s+(.*)~~$/", $match, $m)) {
                return array($state, $m[1], trim($m[2]), $m[4]);
            }
        }
        return false;
    }

    static protected $filetypes = array(
        'apiref'    =>array('url'=>'https://jelix.org/reference/%branch%/'),
    );

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
        if ($mode == 'xhtml'){
            if($data[0] == DOKU_LEXER_SPECIAL) {
                $type = $data[1];
                $version = '';
                $branch = $data[2];
                if (isset(self::$versions[$branch])) {
                    $version = self::$versions[$branch];
                }
                else {
                    $path = __DIR__.'/../../../api/releases/'.$branch.'/latest-stable-version';
                    if (file_exists($path)) {
                        $version = trim(file_get_contents($path));
                        self::$versions[$branch] = $version;
                    }
                }
                if ($version == '' || !isset(self::$filetypes[$type])) {
                    return false;
                }
                $attr = self::$filetypes[$type];
                
                $URL = str_replace(array('%branch%', '%version%'), array($branch.'.x', $version), $attr['url']);
                
                $html = '<a href="'.$URL.'">'.htmlspecialchars($data[3]).'</a>';
                $renderer->doc .= $html;
            }
            return true;
        }
      return false;
    }
}
