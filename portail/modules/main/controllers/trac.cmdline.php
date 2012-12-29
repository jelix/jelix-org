<?php
/**
 * @package   jelix.org
 * @author    Laurent Jouanneau
 * @copyright 2012 Laurent Jouanneau
 * @link      http://jelix.org
 * @license   GNU General Public Licence  http://www.gnu.org/licenses/gpl.html
*/

class tracCtrl extends jControllerCmdLine {

    /**
    * Options to the command line
    *  'method_name' => array('-option_name' => true/false)
    * true means that a value should be provided for the option on the command line
    */
    protected $allowed_options = array(
            'closeroadmap' => array(),
    );

    /**
     * Parameters for the command line
     * 'method_name' => array('parameter_name' => true/false)
     * false means that the parameter is optionnal. All parameters which follow an optional parameter
     * is optional
     */
    protected $allowed_parameters = array(
            'closeroadmap' => array('newversion'=>true, 'nextversion'=>true)
    );

    /**
    *
    */
    function closeroadmap() {
        $rep = $this->getResponse();

        $newversion = $this->param('newversion');
        $nextversion = $this->param('nextversion');
        
        preg_match('/^(\d+)\.(\d+)/', $newversion, $m);
        
        $majorversion = $m[1].'.'.$m[2];
        
        $db = jDb::getConnection('trac');
        $milestone = $db->quote("Jelix $newversion");
        $nextmilestone = $db->quote("Jelix $nextversion");
        $d = mktime();
        
        // close the milestone
        $sql="Update milestone SET completed=".$d." WHERE name =".$milestone;
        $db->exec($sql);

        // create new one
        $description = 'Maintenance release of Jelix '.$majorversion.' (will fixed some bugs discovered in jelix '.$newversion.').';
        $description .= 'In theory, all jelix '.$majorversion.' users could update to this release without modification in their application.';

        $sql = "INSERT INTO milestone(name, due, completed, description) VALUES (".$nextmilestone.", ".($d+(2*30*24*60*60)).", 0, ".$db->quote($description).")";
        $db->exec($sql);
        
        // move opened ticket to new milestone
        $sql="SELECT id FROM ticket WHERE status <> 'closed' and milestone = ".$milestone;
        $rs = $db->query($sql);
        
        while($rec = $rs->fetch()) {
            $sql2 = 'INSERT into ticket_change (ticket, time, author, field, oldvalue, newvalue)
            VALUES('.$rec->id.','.$d.", 'laurentj', 'milestone', ".$milestone.", ".$nextmilestone.")";
            $db->exec($sql2);
        }

        $sql="UPDATE ticket SET milestone = ".$nextmilestone." WHERE status <> 'closed' and milestone = ".$milestone;
        $db->exec($sql);

        $sql="INSERT INTO version (name, time, description) VALUES(".$db->quote($newversion).', '.$d.", '')";
        $db->exec($sql);
        
        return $rep;
    }
}
