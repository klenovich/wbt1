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

 return [
 	'default' => [
 		'name'     => 'Default site',
 		'host'     => '*.*.*',
 		'theme'    => 'landing',
 		'state'    => 'live',
 		'template' => 'index-landing.html',
 		'id'       => 1,
 	],
 	'themes *' => [
 		'name'  => 'Themes',
 		'host'  => 'themes.*.*',
 		'theme' => 'themes-child',
 		'state' => 'live',
 		'id'    => 2,
 	],
 	'plugins *' => [
 		'name'  => 'Plugins',
 		'host'  => 'plugins.*.*',
 		'theme' => 'plugins-child',
 		'state' => 'live',
 		'id'    => 3,
 	],
 	'blog *' => [
 		'name'     => 'Blog',
 		'host'     => 'blog.*.*',
 		'theme'    => 'landing',
 		'template' => 'index-blog.html',
 		'state'    => 'live',
 		'id'       => 4,
 	],
 	'docs *' => [
 		'name'     => 'Docs',
 		'host'     => 'docs.*.*',
 		'theme'    => 'docs-child',
 		'state'    => 'live',
 		'id'       => 5,
 	],
 	'dev *' => [
 		'name'     => 'Dev',
 		'host'     => 'dev.*.*',
 		'theme'    => 'docs-child',
 		'template' => 'index-dev.html',
 		'state'    => 'live',
 		'id'       => 6,
 	],
 	'shop *' => [
 		'name'  => 'Shop',
 		'host'  => 'shop.*.*',
 		'theme' => 'essence',
 		'state' => 'live',
 		'id'    => 7,
 	],
 ];
