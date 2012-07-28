<?php
/**
 * @package   www.jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2006-2012 Laurent Jouanneau
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
*/

class maintenanceCtrl extends jControllerCmdLine {

    /**
    * Options to the command line
    *  'method_name' => array('-option_name' => true/false)
    * true means that a value should be provided for the option on the command line
    */
    protected $allowed_options = array(
           
    );

    /**
     * Parameters for the command line
     * 'method_name' => array('parameter_name' => true/false)
     * false means that the parameter is optionnal. All parameters which follow an optional parameter
     * is optional
     */
    protected $allowed_parameters = array(

    );
    /**
    *
    */
    function migratewiki() {
        $rep = $this->getResponse();
        $c = jDb::getConnection();
        $rs = $c->query("SELECT id_post, message FROM hfnu_posts order by id_post");
        $count= 0;
        $wiki = new jWiki('migrate_forum');
        
        foreach($rs as $row) {
            $msg = str_replace("\r\n", "\n", $row->message);
            $newmsg = $wiki->render($msg);
            $newmsg = preg_replace_callback('!'.preg_quote('</code>')."(\s*)".preg_quote('<code>').'!m', 'trimMatch', $newmsg);
            $sql = "UPDATE hfnu_posts SET message =".$c->quote($newmsg)." WHERE id_post=".$row->id_post;
            $c->exec($sql);
             
            //$rep->addContent($row->id_post."\n".$newmsg."\n\n==================================\n");
            //$rep->addContent($row->id_post."\n".$msg."\n\n==================================\n");
            $count++;
        }
        $rep->addContent("Count=$count\n");
        return $rep;
    }

    function migratesignature() {
        $rep = $this->getResponse();
        $c = jDb::getConnection();
        $rs = $c->query("SELECT id, comment FROM community_users where comment <> '' order by id");
        $count= 0;
        $wiki = new jWiki('migrate_forum');
        //$wiki = new jWiki('hfb_rule');
        
        foreach($rs as $row) {
            $msg = str_replace("\r\n", "\n", $row->comment);
            $newmsg = $wiki->render($msg);
            $newmsg = preg_replace_callback('!'.preg_quote('</code>')."(\s*)".preg_quote('<code>').'!m', 'trimMatch', $newmsg);
            $sql = "UPDATE community_users SET comment =".$c->quote($newmsg)." WHERE id=".$row->id;
            $c->exec($sql);

            //$rep->addContent($row->id."\n".$newmsg."\n\n==================================\n");
            //$rep->addContent($row->id."\n".$msg."\n\n==================================\n");
            $count++;
        }
        $rep->addContent("Count=$count\n");
        return $rep;
    }



}

function trimMatch($matches) {
    return substr($matches[1], 1, -1);
}
