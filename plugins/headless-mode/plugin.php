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

/*
Name: Headless mode
Slug: headless-mode
Category: tools
Url: https://www.vvveb.com
Description: All frontend requests return json response instead of html.
Author: givanz
Version: 0.1
Thumb: headless-mode.svg
Author url: https://www.vvveb.com
*/

use function Vvveb\__;
use Vvveb\System\Core\Response;
use Vvveb\System\Event;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class HeadlessModePlugin {
	function admin() {
		//add admin menu item
		$admin_path = \Vvveb\adminPath();
		Event::on('Vvveb\Controller\Base', 'init-menu', __CLASS__, function ($menu) use ($admin_path) {
			$menu['plugins']['items']['headless-mode-plugin'] = [
				'name'     => __('Headless Mode'),
				'url'      => '/admin/',
				'icon-img' => PUBLIC_PATH . 'plugins/headless-mode/headless-mode.svg',
				'module'   => 'plugins/headless-mode/settings',
				'action'   => 'index',
			];

			return [$menu];
		});
	}

	function app() {
		$response = Response::getInstance();
		$response->setType('json');
	}

	function __construct() {
		if (APP == 'admin') {
			//$this->admin();
		} else {
			if (APP == 'app') {
				$this->app();
			}
		}
	}
}

$headlessModePlugin = new HeadlessModePlugin();
