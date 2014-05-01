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

jimport( 'joomla.application.component.view' );

class WorldcupViewCpanel extends JViewLegacy
{
	/**
	 * Display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'WorldCup' ), 'worldcup' );

		$xmlfile = JPATH_COMPONENT."/worldcup.xml";
		$xml = simplexml_load_file($xmlfile);

		$this->version = (string)$xml->version;

		JToolbarHelper::preferences('com_worldcup');

		parent::display($tpl);
	}
}
