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

use Joomla\CMS\Language\Text;

/**
 * @package		Matware
 * @subpackage	Worldcup
 */
class Helper
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
	static public function getPhases($teamscount = 0) {

		// Declare phases
		$phases = array();
		$phases[] = Text::_( 'Clasification' );
		if ($teamscount > 12) {
			$phases[] = Text::_( 'Round of 16' );
		}
		$phases[] = Text::_( 'Quarter-finals' );
		$phases[] = Text::_( 'Semi-finals' );
		$phases[] = Text::_( 'Match for third place' );
		$phases[] = Text::_( 'Final' );

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
	public function orderBy($data)
	{
		foreach ($data as $key => $row)
		{
				$points[$key]  = $row['points'];
				$gf[$key] = $row['gf'];
				$ge[$key] = $row['ge'];
				$diff[$key] = $row['diff'];
		}

		$res = @array_multisort($points, SORT_DESC, $diff, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

		return $data;
	}
}
