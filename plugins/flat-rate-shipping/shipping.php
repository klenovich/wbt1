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
Name: Flat rate shipping method
Slug: flat-rate-shipping
Category: payment
Url: https://www.vvveb.com
Description: Adds flat rate shipping method on checkout page
Author: givanz
Version: 0.1
Thumb: shipping.svg
Author url: https://www.vvveb.com
*/

namespace Vvveb\Plugins\FlatRateShipping;

use function Vvveb\__;
use function Vvveb\get_setting;
use Vvveb\System\Core\View;
use Vvveb\System\ShippingMethod;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class Shipping extends ShippingMethod {
	private $method_data = [
		'name'                    => 'flat-rate',
		'title'                   => 'Flat rate',
		'description'             => 'Fixed shipping rate',
		'region_id'               => 0,
		'price'	                  => 7,
		'tax_type_id'             => 1,
		'region_group_id'         => 1,
		'free_shipping'           => 0,
		'free_shipping_message'   => 'Add more products worth at least %s to get free shipping!',
	];

	private function getCost() {
		$method_data = &$this->method_data;
		//$method_data = get_setting('flat-rate-shipping', ['price', 'tax_type_id', 'free_shipping', 'free_shipping_message']) + $method_data;
		$method_data = get_setting('flat-rate-shipping', [], []) + $method_data;

		$method_data['text'] = '';
		$subtotal            = $this->cart->getSubtotal();

		if ($method_data['free_shipping'] && ($subtotal > $method_data['free_shipping'])) {
			$method_data['price'] = 0;
			$method_data['text']  = __('Free shipping');
		}
		{
			$method_data['difference'] = max($method_data['free_shipping'] - $subtotal, 0);
		}
	}

	public function getMethod() {
		$this->getCost();

		$region_id = 0;

		if ($region_id == 0 || $region_id == $this->method_data['region_id']) {
			return $this->method_data;
		}
	}

	public function init() {
		//remove previous total and tax
		$this->cart->removeTotal('flat-rate-shipping');
		$this->cart->removeTax('flat-rate-shipping');
	}

	public function setMethod() {
		$view = View ::getInstance();

		if ($this->method_data['free_shipping_message'] && $this->method_data['difference']) {
			$view->info['flat-shipping-message'] = sprintf($this->method_data['free_shipping_message'], $this->method_data['difference']);
		}

		$this->cart->addTax('flat-rate-shipping', $this->method_data['price'], $this->method_data['tax_type_id']);
		$this->cart->addTotal('flat-rate-shipping','Flat rate shipping', $this->method_data['price'], $this->method_data['text']);
	}
}
