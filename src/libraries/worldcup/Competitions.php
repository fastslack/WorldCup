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
class Competitions extends Base
{
  /**
	 * Get the competitions of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 *
	 * @return object An object with the competitions data.
	 */
	public function getCompetitionsList($tournament)
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);
		// Select some values
		$query->select("c.*, t.title AS tname, u.name AS uname");
		// Set the from table
		$query->from($this->_db->qn('#__worldcup_competitions').' AS c');
		// Join
		$query->join('LEFT', '#__worldcup_tournaments AS t ON t.id = c.tid');
		$query->join('LEFT', '#__users AS u ON u.id = c.created_by');

		// Conditions
    // @@ TODO: allow list all tournaments
		$query->where("c.tid = {$tournament}");

		$query->where("c.hidden = 0");

		$query->order("c.name ASC");

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadObjectList();
	}

  /**
	 * Get the competitions users count
	 *
	 * @param  int  $competition  The competition id.
	 *
	 * @return object An int with the total of users
	 */
	public function getCompetitionCount($competition)
	{
		// Get the correct equipment
		$query = $this->_db->getQuery(true);

		// Select some values
		$query->select("COUNT(*)");

		// Set the from table
		$query->from($this->_db->qn('#__worldcup_competitions_map_users').' AS cmu');

		// Conditions
		$query->where("cmu.competition_id = {$competition}");

		// Retrieve the data.
		return $this->_db->setQuery($query)->loadResult();
	}
}
