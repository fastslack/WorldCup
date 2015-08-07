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

class WorldcupViewUsers extends JViewLegacy {

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
		JToolBarHelper::title(JText::_( 'COM_WORLDCUP_USERS_TITLE' ), 'plugin.png' );
		JToolBarHelper::addNew('user.add');
		JToolBarHelper::editList('user.edit');
		JToolBarHelper::deleteList('', 'users.delete');
		JToolBarHelper::cancel('users.cancel', 'JTOOLBAR_CLOSE');
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
			't.place' => JText::_('COM_EXAMPLE_EXAMPLES_PLACE'),
			't.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
