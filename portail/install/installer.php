<?php
/**
* @package   www.jelix.org
* @author    Laurent Jouanneau
* @copyright 2006-2012 Laurent Jouanneau
* @link      http://jelix.org
* @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
*/

require_once (dirname(__FILE__).'./../application-cli.init.php');

$installer = new jInstaller(new textInstallReporter());

$installer->installApplication();

