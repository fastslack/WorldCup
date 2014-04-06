<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class worldcupModelConfig extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		//$array = JRequest::getVar('cid',  0, '', 'array');
		//$this->setId((int)$array[0]);
	}


	function saveConfig( $post ) {

		unset($post['controller']);
		unset($post['option']);
		unset($post['task']);
		unset($post['boxchecked']);

		reset($post);
		//print_r($post);

		$configText = "<?php\n";

		reset($post);
		while (list($key, $value) = each($post)) {
				//echo "Key: $key; Value: $value<br />\n";
				$configText .= "\$worldcupConfig['".$key."'] = \"" . $value . "\";\n";
		}

		$configText .= "?>\n";

		//print_r($configText);

		jimport('joomla.filesystem.file');

		$configFile = JPATH_COMPONENT.DS.'worldcup_config.php';

		if (JFile::exists( $configFile )) {
			require_once( $configFile );
		}else{
			JFile::copy( $configFile . '.orig', $configFile );
		}

		$return = JFile::write($configFile, $configText);

		return $return;

	}


}
?>
