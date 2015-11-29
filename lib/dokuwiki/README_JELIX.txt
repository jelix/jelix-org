HACK jelix

La version pour jelix a été un peu modifiée

- fichiers de langues fr et en
  inc/lang/en/lang.php
  inc/lang/fr/lang.php
- fichier de conf en plus, local_en.php
- dans inc/parser/
  - xhtml.php , pour ajouter les liens cliquables sur les titres
- inc/pageutils.php   bug fix pour le path_info
- inc/form.php  agrandissement de la zone de formulaire
- inc/infoutils.php : chemin du fichier VERSION
- inc/utf8 : class_exists ne doit pas appeler l'autoloader
- doku.php -> articles.php avec des patchs

Des plugins additionnels :

- bookcontents
- bookinfo
- booklegalnotice
- bookpagelegalnotice
- downloadjelix
- freenode
- inlinecode
- language
- latestbranchversion
- linkjelix
- navbar
- notinbook
- redirect
