<?php namespace Sanatorium\Newsletter\Repositories\Newsletterreceiver;

use Cartalyst\Support\Traits;
use Illuminate\Container\Container;
use Symfony\Component\Finder\Finder;

class NewsletterreceiverRepository implements NewsletterreceiverRepositoryInterface {

	use Traits\ContainerTrait, Traits\EventTrait, Traits\RepositoryTrait, Traits\ValidatorTrait;

	/**
	 * The Data handler.
	 *
	 * @var \Sanatorium\Newsletter\Handlers\Newsletterreceiver\NewsletterreceiverDataHandlerInterface
	 */
	protected $data;

	/**
	 * The Eloquent newsletter model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * Constructor.
	 *
	 * @param  \Illuminate\Container\Container  $app
	 * @return void
	 */
	public function __construct(Container $app)
	{
		$this->setContainer($app);

		$this->setDispatcher($app['events']);

		$this->data = $app['sanatorium.newsletter.newsletterreceiver.handler.data'];

		$this->setValidator($app['sanatorium.newsletter.newsletterreceiver.validator']);

		$this->setModel(get_class($app['Sanatorium\Newsletter\Models\Newsletterreceiver']));
	}

	/**
	 * {@inheritDoc}
	 */
	public function grid()
	{
		return $this
			->createModel();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{
		return $this->container['cache']->rememberForever('sanatorium.newsletter.newsletterreceiver.all', function()
		{
			return $this->createModel()->get();
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		return $this->container['cache']->rememberForever('sanatorium.newsletter.newsletterreceiver.'.$id, function() use ($id)
		{
			return $this->createModel()->find($id);
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForCreation(array $input)
	{
		return $this->validator->on('create')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $input)
	{
		return $this->validator->on('update')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function store($id, array $input)
	{
		return ! $id ? $this->create($input) : $this->update($id, $input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $input)
	{
		// Create a new newsletterreceiver
		$newsletterreceiver = $this->createModel();

		// Fire the 'sanatorium.newsletter.newsletterreceiver.creating' event
		if ($this->fireEvent('sanatorium.newsletter.newsletterreceiver.creating', [ $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForCreation($data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Save the newsletterreceiver
			$newsletterreceiver->fill($data)->save();

			// Fire the 'sanatorium.newsletter.newsletterreceiver.created' event
			$this->fireEvent('sanatorium.newsletter.newsletterreceiver.created', [ $newsletterreceiver ]);
		}

		return [ $messages, $newsletterreceiver ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $input)
	{
		// Get the newsletterreceiver object
		$newsletterreceiver = $this->find($id);

		// Fire the 'sanatorium.newsletter.newsletterreceiver.updating' event
		if ($this->fireEvent('sanatorium.newsletter.newsletterreceiver.updating', [ $newsletterreceiver, $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForUpdate($newsletterreceiver, $data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Update the newsletterreceiver
			$newsletterreceiver->fill($data)->save();

			// Fire the 'sanatorium.newsletter.newsletterreceiver.updated' event
			$this->fireEvent('sanatorium.newsletter.newsletterreceiver.updated', [ $newsletterreceiver ]);
		}

		return [ $messages, $newsletterreceiver ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		// Check if the newsletterreceiver exists
		if ($newsletterreceiver = $this->find($id))
		{
			// Fire the 'sanatorium.newsletter.newsletterreceiver.deleted' event
			$this->fireEvent('sanatorium.newsletter.newsletterreceiver.deleted', [ $newsletterreceiver ]);

			// Delete the newsletterreceiver entry
			$newsletterreceiver->delete();

			return true;
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function enable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => true ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function disable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => false ]);
	}

}
