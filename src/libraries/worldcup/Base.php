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

use Joomla\Registry\Registry;
use Joomla\CMS\Factory;

/**
 * Worldcup Results class
 */
class Base extends Registry
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
	public function __construct($data = null)
	{
		$this->_db = Factory::getDbo();
    $this->_my = Factory::getUser();
	}

  /**
	 * Order by
	 *
	 * @param   array  		 An associative array to sort.
	 * @see
	 * @since   1.0
	 */
  function _orderBy($data)
  {
    foreach ($data as $key => $row)
    {
      $points[$key]  = !empty($row['points']) ? $row['points'] : 0 ;
      $gf[$key] = !empty($row['gf']) ? $row['gf'] : 0 ;
      $ge[$key] = !empty($row['ge']) ? $row['ge'] : 0 ;
      $diff[$key] = !empty($row['diff']) ? $row['diff'] : 0 ;
    }

    $res = array_multisort($points, SORT_DESC, $diff, SORT_DESC, $gf, SORT_DESC, $ge, SORT_ASC, $data);

    return $data;
  }
}
