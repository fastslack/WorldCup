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
 * Worldcup Bets class
 */
class WorldcupBets extends JObject
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
	 * Get the bets of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 * @param  int  $user_id  The user id.
	 *
	 * @return object An object with the bets data.
	 */
	public function getBetsList($tournament, $user_id = false)
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("b.mid, b.local, b.visit, b.team1, b.team2");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_bets').' AS b');
		// Join
		$query->join('LEFT', '#__worldcup_matches AS m ON m.id = b.mid');
		// Conditions
		$query->where("b.tid = {$tournament}");

		if ($user_id !== false) {
			$query->where("b.uid = {$user_id}");
		}

		$query->order("m.id ASC");

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObjectList('mid');
	}

	/**
	 * Get the bets of specific tournament and group
	 *
	 * @param  int  $tournament  The tournament id.
	 * @param  int  $user_id  The user id.
	 * @param  int  $group  The group id.
	 *
	 * @return object An object with the bets data.
	 */
	public function getBetsGroupList($tournament, $user_id = false, $group = false)
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("b.mid, m.team1, m.team2, b.local, b.visit");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_bets').' AS b');
		// Join
		$query->join('LEFT', '#__worldcup_matches AS m ON m.id = b.mid');
		// Conditions
		$query->where("b.tid = {$tournament}");

		if ($user_id !== false) {
			$query->where("b.uid = {$user_id}");
		}

		if ($group !== false) {
			$query->where("m.group = {$group}");
		}

		$query->order("b.mid ASC");

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObjectList('mid');
	}
}
