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

namespace Worldcup;

// No direct access to this file
defined('JPATH_PLATFORM') or die;

use Worldcup\Base;

/**
 * Worldcup Teams class
 */
class Teams extends Base
{
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
		$query->select("*");
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

	/**
	 * Get the teams of specific group
	 *
	 * @param  int  $group  The id of the group
	 *
	 * @return array An array with the teams data.
	 */
	static public function getTeamsByGroup($group)
	{
		// Create a new query object.
		$query	= \Joomla\CMS\Factory::getDbo()->getQuery(true);

		// Select the required fields from the table.
		$query->select("t.id, t.name, 0 AS points, 0 AS gf, 0 AS ge, 0 AS diff");
		$query->from('#__worldcup_teams AS t');
		$query->where("t.group = {$group}");

		// Set query
		\Joomla\CMS\Factory::getDbo()->setQuery($query);

		// Execute the query
		try {
			return \Joomla\CMS\Factory::getDbo()->loadAssocList( 'id' );
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}
	}
}
