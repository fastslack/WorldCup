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
use Worldcup\Bets;
use Worldcup\Matches;
use Worldcup\Teams;
use Worldcup\Helper;

/**
 * Worldcup Tournaments class
 */
class Tournaments extends Base
{
	/**
	 * Get the groups of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 *
	 * @return object An object with the groups data.
	 */
	public function getGroupsList($tournament, $flag = 'id')
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("g.*");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_groups').' AS g');
		// Conditions
		$query->where("g.tid = {$tournament}");

		$query->order("g.id ASC");
		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObjectList($flag);
	}

	/**
	* Get the matches of specific tournament
	*
	* @param  int  $tournament  The tournament id.
	* @param  int  $phase  The phase id.
	*
	* @return object An object with the matches data.
	*/
	public function getGroupsTable ($tournament, $user_id, $flag = 'bets') {

		// Loader
		//JLoader::import('helpers.worldcup', JPATH_COMPONENT_ADMINISTRATOR);

		$data = array();
		$db = Factory::getDBO();

		$betsObj = new Bets();
		$matchesObj = new Matches();
		$teamsObj = new Teams();

		// Get the groups
		$groups = $this->getGroupsList($tournament, null);

		// Each group
		$i = 1;

		foreach ($groups as $key => $group) {

			// Get teams
			$teams[$i] = $teamsObj->getTeamsArray($tournament, $group->id);

			// Get bets
			if ($flag == 'bets') {
				$bets = $betsObj->getBetsGroupList($tournament, $user_id, $group->id);
			}else if ($flag == 'results') {
				$bets = $matchesObj->getResultsList($tournament, $group->id);
			}

			// Foreach bets
			foreach ($bets as $bet)
			{
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
			}

			$data[$i] = Helper::orderBy($teams[$i]);

			$i++;
		}

		return $data;
	}
}
