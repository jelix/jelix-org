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

error_reporting(E_ALL);         // mettre 0 pour ne reporter aucune erreur dans le fichier de log
date_default_timezone_set  ('Europe/Paris');
set_error_handler('ErrorHandler');


function cmpBillets($item1, $item2)
{
   $t1 = $item1['date_timestamp'];
   $t2 = $item2['date_timestamp'];

   if ($t1 == $t2) {
       return 0;
   }
   return ($t1 > $t2) ? -1 : 1;
}

$billets = array();
$gCurrentRss ='';

function getBillets(){
   global $urlRssList , $billets;
   $billets = array();
   foreach($urlRssList as $url){
      if(is_array($url['urlrss'])){
        foreach($url['urlrss'] as $urlrss){
            addRss($urlrss, $url['auteur']);
        }
      }else{
        addRss($url['urlrss'], $url['auteur']);
      }
   }
   if(count($billets))
       usort($billets, "cmpBillets");

   return $billets;
}

function addRss($urlrss, $auteur){
   global $billets, $rss, $gCurrentRss;
   $gCurrentRss = $urlrss;
   $rss = fetch_rss( $urlrss );
   if($rss){
      foreach($rss->items as $item){
         $item['channel_title'] =  $rss->channel['title'];
         $item['channel_link'] =  $rss->channel['link'];
         if(isset($item['author_name'])){
             $item['auteur'] = $item['author_name'];
         }elseif(isset($item['dc']['author'])){
             $item['auteur'] =$item['dc']['author'];
         }elseif(isset($item['dc']['creator'])){
             $item['auteur'] =$item['dc']['creator'];
         }elseif(isset($rss->channel['dc']['creator'])){
            $item['auteur'] = $rss->channel['dc']['creator'];
         }else{
            $item['auteur'] = $auteur;
         }
         $billets[] = $item;
      }
   }
}



function ErrorHandler($errno, $errmsg, $filename, $linenum, $vars){
   global $gCurrentRss;
    if (error_reporting() == 0)
        return;
   if(PLANET_ERROR_LOG !=''){
        $f = fopen(PLANET_ERROR_LOG,'a');
        if($f){
            $str = date('Y-m-d H:i:s').' '.$errmsg.' file='.$filename.' '.$linenum." rss=$gCurrentRss \n";
            fwrite($f, $str);
            fclose($f);
        }
   }
}
?>
