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
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * WorldcupModelBets Model
 */
class WorldcupModelBets extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  An optional associative array of configuration settings.
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 't.id',
				'user', 't.user',
				'email', 't.email',
				'bet', 't.bet',

			);
		}

		parent::__construct($config);
	}

	/**
	* Returns a reference to the a Table object, always creating it.
	*
	* @param       type    The table type to instantiate
	* @param       string  A prefix for the table class name. Optional.
	* @param       array   Configuration array for model. Optional.
	* @return      JTable  A database object
	* @since       2.5
	*/
	public function getTable($type = 'Bet', $prefix = 'WorldcupTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$accessId = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', null, 'int');
		$this->setState('filter.access', $accessId);

		$published = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $published);

		$published = $this->getUserStateFromRequest($this->context . '.filter.tid', 'filter_tid', 1, 'string');
		$this->setState('filter.tid', $published);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_worldcup');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('u.id', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id    A prefix for the store id.
	 * @return  string  A store id.
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.access');
		$id .= ':' . $this->getState('filter.state');
		$id .= ':' . $this->getState('filter.tid');

		return parent::getStoreId($id);
	}

	/**
	* Method to build an SQL query to load the list data.
	*
	* @return      string  An SQL query
	*/
	protected function getListQuery()
	{
		$tid = $this->getState('filter.tid');

		// Create a new query object.           
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('u.*, COUNT(b.id) AS count');
		// From the hello table
		$query->from($db->quoteName('#__users') . ' AS u');

		// Join over the groups
		$query->join('LEFT', '#__worldcup_bets AS b ON b.uid = u.id');
		$query->join('LEFT', '#__worldcup_users AS wu ON wu.id = u.id');

		$query->group('id');

		$query->where('wu.tid = ' . $tid);

		// Filter by search in 
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('u.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('u. LIKE ' . $search);
			}
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'u.id');
		$orderDirn = $this->state->get('list.direction', 'asc');

		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission for the component.
	 *
	 * @since   12.2
	 */
	protected function canDelete($record)
	{
		$user = JFactory::getUser();
		return $user->authorise('core.delete', $this->option);
	}

	/**
	 * Method to delete groups.
	 *
	 * @param   array  An array of item ids.
	 * @return  boolean  Returns true on success, false on failure.
	 */
	public function delete($itemIds)
	{
		// Sanitize the ids.
		$itemIds = (array) $itemIds;
		JArrayHelper::toInteger($itemIds);

		// Get a group row instance.
		$table = $this->getTable();

		// Iterate the items to delete each one.
		foreach ($itemIds as $itemId)
		{
			if (!$table->delete($itemId))
			{
				$this->setError($table->getError());
				return false;
			}
		}

		// Clean the cache
		$this->cleanCache();

		return true;
	}
}
