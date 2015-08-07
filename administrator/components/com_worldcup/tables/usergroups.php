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
 * TableWorldCupUsergroups Table class
 *
 */
class TableWorldCupUsergroups extends JTable {
	/** @var int */
	var $id				 = null;
	/** @var string */
	var $sid			 = '';
	/** @var string */
	var $gid      = '';

	function __construct(&$_db) {
		parent::__construct('#__worldcup_usergroups', 'id', $_db);
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
