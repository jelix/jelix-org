{meta_html csstheme 'css/layout.css'}
{meta_html css $j_basepath .'design/2011/design.css'}
{meta_html csstheme 'css/nav.css'}
{meta_html js $j_jelixwww.'jquery/jquery.js'}
<div id="top-box">
	<div class="top-container">
		<div id="accessibility">
			Raccourcis&nbsp;:
			<a href="#article">Contenu</a> -
			<a href="#topmenubar">rubriques</a> -
			<a href="#submenubar">sous rubriques</a>
		</div>
    {zone 'jcommunity~status'}

	<div id="lang-box">
		<a href="{jurl 'havefnubb~category:view', array('id_cat'=>2, 'ctitle'=>'english', 'lang'=>'en_EN')}" hreflang="en" title="english">EN</a>
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
            <li><a href="{jurl 'main~default:indexfr'}">À propos</a></li>
            <li><a href="/articles/fr/telechargement">Téléchargement</a></li>
            <li><a href="/articles/fr/documentation">Documentation</a></li>
            <li class="selected"><a href="/articles/fr/communaute">Communauté</a></li>
            <li><a href="/articles/fr/support">Support</a></li>
        </ul>
    </div>
</div>
<div id="main-content">
    <div class="top-container">
        <div id="content-header">
            <ul id="submenubar">
				<li class="selected"><a href="{jurl 'havefnubb~default:index'}">Forum</a></li>
				<li><a href="/articles/fr/communaute#mailing-list">Mailing List &amp; IRC</a></li>
				<li><a href="/articles/fr/goodies">Goodies</a></li>
            </ul>
        </div>
		<div id="article">
            <!--<div id="article-header">

			</div>-->
			{$MAIN}
			<div id="article-footer">
				{breadcrumb 8, ' > '}
			</div>
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
                <li><a href="https://github.com/jelix/jelix/blob/master/CONTRIBUTING.md">Comment contribuer</a></li>
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
            Copyright 2006-2020 Jelix team. <br/>
            Design par Laurentj. <br/>
			{@havefnubb~main.poweredby@} <a href="http://www.havefnubb.org" title="HaveFnuBB!">HaveFnuBB!</a><br/>
            <img src="/design/btn_jelix_powered.png" alt="page générée par une application Jelix" />
        </p>
    </div>
</div>
