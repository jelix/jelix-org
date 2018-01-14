<?php

$versions = array('1.6'=>'', '1.5'=>'', '1.4'=>'', '1.3'=>'', '1.2'=>'', '1.1'=>'', '1.0'=>'');

foreach ($versions as $branch=>$v) {
    $versions[$branch] = file_get_contents(__DIR__.'/../api/releases/'.$branch.'/latest-stable-version');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Script-Type" content="text/javascript" />
   <meta http-equiv="Content-Style-Type" content="text/css" />
   <title>API Reference - Jelix.org</title>
   <meta name="description" content="Jelix PHP Framework, API reference" />
   <meta name="keywords" content="Framework PHP Jelix API reference standards services web mvc CSS XHTML XUL benchmark copix" />
   <meta name="DC.title" content="Framework PHP Jelix API Reference" />
   <meta name="DC.description" content="Framework PHP Jelix web site" />

   <link rel="icon" type="image/x-icon" href="/favicon.ico" />
   <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
   <link rel="top"   href="/" title="Homepage" />
   <link rel="section"   href="/forums/" title="Forums" />
   <link rel="section"   href="/articles/" title="Wiki" />
   <link rel="start" href="/" />

   <link rel="stylesheet" type="text/css" href="/design/2011/design.css" media="screen" title="jelix" />
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
          <del>fr</del>
      </div>

   </div>
</div>
<div id="header">
    <div class="top-container">
        <h1 id="logo">
             <a href="/" title="Homepage"><img src="/design/logo/logo_jelix_moyen4.png" alt="Jelix" /></a>
        </h1>

        <ul id="topmenubar">
            <li><a href="/en/">About</a></li>
            <li><a href="/articles/en/download">Download</a></li>
            <li class="selected"><a href="/articles/en/documentation">Documentation</a></li>
            <li><a href="/articles/en/community">Community</a></li>
        </ul>
    </div>
</div>
<div id="main-content">
   <div class="top-container">
      <div id="content-header">
         <ul id="submenubar">
             <li><a href="/articles/en/tutorials">Tutorials</a></li>
             <li><a href="http://docs.jelix.org/en/manual-1.6">Manual 1.6</a></li>
             <li><a href="http://docs.jelix.org/en/manual-1.5">1.5</a></li>
             <li><a href="http://docs.jelix.org/en/">Others</a></li>
             <li class="selected"><a href="/reference/">API reference</a></li>
         </ul>
      </div>
      <div id="article">

        <h1>API Reference</h1>
        <dl>
            <dt>Jelix trunk (development, updated each night)</dt>
            <dd><a href="trunk/">HTML, online</a> -
                 <a href="http://download.jelix.org/jelix/documentation/jelix-trunk-apidoc_html.tar.gz">HTML tar.gz</a> -
                 <a href="http://download.jelix.org/jelix/documentation/jelix-trunk-apidoc_html.zip">HTML zip</a>
            </dd>
            <?php
                foreach($versions as $branch=>$version) {
                    ?>
            <dt>Lastest stable release Jelix <?php echo $version?>:</dt>
            <dd><a href="<?php echo $version?>/">HTML, online</a> -
                 <a href="http://download.jelix.org/jelix/releases/<?php echo $branch?>.x/<?php echo $version?>/jelix-<?php echo $version?>-apidoc_html.tar.gz">HTML tar.gz</a> -
                 <a href="http://download.jelix.org/jelix/releases/<?php echo $branch?>.x/<?php echo $version?>/jelix-<?php echo $version?>-apidoc_html.zip">HTML zip</a>
            </dd>
                    <?php
                }
            ?>
       </dl>
        <p>Go on <a href="http://download.jelix.org/jelix/releases">the download web site</a> to retrieve API documentation for old releases, for each branches.</p>
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
                <li><a href="https://github.com/jelix/jelix/issues">issues tracker</a></li>
                <li><a href="https://github.com/jelix/jelix/milestones">roadmap</a></li>
                <li><a href="http://developer.jelix.org/wiki/en/contribute">How to contribute</a></li>
                <li><a href="https://github.com/jelix/jelix">Code source repository</a></li>
            </ul>
        </div>

        <p id="footer-legend">
            Copyright 2006-2018 Jelix team. <br/>
            Icons used on this page come from <a href="http://schollidesign.deviantart.com/art/Human-O2-Iconset-105344123">Human-O2</a>
            and <a href="http://www.oxygen-icons.org/">Oxygen</a> icons sets.<br/>
            Design by Laurentj. <br/>
            <img src="/design/btn_jelix_powered.png" alt="page generated by a Jelix application" />
        </p>
    </div>
</div>


</body>
</html>
