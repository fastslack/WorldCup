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

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');

class worldcupViewConfig extends JView
{
	/**
	 * view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Configuration' ), 'worldcup' );
		JToolBarHelper::custom('cpanel', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();

		$configFile = JPATH_COMPONENT.DS.'worldcup_config.php';
		if (JFile::exists( $configFile )) {
			include( $configFile );
		}else{
			JFile::copy( $configFile.".orig", $configFile );
			include( $configFile );
		}

		#
		# Backup
		#
		$backup[] = JHTML::_( 'select.option', '1', JText::_( "Enabled" ) );
		$backup[] = JHTML::_( 'select.option', '0', JText::_( "Disabled" ) ); 
 
		$lists['backup'] = JHTML::_('select.radiolist', $backup, 'backup', 'class="inputbox" ', 'value', 'text', $worldcupConfig['backup'] );

		#
		# Agreement
		#
		$query = 'SELECT c.id, c.title 
		FROM #__content AS c';
		$db->setQuery( $query );
		$agreement = $db->loadObjectList();

		$lists['agreement'] = JHTML::_('select.genericlist', $agreement, 'agreement', 'class="inputbox" ', 'id', 'title', $worldcupConfig['agreement'] );



		$this->assignRef('lists', $lists);
		$this->assignRef('items', $worldcupConfig);

		parent::display($tpl);
	}
}
