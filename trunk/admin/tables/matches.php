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
 * TableWorldCupMatches Table class
 *
 */
class TableWorldCupMatches extends JTable {
	/** @var int */
	var $id				 = null;
	/** @var int */
	var $tid			 = null;
	/** @var string */
	var $date			 = '';
	/** @var string */
	var $group      = '';
	/** @var string */
	var $place      = '';
	/** @var string */
	var $team1     = '';
	/** @var string */
	var $team2   = '';
	/** @var string */
	var $phase   = '';

	function __construct(&$_db) {
		parent::__construct('#__worldcup_matches', 'id', $_db);
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
