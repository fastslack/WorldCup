<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component Article Model
 *
 * @package     Joomla.Site
 * @subpackage  com_content
 * @since       1.5
 */
class WorldcupModelBets extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_mets.bets';

	/**
	* Returns a reference to the a Table object, always creating it.
	*
	* @param       type    The table type to instantiate
	* @param       string  A prefix for the table class name. Optional.
	* @param       array   Configuration array for model. Optional.
	* @return      JTable  A database object
	* @since       2.5
	*/
	public function getTable($type = 'Bet', $prefix = 'WorldcupTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
}
