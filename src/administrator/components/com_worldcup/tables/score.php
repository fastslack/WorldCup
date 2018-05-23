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
 * TableWorldCupScore Table class
 *
 */
class TableWorldCupScore extends JTable {
	/** @var int */
	var $tid			 = null;
	/** @var string */
	var $uid = null;
	/** @var string */
	var $points = null;
	/** @var string */
	var $count = null;

	function __construct(&$_db) {
		parent::__construct('#__worldcup_score', 'uid', $_db);
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

	/**
	 * Inserts a new row if id is zero or updates an existing row in the database table
	 *
	 * Can be overloaded/supplemented by the child class
	 *
	 * @access public
	 * @param boolean If false, null object variables are not updated
	 * @return null|string null if successful otherwise returns and error message
	 */
	function store( $updateNulls=false )
	{
		$k = $this->_tbl_key;

		$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );

		if( !$ret )	{
			$this->setError(get_class( $this ).'::store failed - '.$this->_db->getErrorMsg());
			return false;
		}	else {
			return true;
		}
	}

}

