<?php
/* comments & extra-whitespaces have been removed by jBuildTools*/
/**
* @package      jelix
* @subpackage   jtpl_plugin
* @author       Laurent Jouanneau
* @contributor  Dominique Papin, Julien Issler, Brunto, DSDenes
* @copyright    2007-2010 Laurent Jouanneau, 2007 Dominique Papin
* @copyright    2008 Julien Issler, 2010 Brunto, 2009 DSDenes
* @link         http://www.jelix.org
* @licence      GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/
function jtpl_function_html_formdatafull($tpl,$form)
{
	echo '<table class="jforms-table" border="0">';
	foreach($form->getControls()as $ctrlref=>$ctrl){
		if($ctrl->type=='submit'||$ctrl->type=='reset'||$ctrl->type=='hidden'||$ctrl->type=='captcha'||$ctrl->type=='secretconfirm')continue;
		if(!$form->isActivated($ctrlref))continue;
		echo '<tr><th scope="row"'.($ctrl->type=='group' ? ' colspan="2" class="jforms-group"' : '').'>';
		echo htmlspecialchars($ctrl->label);
		echo '</th>';
		if($ctrl->type!='group'){
			echo '<td>';
			$value=$ctrl->getDisplayValue($form->getData($ctrlref));
			if(is_array($value)){
				$s='';
				foreach($value as $v){
					$s.=','.htmlspecialchars($v);
				}
				echo substr($s,1);
			}
			else if($ctrl->isHtmlContent())
				echo $value;
			else if($ctrl->type=='textarea')
				echo nl2br(htmlspecialchars($value));
			else
				echo htmlspecialchars($value);
			echo '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}
