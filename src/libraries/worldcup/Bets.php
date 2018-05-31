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
use Worldcup\Teams;

/**
 * Worldcup Bets class
 */
class Bets extends Base
{
	/**
	 * Get the bets of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 * @param  int  $user_id  The user id.
	 *
	 * @return object An object with the bets data.
	 */
	public function getBetsList($competition, $user_id = false, $phase_id = false)
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("b.*");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_bets').' AS b');
		// Join
		$query->join('LEFT', '#__worldcup_matches AS m ON m.id = b.mid');
		// Conditions
		$query->where("b.cid = {$competition}");

		if ($user_id !== false) {
			$query->where("b.uid = {$user_id}");
		}

		if ($phase_id !== false) {
			$query->where("m.phase = {$phase_id}");
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
		$query->select("b.*");
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

  function _getTableData($groups, $cid)
  {
		$data = array();

    foreach ($groups as $key => $value)
		{
			// Create a new query object.
			$query	= $this->_db->getQuery(true);

      // Get teams
      $teams[$key] = Teams::getTeamsByGroup($value->id);

			// Select the required fields from the table.
			$query->select("b.mid, m.team1, m.team2, b.local, b.visit");
			$query->from('#__worldcup_bets AS b');
			$query->join('LEFT', '#__worldcup_matches AS m ON m.id = b.mid');
			$query->where("b.uid = {$this->_my->id}");
      $query->where("b.cid = {$cid}");
      $query->where("m.group = {$value->id}");
			$query->order("b.mid ASC");

			// Set query
			$this->_db->setQuery($query);

			// Execute the query
			try {
				$bets = $this->_db->loadObjectList( );
			} catch (RuntimeException $e) {
				throw new RuntimeException($e->getMessage());
			}

			for($y=0;$y<count($bets);$y++)
      {
				$bet = &$bets[$y];

				if ($bet->local > $bet->visit ) {
					$teams[$key][$bet->team1]['points'] += 3;
				}else if ($bet->local < $bet->visit ) {
					$teams[$key][$bet->team2]['points'] += 3;
				}else if ($bet->local == $bet->visit ) {
					$teams[$key][$bet->team1]['points'] += 1;
					$teams[$key][$bet->team2]['points'] += 1;
				}

				$teams[$key][$bet->team1]['gf'] += $bet->local;
				$teams[$key][$bet->team2]['gf'] += $bet->visit;

				$teams[$key][$bet->team1]['ge'] += $bet->visit;
				$teams[$key][$bet->team2]['ge'] += $bet->local;
			}

			$data[$key] = $this->_orderBy($teams[$key]);
		}

    return $data;
  }
}
