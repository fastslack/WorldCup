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
class TableWorldCupBets extends JTable {
	/** @var int */
	var $id				 = null;
	/** @var string */
	var $tid			 = '';
	/** @var string */
	var $uid			 = '';
	/** @var string */
	var $mid      = '';
	/** @var string */
	var $local      = '';
	/** @var string */
	var $visit      = '';
	/** @var string */
	var $team1      = '';
	/** @var string */
	var $team2      = '';

	function __construct(&$_db) {
		parent::__construct('#__worldcup_bets', 'id', $_db);
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

