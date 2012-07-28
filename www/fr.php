<?php
/**
 * @package     www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2007-2012 Laurent Jouanneau
 * @link     http://jelix.org
 * @licence  http://www.gnu.org/licenses/gpl.html GNU General Public Licence, see LICENCE file
 */

require_once ('../portail/application.init.php');

require_once (JELIX_LIB_CORE_PATH.'request/jClassicRequest.class.php');

$config_file = 'fr/config.ini.php';

$jelix = new jCoordinator($config_file);
$jelix->process(new jClassicRequest());

