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
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package		Matware
 * @subpackage	Worldcup
 */
class WorldcupHelper
{
	/**
	 * Returns an array with the different phases
	 *
	 * @param   int  $teamscount  The total of teams.
	 *
	 * @return  array  Array containing the list of phases.
	 *
	 * @since   1.0
	 */
	public function getPhases($teamscount = 0) { 

		// Declare phases
		$phases = array();
		$phases[0] = JText::_( 'Clasification' );
		if ($teamscount > 12) {
			$phases[1] = JText::_( 'Round of 16' );
		}
		$phases[2] = JText::_( 'Quarter-finals' ); 
		$phases[3] = JText::_( 'Semi-finals' ); 
		$phases[4] = JText::_( 'Match for third place' );
		$phases[5] = JText::_( 'Final' );

		return $phases;
	}

	/**
	 * Order the data correctly
	 *
	 * @param   array  $data  The data to order
	 *
	 * @return  array  Array containing the list ordered.
	 *
	 * @since   1.0
	 */
	public function _orderBy($data) { 

		foreach ($data as $key => $row) {
				$points[$key]  = $row['points'];
				$gf[$key] = $row['gf'];
				$ge[$key] = $row['ge'];
				$diff[$key] = $row['diff'];
		}

		$res = @array_multisort($points, SORT_DESC, $diff, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data; 
	}
}
