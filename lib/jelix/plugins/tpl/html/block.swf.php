<?php
/* comments & extra-whitespaces have been removed by jBuildTools*/
/**
 * @package     jelix
 * @subpackage  jtpl_plugin
 * @author      Lepeltier kévin
 * @contributor Dominique Papin
 * @copyright   2008 Lepeltier kévin
 * @copyright   2008 Dominique Papin
 * @link        http://www.jelix.org
 * @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
 *
 * Inspired by the method satay Drew McLellan (http://www.alistapart.com/articles/flashsatay/)
 */
function jtpl_block_html_swf($compiler,$begin,$params){
	if($begin){
		$sortie='
        $src = '.$params[0].';
        $options = '.$params[1].';
        $params = '.$params[2].';
        $flashvar = '.$params[3].';

        $att = \'\';
        $atts = array(\'id\'=>\'\', \'class\'=>\'\');
        $atts = array_intersect_key($options, $atts);
        foreach( $atts as $key => $val )
            if( !empty($val) )
                $att .= \' \'.$key.\'="\'.$val.\'"\';

        echo \'<object type="application/x-shockwave-flash" data="\'.$src.\'?\';
        if( count($flashvar) ) foreach($flashvar as $key => $val)
            echo \'&\'.$key.\'=\'.$val;
        echo \'" width="\'.$options[\'width\'].\'" height="\'.$options[\'height\'].\'"\'.$att.\'>\';
        echo "    ";
        echo \'<param name="movie" value="\'.$src.\'" />\'."\n";
        if( count($params) ) foreach($params as $key => $val)
            echo \'<param name="\'.$key.\'" value="\'.$val.\'" />\'."\n";
        ';
		return $sortie;
	}else{
		return 'echo \'</object>\';';
	}
}
