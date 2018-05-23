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
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

// Import the plannings class
JLoader::register('WorldcupTeams', JPATH_COMPONENT_ADMINISTRATOR.'/includes/teams.php');

/**
 * WorldcupModelMatches Model
 */
class WorldcupModelMatches extends JModelList
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
				'tid', 't.tid',
				'date', 't.date',
				'group', 't.group',
				'place', 't.place',
				'team1', 't.team1',
				'team2', 't.team2',
				'phase', 't.phase',
				'published', 't.published',

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
	public function getTable($type = 'Match', $prefix = 'WorldcupTable', $config = array())
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

		$tournament = $this->getUserStateFromRequest($this->context . '.filter.tournament', 'filter_tournament', 1, 'int');
		$this->setState('filter.tid', $tournament);

		$group = $this->getUserStateFromRequest($this->context . '.filter.group', 'filter_group');
		$this->setState('filter.group', $group);

		$phase = $this->getUserStateFromRequest($this->context . '.filter.phase', 'filter_phase');
		$this->setState('filter.phase', $phase);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_worldcup');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('t.date', 'asc');
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
		$id .= ':' . $this->getState('filter.group');
		$id .= ':' . $this->getState('filter.phase');

		return parent::getStoreId($id);
	}

	/**
	* Method to build an SQL query to load the list data.
	*
	* @return      string  An SQL query
	*/
	protected function getListQuery()
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('t.id, t.date, t.published, t.phase, t.team1, t.team2');
		// From the hello table
		$query->from($db->quoteName('#__worldcup_matches') . ' AS t');

		// Join over the groups
		$query->select('g.name AS group_name')
			->join('LEFT', '#__worldcup_groups AS g ON g.id = t.group');

		// Join over the place
		$query->select('p.name AS place')
			->join('LEFT', '#__worldcup_places AS p ON p.id = t.place');

		// Join over the team 1
		$query->select('team1.name AS team1_name')
			->join('LEFT', '#__worldcup_teams AS team1 ON team1.id = t.team1');

		// Join over the team2
		$query->select('team2.name AS team2_name')
			->join('LEFT', '#__worldcup_teams AS team2 ON team2.id = t.team2');

		// Filter by search in date
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('t.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('t.date LIKE ' . $search);
			}
		}

		// Filter by tournament id
		if ($tid = $this->getState('filter.tid'))
		{
			$query->where('t.tid = ' . (int) $tid);
		}

		// Filter by phase id
		$phase = !empty($this->getState('filter.phase')) ? $this->getState('filter.phase') : 0;
		$query->where('t.phase = ' . (int) $phase);

		// Filter by group id
		if ($group = $this->getState('filter.group'))
		{
			$query->where('t.group = ' . (int) $group);
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 't.id');
		$orderDirn = $this->state->get('list.direction', 'ASC');

echo str_replace('#__', $this->_db->getPrefix(), $query->__toString());exit;

		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	/**
	 * Get the teams of specific tournament
	 *
	 * @param  int  $tournament  The tournament.
	 *
	 * @return array An array with the teams data.
	 */
	public function getTeamsList($tournament)
	{
		// Create the teams instance
		$teams = new WorldcupTeams();
		// Return
		return $teams->getTeamsList($tournament);
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
