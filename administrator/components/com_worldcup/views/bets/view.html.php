<?php
/**
* Worldcup
*
* @version $Id:
* @package Matware.Worldcup
* @copyright Copyright (C) 2004 - 2018 Matware. All rights reserved.
* @author Matias Aguirre
* @email maguirre@matware.com.ar
* @link http://www.matware.com.ar/
* @license GNU General Public License version 2 or later; see LICENSE
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class WorldcupViewBets extends JViewLegacy {

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

		// Add the toolbar
		$this->addToolBar();

		parent::display($tpl);
	}

	/**
	* Setting the toolbar
	*/
	protected function addToolBar() 
	{
		$canDo = JHelperContent::getActions('com_worldcup', 'bet', $this->state->get('filter.published'));
		$user  = JFactory::getUser();

		JToolBarHelper::title(JText::_( 'COM_WORLDCUP_BETS_TITLE' ), 'plugin.png' );

		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('bet.add');
		}

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('bet.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('bets.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('bets.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}

		JToolBarHelper::cancel('bets.cancel', 'JTOOLBAR_CLOSE');
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
							't.user' =>  JText::_('COM_WORLDCUP_BETS_USER'),
				't.email' =>  JText::_('COM_WORLDCUP_BETS_EMAIL'),
				't.bet' =>  JText::_('COM_WORLDCUP_BETS_BET'),
				't.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
