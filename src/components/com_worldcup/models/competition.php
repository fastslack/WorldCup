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

// No direct access to this file
defined('_JEXEC') or die;

/**
 * Content Component Article Model
 *
 * @package     Joomla.Site
 * @subpackage  com_content
 * @since       1.5
 */
class WorldcupModelCompetition extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_mets.competition';

	/**
	* Returns a reference to the a Table object, always creating it.
	*
	* @param       type    The table type to instantiate
	* @param       string  A prefix for the table class name. Optional.
	* @param       array   Configuration array for model. Optional.
	* @return      JTable  A database object
	* @since       2.5
	*/
	public function getTable($type = 'Competition', $prefix = 'WorldcupTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


  /**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  mixed  The user id on success, false on failure.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		$uid = JFactory::getUser()->id;

    // @@ TODO: Fix tournament
    $data['tid'] = 4;
    $data['created_by'] = $uid;
    $data['code'] = bin2hex(openssl_random_pseudo_bytes(3));
    $data['published'] = 1;

    $table = $this->getTable();
    //$table->save($data);

		//$this->createOwner($table->id, $uid);
	}

	/**
	 * Create the competition owner
	 *
	 * @param  int  $competition  The competition id.
	 *
	 * @return object An int with the total of users
	 */
	public function createOwner($cid, $uid)
	{
    // Insert needed value
    $query = $this->_db->getQuery(true);
    $query->insert('#__worldcup_competitions_map_users')
      ->columns('`competition_id`, `user_id`, `created`, `authorised`')
      ->values("{$cid}, {$uid}, NOW(), 2");

    try {
      return $this->_db->setQuery($query)->execute();
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
	}
}
