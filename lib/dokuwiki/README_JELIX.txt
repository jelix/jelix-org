HACK jelix

La version pour jelix a été quelque peu modifiée

1) les repertoires de dokuwiki ont été placés à deux endroits differents dans

- lib/dokuwiki/  (bin, conf, inc, COPYING, README, VERSION)
- www/ (data, lib)

2)

- fichiers de langues fr et en
  inc/lang/en/lang.php
  inc/lang/fr/lang.php
- fichier de conf en plus, local_en.php
- dans inc/parser/
  - xhtml.php , pour ajouter les liens cliquables sur les titres
- inc/pageutils.php   bug fix pour le path_info
- lib/exe : modification des chemins d'inclusions des fichiers de inc/, et fix de chemins (css.php)
- idem pour plugins/config/settings/config.metadata.php
- iem pour feed.php
- doku.php -> articles.php avec des patchs
