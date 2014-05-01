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

/**
 * Worldcup Teams class
 */
class WorldcupTeams extends JObject
{
	/**
	 * @param   JDatabase  An optional JDatabase instance.
	 * @since  1.0
	 */
	public $_db = null;

	/**
	 * Constructor.
	 *
	 * @param   array  		 An optional associative array of configuration settings.
	 * @see     WorldcupSessions
	 * @since   1.0
	 */
	public function __construct($config = array())
	{
		$this->setProperties($config);

		$this->_db = JFactory::getDbo();
	}

	/**
	 * Get the teams of specific tournament
	 *
	 * @param  int  $tournament  The tournament.
	 *
	 * @return array An array with the teams data.
	 */
	public function getTeamsList($tournament, $group = false)
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("id, name");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_teams'));
		// Conditions
		$query->where("tid = {$tournament}");

		if ($group !== false) {
			$query->where("`group` = {$group}");
		}

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObjectList('id');
	}

	/**
	 * Get the teams of specific tournament
	 *
	 * @param  int  $tournament  The tournament.
	 *
	 * @return array An array with the teams data.
	 */
	public function getTeamsArray($tournament, $group = false)
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("id, name, NULL as points, NULL as gf, NULL as ge, NULL as diff ");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_teams'));
		// Conditions
		$query->where("tid = {$tournament}");

		if ($group !== false) {
			$query->where("`group` = {$group}");
		}

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadAssocList('id');
	}
}
