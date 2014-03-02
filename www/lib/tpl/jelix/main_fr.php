<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Script-Type" content="text/javascript" />
   <meta http-equiv="Content-Style-Type" content="text/css" />
   <title><?php tpl_book_page_title()?> - Jelix.org</title>
   <meta name="description" content="Framework PHP Jelix" />
   <meta name="keywords" content="Framework PHP Jelix standards services web mvc CSS XHTML XUL" />
   <meta name="DC.title" content="Framework PHP Jelix" />
   <meta name="DC.description" content="Framework PHP Jelix web site" />

   <link rel="icon" type="image/x-icon" href="/favicon.ico" />
   <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

   <link rel="top"   href="/" title="Page d'accueil du site" />
   <link rel="section"   href="/forums/" title="Forums" />
   <link rel="section"   href="/articles/" title="Wiki" />
   <link rel="stylesheet" type="text/css" href="/design/2011/design.css?<?php echo filemtime(DOKU_INC.'../../jelix-design/www/design.css')?>" media="all" title="jelix" />
   <link rel="stylesheet" type="text/css" href="/design/2011/print.css?<?php echo filemtime(DOKU_INC.'../../jelix-design/www/print.css')?>" media="print" title="jelix" />
   <?php tpl_metaheaders()?>
</head>
<body>

<div id="top-box">
   <div class="top-container">
      <div id="accessibility">Raccourcis :
         <a href="#article">Contenu</a> -
         <a href="#topmenubar">rubriques</a> -
         <a href="#submenubar">sous rubriques</a>
      </div>
        <div id="lang-box">
          <?php tpl_book_lang(); ?>
          <strong>FR</strong>
        </div>
   </div>
</div>
<?php
$isMinitutorial = (strpos($ID,'fr:tutoriels:minitutoriel') !== false);
$isTutorial = (strpos($ID,'fr:tutoriels') === 0);
$isManual = (strpos($ID,'fr:manuel') === 0);
$isChangelog = (strpos($ID,'fr:changelog')===0);
$isDownload = (strpos($ID,'fr:telechargement')===0);

$menuAbout = in_array($ID, array('fr:apropos','fr:presentation', 'fr:faq','fr:credits','fr:hall-of-fame')) ||  $isMinitutorial;
$menuDownload = ($isDownload || $isChangelog);
$menuDocumentation = (( $isTutorial &&  !$isMinitutorial) || $isManual || $ID == 'fr:documentation');
$menuCommunity = (strpos($ID,'fr:communaute') === 0 || $ID=='fr:goodies');
$menuSupport = (strpos($ID,'fr:support') === 0);
?>
<div id="header">
    <div class="top-container">

        <h1 id="logo">
             <a href="/" title="Homepage"><img src="/design/logo/logo_jelix_moyen4.png" alt="Jelix" /></a>
        </h1>

        <ul id="topmenubar">
            <li<?php if($menuAbout)         echo ' class="selected"';?>><a href="/fr/">À propos</a></li>
            <li<?php if($menuDownload)      echo ' class="selected"';?>><a href="/articles/fr/telechargement">Téléchargement</a></li>
            <li<?php if($menuDocumentation) echo ' class="selected"';?>><a href="/articles/fr/documentation">Documentation</a></li>
            <li<?php if($menuCommunity)     echo ' class="selected"';?>><a href="/articles/fr/communaute">Communauté</a></li>
            <li<?php if($menuSupport)       echo ' class="selected"';?>><a href="/articles/fr/support">Support</a></li>
        </ul>
    </div>
</div>

<div id="main-content">
   <div class="top-container">
      <div id="content-header">
         <ul id="submenubar">
         <?php if($menuAbout) { ?>
             <li><a href="/fr/news">Actualités</a></li>
             <li<?php if($ID=='fr:presentation') echo ' class="selected"';?>><a href="/articles/fr/presentation">Présentation</a></li>
             <li<?php if($isMinitutorial)     echo ' class="selected"';?>><a href="/articles/fr/tutoriels/minitutoriel">Mini tutoriel</a></li>
             <li<?php if($ID=='fr:faq')          echo ' class="selected"';?>><a href="/articles/fr/faq">FAQ</a></li>
             <li<?php if($ID=='fr:credits')      echo ' class="selected"';?>><a href="/articles/fr/credits">Crédits</a></li>
             <li<?php if($ID=='fr:hall-of-fame') echo ' class="selected"';?>><a href="/articles/fr/hall-of-fame">Sites avec Jelix</a></li>
         
         <?php }elseif($menuDownload) { ?>
             <li<?php if(strpos($ID,'fr:telechargement:stable') === 0)  echo ' class="selected"';?>><a href="/articles/fr/telechargement/stable">Version stable</a></li>
             <li<?php if(strpos($ID,'fr:telechargement:nightly') === 0) echo ' class="selected"';?>><a href="/articles/fr/telechargement/nightly">Version instable</a></li>
             <li<?php if($isChangelog)                  echo ' class="selected"';?>><a href="/articles/fr/changelog">Journal des changements</a></li>
             <li<?php if($ID=='fr:telechargement:jtpl')    echo ' class="selected"';?>><a href="/articles/fr/telechargement/jtpl">jTpl Standalone</a></li>
         
         <?php }elseif($menuDocumentation) { ?>
             <li<?php if($isTutorial)   echo ' class="selected"';?>><a href="/articles/fr/tutoriels">Tutoriels</a></li>
             <li><a href="http://docs.jelix.org/fr/manuel-1.6">Manuel 1.6</a></li>
             <li><a href="http://docs.jelix.org/fr/manuel-1.5">1.5</a></li>
             <li><a href="http://docs.jelix.org/fr/manuel-1.4">1.4</a></li>
             <li><a href="http://docs.jelix.org/fr/manuel-1.3">1.3</a></li>
             <li><a href="http://docs.jelix.org/fr/">autres</a></li>
             <li><a href="/reference/index.php.fr">reference API</a></li>
         
         <?php }elseif($menuCommunity) { ?>
             <li><a href="/forums/forum/cat/1-francais">Forums</a></li>
             <li<?php if($ID=='fr:communaute') echo ' class="selected"';?>><a href="/articles/fr/communaute#mailing-list">Mailing List &amp; IRC</a></li>
             <li<?php if($ID=='fr:goodies')    echo ' class="selected"';?>><a href="/articles/fr/goodies">Goodies</a></li>
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
         <a href="<?php echo DOKU_BASE; ?>feed.php" title="Fils rss des changements récents dans le wiki"><img src="<?php echo DOKU_BASE; ?>lib/tpl/default/images/button-rss.png" width="80" height="15" alt="Fils rss des changements récents dans le wiki" /></a>
       
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
            est sponsorisé par <a href="http://innophi.com">Innophi</a>.</p>
        <p>Jelix est publié sous <br/>la licence LGPL</p>
        </div>
        
        <div class="footer-box">
            <ul>
                <li><a href="/fr/news">Actualités</a></li>
                <li><a href="/articles/fr/faq">FAQ</a></li>
                <li><a href="/articles/fr/hall-of-fame">Hall of fame</a></li>
                <li><a href="/articles/fr/credits">Credits</a></li>
                <li><a href="/articles/fr/support">Contacts</a></li>
                <li><a href="/articles/fr/goodies">Goodies</a></li>
            </ul>
        </div>


        <div class="footer-box">
            <ul>
                <li><a href="/articles/fr/telechargement/nightly">Téléchargement nightlies</a></li>
                <li><a href="/articles/fr/changelog">Journal des changements</a></li>
                <li><a href="http://developer.jelix.org/wiki/fr">Suivi des bugs</a></li>
                <li><a href="http://developer.jelix.org/roadmap">roadmap</a></li>
                <li><a href="http://developer.jelix.org/wiki/fr/contribuer">Comment contribuer</a></li>
                <li><a href="https://github.com/jelix/jelix">Dépôt des sources</a></li>
            </ul>
        </div>
<!--
        <div class="footer-box">
            <ul>
                <li><a href="">jtpl standalone</a></li>
                <li><a href="">jbuildtools</a></li>
                <li><a href="">wikirenderer</a></li>
            </ul>
        </div>-->

        <p id="footer-legend">
            Copyright 2006-2014 Jelix team. <br/>
            Les icônes utilisées sur cette page viennent des paquets
            <a href="http://schollidesign.deviantart.com/art/Human-O2-Iconset-105344123">Human-O2</a>
            et <a href="http://www.oxygen-icons.org/">Oxygen</a>.<br/>
            Design par Laurentj. <br/>
            <img src="/design/btn_jelix_powered.png" alt="page générée par une application Jelix" />
        </p>
    </div>
</div>
<?php tpl_indexerWebBug()?>

</body>
</html>
