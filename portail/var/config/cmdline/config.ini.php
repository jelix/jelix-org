;<?php die(''); ?>
;for security reasons , don't remove or modify the first line

startModule=main
startAction="default:index"

[urlengine]
notfoundAct =


[error_handling]
messageLogFormat="%date%\t[%code%]\t%msg%\t%file%\t%line%\n"
logFile=error-cli.log
email="root@jelix.org"
emailHeaders="Content-Type: text/plain; charset=UTF-8\nFrom: webmaster@jelix.org\nX-Mailer: Jelix\nX-Priority: 1 (Highest)\n"
quietMessage="A technical error has occured. Sorry for this trouble."

;  ECHO, ECHOQUIET, EXIT, LOGFILE, SYSLOG, MAIL, TRACE
default="ECHO LOGFILE TRACE EXIT"
error="ECHO LOGFILE TRACE EXIT"
warning="ECHO LOGFILE TRACE"
notice="LOGFILE TRACE "
strict=
; pour les exceptions, il y a implicitement un EXIT
exception="ECHO LOGFILE TRACE"

