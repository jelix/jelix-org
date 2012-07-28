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
class syntax_plugin_bookinfo extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2008-05-09',
            'name'   => 'BookInfo Plugin',
            'desc'   => 'Management of info for a book',
            'url'    => '',
        );
    }

    function getType(){ return 'protected';}

    function getPType(){ return 'block';}

    // must return a number lower than returned by native 'code' mode (200)
    function getSort(){ return 195; }

    function connectTo($mode) {
      $this->Lexer->addEntryPattern('<bookinfo>',$mode,'plugin_bookinfo');
    }

    function postConnect() {
      $this->Lexer->addExitPattern('</bookinfo>', 'plugin_bookinfo');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        global $ID;
        if ($state == DOKU_LEXER_UNMATCHED) {
            $bookinfos=array(
                'title'=>'',
                'subtitle'=>'',
                'title_short'=>'',
                'authors'=>array(),
                'edition'=>'',
                'copyright'=>array('years'=>array(), 'holders'=>array()),
            );
            $lines = preg_split("/\015\012|\015|\012/",$match);
            foreach($lines as $line) {
                if(preg_match("/^\s*(title|subtitle|title_short|author|edition|copyright_years|copyright_holder)\s*=\s*(.*)/", $line,$m)){
                    list(,$name,$value)=$m;
                    if($name == 'title') {
                        $bookinfos['title'] = $value;
                    }elseif($name == 'subtitle') {
                        $bookinfos['subtitle'] = $value;
                    }elseif($name == 'title_short') {
                        $bookinfos['title_short'] = $value;
                    }else if($name == 'author') {
                        $bookinfos['authors'][] =explode('|', $value);
                    }else if($name == 'edition') {
                        $bookinfos['edition'] = $value;
                    }else if($name == 'copyright_years') {
                        $bookinfos['copyright']['years'] = preg_split("/\s*,\s*/", $value);
                    }else if($name == 'copyright_holder') {
                        $bookinfos['copyright']['holders'][]=$value;
                    }
                }
            }
            return array($bookinfos);
        }
        return false;
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
        global $ID;
        if($mode == 'xhtml'){
            if($data[0]) {
                $bi=$data[0];
                $renderer->doc .=  "<div class=\"bookinfos\">\n";
                $renderer->doc .=  "<h1>".$renderer->_xmlEntities($bi['title'])."</h1>\n";
                if($bi['subtitle'] != '')
                    $renderer->doc .=  "<h2>".$renderer->_xmlEntities($bi['subtitle'])."</h2>\n";
                /*if($bi['edition'] != '')
                    $renderer->doc .=  "<h3>".$renderer->_xmlEntities($bi['edition'])."</h3>\n";*/
                $renderer->doc .=  "<div class=\"authors\">".$this->getLang('writtenby')." <ul>";
                foreach($bi['authors'] as $author) {
                    $renderer->doc .=  '<li>'.$author[0].' '.$author[1];
                    if($author[3] != '')
                        $renderer->doc .=  ' ('.$author[3].') ';
                    $renderer->doc .=  '</li>';
                }
                $renderer->doc .=  '</ul></div>';

                $renderer->doc .=  "<div class=\"copyright\">Copyright ";
                $renderer->doc .=  implode(', ', $bi['copyright']['years'])."<br/>";
                $renderer->doc .=  implode(', ', $bi['copyright']['holders'])." </div>\n";
                $renderer->doc .=  "</div>\n";

                $db = new mysqlDb();
                $db->query('REPLACE INTO books (book_id, title, subtitle, title_short, edition, authors, copyright_years, copyright_holders) VALUES (
                    '.$db->quote($ID).',
                    '.$db->quote($bi['title']).',
                    '.$db->quote($bi['subtitle']).',
                    '.$db->quote($bi['title_short']).',
                    '.$db->quote($bi['edition']).',
                    '.$db->quote(serialize($bi['authors'])).',
                    '.$db->quote(serialize($bi['copyright']['years'])).',
                    '.$db->quote(serialize($bi['copyright']['holders'])).'
                )');

            }
        return true;
      }
      return false;
    }

}