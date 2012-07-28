<?php
/**
* @package  xulfr.org
* @subpackage planete
* @version  1.0
* @author   Jouanneau Laurent
* @contributor
* @copyright 2005-2006 Jouanneau laurent
* @link     http://www.xulfr.org
* @licence  GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
*/


require_once('config.php');

$billets = getBillets();

if(count($billets)){
   $ts = $billets[0]['date_timestamp'];
}else{
   $ts = mktime();
}


function display_rsslist_rssseq ($maxbillets = 10)
{
  global $billets;

    $i=0;
    foreach($billets as $billet){
        ?>
        <rdf:li rdf:resource="<?php echo $billet['link'];?>"/>
        <?php
        if(++$i > $maxbillets)
            break;
    }
}

function display_rsslist_rss ($maxbillets = 10)
{
  global $billets;


  $i=0;
  foreach($billets as $billet){
     ?>
<item rdf:about="<?php echo $billet['link'];?>">
    <title><?php echo htmlspecialchars($billet['title']);?></title>
    <link><?php echo htmlspecialchars($billet['link']);?></link>
    <dc:date><?php echo date('Y-m-d\\TH:i:s+00:00',$billet['date_timestamp']); ?></dc:date>
    <dc:language>fr</dc:language>
    <dc:creator><?php echo htmlspecialchars($billet['channel_title']);?></dc:creator>
    <dc:subject></dc:subject>
	<description><?php
      if(isset($billet['description']))
         echo htmlspecialchars($billet['description']);
         ?></description>
	<content:encoded><![CDATA[<?php
      if(isset($billet['content']['encoded']))
         echo $billet['content']['encoded'];
     ?>]]></content:encoded>
</item>
     <?php
     if(++$i > $maxbillets)
          break;
  }
}


header('Content-Type: text/xml; charset=UTF-8') ;

echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
?>

<rdf:RDF
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
  xmlns:admin="http://webns.net/mvcb/"
  xmlns:cc="http://web.resource.org/cc/"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns="http://purl.org/rss/1.0/">

<channel rdf:about="http://planet.jelix.org/">
  <title>Planète Jelix</title>
  <description></description>
  <link>http://planet.jelix.org/</link>
  <dc:language>en-EN</dc:language>
  <dc:creator></dc:creator>
  <dc:rights></dc:rights>
  <dc:date><?php echo date('Y-m-d\\TH:i:s+00:00',$ts); ?></dc:date>
  <admin:generatorAgent rdf:resource="http://planet.jelix.org/" />

  <items>
  <rdf:Seq>
     <?php display_rsslist_rssseq() ?>
  </rdf:Seq>
  </items>
</channel>
  <?php  display_rsslist_rss(); ?>
</rdf:RDF>
