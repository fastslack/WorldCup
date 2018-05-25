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

$controller = JControllerLegacy::getInstance('Worldcup');

$task = JFactory::getApplication()->input->get('task', '');
$controller->execute(JFactory::getApplication()->input->get('task', 'subscribe'));
$controller->redirect();
