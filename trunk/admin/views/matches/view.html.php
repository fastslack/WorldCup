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

class WorldcupViewMatches extends JViewLegacy {

	protected $items;

	protected $pagination;

	protected $state;

	function display($tpl = null) {

		$this->state		= $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// Declare phases
		$this->phases = array();
		$this->phases[0] = JText::_( 'Clasification' );
		//if ($teamscount > 12) {
			$this->phases[1] = JText::_( 'Round of 16' );
		//}
		$this->phases[2] = JText::_( 'Quarter-finals' ); 
		$this->phases[3] = JText::_( 'Semi-finals' ); 
		$this->phases[4] = JText::_( 'Match for third place' );
		$this->phases[5] = JText::_( 'Final' );

		// Add the toolbar
		$this->addToolBar();

		parent::display($tpl);
	}

	/**
	* Setting the toolbar
	*/
	protected function addToolBar() 
	{
		$canDo = JHelperContent::getActions('com_worldcup', 'match', $this->state->get('filter.published'));
		$user  = JFactory::getUser();

		JToolBarHelper::title(JText::_( 'COM_WORLDCUP_MATCHES_TITLE' ), 'plugin.png' );

		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('match.add');
		}

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('match.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('matches.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('matches.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}

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
							't.tid' =>  JText::_('COM_WORLDCUP_MATCHES_TID'),
				't.date' =>  JText::_('COM_WORLDCUP_MATCHES_DATE'),
				't.group' =>  JText::_('COM_WORLDCUP_MATCHES_GROUP'),
				't.place' =>  JText::_('COM_WORLDCUP_MATCHES_PLACE'),
				't.team1' =>  JText::_('COM_WORLDCUP_MATCHES_TEAM1'),
				't.team2' =>  JText::_('COM_WORLDCUP_MATCHES_TEAM2'),
				't.phase' =>  JText::_('COM_WORLDCUP_MATCHES_PHASE'),
				't.published' =>  JText::_('COM_WORLDCUP_MATCHES_PUBLISHED'),
				't.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
