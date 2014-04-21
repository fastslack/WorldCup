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

/**
 * Worldcup Tournaments class
 */
class WorldcupTournaments extends JObject
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
	 * Get the groups of specific tournament
	 *
	 * @param  int  $tournament  The tournament id.
	 *
	 * @return object An object with the groups data.
	 */
	public function getGroupsList($tournament)
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
		return $this->_db->setQuery($query)->loadObjectList('id');
	}
}
