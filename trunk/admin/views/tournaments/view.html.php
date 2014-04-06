<?php
/**
* Worldcup
*
* @version $Id:
* @package Matware.Worldcup
* @copyright Copyright (C) 2004 - 2014 Matware. All rights reserved.
* @author Matias Aguirre
* @email maguirre@matware.com.ar
* @link http://www.matware.com.ar/
* @license GNU General Public License version 2 or later; see LICENSE
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class WorldcupViewTournaments extends JViewLegacy {

	protected $items;

	protected $pagination;

	protected $state;

	function display($tpl = null) {

		$this->state		= $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
   

		$lists['costs'] = array();
		$lists['costs'][] = JText::_( 'Subscriber' );
		$lists['costs'][] = JText::_( 'Site Owner' );

		$lists['permission'] = array();
		$lists['permission'][] = JText::_( 'Public' );
		$lists['permission'][] = JText::_( 'Private' ); 

		// Add the toolbar
		$this->addToolBar();

		parent::display($tpl);
	}

	/**
	* Setting the toolbar
	*/
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_( 'COM_WORLDCUP_TOURNAMENT_TITLE' ), 'soccer_3_48.png' );
		JToolBarHelper::addNew('tournament.add');
		JToolBarHelper::editList('tournament.edit');
		JToolBarHelper::deleteList('', 'tournaments.delete');
		JToolBarHelper::back();
		JToolBarHelper::spacer();
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			't.title' => JText::_('JGRID_HEADING_ORDERING'),
			't.place' => JText::_('COM_WORLDCUP_TOURNAMENTS_PLACE'),
			't.id' => JText::_('JGRID_HEADING_ID')
		);
	}






	function _displayForm ($tpl = null) {
		global $mainframe;

		$db =& JFactory::getDBO();
		$task = JRequest::getVar( 'task' );
		$hid  = JRequest::getVar( 'cid', array(), 'post', 'array' );

		if ($task == "edit") {
			$title = JText::_( 'Edit Tournament' );
		}else{
			$title = JText::_( 'Add Tournament' );
		}

		JToolBarHelper::title( $title, 'plugin.png' );
		JToolBarHelper::custom('display', 'back.png', 'back_f2.png', 'Back', false, false);
		JToolBarHelper::save();
		JToolBarHelper::spacer();

		$tournament = new TableWorldCupTournaments($db);
		$tournament->load($hid[0]);

		//print_r($tournament);

		$mode[] = JHTML::_( 'select.option', '1', 'Championship' );
		$mode[] = JHTML::_( 'select.option', '2', 'League' ); // first parameter is value, second is text
 
		$lists['mode'] = JHTML::_('select.genericlist', $mode, 'mode', 'class="inputbox" ', 'value', 'text', $tournament->mode );

/*
		$permission[] = JHTML::_( 'select.option', '0', 'Public' );
		$permission[] = JHTML::_( 'select.option', '1', 'Private' ); // first parameter is value, second is text
 
		$lists['permission'] = JHTML::_('select.genericlist', $permission, 'permission', 'class="inputbox" ', 'value', 'text', $tournament->permission );
*/

		$this->assignRef('title', $title);
		$this->assignRef('lists', $lists);
		$this->assignRef('tournament', $tournament);

		parent::display($tpl);
	} 

}
