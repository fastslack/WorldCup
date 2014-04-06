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
jimport('joomla.application.component.controller');

class WorldcupController extends JControllerLegacy {

	/**
	 * Method to display a view.
	 *
	 * @param   boolean			$cachable	If true, the view output will be cached
	 * @param   array  $urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	function display($cachable = false, $urlparams = array()) 
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'cpanel'));
 
		// call parent behavior
		parent::display($cachable);
	}
}
