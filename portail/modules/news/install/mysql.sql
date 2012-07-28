-- copyright 2007 laurent jouanneau

-- --------------------------------------------------------

-- 
-- Structure de la table `news`
-- 

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL auto_increment,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `date_create` datetime NOT NULL,
  `lang` varchar(5) NOT NULL,
  `author` varchar(50) default NULL,
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;