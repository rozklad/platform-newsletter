<?php namespace Sanatorium\Newsletter\Handlers\Newsletterreceiver;

use Sanatorium\Newsletter\Models\Newsletterreceiver;
use Cartalyst\Support\Handlers\EventHandlerInterface as BaseEventHandlerInterface;

interface NewsletterreceiverEventHandlerInterface extends BaseEventHandlerInterface {

	/**
	 * When a newsletterreceiver is being created.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function creating(array $data);

	/**
	 * When a newsletterreceiver is created.
	 *
	 * @param  \Sanatorium\Newsletter\Models\Newsletterreceiver  $newsletterreceiver
	 * @return mixed
	 */
	public function created(Newsletterreceiver $newsletterreceiver);

	/**
	 * When a newsletterreceiver is being updated.
	 *
	 * @param  \Sanatorium\Newsletter\Models\Newsletterreceiver  $newsletterreceiver
	 * @param  array  $data
	 * @return mixed
	 */
	public function updating(Newsletterreceiver $newsletterreceiver, array $data);

	/**
	 * When a newsletterreceiver is updated.
	 *
	 * @param  \Sanatorium\Newsletter\Models\Newsletterreceiver  $newsletterreceiver
	 * @return mixed
	 */
	public function updated(Newsletterreceiver $newsletterreceiver);

	/**
	 * When a newsletterreceiver is deleted.
	 *
	 * @param  \Sanatorium\Newsletter\Models\Newsletterreceiver  $newsletterreceiver
	 * @return mixed
	 */
	public function deleted(Newsletterreceiver $newsletterreceiver);

}
