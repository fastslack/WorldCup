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
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class WorldCupView extends JViewLegacy
{
	function __construct($config = array())
	{
		parent::__construct($config);

		// Create the db instance
		$this->_db =& JFactory::getDBO();
		// Create the JUser instance
		$this->_my =& JFactory::getUser();
	}
}
