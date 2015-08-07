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
 * Working Copy Table class
 *
 */
class TableWorldCupGroups extends JTable {
	/** @var int */
	var $id				= null;
	/** @var int */
	var $tid			 = null;
	/** @var string */
	var $name			= '';

	function __construct(&$_db) {
		parent::__construct('#__worldcup_groups', 'id', $_db);
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
