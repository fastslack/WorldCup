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
 * Worldcup Results class
 */
class Results extends Base
{


  function _getTableData($groups) {

		$data = array();
		$db = JFactory::getDBO();

		foreach ($groups as $key => $value)
		{
			// Create a new query object.
			$query	= $this->_db->getQuery(true);

      // Get teams
      $teams[$key] = Teams::getTeamsByGroup($value->id);

			// Select the required fields from the table.
			$query->select("r.mid, m.team1, m.team2, r.local, r.visit");
			$query->from('#__worldcup_results AS r');
			$query->join('LEFT', '#__worldcup_matches AS m ON m.id = r.mid');
			$query->where("m.group = {$value->id}");
			$query->order("r.mid ASC");

			// Set query
			$db->setQuery($query);

			// Execute the query
			try {
				$bets = $db->loadObjectList( );
			} catch (RuntimeException $e) {
				throw new RuntimeException($e->getMessage());
			}

			// bets
			for($y=0;$y<count($bets);$y++)
			{
				$bet = &$bets[$y];

				if ($bet->local > $bet->visit ) {
					$teams[$i][$bet->team1]['points'] += 3;
				}else if ($bet->local < $bet->visit ) {
					$teams[$i][$bet->team2]['points'] += 3;
				}else if ($bet->local == $bet->visit ) {
					$teams[$i][$bet->team1]['points'] += 1;
					$teams[$i][$bet->team2]['points'] += 1;
				}

				$teams[$i][$bet->team1]['gf'] += $bet->local;
				$teams[$i][$bet->team2]['gf'] += $bet->visit;

				$teams[$i][$bet->team1]['ge'] += $bet->visit;
				$teams[$i][$bet->team2]['ge'] += $bet->local;

				$teams[$i][$bet->team1]['diff'] += $bet->local;
				$teams[$i][$bet->team1]['diff'] -= $bet->visit;

				$teams[$i][$bet->team2]['diff'] += $bet->visit;
				$teams[$i][$bet->team2]['diff'] -= $bet->local;
			}

			$data[$i] = $this->_orderBy($teams[$i]);
		}

		return $data;
	}

}
