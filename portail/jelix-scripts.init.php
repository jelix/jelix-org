<?php
/**
 * @package     www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2007-2012 Laurent Jouanneau
 * @link     http://jelix.org
 * @licence  http://www.gnu.org/licenses/gpl.html GNU General Public Licence, see LICENCE file
 */

require(dirname(__FILE__).'/../lib/jelix/init.php');

define ('JELIX_APP_PATH', dirname (__FILE__).'/'); // don't change

define ('JELIX_APP_VAR_PATH',     JELIX_APP_PATH.'var/');
define ('JELIX_APP_LOG_PATH',     JELIX_APP_PATH.'var/log/');
define ('JELIX_APP_CONFIG_PATH',  JELIX_APP_PATH.'var/config/');
define ('JELIX_APP_WWW_PATH',     realpath(JELIX_APP_PATH.'../www/').'/');
define ('JELIX_APP_CMD_PATH',     JELIX_APP_PATH.'scripts/');

// the temp path for jelix-scripts
define ('JELIX_APP_TEMP_PATH',    realpath(JELIX_APP_PATH.'../temp/portail-scripts/').'/');

// the temp path for cli scripts of the application
define ('JELIX_APP_TEMP_CLI_PATH',    realpath(JELIX_APP_PATH.'../temp/portail-cli/').'/');

// the temp path for the web scripts of the application (the same value as JELIX_APP_TEMP_PATH in application.init.php)
define ('JELIX_APP_REAL_TEMP_PATH',    realpath(JELIX_APP_PATH.'../temp/portail/').'/');