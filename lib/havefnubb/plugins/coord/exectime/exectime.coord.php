<?php
/**
* @package    jelix
* @subpackage coord_plugin
* @author     laurentj
* @contributor
* @copyright  2010 Laurent jouanneau
* @licence  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public Licence, see LICENCE file
*/
/**
 * 
 */
class exectimeCoordPlugin implements jICoordPlugin {
    public $config;

    protected $startTime = 0;

    function __construct($conf){
        $this->config = $conf;
    }

    /**
     * @param  array  $params   plugin parameters for the current action
     * @return null or jSelectorAct  if action should change
     */
    public function beforeAction ($params){
        $this->startTime = microtime(true);
        return null;
    }

    public function beforeOutput(){
    }

    public function afterProcess (){
        global $gJCoord;
        $end = microtime(true);
        $resp = $gJCoord->response;
        require_once(JELIX_LIB_CORE_PATH.'response/jResponseHtml.class.php');
        if ($resp instanceof jResponseHtml) {
            echo '<p>'.($end-$this->startTime).' s</p>';
        }
        
    }
}
