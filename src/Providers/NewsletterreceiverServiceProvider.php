<?php namespace Sanatorium\Newsletter\Providers;

use Cartalyst\Support\ServiceProvider;

class NewsletterreceiverServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register the attributes namespace
		$this->app['platform.attributes.manager']->registerNamespace(
			$this->app['Sanatorium\Newsletter\Models\Newsletterreceiver']
		);

		// Subscribe the registered event handler
		$this->app['events']->subscribe('sanatorium.newsletter.newsletterreceiver.handler.event');
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		// Register the repository
		$this->bindIf('sanatorium.newsletter.newsletterreceiver', 'Sanatorium\Newsletter\Repositories\Newsletterreceiver\NewsletterreceiverRepository');

		// Register the data handler
		$this->bindIf('sanatorium.newsletter.newsletterreceiver.handler.data', 'Sanatorium\Newsletter\Handlers\Newsletterreceiver\NewsletterreceiverDataHandler');

		// Register the event handler
		$this->bindIf('sanatorium.newsletter.newsletterreceiver.handler.event', 'Sanatorium\Newsletter\Handlers\Newsletterreceiver\NewsletterreceiverEventHandler');

		// Register the validator
		$this->bindIf('sanatorium.newsletter.newsletterreceiver.validator', 'Sanatorium\Newsletter\Validator\Newsletterreceiver\NewsletterreceiverValidator');
	}

}
