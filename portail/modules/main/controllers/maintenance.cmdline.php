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
        "deletezombieusers" => array('--all'=>false, '--confirm'=>false),
        "deleteunconfirmedusers" => array('--all'=>false, '--confirm'=>false)
    );

    /**
     * Parameters for the command line
     * 'method_name' => array('parameter_name' => true/false)
     * false means that the parameter is optionnal. All parameters which follow an optional parameter
     * is optional
     */
    protected $allowed_parameters = array(
        'deleteuser' => array('login'=>true)
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


    function deletezombieusers() {
        $rep = $this->getResponse();

        $c = jDb::getConnection();

        $sql = 'SELECT id, login, email, create_date FROM community_users WHERE status = 1 AND id NOT IN (SELECT distinct id_user FROM hfnu_posts)';
        if (!$this->option('--all')) {
            $d = new DateTime();
            $interval = new DateInterval("P15D");
            $d->sub($interval);
            $sql.= ' AND create_date < '.$c->quote($d->format("Y-m-d"));
        }
        $confirm = $this->option('--confirm');
        $rs = $c->query($sql);
        foreach($rs as $rec) {
            $rep->addContent('- '.$rec->login.' ('.$rec->id.') - '.$rec->email.' - '.$rec->create_date."\n");
            if ($confirm) {
                $this->_deleteUser($rep, $rec->login, $rec->id);
            }
        }

        if (!$confirm) {
            $rep->addContent("\nAdd option --confirm to really delete them\n");
        }
        return $rep;
    }


    function deleteunconfirmedusers()
    {
        $rep = $this->getResponse();

        $c = jDb::getConnection();

        if ($this->option('--all')) {
            $rs = $c->query('SELECT id, login, request_date FROM community_users WHERE status = 0 ');
        }
        else {
            $d = new DateTime();
            $interval = new DateInterval("P2D");
            $d->sub($interval);
            $rs = $c->query('SELECT id, login, request_date FROM community_users WHERE status = 0 AND request_date < '.$c->quote($d->format("Y-m-d")) );
        }

        $confirm = $this->option('--confirm');

        foreach($rs as $rec) {
            $rep->addContent('- '.$rec->login.' - '.$rec->request_date."\n");
            if ($confirm) {
                $this->_deleteUser($rep, $rec->login, $rec->id);
            }
        }
        if (!$confirm) {
            $rep->addContent("\nAdd option --confirm to really delete them\n");
        }
        return $rep;
    }


    function deleteuser()
    {
        $rep = $this->getResponse();
        $login = $this->param('login');
        $this->_deleteUser($rep, $login);
        return $rep;
    }

    protected function _deleteUser($rep, $login, $id_user=null)
    {
        $c = jDb::getConnection();
        $loginB = $c->quote($login);

        if ($id_user === null) {
            $rs = $c->query("SELECT id from community_users where login = ".$loginB);
            if (!$rs || ! ($rec = $rs->fetch())) {
                $rep->addContent("unkown user\n");
                return false;
            }
            $id_user = $rec->id;
        }

        $rs = $c->query("select id_post, id_forum, thread_id, subject FROM hfnu_posts where id_user= ".$id_user);
        if (!$rs || count($all=$rs->fetchAll())) {
            $rep->addContent("The user '".$login."' has some posts. delete them before deleting the user\n");
            foreach($all as $rec) {
                $rep->addContent(' - '.$rec->id_post.':"'.$rec->subject.'", forum:'.$rec->id_forum.'", thread:'.$rec->thread_id."\n");
            }
            return false;
        }

        $rs = $c->query("select id_thread, id_first_msg FROM hfnu_threads where id_user= ".$id_user);
        if (!$rs || count($all=$rs->fetchAll())) {
            $rep->addContent("The user '".$login."' has some threads. delete them before deleting the user\n");
            foreach($all as $rec) {
                $rep->addContent(' - '.$rec->id_thread.', first msg:'.$rec->id_first_msg."\n");
            }
            return false;
        }

        $c->exec('DELETE FROM connectedusers WHERE login ='.$loginB);
        $c->exec('DELETE FROM hfnu_bans WHERE ban_username ='.$loginB);
        $c->exec('DELETE FROM hfnu_notify WHERE id_user='.$id_user);
        $c->exec('DELETE FROM hfnu_rates WHERE id_user='.$id_user);
        $c->exec('DELETE FROM hfnu_read_forum WHERE id_user='.$id_user);
        $c->exec('DELETE FROM hfnu_read_posts WHERE id_user='.$id_user);
        $c->exec('DELETE FROM hfnu_subscriptions WHERE id_user='.$id_user);
        $c->exec('DELETE FROM hfnu_subscript_forum WHERE id_user='.$id_user);
        $c->exec('DELETE FROM jmessenger WHERE id_from='.$id_user.' or id_for='.$id_user);

        $rs = $c->query("select id_aclgrp from jacl2_group where ownerlogin =".$loginB);
        if ($rs && $rec = $rs->fetch()) {
            $private_group_id = $rec->id_aclgrp;
            $c->exec('DELETE FROM jacl2_rights WHERE id_aclgrp ='.$private_group_id);
            $c->exec('DELETE FROM jacl2_user_group WHERE login ='.$loginB);
            $c->exec('DELETE FROM jacl2_group WHERE id_aclgrp ='.$private_group_id);
        }
        $c->exec('DELETE FROM hfnu_member_custom_fields WHERE id_user='.$id_user);
        $c->exec('DELETE FROM community_users WHERE id='.$id_user);

        $rep->addContent("user deleted\n");
        return true;
    }
}

function trimMatch($matches) {
    return substr($matches[1], 1, -1);
}
