<?php


class mysqlDb {

    protected static $cnx;

    function __construct(){

        if  ($this->cnx === null) {

            $conf = parse_ini_file(DOKU_INC.'../../portail/var/config/dbprofils.ini.php',true);

            $this->conf = $conf[$conf['default']];
            if($this->cnx = @mysql_pconnect($this->conf['host'], $this->conf['user'], $this->conf['password'])) {
                if(isset($this->conf['force_encoding']) && $this->conf['force_encoding'] == true){
                    mysql_query("SET CHARACTER SET 'utf8'", $this->cnx);
                }
            }else{
                throw new Exception('error on db connection');
            }
        }
    }

    function query ($query) {

        if(!mysql_select_db($this->conf['database'], $this->cnx)){
                    throw new Exception('error during mysql_select_db ('.mysql_errno($this->cnx).')');
        }
        if($qI = mysql_query($query, $this->cnx)){
            return $qI;
        }else{
	echo '##'.$query.'####';
            throw new Exception('bad mysql query: '.mysql_error($this->cnx).'  ('.$query.')  ');
        }
    }


    function quote($text){
        if(!is_string($text))
        throw new Exception('erreur param quote');
      return "'".mysql_real_escape_string($text,  $this->cnx)."'";
    }
    
    function fetchOne($query) {
        $cur = $this->query($query);
        if($cur) {
            $res = mysql_fetch_object($cur);
            mysql_free_result($cur);
            return $res;
        }
        return false;
    }
}

