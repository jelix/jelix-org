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

            echo '<div class="news-infos">', date('d-m-Y  H:i:s',$billet['date_timestamp']),'</div>';
            echo '<div class="news-content">';
            //<div class="content">
            if(isset($billet['content']['encoded'])){
              echo $billet['content']['encoded'];
            }else{
               echo '<p>',htmlspecialchars($billet['description']),'</p>';
            }

            echo '</div>';
            echo '<p class="post-info">By ',$billet['auteur'];
            echo ' <a href="',$billet['link'],'" title="article on the original web site">sur ', htmlspecialchars($billet['channel_title']), '</a></p>';
            echo '</div>';

            if(++$i > $maxbillets)
                break;
        }
    }else{
        echo '<p>No post for the moment. If you want to appear on this planet, subscribe yourself !.</p>';
    }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_EN" lang="en_EN">
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type"/>
    <title>Jelix Planet - Jelix, PHP framework</title>
    <meta name="description" content="Planet of blogs on Jelix" />
    <meta name="keywords" content="PHP Framework Jelix standards web services mvc CSS XHTML XUL" />
    <link type="text/css" href="/design/2008/design.css" media="screen" title="Jelix" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <meta name="DC.title" content="Jelix, PHP framework" />
    <meta name="DC.description" content="Planet of blogs on Jelix" />
    <meta name="robots" content="index,follow,all" />
    <link rel="alternate" type="application/rss+xml" title="RSS news feed" href="/en/rss.php" />
</head>
<body >
    <div id="top-box">
        <div id="accessibility">Short cuts :
            <a href="#main">Content</a> -
            <a href="#news">blogs list</a> -
            <a href="#topmenubar">sections</a>
        </div>
        <div id="lang-box">
            <strong>en</strong> <a href="/fr/" hreflang="fr">fr</a>
        </div>
    </div>

   <h1 id="logo"><img src="/design/logo/logo_jelix_moyen2.png" alt="Jelix" /><br/>
   The planet
   </h1>

<div id="header">

<ul id="topmenubar">
    <li class="selected"><a href="/en/">Planet</a></li>
    <li><a href="http://jelix.org">Portal</a></li>
    <li><a href="http://developer.jelix.org">Developers</a></li>
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
      <p>Do you want to add your blog on the planet ? Send an email to <em>laurent at jelix dot org</em>.</p>
    </div>
    <div class="menubox">
        <h3>Syndication</h3>
        <ul>
           <li><a href="rss.php">Rss</a></li>
        </ul>
        <p>Note : RSS flux are updated every 4 hours.</p>
    </div>
 </div>
 <div style="margin-right:24em;">
  <h1 id="top">Last posts</h1>
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