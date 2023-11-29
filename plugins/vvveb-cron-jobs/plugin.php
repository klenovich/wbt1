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
Name: Vvveb core cron jobs
Slug: vvveb-cron-jobs
Category: tools
Url: https://www.vvveb.com
Description: Vvveb core cron jobs used for maintenance, provides crons for stale cache clear, backup etc
Author: givanz
Version: 0.1
Thumb: vvveb-cron-jobs.svg
Author url: https://www.vvveb.com
*/

use Vvveb\System\Cron;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class VvvebCoreCrons {
	function admin() {
	}

	function app() {
	}

	function __construct() {
		Cron::registerCron('cache', __CLASS__, 'Clear stale cache');
		Cron::registerCron('backup', __CLASS__, 'Automatic backup');
		Cron::registerCron('currency', __CLASS__, 'Updates currency rates');
		Cron::registerCron('gdpr', __CLASS__, 'Handles gdpr data removals');
		Cron::registerCron('subscription', __CLASS__, 'Subscription checking');

		if (APP == 'admin') {
			$this->admin();
		} else {
			if (APP == 'app') {
				$this->app();
			}
		}
	}
}

$vvvebCoreCrons = new VvvebCoreCrons();
