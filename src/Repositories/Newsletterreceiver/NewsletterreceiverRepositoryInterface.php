<?php namespace Sanatorium\Newsletter\Repositories\Newsletterreceiver;

interface NewsletterreceiverRepositoryInterface {

	/**
	 * Returns a dataset compatible with data grid.
	 *
	 * @return \Sanatorium\Newsletter\Models\Newsletterreceiver
	 */
	public function grid();

	/**
	 * Returns all the newsletter entries.
	 *
	 * @return \Sanatorium\Newsletter\Models\Newsletterreceiver
	 */
	public function findAll();

	/**
	 * Returns a newsletter entry by its primary key.
	 *
	 * @param  int  $id
	 * @return \Sanatorium\Newsletter\Models\Newsletterreceiver
	 */
	public function find($id);

	/**
	 * Determines if the given newsletter is valid for creation.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForCreation(array $data);

	/**
	 * Determines if the given newsletter is valid for update.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForUpdate($id, array $data);

	/**
	 * Creates or updates the given newsletter.
	 *
	 * @param  int  $id
	 * @param  array  $input
	 * @return bool|array
	 */
	public function store($id, array $input);

	/**
	 * Creates a newsletter entry with the given data.
	 *
	 * @param  array  $data
	 * @return \Sanatorium\Newsletter\Models\Newsletterreceiver
	 */
	public function create(array $data);

	/**
	 * Updates the newsletter entry with the given data.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Sanatorium\Newsletter\Models\Newsletterreceiver
	 */
	public function update($id, array $data);

	/**
	 * Deletes the newsletter entry.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id);

}
