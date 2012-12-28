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

class syntax_plugin_downloadjelix extends DokuWiki_Syntax_Plugin {


    static $versions = array();

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2012-12-28',
            'name'   => 'downloadjelix Plugin',
            'desc'   => 'Generate a link to one of a jelix package with the latest version of the given branch. Syntax: ~~download jelixopt 1.3~~',
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
        $this->Lexer->addSpecialPattern('~~download\s+(?:[^~]+)~~',$mode,'plugin_downloadjelix');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        if($state == DOKU_LEXER_SPECIAL) {
            if (preg_match("/^~~download\s+([a-z]+)\s+(\d+(\.\d+)*)\s*~~$/", $match, $m)) {
                return array($state, $m[1], trim($m[2]));
            }
        }
        return false;
    }

    protected $baseUrl = 'http://download.jelix.org/';
    protected $basePath = '../../../../download/www/';
    static protected $filetypes = array(
        // 'type'=>array('filename%branch%/%version%', 'downloadbaseurl', 'systembasepath')
        'jelixgold' =>array('name'=>'jelix/releases/%branch%/%version%/jelix-%version%-gold.tar.gz',   'zip'=>true),
        'jelixopt'  =>array('name'=>'jelix/releases/%branch%/%version%/jelix-%version%-opt.tar.gz',    'zip'=>true),
        'jelixdev'  =>array('name'=>'jelix/releases/%branch%/%version%/jelix-%version%-dev.tar.gz',    'zip'=>true),
        'fonts'     =>array('name'=>'jelix/releases/%branch%/%version%/jelix-%version%-pdf-fonts.zip'),
        'manual'    =>array('name'=>'jelix/releases/%branch%/%version%/jelix-manual-%version%.pdf'),
        'apiref'    =>array('name'=>'jelix/releases/%branch%/%version%/jelix-%version%-apidoc_html.zip'),
        'testapp'   =>array('name'=>'jelix/releases/%branch%/%version%/testapp-%version%.tar.gz',      'zip'=>true)
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
                
                $filename = str_replace(array('%branch%', '%version%'), array($branch.'.x', $version), $attr['name']);
                $file = basename($filename);
                $html = '<a href="'.$this->baseUrl.$filename.'">'.$file.'</a>';
                if (isset($attr['zip'])) {
                    $filename = str_replace('.tar.gz', 'zip', $filename);
                    $html .= ' (<a href="'.$this->baseUrl.$filename.'">zip</a>)';
                }
                $renderer->doc .= $html;
            }
            return true;
        }
      return false;
    }

}
