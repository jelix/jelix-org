;<?php die(''); ?>
;for security reasons , don't remove or modify the first line

startModule=main
startAction="default:index"


[coordplugins]
autolocale=autolocale.plugin.ini.php
; this break the access of the main page (thechnical error)
; it is only usefull for forums.php entry point.
; if we go on the forum then go back to the home ; the error disappears
; auth="havefnubb/auth.coord.ini.php"

[responses]


[acl2]
driver=db

