<?php
/**
* @package      jcommunity
* @subpackage
* @author       Laurent Jouanneau <laurent@xulfr.org>
* @contributor
* @copyright    2007-2010 Laurent Jouanneau
* @link         http://jelix.org
* @licence      http://www.gnu.org/licenses/gpl.html GNU General Public Licence, see LICENCE file
*/


class registrationZone extends jZone {

   protected $_tplname='registration';


    protected function _prepareTpl(){
        $form = jForms::get('registration');
        if($form == null){
            $form = jForms::create('registration');
        }
        jForms::destroy('confirmation');
        jEvent::notify('jcommunity_registration_init_form', array('form'=>$form,'tpl'=>$this->_tpl) );
        $this->_tpl->assign('form',$form);
        global $gJConfig;
        if (isset($gJConfig->jcommunity['disable_mail_confirmation'])) {
            $this->_tpl->assign('disable_mail_confirmation',$gJConfig->jcommunity['disable_mail_confirmation']);
        }
        else {
            $this->_tpl->assign('disable_mail_confirmation', false);
        }
    }

}

?>