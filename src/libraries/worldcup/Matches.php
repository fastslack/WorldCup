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
 * Worldcup Matches class
 */
class Matches extends Base
{
	/**
	 * Get the matches of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 * @param  int  $phase  The phase id.
	 *
	 * @return object An object with the matches data.
	 */
	public function getMatchesList($tournament, $phase = false, $group = false)
	{
		// Get query instance
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("m.*, p.name AS pname");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_matches').' AS m');
		// Join
		$query->join('LEFT', '#__worldcup_places AS p ON p.id = m.place');
		// Conditions
		$query->where("m.tid = {$tournament}");

		if ($phase !== false) {
			$query->where("m.phase = {$phase}");
		}

		if ($group !== false) {
			$query->where("m.group = {$group}");
		}

		$query->order("m.id ASC");

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObjectList();
	}

	/**
	 * Get the matches of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 * @param  int  $group  The group id.
	 *
	 * @return object An object with the matches data.
	 */
	public function getResultsList($tournament, $group = false)
	{
		// Get query instance
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("r.mid, m.team1, m.team2, r.local, r.visit");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_results').' AS r');
		// Join
		$query->join('LEFT', '#__worldcup_matches AS m ON m.id = r.mid');
		// Conditions
		$query->where("m.tid = {$tournament}");

		if ($group !== false) {
			$query->where("m.group = {$group}");
		}

		$query->order("r.mid ASC");

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObjectList('mid');
	}

	/**
	 * Get the final matche for specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 *
	 * @return object An object with the matches data.
	 */
	public function getFinalMatch($tournament)
	{
		// Get query instance
		$query = $this->_db->getQuery(true);

		// Select some values
		$query->select("m.id, m.team1, m.team2");

		// Set the from table
		$query->from($this->_db->qn('#__worldcup_matches').' AS m');

		// Conditions
		$query->where("m.tid = {$tournament}");
		$query->where("m.phase = 5");

		$query->setLimit(1);

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObject();
	}

	/**
	* Order the table data
	*
	* @param  array  $data  The data to be ordered.
	*
	* @return object An object with the data.
	*/
	protected function __orderBy($data)
	{
		foreach ($data as $key => $row)
		{
				$points[$key]  = $row['points'];
				$gf[$key] = $row['gf'];
				$ge[$key] = $row['ge'];
		}

		$res = array_multisort($points, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data;
	}
}
