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
array('nom'=>'Bastnic\'s blog',
        'urlrss'=>'http://bastnic.info/index.php/feed/tag/Jelix/rss2',
        'urlsite'=>'http://bastnic.info/',
        'auteur'=>'Bast'),
array('nom'=>'bballizlife\'s blog',
        'urlrss'=>'http://bballizlife.com/blog/feed/tag/jelix/atom',
        'urlsite'=>'http://bballizlife.com/blog/',
        'auteur'=>'Loïc Mathaud'),

array('nom'=>'Carnet Web de Sébastien De Bollivier',
        'urlrss'=>'http://www.despe974.org/category/jelix/feed/',
        'urlsite'=>'http://www.despe974.org/',
        'auteur'=>'Sébastien De Bollivier'),

/*array('nom'=>'Doubleface',
        'urlrss'=>'http://blog.doubleface.info/index.php?feed/tag/jelix/rss2',
        'urlsite'=>'http://blog.doubleface.info/',
        'auteur'=>'Christophe Thiriot'),
*/
array('nom'=>'Foxmask',
        'urlrss'=>'http://www.foxmask.info/tag/jelix/feed/',
        'urlsite'=>'http://www.foxmask.info/',
        'auteur'=>'Foxmask'),

array('nom'=>'Jy[B]log',
        'urlrss'=>'http://ljouanneau.com/blog/feed/tag/jelix/atom',
        'urlsite'=>'http://ljouanneau.com/blog/',
        'auteur'=>'Laurent Jouanneau'),


array('nom'=>'m@nOO',
        'urlrss'=>'http://manoo.fr/dev/index.php?feed/tag/jelix/atom',
        'urlsite'=>'http://manoo.fr/dev/',
        'auteur'=>'m@nOO'),

array('nom'=>'jShop',
        'urlrss'=>'http://blog.jshop.toopi.info/?feed/atom',
        'urlsite'=>'http://blog.jshop.toopi.info/',
        'auteur'=>'Kevin'),



);





?>
