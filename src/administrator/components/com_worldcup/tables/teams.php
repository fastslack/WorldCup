<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * TableWorldCupTeams Table class
 *
 */
class TableWorldCupTeams extends JTable {
	/** @var int */
	var $id				 = null;
	/** @var int */
	var $tid			 = null;
	/** @var string */
	var $name      = '';
	/** @var string */
	var $group     = '';
	/** @var string */
	var $flag   = '';

	function __construct(&$_db) {
		parent::__construct('#__worldcup_teams', 'id', $_db);
	}

	/**
	 * Overloaded check function
	 *
	 * @access public
	 * @return boolean
	 * @see JTable::check
	 * @since 1.5
	 */
	function check() {
		return true;
	}

}
