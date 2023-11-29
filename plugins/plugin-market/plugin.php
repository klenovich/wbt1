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
Name: Plugin market
Slug: plugin-market
Category: market
Url: https://www.vvveb.com
Description: Adds plugin product type and support for "Plugin market" plugin.
Author: givanz
Version: 0.1
Thumb: plugin-market.svg
Author url: https://www.vvveb.com
Settings: /admin/?module=plugins/plugin-market/settings
*/

use function Vvveb\__;
use Vvveb\System\Event;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class PluginMarketPlugin {
	function customProduct() {
		Event::on('Vvveb\Controller\Base', 'customProducts', __CLASS__, function ($custom_products) {
			$custom_products += ['plugin' => [
				'product_type'   => 'plugin',
				'plural'         => 'plugins',
				'icon-img'       => PUBLIC_PATH . 'plugins/plugin-market/plugin-market.svg',
				//'icon'        => 'la la-brush',
			]];

			return [$custom_products];
		});
	}

	function admin() {
		//add admin menu item
		$admin_path = \Vvveb\adminPath();
		Event::on('Vvveb\Controller\Base', 'init-menu', __CLASS__, function ($menu) use ($admin_path) {
			$menu['plugins']['items']['cdn'] = [
				'name'     => __('Plugin market'),
				'url'      => $admin_path . '?module=plugins/plugin-market/settings',
				'icon-img' => PUBLIC_PATH . 'plugins/plugin-market/plugin-market.svg',
			];

			return [$menu];
		});

		//add plugin custom product
		$this->customProduct();
	}

	function app() {
		//if (isEditor()) return;

		//change image base path to point to cdn
		Event::on('Vvveb\System\Images', 'publicPath', __METHOD__ , function ($publicPath, $type, $image, $size) {
			//$publicPath = 'https://cdn.statically.io/img/example.com/' . $_SERVER['HTTP_Hroduct'] . '/';
			return [$publicPath, $type, $image, $size];
		});

		//add download link
		Event::on('Vvveb\Component\Products', 'results', __METHOD__ , function ($results) {
			foreach ($results['products'] as &$product) {
				$product['download_link'] = PUBLIC_PATH . 'market/plugins/' . $product['slug'] . '.zip';
			}

			return [$results];
		});

		//add download link
		Event::on('Vvveb\Component\Product', 'results', __METHOD__ , function ($results) {
			if ($results) {
				$results['download_link'] = PUBLIC_PATH . 'market/plugins/' . $results['slug'] . '.zip';
			}

			return [$results];
		});

		//rewrite product content images

		/*
		Event::on('Vvveb\System\Images', 'image', __METHOD__ , function ($type, $image, $size) {
			return $image;
		});*/

		//on cache purge also purge cdn
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

$cdnPlugin = new PluginMarketPlugin();
