<?php
/**
 * WorldCup
 *
 * @version $Id:
 * @package WorldCup
 * @copyright Copyright (C) 2004 - 2018 Matware. All rights reserved.
 * @author Matias Aguirre
 * @email maguirre@matware.com.ar
 * @link http://www.matware.com.ar/
 * @license GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Worldcup Component Controller
 *
 * @since  1.5
 */
class WorldcupController extends JControllerLegacy
{
	/**
	 * Method to show a Worldcup view
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 *
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		// Set the default view name and format from the Request.
		$vName = $this->input->get('view', 'results');
		$this->input->set('view', $vName);

		$user = JFactory::getUser();

		if ($user->get('id') || ($this->input->getMethod() === 'POST' && $vName === 'category'))
		{
			$cachable = false;
		}

		$safeurlparams = array('id' => 'INT', 'limit' => 'UINT', 'limitstart' => 'UINT',
								'filter_order' => 'CMD', 'filter_order_Dir' => 'CMD', 'lang' => 'CMD');

		parent::display($cachable, $safeurlparams);

		return $this;
	}
}
