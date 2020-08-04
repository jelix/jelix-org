{meta_html js $j_jelixwww.'jquery/jquery.js'}
{meta_html js '/design/2011/home.js'}

        <p id="slogan">Jelix est un framework PHP open-source pour applications Web</p>

        <div id="releases">
            <p id="latest-release"><img src="/design/2011/icons/human-folder-downloads.png" />
                <a href="/articles/fr/telechargement/stable/1.7">Téléchargez Jelix {$versions['1.7']}</a>
                </p>
            <p id="other-releases">
                <a href="/articles/fr/telechargement/stable/1.6">{$versions['1.6']}</a> -
                <a href="/articles/fr/telechargement/nightly#telechargement-jelix-nightly">nightly</a></p>
        </div>

        <div id="carrousel">
            <div class="button prev" >
                <a href="#" class="carrousel-previous"><img src="/design/2011/left-arrow.png" alt="Previous" /></a>
            </div>
            <div class="button next">
               <a href="#" class="carrousel-next"><img src="/design/2011/right-arrow.png" alt="Next" /></a>
           </div>
            <div class="carrousel-container">
                <div class="carrousel-sections">
                    <div class="section">
                        <h2>Un framework robuste</h2>
                        <div class="section-screenshot"><img src="/design/2011/carroussel/logo3d_jelix_3quart.png" alt="screenshot" /></div>
                        <p>Depuis 2006, Jelix offre des solutions pérennes à vos projets d'applications
                            et sites web&nbsp;:</p>
                        <ul>
                            <li>Une architecture en modules réutilisables&nbsp;:
                                <strong>capitalisez sur vos développements !</strong></li>
                            <li>Une logique <abbr title="Modele Vue Controleur">MVC</abbr> et
                                une arborescence normalisée pour <strong>une maintenance facilitée</strong></li>
                            <li>Des plugins pour étendre la plupart des composants</li>
                            <li>Des APIs simples et nombreuses</li>
                            <li>Un coeur performant pour les sites exigeants</li>
                        </ul>
                    </div>
                    <div class="section">
                        <h2>Développement rapide et aisé</h2>
                        <div class="section-screenshot"><img src="/design/2011/carroussel/admin-debug.png" alt="screenshot" /></div>
                        <p>Jelix offre des composants et outils pour développer plus rapidement&nbsp;:</p>
                        <ul>
                            <li><a href="https://docs.jelix.org/fr/manuel-1.7/modules/controleurs/crud">Contrôleur CRUD générique</a>,
                                module d'<a href="https://docs.jelix.org/fr/manuel-1.7/application/creer-administration">interface d'administration</a>,
                                <a href="https://docs.jelix.org/fr/manuel-1.7/modules/vues/index">vues dédiées</a> à (X)HTML, ATOM, RSS,
                                ZIP, PDF...</li>
                            <li><a href="https://docs.jelix.org/fr/manuel-1.7/installation/jelix-scripts">Scripts en lignes de commande</a> pour générer rapidement du code</li>
                            <li><a href="https://docs.jelix.org/fr/manuel-1.7/outils-dev/deboggage#la-debug-barre">Debug bar</a> pour faciliter le debuggage.</li>
                        </ul>
                        <p>Utilisez les modules et plugins disponibles <strong><a href="https://packagist.org/packages/jelix">sur Packagist</a></strong>.
                            <a href="/articles/fr/composants-independants">Utilisez certains composants</a> en dehors de Jelix</p>
                    </div>
                    <div class="section">
                        <h2>Fonctionnalités</h2>
                        <div class="section-screenshot"><img src="/design/2011/carroussel/soap-tpl.png" alt="screenshot" /></div>
                        <p>Le framework fourni une multitude de composants&nbsp;:
                            <a href="https://docs.jelix.org/fr/manuel-1.7/composants/daos">un ORM</a>,
                            un <a href="https://docs.jelix.org/fr/manuel-1.7/composants/jforms">système de formulaire</a>,
                            un <a href="https://docs.jelix.org/fr/manuel-1.7/composants/templates">moteur de template</a>,
                            un <a href="https://docs.jelix.org/fr/manuel-1.7/composants/events">système évènementiel</a>,
                            un module d'<a href="https://docs.jelix.org/fr/manuel-1.7/composants/authentification">authentification</a>,
                            de <a href="https://docs.jelix.org/fr/manuel-1.7/composants/droits">gestion de droits</a>...</p>
                        <p>Sans oublier l'aspect <a href="https://docs.jelix.org/fr/manuel-1.7/composants/locales">multi-langue</a> et
                            la gestion de <a href="https://docs.jelix.org/fr/manuel-1.7/application/themes">themes</a> graphiques.</p>
                        <p>Développez aisément vos services Web, qu'ils soient
                            <a href="https://docs.jelix.org/fr/manuel-1.7/modules/controleurs/rest-full">REST-Full</a>,
                            en <a href="https://docs.jelix.org/fr/manuel-1.7/modules/services-web/soap">SOAP</a>,
                            en <a href="https://docs.jelix.org/fr/manuel-1.7/modules/services-web/xml-rpc">xml-rpc</a>,
                            en <a href="https://docs.jelix.org/fr/manuel-1.7/modules/services-web/ajax">ajax</a> etc.</p>
                    </div>
                    <div class="section">
                        <h2>Qualité et robustesse</h2>
                        <div class="section-screenshot"><img src="/design/2011/carroussel/security-test.png" alt="screenshot" /></div>
                        <p>Une robustesse à tout niveau&nbsp;:</p>
                        <ul>
                            <li>Sécurité avant tout&nbsp;: dans les formulaires, l'authentification...</li>
                            <li>Une gestion poussée des erreurs, et respectant les protocoles utilisés</li>
                            <li>Des milliers de tests unitaires sur les composants de jelix</li>
                            <li>Intégration de PHPUnit pour vos propres tests</li>
                        </ul>
                    </div>
                    <div class="section">
                        <h2>Deploiement</h2>
                        <div class="section-screenshot"><img src="/design/2011/carroussel/wizard.png" alt="screenshot" /></div>
                        <p>Un deploiement aisé et rapide grâce au
                            <a href="https://docs.jelix.org/fr/manuel-1.7/configurateur-installateur/creer-script-installation">système d'installation et de mise à jour</a> de Jelix.</p>
                        <p>Vous diffusez votre application à un large public ? Utilisez
                            <a href="https://docs.jelix.org/fr/manuel-1.7/configurateur-installateur/creer-wizard">le wizard</a> de jelix,
                            et en quelques clics l'application est installée et prête à l'emploi</p>
                    </div>
                    <div class="section">
                        <h2>Choisissez Jelix !</h2>
                        <div class="section-screenshot"><img src="/design/2011/carroussel/medaillon.png" alt="screenshot" /></div>
                        <p>La communauté francophone et anglophone des utilisateurs de jelix, ainsi
                        qu'un support professionnel, sont là pour vous accompagner dans l'utilisation du framework.</p>
                        <p>Du site aux millions de visiteurs/jour à l'application intranet en passant
                        par la boutique e-commerce, des centaines de projets reposent sur Jelix.
                        Pourquoi pas le vôtre ?</p>
                    </div>
               </div>
            </div>
        </div>

{*
        <div class="content-box" id="jelix-users">
            <h2>Ils utilisent Jelix</h2>

            <ul>
                <li><a href="#jelix-users-1"><img src="/design/2011/users/transatel.png" alt="Transatel" /></a></li>
                <li><a href="#jelix-users-2"><img src="/design/2011/users/3liz.png" alt="3Liz"/></a></li>
                <li><a href="#jelix-users-3"><img src="/design/2011/users/overblog.png" alt="Over-Blog"/></a></li>
                <li><a href="#jelix-users-4"><img src="/design/2011/users/bp2i.png" alt="BNP Parisbas"/></a></li>
            </ul>
            <div id="jelix-users-description">
                <p id="jelix-users-1">En 2011, <a href="http://transatel.com">Transatel</a> a choisi Jelix pour développer ses applications B2B qui
                    servent à gérer des millions de carte SIM (individuels ou 'Machine To Machine') pour leurs clients
                    professionnels. Parmi eux, Everything Everywhere (joint-venture de Orange et T-Mobile au Royaume Uni), Mobistars et
                    d'autres MVNOs.</p>
                <p id="jelix-users-2"><a href="http://3liz.com">3Liz</a>, spécialisé dans les solutions pour les systèmes d'informations géographiques,
                fournis des applications web comme <a href="https://lizmap.com/">LizMap</a>, reposant sur Jelix.</p>
                <p id="jelix-users-3">De 2006 à 2012, Jelix a motorisé la plus grosse plateforme de blog européène, over-blog.com.
                    <br/>Over-Blog était l'un des premiers utilisateurs historique de Jelix.</p>
                <p id="jelix-users-4">BNP Parisbas utilise jelix dans des applications intranet.</p>
            </div>
            <p>Et <a href="/articles/fr/hall-of-fame">bien plus encore...</a></p>
        </div>
*}

        <div class="content-box" id="home-items">
            
            <div class="home-item">
                <h2>Documentation</h2>

                <dl>
                    <dt><img src="/design/2011/icons/applications-education.png" />
                        <a href="/articles/fr/tutoriels/minitutoriel/1.6.x">Mini tutoriel</a></dt>
                    <dd>Pour découvrir Jelix</dd>
                    <dt><img src="/design/2011/icons/applications-office.png" />
                        <a href="https://docs.jelix.org/fr/manuel-1.7/">Manuel complet</a></dt>
                    <dd>En français, <a href="https://docs.jelix.org/fr/manuel-1.7/">en ligne</a>,
                    pour bien apprendre les concepts et l'utilisation des composants de Jelix</dd>
                    <!--<dt><img src="icons/applications-science.png" /><a href="">Cookbook</a></dt>
                    <dd>Trucs et astuces</dd>-->
                    <dt><img src="/design/2011/icons/applications-system.png" /><a href="/reference/">Référence détaillée des APIs</a></dt>
                    <dd>Entrez dans le coeur de Jelix</dd>
                    <dt><a href="/articles/fr/composants-independants">Composants indépendants</a></dt>
                    <dd>Liste des composants que vous pouvez utilisez sans Jelix</dd>
                </dl>
            </div>
            
            <div class="home-item">
                <h2>Communauté</h2>
                
                <dl>
                    <dt><img src="/design/2011/icons/vegastrike.png" /><a href="https://booster.jelix.org">Booster !</a></dt>
                    <dd>Profitez des modules et plugins de la communauté pour booster vos projets</dd>
                    <dt><img src="/design/2011/icons/emblem-people.png" /><a href="{jurl 'havefnubb~category:view',array('id_cat'=>1,'ctitle'=>'Français')}">Forum</a></dt>
                    <dd>Posez vos questions sur le forum</dd>
                    <dt><img src="/design/2011/icons/help-faq.png" /><a href="/articles/fr/irc">IRC</a></dt>
                    <dd>Discutez en live avec votre client IRC préféré <a href="/articles/fr/irc">ou sur le site</a></dd>
                </dl>
            </div>

            <div class="home-item">
                <h2>Contributions</h2>
                <dl>
                    <dt><img src="/design/2011/icons/github.jpg" /><a href="https://github.com/jelix/jelix">Jelix sur Github !</a></dt>
                    <dd>Forkez et proposez des améliorations</dd>
                    <dt><img src="/design/2011/icons/bug-buddy.png" /><a href="https://github.com/jelix/jelix/issues">Suivi des bugs</a></dt>
                    <dd>Rapportez les bugs rencontrés, ou vos demandes d'améliorations</dd>
                </dl>
            </div>
            <hr />
       
        </div>

        <div class="content-box">
            <div class="home-item" id="home-news">
            
                <h2>Actualités</h2>
			   {$news}
			   <p class="news-link"><a href="{jurl 'news~default:index', array('lang'=>'fr_FR')}">Autres brêves</a>,
			   <a href="{jurl 'news~default:rss', array('lang'=>'fr_FR')}">fils RSS</a></p>

            </div>

            <div class="home-item">
				<h2>Liste de discussion</h2>
				<p>Tenez-vous au courant de l'actualité Jelix par mail,
				et discutez avec les autres utilisateurs.
                    <a href="https://groups.google.com/forum/#!forum/jelix/join">Inscrivez-vous</a>.</p>
            </div>  
            <div class="home-item">
            <h2>Jelix Sur twitter</h2>
                <p><a href="https://twitter.com/jelixfmk">@jelixfmk</a></p>
            </div>
            <hr />
        </div>

