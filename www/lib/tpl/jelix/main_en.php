<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Script-Type" content="text/javascript" />
   <meta http-equiv="Content-Style-Type" content="text/css" />
   <title><?php tpl_book_page_title()?> - Jelix.org</title>
   <meta name="description" content="Jelix, an open source PHP5 Framework" />
   <meta name="keywords" content="PHP Framework Jelix standards web services mvc CSS XHTML XUL" />
   <meta name="DC.title" content="PHP Framework Jelix" />
   <meta name="DC.description" content="Framework PHP Jelix web site" />

   <link rel="icon" type="image/x-icon" href="/favicon.ico" />
   <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

   <link rel="top"   href="/" title="Homepage of the web site" />
   <link rel="section"   href="/forums/" title="Forums" />
   <link rel="section"   href="/articles/" title="Wiki" />
   <link rel="stylesheet" type="text/css" href="/design/2011/design.css?<?php echo filemtime(DOKU_INC.'../../design/2011/design.css')?>" media="all" title="jelix" />
   <link rel="stylesheet" type="text/css" href="/design/2011/print.css?<?php echo filemtime(DOKU_INC.'../../design/2011/print.css')?>" media="print" title="jelix" />
   <?php tpl_metaheaders()?>
</head>
<body>
<div id="top-box">
   <div class="top-container">
      <div id="accessibility">
       Quick links:
       <a href="#article">Content</a> -
       <a href="#topmenubar">sections</a> -
       <a href="#submenubar">sub sections</a>
       </div>
      <div id="lang-box">
          <strong>EN</strong>
          <?php tpl_book_lang(); ?>
      </div>

   </div>
</div>
<?php

$isMinitutorial = (strpos($ID,'en:tutorials:minitutorial') !== false);
$isTutorial = (strpos($ID,'en:tutorials') === 0);
$isManual = (strpos($ID,'en:manual') === 0);
$isChangelog = (strpos($ID,'en:changelog')===0);
$isDownload = (strpos($ID,'en:download')===0);

$menuAbout = in_array($ID, array('en:about','en:faq', 'en:features','en:credits','en:hall-of-fame')) ||  $isMinitutorial;
$menuDownload = ($isDownload || $isChangelog);
$menuDocumentation = (($isTutorial && !$isMinitutorial)|| $isManual || $ID == 'en:documentation');
$menuCommunity = (strpos($ID,'en:community') === 0 || $ID=='en:goodies');

?>
<div id="header">
    <div class="top-container">
        <h1 id="logo">
             <a href="/" title="Homepage"><img src="/design/logo/logo_jelix_moyen4.png" alt="Jelix" /></a>
        </h1>

        <ul id="topmenubar">
            <li<?php if($menuAbout)         echo ' class="selected"';?>><a href="/en/">About</a></li>
            <li<?php if($menuDownload)      echo ' class="selected"';?>><a href="/articles/en/download">Download</a></li>
            <li<?php if($menuDocumentation) echo ' class="selected"';?>><a href="/articles/en/documentation">Documentation</a></li>
            <li<?php if($menuCommunity)     echo ' class="selected"';?>><a href="/articles/en/community">Community</a></li>
        </ul>
    </div>
</div>
<div id="main-content">
   <div class="top-container">
      <div id="content-header">
         <ul id="submenubar">
         <?php if($menuAbout){ ?>
             <li><a href="/en/news">News</a></li>
             <li<?php if($ID=='en:features') echo ' class="selected"';?>><a href="/articles/en/features">Features</a></li>
             <li<?php if($isMinitutorial)    echo ' class="selected"';?>><a href="/articles/en/tutorials/minitutorial">Mini tutorial</a></li>
             <li<?php if($ID=='en:faq')      echo ' class="selected"';?>><a href="/articles/en/faq">FAQ</a></li>
             <li<?php if($ID=='en:credits')  echo ' class="selected"';?>><a href="/articles/en/credits">Credits</a></li>
             <li<?php if($ID=='en:hall-of-fame') echo ' class="selected"';?>><a href="/articles/en/hall-of-fame">Hall of fame</a></li>
         
         <?php }elseif($menuDownload) { ?>
             <li<?php if(strpos($ID,'en:download:stable')===0)  echo ' class="selected"';?>><a href="/articles/en/download/stable">Stable version</a></li>
             <li<?php if(strpos($ID,'en:download:nightly')===0) echo ' class="selected"';?>><a href="/articles/en/download/nightly">Unstable version</a></li>
             <li<?php if($isChangelog)            echo ' class="selected"';?>><a href="/articles/en/changelog">Last changes</a></li>
             <li<?php if($ID=='en:download:jtpl') echo ' class="selected"';?>><a href="/articles/en/download/jtpl">jTpl Standalone</a></li>
         
         <?php }elseif($menuDocumentation) { ?>
             <li<?php if($isTutorial) echo ' class="selected"';?>><a href="/articles/en/tutorials">Tutorials</a></li>
             <li><a href="http://docs.jelix.org/en/manual-1.5">Manual 1.5</a></li>
             <li><a href="http://docs.jelix.org/en/manual-1.4">1.4</a></li>
             <li><a href="http://docs.jelix.org/en/manual-1.3">1.3</a></li>
             <li><a href="http://docs.jelix.org/en/manual-1.2">1.2</a></li>
             <li><a href="http://docs.jelix.org/en/">others</a></li>
             <li><a href="/reference/index.php.en">API reference</a></li>
         
         <?php }elseif($menuCommunity) { ?>
             <li><a href="/forums/forum/cat/2-english">Forums</a></li>
             <li<?php if($ID=='en:community') echo ' class="selected"';?>><a href="/articles/en/community#mailing-list">Mailing List &amp; IRC</a></li>
             <li<?php if($ID=='en:goodies')   echo ' class="selected"';?>><a href="/articles/en/goodies">Goodies</a></li>
         <?php } ?>
            <li><?php tpl_searchform()?></li>

         </ul>
      </div>
      <div id="article">
         <div id="article-header">
             <p><?php tpl_breadcrumbs()?></p>

             <p class="article-links">Wiki:
               <?php tpl_actionlink('index')?> -
               <?php tpl_actionlink('recent');?> -
               <?php tpl_link(wl($ID,'do=backlink'),"Back link")?>
             </p>
         </div>
         <div><?php html_msgarea()?></div>

         <?php
         tpl_book_page_header();
         tpl_content();
         tpl_book_page_footer();
         tpl_youarehere();
         ?>
         <div id="article-footer">
            <div id="info">
               <div class="wfooterinfo"> <?php tpl_pageinfo()?> </div>
               <div class="wfooterbuttons">
               <?php tpl_button('edit')?>
               <?php tpl_button('history')?>
               <?php tpl_button('revert')?>
               <?php tpl_button('media')?>
               </div>
            </div>
            
            <div id="authinfo">
               <div class="wfooterinfo"> <?php tpl_userinfo()?> </div>
               <div class="wfooterbuttons">
                   <?php tpl_button('admin');?>
                   <?php tpl_button('profile')?>
                   <?php tpl_button('login')?>
                   <?php tpl_button('subscribe'); ?>
               </div>
            </div>
         </div>
      </div>

      <div id="mainfooter">
        <a href="<?php echo DOKU_BASE; ?>feed.php" title="Recent changes RSS feed"><img src="<?php echo DOKU_BASE; ?>lib/tpl/default/images/button-rss.png" width="80" height="15" alt="Recent changes RSS feed" /></a>
        <a href="http://creativecommons.org/licenses/by-nc-sa/2.0/" rel="license" title="Creative Commons License"><img src="<?php echo DOKU_BASE; ?>lib/tpl/default/images/button-cc.gif" width="80" height="15" alt="Creative Commons License" /></a>
      <!--
      
      <rdf:RDF xmlns="http://web.resource.org/cc/"
          xmlns:dc="http://purl.org/dc/elements/1.1/"
          xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
      <Work rdf:about="">
         <dc:type rdf:resource="http://purl.org/dc/dcmitype/Text" />
         <license rdf:resource="http://creativecommons.org/licenses/by-nc-sa/2.0/" />
      </Work>
      
      <License rdf:about="http://creativecommons.org/licenses/by-nc-sa/2.0/">
         <permits rdf:resource="http://web.resource.org/cc/Reproduction" />
         <permits rdf:resource="http://web.resource.org/cc/Distribution" />
         <requires rdf:resource="http://web.resource.org/cc/Notice" />
         <requires rdf:resource="http://web.resource.org/cc/Attribution" />
         <prohibits rdf:resource="http://web.resource.org/cc/CommercialUse" />
         <permits rdf:resource="http://web.resource.org/cc/DerivativeWorks" />
         <requires rdf:resource="http://web.resource.org/cc/ShareAlike" />
      </License>
      
      </rdf:RDF>
      
      -->
      </div>
   </div>
</div>

<div id="footer">
    <div class="top-container">
        <div class="footer-box">
        <p><img src="/design/logo/logo_jelix_moyen5.png" alt="Jelix" /><br/>
            is supported by <a href="http://innophi.com">Innophi</a>.</p>
        <p>Jelix is released under <br/>the LGPL Licence</p>
        </div>

        <div class="footer-box">
            <ul>
                <li><a href="/en/news">News</a></li>
                <li><a href="/articles/en/faq">FAQ</a></li>
                <li><a href="/articles/en/hall-of-fame">Hall of fame</a></li>
                <li><a href="/articles/en/credits">Credits</a></li>
                <li><a href="/articles/en/support">Contacts</a></li>
                <li><a href="/articles/en/goodies">Goodies</a></li>
            </ul>
        </div>


        <div class="footer-box">
            <ul>
                <li><a href="/articles/en/download/nightly">download nightlies</a></li>
                <li><a href="/articles/en/changelog">changelog</a></li>
                <li><a href="http://developer.jelix.org/wiki/en">issues tracker</a></li>
                <li><a href="http://developer.jelix.org/roadmap">roadmap</a></li>
                <li><a href="http://developer.jelix.org/wiki/en/contribute">How to contribute</a></li>
                <li><a href="https://github.com/jelix/jelix">Code source repository</a></li>
            </ul>
        </div>

        <p id="footer-legend">
            Copyright 2006-2013 Jelix team. <br/>
            Icons used on this page come from <a href="http://schollidesign.deviantart.com/art/Human-O2-Iconset-105344123">Human-O2</a>
            and <a href="http://www.oxygen-icons.org/">Oxygen</a> icons sets.<br/>
            Design by Laurentj. <br/>
            <img src="/design/btn_jelix_powered.png" alt="page generated by a Jelix application" />
        </p>
    </div>
</div>



<?php tpl_indexerWebBug()?>

</body>
</html>
