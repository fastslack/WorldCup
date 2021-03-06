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
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * WorldcupModelTournament Model
 */
class WorldcupModelTournament extends JModelAdmin
{
	/**
	* Returns a reference to the a Table object, always creating it.
	*
	* @param       type    The table type to instantiate
	* @param       string  A prefix for the table class name. Optional.
	* @param       array   Configuration array for model. Optional.
	* @return      JTable  A database object
	* @since       2.5
	*/
	public function getTable($type = 'Tournament', $prefix = 'WorldcupTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	* Method to get the record form.
	*
	* @param       array   $data           Data for the form.
	* @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
	* @return      mixed   A JForm object on success, false on failure
	* @since       2.5
	*/
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_worldcup.tournament', 'tournament',
    	array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
    	return false;
		}
		return $form;
	}

	/**
	* Method to get the data that should be injected in the form.
	*
	* @return      mixed   The data for the form.
	* @since       2.5
	*/
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_worldcup.edit.tournament.data', array());
		if (empty($data)) 
		{
		  $data = $this->getItem();
		}
		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success, False on error.
	 *
	 * @since   12.2
	 */
	public function save($data)
	{
		$table = JTable::getInstance('Tournament', 'WorldcupTable');

		$key = $table->getKeyName();
		$pk = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
		$isNew = true;

		// Allow an exception to be thrown.
		try
		{
			// Load the row if saving an existing record.
			if ($pk > 0)
			{
				$table->load($pk);
				$isNew = false;
			}

			// Bind the equipment info data.
			if (!$table->save($data))
			{
				$this->setError($table->getError());
				return false;
			}

			// Clean the cache.
			$this->cleanCache();

		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		$pkName = $table->getKeyName();

		if (isset($table->$pkName))
		{
			$this->setState($this->getName() . '.id', $table->$pkName);
		}
		$this->setState($this->getName() . '.new', $isNew);

		return true;
	}
}
