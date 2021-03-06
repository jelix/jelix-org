;<?php die(''); ?>
;for security reasons, don't remove or modify the first line

; name of the default profil to use
default = myapp

; each section correspond to a cache profile
; the name of the section is the name of the profile, to use as an argument
; for jCache methods
; Parameters in each sections depends of the driver type

[myapp]

; Parameters common to all drivers :

; disable or enable cache for this profile
enabled = 1
; driver type (file, db, memcached)
driver = file
; TTL used (0 means no expire)
ttl = 0


; Automatic cleaning configuration (not necessary with memcached)
;   0 means disabled
;   1 means systematic cache cleaning of expired data (at each set or add call)
;   greater values mean less frequent cleaning
;automatic_cleaning_factor = 0

; Parameters for file driver :

; directory where to put the cache files (optional default 'JELIX_APP_TEMP_PATH/cache/')
cache_dir = 
; enable / disable locking file
file_locking = 1
; directory level. Set the directory structure level. 0 means "no directory structure", 1 means "one level of directory", 2 means "two levels"...
directory_level = 0
; umask for directory structure (default '0700')
directory_umask = 
; prefix for cache files (default 'jelix_cache')
file_name_prefix = ""
; umask for cache files (default '0600')
cache_file_umask = 

; Parameters for db driver :

; dao used (default 'jelix~jcache')
;dao = ""
; dbprofil (optional)
;dbprofile = "" 


; Parameters for memcached driver :

; Memcached servers. 
; Can be a list e.g
;servers = memcache_host1:11211,memcache_host2:11211,memcache_host3:11211 i.e HOST_NAME:PORT
;servers = 
