<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class joomclipViewHelp extends JView {
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Help' ), 'help_header.png' );

		parent::display($tpl);
	}
}
