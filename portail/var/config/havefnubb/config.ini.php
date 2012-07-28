;<?php die(''); ?>
;for security reasons , don't remove or modify the first line

startModule=havefnubb
startAction="default:index"

[coordplugins]
autolocale=autolocale.plugin.ini.php
auth="havefnubb/auth.coord.ini.php"
jacl2="havefnubb/jacl2.coord.ini.php"
activeusers="havefnubb/activeusers.coord.ini.php"
banuser="havefnubb/banuser.coord.ini.php"
history="havefnubb/history.coord.ini.php"
flood="havefnubb/flood.coord.ini.php"

[responses]
html=fnuHtmlResponse

[error_handling]
logFile=error-hfnubb.log

[urlengine]
; name of url engine :  "simple" or "significant"
; engine=simple
; engine=basic_significant
engine=significant

enableParser=on
multiview=on

defaultEntrypoint=forums
entrypointExtension=.php

notfoundAct="havefnubb~hfnuerror:notfound"
[acl2]
driver=db

[modules]
jacl2db.access=1
activeusers.access=2
hfnucontact.access=2
hfnuhardware.access=1
hfnuim.access=1
hfnurates.access=2
hfnusearch.access=2
jmessenger.access=2
jtags.access=2
