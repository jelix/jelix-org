<?php
/**
* @package   %%appname%%
* @author    %%default_creator_name%%
* @copyright %%default_copyright%%
* @link      %%default_website%%
* @license   %%default_license_url%% %%default_license%%
*/

require_once (dirname(__FILE__).'./../application-cli.init.php');

$installer = new jInstaller(new textInstallReporter());

$installer->installApplication();

