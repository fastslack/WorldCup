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
use Worldcup\Bets;
use Worldcup\Results;

/**
 * Worldcup Users class
 */
class Score extends Base
{

  /**
	 * Get the score of specific user
	 *
	 * @param  int  $user_id  The user id.
	 *
	 * @return int An int value of score.
	 */
	public function getUserScore($competition, $user_id = false)
	{
    $tid = 4;
    $points = 0;

    // Get results
    $betsObj = new Bets;
		$resultsObj = new Results;

    $results = $resultsObj->getResultsList($tid);
    $bets = $betsObj->getBetsList($competition, $user_id);


    foreach ($results as $key => $result)
    {
      $bet = isset($bets[$result->mid]) ? $bets[$result->mid] : '';

      $game['result'] = "result";
      $game['bet'] = "bet";

      // Results check
      if($result->local == $result->visit) {
        $game['result'] = "deuce";
      }

      // Simple
      if($result->local > $result->visit) {
        $game['result'] = "local";
      }else if($result->local < $result->visit) {
        $game['result'] = "visit";
      }

      // Who wins on bets
      if (is_object($bet))
      {
        if($bet->local > $bet->visit) {
          $game['bet'] = "local";
        }else if($bet->local < $bet->visit) {
          $game['bet'] = "visit";
        }
      }

      // Bets check
      if (is_object($bet)) {
        if($bet->local == $bet->visit) {
          $game['bet'] = "deuce";
        }
      }

      // Adding score
      if($bet->local == $result->local && $bet->visit == $result->visit)
      {
        $points += 3;
      } elseif (($game['bet'] == "deuce" && $game['result'] == "deuce") && ($bet->local != $result->local)) {
        $points += 1;
      }else if($game['bet'] == $game['result']) {
        $points += 2;
      }
    }

    return $points;
	}
}
