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

use Joomla\CMS\Factory;
use Worldcup\Base;
use Worldcup\Teams;

/**
 * Worldcup Results class
 */
class Results extends Base
{
  /**
	 * Get the results of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 *
	 * @return object An object with the competitions data.
	 */
	public function getResultsList($tournament)
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);

		// Select some values
		$query->select("r.*");

		// Set the from table
		$query->from($this->_db->qn('#__worldcup_results').' AS r');

		// Conditions
		$query->where("r.tid = {$tournament}");

		$query->order("r.mid ASC");

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObjectList('mid');
	}

  function getTableData($groups) {

		$data = array();
		$db = Factory::getDBO();

		foreach ($groups as $key => $value)
		{
			// Create a new query object.
			$query	= $this->_db->getQuery(true);

      // Get teams
      $teams[$key] = Teams::getTeamsByGroup($key);

			// Select the required fields from the table.
			$query->select("m.id, m.team1, m.team2, r.local, r.visit");
			$query->from('#__worldcup_matches AS m');
			$query->join('LEFT', '#__worldcup_results AS r ON r.mid = m.id');
			$query->where("m.group = {$key}");
			$query->order("r.mid ASC");

			// Set query
			$db->setQuery($query);

			// Execute the query
			try {
				$results = $db->loadObjectList( );
			} catch (RuntimeException $e) {
				throw new RuntimeException($e->getMessage());
			}

			// bets
			for($y=0;$y<count($results);$y++)
			{
				$bet = &$results[$y];

				if ($bet->local > $bet->visit ) {
					$teams[$key][$bet->team1]['points'] += 3;
				}else if ($bet->local < $bet->visit ) {
					$teams[$key][$bet->team2]['points'] += 3;
				}else if ((!empty($bet->local) && !empty($bet->local)) && $bet->local == $bet->visit ) {
					$teams[$key][$bet->team1]['points'] += 1;
					$teams[$key][$bet->team2]['points'] += 1;
				}

        if (!empty($bet->local) && !empty($bet->local))
        {
          $teams[$key][$bet->team1]['gf'] += $bet->local;
          $teams[$key][$bet->team2]['gf'] += $bet->visit;

          $teams[$key][$bet->team1]['ge'] += $bet->visit;
          $teams[$key][$bet->team2]['ge'] += $bet->local;

          $teams[$key][$bet->team1]['diff'] += $bet->local;
          $teams[$key][$bet->team1]['diff'] -= $bet->visit;

          $teams[$key][$bet->team2]['diff'] += $bet->visit;
          $teams[$key][$bet->team2]['diff'] -= $bet->local;
        }
			}

			$data[$key] = $this->_orderBy($teams[$key]);
		}

		return $data;
	}

}
