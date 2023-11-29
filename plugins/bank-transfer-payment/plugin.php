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
Name: Bank transfer payment method
Slug: bank-transfer-payment
Category: payment
Url: https://www.vvveb.com
Description: Adds cash on delivery payment method on checkout page
Author: givanz
Version: 0.1
Thumb: cash.svg
Author url: https://www.vvveb.com
*/

use Vvveb\Plugins\BankTransferPayment\Payment;
use Vvveb\System\Payment as PaymentApi;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class BankTransferPayment {
	function admin() {
	}

	function app() {
	}

	function __construct() {
		if (Vvveb\isEditor()) {
			return;
		}

		$payment = PaymentApi::getInstance();
		$payment->registerMethod('bank-transfer', Payment::class);

		if (APP == 'admin') {
			$this->admin();
		} else {
			if (APP == 'app') {
				$this->app();
			}
		}
	}
}

$BankTransferPayment = new BankTransferPayment();
