<?php namespace Sanatorium\Newsletter\Handlers\Newsletterreceiver;

use Illuminate\Events\Dispatcher;
use Sanatorium\Newsletter\Models\Newsletterreceiver;
use Cartalyst\Support\Handlers\EventHandler as BaseEventHandler;

class NewsletterreceiverEventHandler extends BaseEventHandler implements NewsletterreceiverEventHandlerInterface {

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$dispatcher->listen('sanatorium.newsletter.newsletterreceiver.creating', __CLASS__.'@creating');
		$dispatcher->listen('sanatorium.newsletter.newsletterreceiver.created', __CLASS__.'@created');

		$dispatcher->listen('sanatorium.newsletter.newsletterreceiver.updating', __CLASS__.'@updating');
		$dispatcher->listen('sanatorium.newsletter.newsletterreceiver.updated', __CLASS__.'@updated');

		$dispatcher->listen('sanatorium.newsletter.newsletterreceiver.deleted', __CLASS__.'@deleted');
	}

	/**
	 * {@inheritDoc}
	 */
	public function creating(array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function created(Newsletterreceiver $newsletterreceiver)
	{
		$this->flushCache($newsletterreceiver);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updating(Newsletterreceiver $newsletterreceiver, array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function updated(Newsletterreceiver $newsletterreceiver)
	{
		$this->flushCache($newsletterreceiver);
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleted(Newsletterreceiver $newsletterreceiver)
	{
		$this->flushCache($newsletterreceiver);
	}

	/**
	 * Flush the cache.
	 *
	 * @param  \Sanatorium\Newsletter\Models\Newsletterreceiver  $newsletterreceiver
	 * @return void
	 */
	protected function flushCache(Newsletterreceiver $newsletterreceiver)
	{
		$this->app['cache']->forget('sanatorium.newsletter.newsletterreceiver.all');

		$this->app['cache']->forget('sanatorium.newsletter.newsletterreceiver.'.$newsletterreceiver->id);
	}

}
