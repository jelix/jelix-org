This directory contains source code of some websites of the project JELIX.

`www/` is the document root of http://jelix.org. It is mainly a Jelix application. The source code of this
application is in `portail/` and `lib/`. The forum is using modules of Havefnubb, and the wiki is based
on Dokuwiki.

- `download/www` is the document root of http://download.jelix.org
- `forge/` is the document root of http://forge.jelix.org, which is a dead site now
- `planet/` is the document root of http://planet.jelix.org

- `closed/` becomes the document root of one of websites, when we close it.
- `scripts/` contains various scripts to maintain the web site, to build  nightlies etc.
- `temp/` contains temporary files for the portal.


All files for design (css, images..) are in a separate repository, https://github.com/jelix/jelix-design,
because they are shared with other web sites. (see https://github.com/jelix/docs-jelix-org and
http://bitbucket.org/foxmask/booster)

To install the web site, see scripts/install/install.txt.


See LICENSE file to know your rights to reuse the source code of these web sites.