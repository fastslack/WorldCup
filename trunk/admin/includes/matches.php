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

JLoader::register('WorldcupTournaments', JPATH_COMPONENT_ADMINISTRATOR.'/includes/tournaments.php');

/**
 * Worldcup Matches class
 */
class WorldcupMatches extends JObject
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
	 * Get the matches of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 * @param  int  $phase  The phase id.
	 *
	 * @return object An object with the matches data.
	 */
	public function getMatchesList($tournament, $phase = false, $group = false)
	{
		// Get the correct equipment
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
	* @param  int  $phase  The phase id.
	*
	* @return object An object with the matches data.
	*/
	public function getSecondPhaseTable ($tournament, $user_id) {

		$data = array();
		$db =& JFactory::getDBO();

		$betsObj = new WorldcupBets();
		$teamsObj = new WorldcupTeams();
		$tournamentObj = new WorldcupTournaments();

		// Get the groups
		$groups = $tournamentObj->getGroupsList($tournament);

		$values = array('points', 'gf', 'ge');


		for($i=1;$i<=count($groups);$i++) {

			$group = $groups[$i];

			// Get teams	
			$teams[$i] = $teamsObj->getTeamsArray($tournament, $group->id);

			// Get bets
			$bets = $betsObj->getBetsGroupList($tournament, $user_id, $group->id);

			// Foreach bets
			foreach ($bets as $bet)
			{
				foreach ($values as $val)
				{
					if (!isset($teams[$i][$bet->team1][$val])) {
						$teams[$i][$bet->team1][$val] = 0;
					}

					if (!isset($teams[$i][$bet->team2][$val])) {
						$teams[$i][$bet->team2][$val] = 0;
					}
				}

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

			$data[$i] = $this->__orderBy($teams[$i]);
		}

		return $data;
	}

	/**
	* Order the table data
	*
	* @param  array  $data  The data to be ordered.
	*
	* @return object An object with the data.
	*/
	protected function __orderBy($data) { 

		foreach ($data as $key => $row) {
				$points[$key]  = $row['points'];
				$gf[$key] = $row['gf'];
				$ge[$key] = $row['ge'];
		}

		$res = array_multisort($points, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data; 
	}
}
