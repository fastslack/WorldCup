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
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

JLoader::register('WorldcupMatches', JPATH_COMPONENT_ADMINISTRATOR.'/includes/matches.php');
JLoader::register('WorldcupTournaments', JPATH_COMPONENT_ADMINISTRATOR.'/includes/tournaments.php');

/**
 * WorldcupModelBet Model
 */
class WorldcupModelBet extends JModelAdmin
{
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
	* Method to get the record form.
	*
	* @param       array   $data           Data for the form.
	* @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
	* @return      mixed   A JForm object on success, false on failure
	* @since       2.5
	*/
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_worldcup.bet', 'bet',
    	array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
    	return false;
		}
		return $form;
	}

	/**
	* Method to get the data that should be injected in the form.
	*
	* @return      mixed   The data for the form.
	* @since       2.5
	*/
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_worldcup.edit.bet.data', array());
		if (empty($data)) 
		{
		  $data = $this->getItem();
		}
		return $data;
	}

	/**
	* Method to get the data that should be injected in the form.
	*
	* @return      mixed   The data for the form.
	* @since       2.5
	*/
	public function getItems() 
	{
/*
		// Get the patient id
		$tid = JFactory::getApplication()->input->get('tid');

		$matchesObj = new WorldcupMatches();
		$tournamentObj = new WorldcupTournaments();

		$group = $tournamentObj->getGroupsList($tid);

		$matches = $matchesObj->getMatchesList($tid, 0, 'group');

print_r($matches);


		// Create a new query object.           
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('u.*, COUNT(b.id) AS count');
		// From the hello table
		$query->from($db->quoteName('#__users') . ' AS u');

		// Join over the groups
		$query->join('LEFT', '#__worldcup_bets AS b ON b.uid = u.id');

		$query->group('id');

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
*/

		return $matches;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success, False on error.
	 *
	 * @since   12.2
	 */
	public function save($data)
	{
		$table = JTable::getInstance('Bet', 'WorldcupTable');

		$key = $table->getKeyName();
		$pk = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
		$isNew = true;

		// Allow an exception to be thrown.
		try
		{
			// Load the row if saving an existing record.
			if ($pk > 0)
			{
				$table->load($pk);
				$isNew = false;
			}

			// Bind the equipment info data.
			if (!$table->save($data))
			{
				$this->setError($table->getError());
				return false;
			}

			// Clean the cache.
			$this->cleanCache();

		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		$pkName = $table->getKeyName();

		if (isset($table->$pkName))
		{
			$this->setState($this->getName() . '.id', $table->$pkName);
		}
		$this->setState($this->getName() . '.new', $isNew);

		return true;
	}
}
