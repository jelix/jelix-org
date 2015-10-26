<div id="top-box">
    <div class="top-container">
        <div id="accessibility">
            Raccourcis&nbsp;:{if isset($homepage)}
            <a href="#slogan">Contenu</a> -
            <a href="#topmenubar">rubriques</a>
            {else}
            <a href="#article">Contenu</a> -
            <a href="#topmenubar">rubriques</a> -
            <a href="#submenubar">sous rubriques</a>
            {/if}
        </div>

        <div id="lang-box">
            {if $link_lang}<a href="{jurl $link_lang[0], $link_lang[1]}" hreflang="en" title="english version">EN</a>{/if}
            <strong>FR</strong>
        </div>
    </div>
</div>

<div id="header">
    <div class="top-container">

        <h1 id="logo">
             <a href="/" title="Page d'accueil du site"><img src="/design/logo/logo_jelix_moyen4.png" alt="Jelix" /></a>
        </h1>

        <ul id="topmenubar">
            <li class="selected"><a href="{jurl 'main~default:indexfr'}">À propos</a></li>
            <li><a href="/articles/fr/telechargement">Téléchargement</a></li>
            <li><a href="/articles/fr/documentation">Documentation</a></li>
            <li><a href="/articles/fr/communaute">Communauté</a></li>
            <li><a href="/articles/fr/support">Support</a></li>
        </ul>
    </div>
</div>
<div id="main-content">
    <div class="top-container">

        {if $heading}
        <div id="content-header">
            <ul id="submenubar">
                <li  class="selected"><a href="/fr/news">Actualités</a></li>
                <li><a href="/articles/fr/presentation">Présentation</a></li>
                <li><a href="/articles/fr/tutoriels/minitutoriel">Mini tutoriel</a></li>
                <li><a href="/articles/fr/faq">FAQ</a></li>
                <li><a href="/articles/fr/credits">Crédits</a></li>
                <li><a href="/articles/fr/hall-of-fame">Sites avec Jelix</a></li>
            </ul>
        </div>
        {/if}

        {$MAIN}

        {if $MAINFOOTER}
        <div id="mainfooter">
        {$MAINFOOTER}
        </div>
        {/if}
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
                <li><a href="{jurl 'news~default:index', array('lang'=>'fr_FR')}">Actualités</a></li>
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
                <li><a href="https://github.com/jelix/jelix/issues">Suivi des bugs</a></li>
                <li><a href="https://github.com/jelix/jelix/milestones">roadmap</a></li>
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
            Copyright 2006-2015 Jelix team. <br/>
            Les icônes utilisées sur cette page viennent des paquets
            <a href="http://schollidesign.deviantart.com/art/Human-O2-Iconset-105344123">Human-O2</a>
            et <a href="http://www.oxygen-icons.org/">Oxygen</a>.<br/>
            Design par Laurentj. <br/>
            <img src="/design/btn_jelix_powered.png" alt="page générée par une application Jelix" />
        </p>
    </div>
</div>
