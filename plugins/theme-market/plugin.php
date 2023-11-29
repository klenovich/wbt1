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
Name: Theme market
Slug: theme-market
Category: market
Url: https://www.vvveb.com
Description: Adds theme product type and support for "Theme market" theme.
Author: givanz
Version: 0.1
Thumb: theme-market.svg
Author url: https://www.vvveb.com
Settings: /admin/?module=plugins/theme-market/settings
*/

use function Vvveb\__;
use Vvveb\System\Event;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class ThemeMarketPlugin {
	function customProduct() {
		Event::on('Vvveb\Controller\Base', 'customProducts', __CLASS__, function ($custom_products) {
			$custom_products += ['theme' => [
				'product_type'   => 'theme',
				'plural'         => 'themes',
				'icon-img'       => PUBLIC_PATH . 'plugins/theme-market/theme-market.svg',
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
				'name'     => __('Theme market'),
				'url'      => $admin_path . '?module=plugins/theme-market/settings',
				'icon-img' => PUBLIC_PATH . 'plugins/theme-market/theme-market.svg',
			];

			return [$menu];
		});

		//add theme custom product
		$this->customProduct();
	}

	function app() {
		//if (isEditor()) return;

		//change image path to point to themes folder
		Event::on('Vvveb\System\Images', 'image', __METHOD__ , function ($image, $type, $size) {
			if ($type == 'product') {
				$image = str_replace('/media/', '', $image);
			}

			return [$image, $type, $size];
		});

		//add download link
		Event::on('Vvveb\Component\Products', 'results', __METHOD__ , function ($results) {
			foreach ($results['products'] as &$product) {
				$product['download_link'] = PUBLIC_PATH . 'market/themes/' . $product['slug'] . '.zip';
			}

			return [$results];
		});

		//add download link
		Event::on('Vvveb\Component\Product', 'results', __METHOD__ , function ($results) {
			if ($results) {
				$results['download_link'] = PUBLIC_PATH . 'market/themes/' . $results['slug'] . '.zip';
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

$cdnPlugin = new ThemeMarketPlugin();
