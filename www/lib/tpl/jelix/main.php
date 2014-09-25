<?php 

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
require_once(dirname(__FILE__).'/../../../../lib/dokuwiki/hack/book.lib.php');

tpl_load_book_page();
?>
<!DOCTYPE html>
<?php
$ljlang = $conf['lang'];
if( $ljlang !='en' && $ljlang !='fr')
  $ljlang = 'en';

require(dirname(__FILE__).'/main_'.$ljlang.'.php')
?>
