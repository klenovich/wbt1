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
Name: Cash on delivery payment method
Slug: cash-on-delivery-payment
Category: payment
Url: https://www.vvveb.com
Description: Adds cash on delivery payment method on checkout page
Author: givanz
Version: 0.1
Thumb: cash.svg
Author url: https://www.vvveb.com
*/

namespace Vvveb\Plugins\CashOnDeliveryPayment;

use Vvveb\System\PaymentMethod;

class Payment extends PaymentMethod {
	public function getMethod() {
		$method_data = [
			'name'           => 'cash-on-delivery',
			'title'          => 'Cash on delivery',
			'description'    => 'Pay cash on delivery',
			'cost' 		        => 1,
			'terms'          => '',
			'tax'            => 1,
			'vat'            => 1,
			'region_id'      => 1,
		];

		return $method_data;
	}

	public function init() {
	}

	public function setMethod() {
	}
}
