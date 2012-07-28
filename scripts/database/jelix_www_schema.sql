-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: jelix_www
-- ------------------------------------------------------
-- Server version	5.1.49-3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `book_pages`
--

DROP TABLE IF EXISTS `book_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_pages` (
  `book_page_id` varchar(100) NOT NULL,
  `book_id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `contents_order` tinyint(4) NOT NULL DEFAULT '0',
  `type` char(1) NOT NULL,
  `parent` varchar(100) DEFAULT NULL,
  `next` varchar(100) DEFAULT NULL,
  `prev` varchar(100) DEFAULT NULL,
  `path` text,
  PRIMARY KEY (`book_page_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `book_id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `title_short` varchar(255) NOT NULL,
  `edition` varchar(255) NOT NULL,
  `authors` tinytext NOT NULL,
  `copyright_years` varchar(255) NOT NULL,
  `copyright_holders` tinytext NOT NULL,
  `hierarchy` text,
  `legalnotice` text,
  `legalnoticehtml` text,
  `pagelegalnoticehtml` text,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_users`
--

DROP TABLE IF EXISTS `community_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `keyactivate` varchar(10) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `abstract` text NOT NULL,
  `content` text NOT NULL,
  `date_create` datetime NOT NULL,
  `lang` varchar(5) NOT NULL,
  `author` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`news_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_banlists`
--

DROP TABLE IF EXISTS `phorum_banlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_banlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `pcre` tinyint(4) NOT NULL DEFAULT '0',
  `string` varchar(255) NOT NULL DEFAULT '',
  `comments` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_bans`
--

DROP TABLE IF EXISTS `phorum_bans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_bans` (
  `ban_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_username` varchar(200) DEFAULT NULL,
  `ban_ip` varchar(255) DEFAULT NULL,
  `ban_email` varchar(50) DEFAULT NULL,
  `ban_message` varchar(255) DEFAULT NULL,
  `ban_expire` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ban_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_category`
--

DROP TABLE IF EXISTS `phorum_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_category` (
  `id_cat` int(12) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_order` int(4) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_community_users`
--

DROP TABLE IF EXISTS `phorum_community_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_community_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `keyactivate` varchar(10) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_connected`
--

DROP TABLE IF EXISTS `phorum_connected`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_connected` (
  `id_user` int(12) NOT NULL DEFAULT '1',
  `member_ip` varchar(200) NOT NULL DEFAULT '',
  `connected` int(10) unsigned NOT NULL DEFAULT '0',
  `idle` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_files`
--

DROP TABLE IF EXISTS `phorum_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(11) NOT NULL DEFAULT '0',
  `file_data` mediumtext NOT NULL,
  `add_datetime` int(10) unsigned NOT NULL DEFAULT '0',
  `message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `link` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`file_id`),
  KEY `add_datetime` (`add_datetime`),
  KEY `message_id_link` (`message_id`,`link`),
  KEY `user_id_link` (`user_id`,`link`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_forum`
--

DROP TABLE IF EXISTS `phorum_forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_forum` (
  `id_forum` int(12) NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(255) NOT NULL,
  `id_cat` int(12) NOT NULL,
  `forum_desc` varchar(255) NOT NULL,
  `forum_order` int(4) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_level` int(4) NOT NULL,
  `forum_type` int(1) NOT NULL,
  `forum_url` varchar(255) DEFAULT NULL,
  `post_expire` int(5) DEFAULT '0',
  PRIMARY KEY (`id_forum`),
  KEY `id_cat` (`id_cat`),
  KEY `parent_id` (`parent_id`),
  KEY `child_level` (`child_level`),
  KEY `forum_type` (`forum_type`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_forum_group_xref`
--

DROP TABLE IF EXISTS `phorum_forum_group_xref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_forum_group_xref` (
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `permission` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`forum_id`,`group_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_forums`
--

DROP TABLE IF EXISTS `phorum_forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_forums` (
  `forum_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` smallint(6) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `template` varchar(50) NOT NULL DEFAULT '',
  `folder_flag` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `list_length_flat` int(10) unsigned NOT NULL DEFAULT '0',
  `list_length_threaded` int(10) unsigned NOT NULL DEFAULT '0',
  `moderation` int(10) unsigned NOT NULL DEFAULT '0',
  `threaded_list` tinyint(4) NOT NULL DEFAULT '0',
  `threaded_read` tinyint(4) NOT NULL DEFAULT '0',
  `float_to_top` tinyint(4) NOT NULL DEFAULT '0',
  `check_duplicate` tinyint(4) NOT NULL DEFAULT '0',
  `allow_attachment_types` varchar(100) NOT NULL DEFAULT '',
  `max_attachment_size` int(10) unsigned NOT NULL DEFAULT '0',
  `max_attachments` int(10) unsigned NOT NULL DEFAULT '0',
  `pub_perms` int(10) unsigned NOT NULL DEFAULT '0',
  `reg_perms` int(10) unsigned NOT NULL DEFAULT '0',
  `display_ip_address` smallint(5) unsigned NOT NULL DEFAULT '1',
  `allow_email_notify` smallint(5) unsigned NOT NULL DEFAULT '1',
  `language` varchar(100) NOT NULL DEFAULT 'english',
  `email_moderators` tinyint(1) NOT NULL DEFAULT '0',
  `message_count` int(10) unsigned NOT NULL DEFAULT '0',
  `thread_count` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post_time` int(10) unsigned NOT NULL DEFAULT '0',
  `display_order` int(10) unsigned NOT NULL DEFAULT '0',
  `read_length` int(10) unsigned NOT NULL DEFAULT '0',
  `edit_post` tinyint(1) NOT NULL DEFAULT '1',
  `template_settings` text NOT NULL,
  `count_views` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `display_fixed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vroot` int(10) NOT NULL DEFAULT '0',
  `reverse_threading` tinyint(1) NOT NULL DEFAULT '0',
  `inherit_id` int(10) unsigned DEFAULT NULL,
  `max_totalattachment_size` int(10) unsigned DEFAULT '0',
  `sticky_count` int(10) unsigned NOT NULL DEFAULT '0',
  `cache_version` int(10) unsigned NOT NULL DEFAULT '0',
  `forum_path` text NOT NULL,
  `count_views_per_thread` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`forum_id`),
  KEY `name` (`name`),
  KEY `active` (`active`,`parent_id`),
  KEY `group_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_groups`
--

DROP TABLE IF EXISTS `phorum_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `open` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_jacl2_group`
--

DROP TABLE IF EXISTS `phorum_jacl2_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_jacl2_group` (
  `id_aclgrp` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '',
  `grouptype` tinyint(4) NOT NULL DEFAULT '0',
  `ownerlogin` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_aclgrp`)
) ENGINE=MyISAM AUTO_INCREMENT=560 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_jacl2_rights`
--

DROP TABLE IF EXISTS `phorum_jacl2_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_jacl2_rights` (
  `id_aclsbj` varchar(100) NOT NULL DEFAULT '',
  `id_aclgrp` int(11) NOT NULL DEFAULT '0',
  `id_aclres` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_aclsbj`,`id_aclgrp`,`id_aclres`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_jacl2_subject`
--

DROP TABLE IF EXISTS `phorum_jacl2_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_jacl2_subject` (
  `id_aclsbj` varchar(100) NOT NULL DEFAULT '',
  `label_key` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_aclsbj`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_jacl2_user_group`
--

DROP TABLE IF EXISTS `phorum_jacl2_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_jacl2_user_group` (
  `login` varchar(50) NOT NULL DEFAULT '',
  `id_aclgrp` int(11) NOT NULL DEFAULT '0',
  KEY `login` (`login`,`id_aclgrp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_jmessenger`
--

DROP TABLE IF EXISTS `phorum_jmessenger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_jmessenger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_from` int(11) NOT NULL DEFAULT '0',
  `id_for` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `isSeen` tinyint(4) NOT NULL,
  `isArchived` tinyint(4) NOT NULL,
  `isReceived` tinyint(4) NOT NULL,
  `isSend` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_member`
--

DROP TABLE IF EXISTS `phorum_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_member` (
  `id_user` int(12) NOT NULL AUTO_INCREMENT,
  `member_login` varchar(50) NOT NULL,
  `member_password` varchar(50) NOT NULL,
  `member_email` varchar(255) NOT NULL,
  `member_nickname` varchar(50) DEFAULT NULL,
  `member_status` tinyint(4) NOT NULL DEFAULT '0',
  `member_keyactivate` varchar(10) DEFAULT NULL,
  `member_request_date` datetime DEFAULT NULL,
  `member_website` varchar(255) DEFAULT NULL,
  `member_firstname` varchar(40) DEFAULT NULL,
  `member_birth` date NOT NULL DEFAULT '1980-01-01',
  `member_country` varchar(100) DEFAULT NULL,
  `member_town` varchar(100) DEFAULT NULL,
  `member_comment` varchar(255) DEFAULT NULL,
  `member_avatar` varchar(255) DEFAULT NULL,
  `member_xfire` varchar(80) DEFAULT NULL,
  `member_icq` varchar(80) DEFAULT NULL,
  `member_hotmail` varchar(255) DEFAULT NULL,
  `member_yim` varchar(255) DEFAULT NULL,
  `member_aol` varchar(255) DEFAULT NULL,
  `member_gtalk` varchar(255) DEFAULT NULL,
  `member_jabber` varchar(255) DEFAULT NULL,
  `member_proc` varchar(40) DEFAULT NULL,
  `member_mb` varchar(40) DEFAULT NULL,
  `member_card` varchar(40) DEFAULT NULL,
  `member_ram` varchar(40) DEFAULT NULL,
  `member_display` varchar(40) DEFAULT NULL,
  `member_screen` varchar(40) DEFAULT NULL,
  `member_mouse` varchar(40) DEFAULT NULL,
  `member_keyb` varchar(40) DEFAULT NULL,
  `member_os` varchar(40) DEFAULT NULL,
  `member_connection` varchar(40) DEFAULT NULL,
  `member_last_connect` int(12) DEFAULT NULL,
  `member_show_email` varchar(1) DEFAULT 'N',
  `member_language` varchar(40) DEFAULT 'fr_FR',
  `member_nb_msg` int(12) DEFAULT '0',
  `member_last_post` int(12) NOT NULL DEFAULT '0',
  `member_created` datetime DEFAULT NULL,
  `member_gravatar` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`member_login`),
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=567 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_member_custom_fields`
--

DROP TABLE IF EXISTS `phorum_member_custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_member_custom_fields` (
  `id_user` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id_user`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_messages`
--

DROP TABLE IF EXISTS `phorum_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `thread` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `ip` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2',
  `msgid` varchar(100) NOT NULL DEFAULT '',
  `modifystamp` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `thread_count` int(10) unsigned NOT NULL DEFAULT '0',
  `moderator_post` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sort` tinyint(4) NOT NULL DEFAULT '2',
  `datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `meta` mediumtext NOT NULL,
  `viewcount` int(10) unsigned NOT NULL DEFAULT '0',
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  `recent_message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `recent_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `recent_author` varchar(255) NOT NULL DEFAULT '',
  `moved` tinyint(1) NOT NULL DEFAULT '0',
  `threadviewcount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`),
  KEY `thread_message` (`thread`,`message_id`),
  KEY `thread_forum` (`thread`,`forum_id`),
  KEY `special_threads` (`sort`,`forum_id`),
  KEY `status_forum` (`status`,`forum_id`),
  KEY `list_page_float` (`forum_id`,`parent_id`,`modifystamp`),
  KEY `list_page_flat` (`forum_id`,`parent_id`,`thread`),
  KEY `forum_max_message` (`forum_id`,`message_id`,`status`,`parent_id`),
  KEY `last_post_time` (`forum_id`,`status`,`modifystamp`),
  KEY `next_prev_thread` (`forum_id`,`status`,`thread`),
  KEY `dup_check` (`forum_id`,`author`(50),`subject`,`datestamp`),
  KEY `recent_user_id` (`recent_user_id`),
  KEY `new_count` (`forum_id`,`status`,`moved`,`message_id`),
  KEY `new_threads` (`forum_id`,`status`,`parent_id`,`moved`,`message_id`),
  KEY `user_messages` (`user_id`,`message_id`),
  KEY `updated_threads` (`status`,`parent_id`,`modifystamp`),
  KEY `recent_threads` (`status`,`parent_id`,`message_id`,`forum_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6470 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_messages_edittrack`
--

DROP TABLE IF EXISTS `phorum_messages_edittrack`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_messages_edittrack` (
  `track_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `diff_body` text,
  `diff_subject` text,
  PRIMARY KEY (`track_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_notify`
--

DROP TABLE IF EXISTS `phorum_notify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_notify` (
  `id_notify` int(12) NOT NULL AUTO_INCREMENT,
  `id_user` int(12) NOT NULL,
  `id_post` int(12) NOT NULL,
  `parent_id` int(12) NOT NULL,
  `id_forum` int(12) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_created` int(12) NOT NULL,
  `date_modified` int(12) NOT NULL,
  PRIMARY KEY (`id_notify`),
  KEY `id_user` (`id_user`),
  KEY `id_post` (`id_post`)
) ENGINE=MyISAM AUTO_INCREMENT=6616 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_pm_buddies`
--

DROP TABLE IF EXISTS `phorum_pm_buddies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_pm_buddies` (
  `pm_buddy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `buddy_user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pm_buddy_id`),
  UNIQUE KEY `userids` (`user_id`,`buddy_user_id`),
  KEY `buddy_user_id` (`buddy_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_pm_folders`
--

DROP TABLE IF EXISTS `phorum_pm_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_pm_folders` (
  `pm_folder_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `foldername` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`pm_folder_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_pm_messages`
--

DROP TABLE IF EXISTS `phorum_pm_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_pm_messages` (
  `pm_message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(100) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `datestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `meta` mediumtext NOT NULL,
  PRIMARY KEY (`pm_message_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_pm_xref`
--

DROP TABLE IF EXISTS `phorum_pm_xref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_pm_xref` (
  `pm_xref_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pm_folder_id` int(10) unsigned NOT NULL DEFAULT '0',
  `special_folder` varchar(10) DEFAULT NULL,
  `pm_message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `read_flag` tinyint(1) NOT NULL DEFAULT '0',
  `reply_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pm_xref_id`),
  KEY `xref` (`user_id`,`pm_folder_id`,`pm_message_id`),
  KEY `read_flag` (`read_flag`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_posts`
--

DROP TABLE IF EXISTS `phorum_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_posts` (
  `id_post` int(12) NOT NULL AUTO_INCREMENT,
  `id_user` int(12) NOT NULL,
  `id_forum` int(12) NOT NULL,
  `parent_id` int(12) NOT NULL,
  `status` varchar(12) NOT NULL DEFAULT 'opened',
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_created` int(12) NOT NULL,
  `date_modified` int(12) NOT NULL,
  `viewed` int(12) NOT NULL,
  `poster_ip` varchar(15) NOT NULL,
  `censored_msg` varchar(50) DEFAULT NULL,
  `read_by_mod` int(1) DEFAULT '0',
  PRIMARY KEY (`id_post`),
  KEY `id_user` (`id_user`,`id_forum`,`parent_id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=8939 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_rank`
--

DROP TABLE IF EXISTS `phorum_rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_rank` (
  `id_rank` int(12) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(40) NOT NULL,
  `rank_limit` int(9) NOT NULL,
  PRIMARY KEY (`id_rank`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_rates`
--

DROP TABLE IF EXISTS `phorum_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_rates` (
  `id_user` int(11) NOT NULL,
  `id_source` int(11) NOT NULL,
  `source` varchar(40) NOT NULL,
  `ip` varchar(80) NOT NULL,
  `level` float NOT NULL,
  PRIMARY KEY (`id_user`,`id_source`,`source`),
  KEY `id_user` (`id_user`),
  KEY `id_source` (`id_source`),
  KEY `source` (`source`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_read_forum`
--

DROP TABLE IF EXISTS `phorum_read_forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_read_forum` (
  `id_user` int(12) NOT NULL,
  `id_forum` int(12) NOT NULL,
  `date_read` int(12) NOT NULL,
  PRIMARY KEY (`id_user`,`id_forum`,`date_read`),
  KEY `id_user` (`id_user`),
  KEY `id_forum` (`id_forum`),
  KEY `date_read` (`date_read`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_read_posts`
--

DROP TABLE IF EXISTS `phorum_read_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_read_posts` (
  `id_user` int(12) NOT NULL,
  `id_forum` int(12) NOT NULL,
  `id_post` int(12) NOT NULL,
  PRIMARY KEY (`id_user`,`id_forum`,`id_post`),
  KEY `id_user` (`id_user`),
  KEY `id_forum` (`id_forum`),
  KEY `id_post` (`id_post`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_sc_tags`
--

DROP TABLE IF EXISTS `phorum_sc_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_sc_tags` (
  `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) NOT NULL,
  `nbuse` int(11) DEFAULT '0',
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `uk_tag` (`tag_name`)
) ENGINE=MyISAM AUTO_INCREMENT=639 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_sc_tags_tagged`
--

DROP TABLE IF EXISTS `phorum_sc_tags_tagged`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_sc_tags_tagged` (
  `tt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(10) unsigned NOT NULL,
  `tt_scope_id` varchar(50) NOT NULL,
  `tt_subject_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tt_id`),
  KEY `idx1_tt` (`tt_scope_id`,`tt_subject_id`),
  KEY `idx2_tt` (`tag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=792 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_search`
--

DROP TABLE IF EXISTS `phorum_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_search` (
  `message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `search_text` mediumtext NOT NULL,
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`),
  KEY `forum_id` (`forum_id`),
  FULLTEXT KEY `search_text` (`search_text`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_search_words`
--

DROP TABLE IF EXISTS `phorum_search_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_search_words` (
  `id` varchar(30) NOT NULL,
  `datasource` varchar(40) NOT NULL DEFAULT '',
  `words` varchar(255) NOT NULL,
  `weight` int(4) NOT NULL,
  PRIMARY KEY (`id`,`datasource`,`words`),
  KEY `words` (`words`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_settings`
--

DROP TABLE IF EXISTS `phorum_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_settings` (
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` enum('V','S') NOT NULL DEFAULT 'V',
  `data` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_subscribers`
--

DROP TABLE IF EXISTS `phorum_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_subscribers` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sub_type` tinyint(4) NOT NULL DEFAULT '0',
  `thread` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`forum_id`,`thread`),
  KEY `forum_id` (`forum_id`,`thread`,`sub_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_subscriptions`
--

DROP TABLE IF EXISTS `phorum_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_subscriptions` (
  `id_user` int(12) NOT NULL,
  `id_post` int(12) NOT NULL,
  PRIMARY KEY (`id_user`,`id_post`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_user_custom_fields`
--

DROP TABLE IF EXISTS `phorum_user_custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_user_custom_fields` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  PRIMARY KEY (`user_id`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_user_group_xref`
--

DROP TABLE IF EXISTS `phorum_user_group_xref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_user_group_xref` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_user_newflags`
--

DROP TABLE IF EXISTS `phorum_user_newflags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_user_newflags` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `message_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`forum_id`,`message_id`),
  KEY `move` (`message_id`,`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_user_permissions`
--

DROP TABLE IF EXISTS `phorum_user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_user_permissions` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `permission` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`forum_id`),
  KEY `forum_id` (`forum_id`,`permission`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phorum_users`
--

DROP TABLE IF EXISTS `phorum_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phorum_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `password_temp` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `email_temp` varchar(110) NOT NULL DEFAULT '',
  `hide_email` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `signature` text NOT NULL,
  `threaded_list` tinyint(4) NOT NULL DEFAULT '0',
  `posts` int(10) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `threaded_read` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` int(10) unsigned NOT NULL DEFAULT '0',
  `date_last_active` int(10) unsigned NOT NULL DEFAULT '0',
  `last_active_forum` int(10) unsigned NOT NULL DEFAULT '0',
  `hide_activity` tinyint(1) NOT NULL DEFAULT '0',
  `show_signature` tinyint(1) NOT NULL DEFAULT '0',
  `email_notify` tinyint(1) NOT NULL DEFAULT '0',
  `tz_offset` float(4,2) NOT NULL DEFAULT '-99.00',
  `is_dst` tinyint(1) NOT NULL DEFAULT '0',
  `user_language` varchar(100) NOT NULL,
  `user_template` varchar(100) NOT NULL,
  `sessid_st` varchar(50) NOT NULL DEFAULT '',
  `moderator_data` text NOT NULL,
  `pm_email_notify` tinyint(1) NOT NULL DEFAULT '1',
  `sessid_lt` varchar(50) NOT NULL DEFAULT '',
  `sessid_st_timeout` int(10) unsigned NOT NULL DEFAULT '0',
  `moderation_email` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `settings_data` mediumtext NOT NULL,
  `real_name` varchar(255) NOT NULL DEFAULT '',
  `display_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  KEY `active` (`active`),
  KEY `userpass` (`username`,`password`),
  KEY `activity` (`date_last_active`,`hide_activity`,`last_active_forum`),
  KEY `date_added` (`date_added`),
  KEY `email_temp` (`email_temp`),
  KEY `sessid_st` (`sessid_st`),
  KEY `cookie_sessid_lt` (`sessid_lt`),
  KEY `real_name` (`real_name`),
  KEY `admin` (`admin`)
) ENGINE=MyISAM AUTO_INCREMENT=414 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-10-30 21:49:06
