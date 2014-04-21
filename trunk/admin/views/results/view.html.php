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

class WorldcupViewResults extends JViewLegacy {

	protected $items;

	protected $pagination;

	protected $state;

	function display($tpl = null) {

		// Loading the helper
		JLoader::import('helpers.worldcup', JPATH_COMPONENT_ADMINISTRATOR);

		$model = $this->getModel();

		$this->state		= $this->get('State');
		//$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
 
		// Get groups
		$groups = $model->getGroups(1);

		## 
		## Get Data for table groups
		##
		$data = WorldcupHelper::_getTableData($groups);

print_r($data);

		// Add the toolbar
		$this->addToolBar();

		parent::display($tpl);
	}

	/**
	* Setting the toolbar
	*/
	protected function addToolBar() 
	{
		$canDo = JHelperContent::getActions('com_worldcup', 'result', $this->state->get('filter.published'));
		$user  = JFactory::getUser();

		JToolBarHelper::title(JText::_( 'COM_WORLDCUP_RESULTS_TITLE' ), 'plugin.png' );

		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('result.add');
		}

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('result.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('results.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('results.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}

		JToolBarHelper::cancel('results.cancel', 'JTOOLBAR_CLOSE');
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
							't.tid' =>  JText::_('COM_WORLDCUP_RESULTS_TID'),
				't.date' =>  JText::_('COM_WORLDCUP_RESULTS_DATE'),
				't.group' =>  JText::_('COM_WORLDCUP_RESULTS_GROUP'),
				't.place' =>  JText::_('COM_WORLDCUP_RESULTS_PLACE'),
				't.team1' =>  JText::_('COM_WORLDCUP_RESULTS_TEAM1'),
				't.team2' =>  JText::_('COM_WORLDCUP_RESULTS_TEAM2'),
				't.phase' =>  JText::_('COM_WORLDCUP_RESULTS_PHASE'),
				't.published' =>  JText::_('COM_WORLDCUP_RESULTS_PUBLISHED'),
				't.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
