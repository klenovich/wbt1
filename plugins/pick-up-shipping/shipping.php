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
Name: Pick up shipping method
Slug: pick-up-shipping
Category: payment
Url: https://www.vvveb.com
Description: Adds cash on delivery payment method on checkout page
Author: givanz
Version: 0.1
Thumb: shipping.svg
Author url: https://www.vvveb.com
*/

namespace Vvveb\Plugins\PickUpShipping;

use Vvveb\System\ShippingMethod;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class Shipping extends ShippingMethod {
	private $method_data = [
		'name'           => 'pick-up',
		'title'          => 'Pick up',
		'description'    => 'Pick up from store',
		'cost' 	         => 1,
		'terms'          => '',
		'tax'            => 1,
		'vat'            => 1,
		'region_id'      => 1,
		'price'	         => 10,
		'tax_type_id'    => 1,
	];

	private function getCost() {
	}

	public function getMethod() {
		$cost = 10;
		$text = '';

		if ($this->cart->getSubtotal() > 1000) {
			$this->method_data['price'] = 0;
			$text                       = 'Free shipping';
		}

		return $this->method_data;
	}

	public function init() {
		//remove previous total
		$this->cart->removeTotal('pick-up-shipping');
		$this->cart->removeTax('pick-up-shipping');
	}

	public function setMethod() {
		$text = '';

		if ($this->cart->getSubtotal() > 1000) {
			$this->method_data['price'] = 0;
			$text                       = 'Free shipping';
		}

		$this->cart->addTotal('pick-up-shipping','Pick up shipping', $this->method_data['price'], $text);
		$this->cart->addTax('pick-up-shipping', $this->method_data['price'], $this->method_data['tax_type_id']);
	}
}
