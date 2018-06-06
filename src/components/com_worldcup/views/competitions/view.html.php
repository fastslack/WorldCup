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

require_once (JPATH_COMPONENT.'/view.php');

class WorldCupViewCompetitions extends WorldCupView
{

  function display($tpl = null)	{

		// Get the tournament id
		$this->tid = JFactory::getApplication()->input->get('tid', 4);

    $this->competitions = $this->_competitions->getCompetitionsList();

		parent::display($tpl);
	}

}
