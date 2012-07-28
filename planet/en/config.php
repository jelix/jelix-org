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

define('MAGPIE_CACHE_ON',true);      // activation du cache
define('MAGPIE_CACHE_DIR', 'temp/');  // nom du repertoire contenant les caches
define('MAGPIE_CACHE_AGE', 60*60*4);  // age du cache maximum (ici 4h)
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

//define('PLANET_ERROR_LOG', 'temp/erreur.log'); // fichier contenant les erreurs php
define('PLANET_ERROR_LOG', '');

require_once('../magpierss/common.php');
require_once('../magpierss/rss_fetch.inc');


/* format de la liste des fils
  liste de
      array('nom'=>'nom affiché',
         'urlrss'=>'simple chaine contenant un lien ou tableau de liens',
         'urlsite'=>'site du blog',
         'auteur'=>'Nom de l'auteur du blog')
*/

$urlRssList = array(
/*array('nom'=>'Jy[B]log',
        'urlrss'=>'http://ljouanneau.com/dotclear/rss.php?cat=jelix',
        'urlsite'=>'http://ljouanneau.com/blog/',
        'auteur'=>'Laurent Jouanneau'),*/
);


?>
