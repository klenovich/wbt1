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

namespace Vvveb\Component;

use function Vvveb\commentStatusBadgeClass;
use function Vvveb\orderStatusBadgeClass;
use Vvveb\Sql\StatSQL;
use Vvveb\System\Cache;
use Vvveb\System\Component\ComponentBase;
use Vvveb\System\Core\View;
use Vvveb\System\Event;
use Vvveb\System\Update;

class Notifications extends ComponentBase {
	public static $defaultOptions = [
	];

	public $options = [];

	private $stats;

	private $count = 0;

	private $notifications = [];

	private $menu = [];

	protected function orders() {
		$orderCount      = $this->stats->getOrdersCount($this->options)['orders'] ?? [];

		$orderStatsusNew = 1; //get from site config
		$newOrders       = ($orderCount[$orderStatsusNew]['count'] ?? 0);

		if ($newOrders > 0) {
			$this->count += $newOrders;
			$this->menu['sales']                = [];
			$this->menu['sales']['badge']       =  $newOrders;
			$this->menu['sales']['badge-class'] =  'badge bg-primary-subtle text-body mx-2';
		}

		//set order name as array keys
		foreach ($orderCount as $type => $orders) {
			if (isset($orders['name'])) {
				$orders['badge']             = orderStatusBadgeClass($orders['order_status_id']);
				$orders['icon']              = 'icon-bag-handle-outline';
				$orderCount[$orders['name']] = $orders;
				unset($orderCount[$type]);
			}
		}

		$this->notifications['orders'] = $orderCount + $this->notifications['orders'];
	}

	protected function users() {
	}

	protected function products() {
		$productCount      = $this->stats->getProductStockCount($this->options)['products'] ?? [];

		foreach ($productCount as $type => &$products) {
			$products['icon']                     = 'icon-cube-outline';
			$products['badge']                    = commentStatusBadgeClass($products['stock_status_id']);
		}

		$this->notifications['products'] = $productCount + $this->notifications['products'];
	}

	protected function comments() {
		$commentCount      = $this->stats->getCommentsCount($this->options)['comments'] ?? [];
		$comment_status    = [
			0  => 'pending',
			1  => 'approved',
			2  => 'spam',
			3  => 'trash',
		];

		$commentStatsusNew = 0; //get from site config
		$newComments       = ($commentCount[$commentStatsusNew]['count'] ?? 0);

		if ($newComments > 0) {
			$this->count += $newComments;
			$this->menu['post']                = [];
			$this->menu['post']['badge']       =  $newComments;
			$this->menu['post']['badge-class'] =  'badge bg-primary-subtle text-body mx-2';

			$this->menu['post']['items']['comments']                = [];
			$this->menu['post']['items']['comments']['badge']       =  $newComments;
			$this->menu['post']['items']['comments']['badge-class'] =  'badge bg-primary-subtle text-body mx-2';
		}

		foreach ($commentCount as $type => $comments) {
			$comments['icon']                     = 'la la-comment';
			$comments['badge']                    = commentStatusBadgeClass($comments['status']);
			$commentCount[$comment_status[$type]] = $comments;
			unset($commentCount[$type]);
		}

		$this->notifications['comments'] = $commentCount + $this->notifications['comments'];
	}

	protected function reviews() {
		$reviewCount       = $this->stats->getReviewsCount($this->options)['reviews'] ?? [];
		$comment_status    = [
			0  => 'pending',
			1  => 'approved',
			2  => 'spam',
			3  => 'trash',
		];

		$reviewStatsusNew = 0; //get from site config
		$newReviews       = ($reviewCount[$reviewStatsusNew]['count'] ?? 0);

		if ($newReviews > 0) {
			$this->count += $newReviews;
			//$this->menu['product'] = [];
			$this->menu['product']['badge']       =  $newReviews;
			$this->menu['product']['badge-class'] =  'badge bg-primary-subtle text-body mx-2';

			//$this->menu['product']['items']['reviews'] = [];
			$this->menu['product']['items']['reviews']['badge']       =  $newReviews;
			$this->menu['product']['items']['reviews']['badge-class'] =  'badge bg-primary-subtle text-body mx-2';
		}

		foreach ($reviewCount as $type => $reviews) {
			$reviews['icon']                     = ' la la-comments';
			$reviews['badge']                    =  commentStatusBadgeClass($reviews['status']);
			$reviewCount[$comment_status[$type]] = $reviews;
			unset($reviewCount[$type]);
		}

		$this->notifications['reviews'] = $reviewCount + $this->notifications['reviews'];
	}

	protected function questions() {
		$questionCount      = $this->stats->getQuestionsCount($this->options)['questions'] ?? [];
		$comment_status     = [
			0  => 'pending',
			1  => 'approved',
			2  => 'spam',
			3  => 'trash',
		];

		$questionStatsusNew = 0; //get from site config
		$newQuestions       = ($questionCount[$questionStatsusNew]['count'] ?? 0);

		if ($newQuestions > 0) {
			$this->count += $newQuestions;
			//$this->menu['product'] = [];
			$this->menu['product']['badge']       =  ($this->menu['product']['badge'] ?? 0) + $newQuestions;
			$this->menu['product']['badge-class'] =  'badge bg-primary-subtle text-body mx-2';

			//$this->menu['product']['items']['questions'] = [];
			$this->menu['product']['items']['questions']['badge']       =  $newQuestions;
			$this->menu['product']['items']['questions']['badge-class'] =  'badge bg-primary-subtle text-body mx-2';
		}

		foreach ($questionCount as $type => $questions) {
			$questions['icon']                     = 'la la-question-circle';
			$questions['badge']                    = commentStatusBadgeClass($questions['status']);
			$questionCount[$comment_status[$type]] = $questions;
			unset($questionCount[$type]);
		}

		$this->notifications['questions'] = $questionCount + $this->notifications['questions'];
	}

	function request(&$results, $index) {
		//add menu notification count

		if ($results['menu'] && $index == 0) {
			$view       = View::getInstance();
			$view->menu = array_merge_recursive($view->menu, $results['menu']);
		}
	}

	function results() {
		// return [];
		$cache = Cache::getInstance();

		$this->notifications = [
			'updates' => [
				'core' => ['hasUpdate' => 1, 'version' => '1.0'],
			],
			'orders' => [
				'processing' => ['count' => 0, 'icon' => 'icon-bag-handle-outline', 'badge' => 'bg-primary-subtle text-body'],
				'complete'   => ['count' => 0, 'icon' => 'icon-bag-handle-outline', 'badge' => 'bg-success-subtle text-body'],
				'processed'  => ['count' => 0, 'icon' => 'icon-bag-handle-outline', 'badge' => 'bg-secondary-subtle text-body'],
			],
			'users' => [
				'month' => ['count' => 0, 'icon' => 'icon-person-outline', 'badge' => 'bg-secondary-subtle text-body'],
				'year'  => ['count' => 0, 'icon' => 'icon-person-outline', 'badge' => 'bg-secondary-subtle text-body'],
			],
			'products' => [
			],
			'comments' => [
				'pending'   => ['count' => 0, 'icon' => 'la la-comment', 'badge' => 'bg-primary-subtle text-body'],
				'approved'  => ['count' => 0, 'icon' => 'la la-comment', 'badge' => 'bg-secondary-subtle text-body'],
				'spam'      => ['count' => 0, 'icon' => 'la la-comment', 'badge' => 'bg-secondary-subtle text-body'],
				'trash'     => ['count' => 0, 'icon' => 'la la-comment', 'badge' => 'bg-secondary-subtle text-body'],
			],
			'reviews' => [
				'pending'   => ['count' => 0, 'icon' => 'la la-comment', 'badge' => 'bg-primary-subtle text-body'],
				'approved'  => ['count' => 0, 'icon' => 'la la-comment', 'badge' => 'bg-secondary-subtle text-body'],
				'spam'      => ['count' => 0, 'icon' => 'la la-comment', 'badge' => 'bg-secondary-subtle text-body'],
				'trash'     => ['count' => 0, 'icon' => 'la la-comment', 'badge' => 'bg-secondary-subtle text-body'],
			],
			'questions' => [
				'pending'   => ['count' => 0, 'icon' => 'la la-question-circle', 'badge' => 'bg-primary-subtle text-body'],
				'approved'  => ['count' => 0, 'icon' => 'la la-question-circle', 'badge' => 'bg-secondary-subtle text-body'],
				'spam'      => ['count' => 0, 'icon' => 'la la-question-circle', 'badge' => 'bg-secondary-subtle text-body'],
				'trash'     => ['count' => 0, 'icon' => 'la la-question-circle', 'badge' => 'bg-secondary-subtle text-body'],
			],
		];

		$this->stats = new StatSQL();
		$this->orders();
		$this->users();
		$this->products();
		$this->comments();
		$this->reviews();
		$this->questions();

		$update  = new Update();
		$updates = $update->checkUpdates('core');

		$this->notifications['updates']['core'] = $updates;
		$this->count += max($updates['hasUpdate'], 0);

		$results = [
			'notifications' => $this->notifications,
			'count'         => $this->count,
			'menu'          => $this->menu,
		];

		list($results) = Event::trigger(__CLASS__, __FUNCTION__, $results);

		return $results;
	}
}
