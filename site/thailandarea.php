<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Thailandarea
 * @author     Anugool Sridum <a.sridum@gmail.com>
 * @copyright  2020 Anugool Sridum
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Controller\BaseController;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Thailandarea', JPATH_COMPONENT);
JLoader::register('ThailandareaController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = BaseController::getInstance('Thailandarea');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
