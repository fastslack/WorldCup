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

class WorldCupViewCompetition extends WorldCupView
{

  function display($tpl = null)	{

		// Get the patient id
		$this->tid = JFactory::getApplication()->input->get('tid', 4);

    switch ($this->getLayout()) {
			case 'show':
				$this->show($tpl);
				return;
		}

		parent::display($tpl);
	}

  function show($tpl = null)
	{
    $my = JFactory::getUser();
		$app = JFactory::getApplication();

		if (empty($my->id))
		{
			// Redirect to the return page.
			$app->redirect('index.php?option=com_users&view=registration');
			$app->close();
		}

		$this->cid = JFactory::getApplication()->input->getInt('id');

    // Get teams
		$this->teams = $this->_teams->getTeamsList($this->tid);

    $this->competition = $this->_competitions->getCompetitionById($this->cid);
    $this->competition_users = $this->_competitions->getCompetitionUsers($this->cid);

    // Get score
    foreach ($this->competition_users as $key => &$user) {
      $user->score = $this->_score->getUserScore($this->cid, $user->id);
    }

    // Score sorting
    function cmp($a, $b)
    {
        return strcmp($b->score, $a->score);
    }

    usort($this->competition_users, "cmp");

    // Final
    $this->finalMatch = $this->_matches->getFinalMatch($this->tid);

		parent::display($tpl);
	}

}
