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
Name: Minify css and js
Slug: minify
Category: performance
Url: https://www.vvveb.com
Description: Minify javascript and css for better frontend performance.
Author: givanz
Version: 0.1
Thumb: minify.svg
Author url: https://www.vvveb.com
*/

use function Vvveb\__;
use Vvveb\System\Event;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class MinifyPlugin {
	function admin() {
		//add admin menu item
		$admin_path = \Vvveb\adminPath();
		Event::on('Vvveb\Controller\Base', 'init-menu', __CLASS__, function ($menu) use ($admin_path) {
			$menu['plugins']['items']['minify-plugin'] = [
				'name'     => __('Minify'),
				'url'      => '/admin/',
				'icon-img' => PUBLIC_PATH . 'plugins/minify/minify.svg',
			];

			return [$menu];
		});
	}

	function app() {
	}

	function __construct() {
		if (APP == 'admin') {
			$this->admin();
		} else {
			if (APP == 'app') {
				$this->app();
			}
		}
	}
}

$minifyPlugin = new MinifyPlugin();
