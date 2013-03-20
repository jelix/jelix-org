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
require_once(DOKU_INC.'../lib/dokuwiki/hack/mysql.lib.php');
/**
 */
class syntax_plugin_bookcontents extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Laurent Jouanneau',
            'email'  => '',
            'date'   => '2008-05-09',
            'name'   => 'BookContents Plugin',
            'desc'   => 'Management of contents for a book',
            'url'    => '',
        );
    }

    function getType(){ return 'protected';}

    function getPType(){ return 'block';}

    // must return a number lower than returned by native 'code' mode (200)
    function getSort(){ return 195; }

    function connectTo($mode) {
      $this->Lexer->addEntryPattern('<bookcontents>',$mode,'plugin_bookcontents');
    }

    function postConnect() {
      $this->Lexer->addExitPattern('</bookcontents>', 'plugin_bookcontents');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        global $ID;
        if ($state == DOKU_LEXER_UNMATCHED) {
            $lines = preg_split("/\015\012|\015|\012/",$match);

            $levelStack = array();
            $currentLevel = false;
            $currentContents = array();

            $contents = array();
/*
array(
    array( type, pageId, title,
            array(
                array(type, pageId, title,
                    array(
                        array(type, pageId, title,
                            array(
                            )
                        )
                    )
                )
            )
        ),
);*/

            foreach($lines as $line) {
                if(preg_match("/^(\s*)\-\s*(foreword|part|chapter|section)\s*\:\s*\[\[([\w\-\:\.]+)\s*\|(.*)\]\]/", $line, $m)) {
                    list(,$level, $type, $pageId, $title) = $m;
                    resolve_pageid(getNS($ID),$pageId,$exists);
                    $level = strlen($level);

                    if($currentLevel === false) {
                        $currentLevel = $level;
                        $levelStack[0] = array($currentLevel, $currentContents);
                        $currentContents[] = array($type, $pageId, $title, array());
                    } else {
                        if($currentLevel == $level) {
                            $currentContents[] = array($type, $pageId, $title, array());

                        } else if($currentLevel < $level) {
                            $l = count($levelStack) -1;
                            $levelStack[$l][1] = $currentContents;
                            $currentContents = array( array($type, $pageId, $title, array()));
                            $levelStack[$l+1] = array( $level, $currentContents);
                            $currentLevel = $level;
                        } else {
                            for($i=count($levelStack)-1; $i >= 0; $i --) {
                                if($levelStack[$i][0] > $level) {
                                    $levelStack[$i][1] = $currentContents;
                                    if( $i > 0) {
                                        $currentLevel = $levelStack[$i-1][0];
                                        $j = count($levelStack[$i-1][1]) -1;
                                        $levelStack[$i-1][1][$j][3] = $currentContents;
                                        $currentContents = $levelStack[$i-1][1];
                                    } else {
                                        $contents = $currentContents;
                                    }
                                    unset($levelStack[$i]);
                                    continue;
                                } else if($levelStack[$i][0] == $level) {
                                    $currentContents [] = array($type, $pageId, $title, array());
                                    break;
                                 } else {
                                    $levelStack[$i+1] = array( $level, array());
                                    $currentContents = array(array($type, $pageId, $title, array()));
                                    $currentLevel = $level;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            for($i=count($levelStack)-1; $i >= 0; $i --) {
                $levelStack[$i][1] = $currentContents;
                if($i>0) {
                    $j = count($levelStack[$i-1][1]) -1;
                    $levelStack[$i-1][1][$j][3] = $currentContents;
                    $currentContents = $levelStack[$i-1][1];
                } else {
                    $contents = $currentContents;
                }
                unset($levelStack[$i]);
            }
            return array($contents, $match);
        }
        return false;
    }

    protected $db;

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
      global $ID;
      if($mode == 'xhtml'){
            if(count($data[0])) {
                $this->db = new mysqlDb();
                if($this->db->fetchOne('SELECT book_id FROM  books WHERE book_id='.$this->db->quote($ID)))
                    $this->db->query('UPDATE books SET hierarchy='.$this->db->quote(serialize($data[0])).' WHERE book_id='.$this->db->quote($ID));
                else 
                    $this->db->query('INSERT books (hierarchy, book_id) VALUES ('.$this->db->quote(serialize($data[0])).', '.$this->db->quote($ID).')');

                $this->db->query('DELETE FROM book_pages  WHERE book_id='.$this->db->quote($ID));

                $renderer->doc .=  '<h2>'.$this->getLang('contents')."</h2>\n";
                $renderer->doc .=  '<ul class="bookcontents">'."\n";
                $prev = null;
                $path = array();
                foreach($data[0] as $k=>$item) {
                    if($prev!== null){
                        $renderer->doc .= $this->_renderContentsItem($k, $item,$renderer,$path, $ID, $prev[1]);
                        $this->db->query('UPDATE book_pages SET next='.$this->db->quote($item[1]).' WHERE book_page_id='.$this->db->quote($prev[1]));
                    }else {
                        $renderer->doc .= $this->_renderContentsItem($k, $item,$renderer, $path, $ID);
                    }
                    $prev = $item;
                }
                $renderer->doc .=  '</ul>'."\n";

            }
        return true;
      }
      return false;
    }

    function _renderContentsItem($order, $item, &$renderer, $path, $parent=null, $previous=null) {
        global $ID;
        $title = ($item[2]?$item[2]:$item[1]);
        $c = '<li class="'.$item[0].'">'. $renderer->internallink($item[1], ($item[2]?$item[2]:null), null, true);
        $this->db->query('REPLACE INTO book_pages (book_page_id, book_id, title , type ,contents_order, parent, next, prev, path) VALUES (
            '.$this->db->quote($item[1]).',
            '.$this->db->quote($ID).',
            '.$this->db->quote($title).',
            '.$this->db->quote($item[0]).',
            '.$order.',
            '.($parent === null?'NULL':$this->db->quote($parent)).',
            NULL,
            '.($previous === null?'NULL':$this->db->quote($previous)).',
            '.$this->db->quote(serialize($path)).'
            )');

        $path[]=array($item[1], $title);

        if(count($item[3])){
            $c.='<ul>';
            $prev = null;
            foreach($item[3] as $k=>$i) {
                if($prev!== null){
                    $c.= $this->_renderContentsItem($k, $i, $renderer, $path, $item[1], $prev[1]);
                    $this->db->query('UPDATE book_pages SET next='.$this->db->quote($i[1]).' WHERE book_page_id='.$this->db->quote($prev[1]));
                }
                else {
                    $c.= $this->_renderContentsItem($k, $i, $renderer, $path, $item[1]);
                }
                $prev = $i;
            }
            $c.='</ul>';
        }
        $c.='</li>';

        return $c;
    }
}
