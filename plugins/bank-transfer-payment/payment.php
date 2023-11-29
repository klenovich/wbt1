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

namespace Vvveb\Plugins\BankTransferPayment;

use Vvveb\System\PaymentMethod;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class Payment extends PaymentMethod {
	public function getMethod() {
		$method_data = [
			'name'           => 'bank-transfer',
			'title'          => 'Bank transfer',
			'description'    => 'Bank transfer details',
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
