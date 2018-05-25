<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

require_once (JPATH_COMPONENT.'/view.php');

class WorldCupViewCompetition extends WorldCupView
{

  function display($tpl = null)	{

		// Get the patient id
		$this->tid = JFactory::getApplication()->input->get('tid', 4);


		parent::display($tpl);
	}

}
