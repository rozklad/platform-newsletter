<?php namespace Sanatorium\Newsletter\Handlers\Newsletterreceiver;

interface NewsletterreceiverDataHandlerInterface {

	/**
	 * Prepares the given data for being stored.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function prepare(array $data);

}
