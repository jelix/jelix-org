<?php 

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
require_once(dirname(__FILE__).'/../../../../lib/dokuwiki/hack/book.lib.php');

tpl_load_book_page();

echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
            
<?php
$ljlang = $conf['lang'];
if( $ljlang !='en' && $ljlang !='fr')
  $ljlang = 'en';

require(dirname(__FILE__).'/main_'.$ljlang.'.php')
?>
