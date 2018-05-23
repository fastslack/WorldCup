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
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Worldcup Result table class
 *
 */
class WorldcupTableResult extends JTable {

  /**
   * Constructor
   *
   * @param object Database connector object
   */
	function __construct(&$_db) {
		parent::__construct('#__worldcup_results', 'id', $_db);
	}
}
