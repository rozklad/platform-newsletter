<?php namespace Sanatorium\Newsletter\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Sanatorium\Newsletter\Repositories\Newsletterreceiver\NewsletterreceiverRepositoryInterface;

class NewsletterreceiversController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

	/**
	 * The Newsletter repository.
	 *
	 * @var \Sanatorium\Newsletter\Repositories\Newsletterreceiver\NewsletterreceiverRepositoryInterface
	 */
	protected $newsletterreceivers;

	/**
	 * Holds all the mass actions we can execute.
	 *
	 * @var array
	 */
	protected $actions = [
		'delete',
		'enable',
		'disable',
	];

	/**
	 * Constructor.
	 *
	 * @param  \Sanatorium\Newsletter\Repositories\Newsletterreceiver\NewsletterreceiverRepositoryInterface  $newsletterreceivers
	 * @return void
	 */
	public function __construct(NewsletterreceiverRepositoryInterface $newsletterreceivers)
	{
		parent::__construct();

		$this->newsletterreceivers = $newsletterreceivers;
	}

	/**
	 * Display a listing of newsletterreceiver.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/newsletter::newsletterreceivers.index');
	}

	/**
	 * Datasource for the newsletterreceiver Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->newsletterreceivers->grid();

		$columns = [
			'id',
			'email',
			'enabled',
			'user_id',
			'created_at',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		$transformer = function($element)
		{
			$element->edit_uri = route('admin.sanatorium.newsletter.newsletterreceivers.edit', $element->id);

			return $element;
		};

		return datagrid($data, $columns, $settings, $transformer);
	}

	/**
	 * Show the form for creating new newsletterreceiver.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new newsletterreceiver.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating newsletterreceiver.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating newsletterreceiver.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified newsletterreceiver.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		$type = $this->newsletterreceivers->delete($id) ? 'success' : 'error';

		$this->alerts->{$type}(
			trans("sanatorium/newsletter::newsletterreceivers/message.{$type}.delete")
		);

		return redirect()->route('admin.sanatorium.newsletter.newsletterreceivers.all');
	}

	/**
	 * Executes the mass action.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function executeAction()
	{
		$action = request()->input('action');

		if (in_array($action, $this->actions))
		{
			foreach (request()->input('rows', []) as $row)
			{
				$this->newsletterreceivers->{$action}($row);
			}

			return response('Success');
		}

		return response('Failed', 500);
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{
		// Do we have a newsletterreceiver identifier?
		if (isset($id))
		{
			if ( ! $newsletterreceiver = $this->newsletterreceivers->find($id))
			{
				$this->alerts->error(trans('sanatorium/newsletter::newsletterreceivers/message.not_found', compact('id')));

				return redirect()->route('admin.sanatorium.newsletter.newsletterreceivers.all');
			}
		}
		else
		{
			$newsletterreceiver = $this->newsletterreceivers->createModel();
		}

		// Show the page
		return view('sanatorium/newsletter::newsletterreceivers.form', compact('mode', 'newsletterreceiver'));
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{
		// Store the newsletterreceiver
		list($messages) = $this->newsletterreceivers->store($id, request()->all());

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			$this->alerts->success(trans("sanatorium/newsletter::newsletterreceivers/message.success.{$mode}"));

			return redirect()->route('admin.sanatorium.newsletter.newsletterreceivers.all');
		}

		$this->alerts->error($messages, 'form');

		return redirect()->back()->withInput();
	}

}
