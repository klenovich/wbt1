<?php

/**
 * Vvveb
 *
 * Copyright (C) 2022  Ziadin Givan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

/**
 * @package Vvveb Contact form plugin
 * @version 0.1
 */
/*
Name: Vvveb.com Contact form
Slug: vvveb-com-contact-form
Category: email
Url: https://www.vvveb.com
Description: Contact forms for vvveb.com
Thumb: contact-form.svg
Author: givanz
Status: active
Version: 0.1
Author url: https://www.vvveb.com
*/

use function Vvveb\__;
use Vvveb\System\Core\View;
use Vvveb\System\Routes;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

#[\AllowDynamicProperties]
class VvvebContactFormPlugin {
	function admin() {
	}

	function saveMessage() {
		$file = DIR_ROOT . '/' . date('Y-M-d h:m:s') . ' - ' . rand(0, 1000) . '.txt';

		//robots will also fill hidden inputs
		if (
			isset($_POST['firstname-empty']) && empty($_POST['firstname-empty']) &&
			isset($_POST['lastname-empty']) && empty($_POST['lastname-empty']) &&
			isset($_POST['subject-empty']) && empty($_POST['subject-empty'])
		) {
			if (file_put_contents($file,  print_r($_POST, 1) . print_r($_SERVER, 1) . print_r($_GET, 1))) {
				//$this->view->success[] = 'Message was sent. Thank you!';
			} else {
				$this->view->errors[] = __('Error sending message');
			}
		} else {
			$this->view->errors[] = __('Error sending message');
		}
	}

	function app() {
		//use get parameters for form autocomplete
		$template = $this->view->getTemplateEngineInstance();
		//$template->loadTemplateFile(__DIR__ . '/app/template/common.tpl');

		//check if contact page
		if ($url = Routes::getUrlData()) {
			if ($url['route'] == 'content/page/index' && $url['slug'] == 'contact') {
				if (isset($_POST['message'])) {
					$this->saveMessage();
				}
			}
		}
	}

	function __construct() {
		if (Vvveb\isEditor()) {
			return;
		}

		$this->view = View::getInstance();

		if (APP == 'admin') {
			$this->admin();
		} elseif (APP == 'app' && ! defined('CLI')) {
			$this->app();
		}
	}
}

$vvvebContactFormPlugin = new VvvebContactFormPlugin();
