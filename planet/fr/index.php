<?php

/**
* @package  xulfr.org
* @subpackage planete
* @version  1.1
* @author   Jouanneau Laurent
* @contributor
* @copyright 2005-2008 Jouanneau laurent
* @link     http://www.xulfr.org
* @licence  GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
*/


/*
if (strstr($_SERVER['HTTP_ACCEPT'],'application/xhtml+xml')){
  header("Content-type: application/xhtml+xml");
  echo "<?xml version='1.0' encoding='iso-8859-1'?>\n";
} else {*/
  header("Content-type: text/html; charset=utf-8");
//}

require_once('config.php');

function display_rsslist_html ($maxbillets = 10)
{
  $billets = getBillets();
   if(count($billets)){
        $i=0;
        foreach($billets as $billet){
            echo '<div class="news">';
            echo '<h2><a href="',$billet['link'],'">',htmlspecialchars($billet['title']),'</a></h2>';

            echo '<div class="news-infos">', date('d-m-Y à H:i:s',$billet['date_timestamp']),'</div>';
            echo '<div class="news-content">';
            //<div class="content">
            if(isset($billet['content']['encoded'])){
              echo $billet['content']['encoded'];
            }else{
               echo '<p>',htmlspecialchars($billet['description']),'</p>';
            }

            echo '</div>';
            echo '<p class="post-info">Par ',$billet['auteur'];
            echo ' <a href="',$billet['link'],'" title="article sur le site original">sur ', htmlspecialchars($billet['channel_title']), '</a></p>';
            echo '</div>';

            if(++$i > $maxbillets)
                break;
        }
    }else{
        echo '<p>Pas de billets pour le moment.</p>';
    }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr_FR" lang="fr_FR">
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type"/>
    <title>Planète Jelix - Jelix, framework PHP</title>
    <meta name="description" content="Planète des blogs sur Jelix" />
    <meta name="keywords" content="PHP Framework Jelix standards web services mvc CSS XHTML XUL" />
    <link type="text/css" href="/design/2008/design.css" media="screen" title="Jelix" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <meta name="DC.title" content="Jelix, PHP framework" />
    <meta name="DC.description" content="Planete à propos de Jelix, un framework PHP" />
    <meta name="robots" content="index,follow,all" />
    <link rel="alternate" type="application/rss+xml" title="RSS news feed" href="/fr/rss.php" />
</head>
<body >
    <div id="top-box">
        <div id="accessibility">Raccourcis :
            <a href="#main">Contenu</a> -
            <a href="#news">Liste des blogs</a>
        </div>
        <div id="lang-box">
            <a href="/en/" hreflang="en">en</a>  <strong>fr</strong>
        </div>
    </div>

   <h1 id="logo"><img src="/design/logo/logo_jelix_moyen2.png" alt="Jelix" /><br/>
   La planète
   </h1>
    
<div id="header">

<ul id="topmenubar">
    <li class="selected"><a href="/fr/">Accueil</a></li>
    <li><a href="http://jelix.org">Portail</a></li>
    <li><a href="http://developer.jelix.org">Développeurs</a></li>
</ul>

<ul id="submenubar">
</ul>

</div>

<div id="main">

  <div id="homesidebar">

    <div id="news">

      <h1>Blogs</h1>
      <ul>
      <?php
      foreach($urlRssList as $url){
      ?>
      <li><a href="<?php echo $url['urlsite']?>" title="<?php echo $url['auteur']?>"><?php echo $url['nom']?></a></li>
      <?php } ?>
      </ul>
         <p>Vous voulez que votre blog soit intégré à cette liste ?
         Envoyez un mail à <em>laurent chez jelix.org</em>.</p>
    </div>
    <div class="menubox">
        <h3>Syndication</h3>
        <ul>
           <li><a href="rss.php">Rss</a></li>
        </ul>
        <p>Note : la récupération des fils RSS se fait toutes les 4 heures</p>
    </div>
  </div>
  <div style="margin-right:24em;">
  <h1 id="top">Les derniers billets</h1>
  <?php

  display_rsslist_html();

  ?>
  </div>
  <div style="clear:both;"></div>
</div>
<div id="footer" class="full">
 
</div>

</body>
</html>