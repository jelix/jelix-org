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
class syntax_plugin_bookpagelegalnotice extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2008-05-13',
            'name'   => 'BookPageLegalNotice Plugin',
            'desc'   => 'To specify legal notice to display on each page of the book',
            'url'    => '',
        );
    }

    function getType(){ return 'container';}

    function getPType(){ return 'block';}

    function getAllowedTypes() {
        return array('formatting','substition','container');
    }

    // must return a number lower than returned by native 'code' mode (200)
    function getSort(){ return 195; }

    function connectTo($mode) {
      $this->Lexer->addEntryPattern('<bookpagelegalnotice>',$mode,'plugin_bookpagelegalnotice');
    }

    function postConnect() {
      $this->Lexer->addExitPattern('</bookpagelegalnotice>', 'plugin_bookpagelegalnotice');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        global $ID;
        //if($state == DOKU_LEXER_UNMATCHED)
            return array($state, $match);
        return false;
    }

    protected $noticePos;

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
        global $ID;
      if($mode == 'xhtml'){

        switch ($data[0]) {
            case DOKU_LEXER_ENTER :      $renderer->doc .= '<div class="booklegalnotice bookpagelegalnotice">'; $this->noticePos = mb_strlen( $renderer->doc, 'UTF-8'); break;
            case DOKU_LEXER_UNMATCHED :  $renderer->doc .= $renderer->_xmlEntities($data[1]);   break;
            case DOKU_LEXER_EXIT :       $legalnotice = mb_substr($renderer->doc, $this->noticePos, mb_strlen($renderer->doc), 'UTF-8');
                                         $renderer->doc .= "</div>";
                                         $db = new mysqlDb();
                                         if($db->fetchOne('SELECT book_id FROM  books WHERE book_id='.$db->quote($ID)))
                                            $db->query('UPDATE books SET pagelegalnoticehtml='.$db->quote($legalnotice).' WHERE book_id='.$db->quote($ID));
                                         else 
                                            $db->query('INSERT books (pagelegalnoticehtml, book_id) VALUES ('.$db->quote($legalnotice).', '.$db->quote($ID).')');
                                         break;
        }
        return true;
      }
      return false;
    }
}
