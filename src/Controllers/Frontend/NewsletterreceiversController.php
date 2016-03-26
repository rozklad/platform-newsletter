<?php namespace Sanatorium\Newsletter\Controllers\Frontend;

use Platform\Foundation\Controllers\Controller;
use Sentinel;
use Cookie;
use Event;

class NewsletterreceiversController extends Controller {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/newsletter::index');
	}

	public function subscribe()
	{
		$receivers = app('Sanatorium\Newsletter\Repositories\Newsletterreceiver\NewsletterreceiverRepositoryInterface');

		$user_id = 0;

		if ( Sentinel::check() ) {
			$user = Sentinel::getUser();
			$user_id = $user->id;
		}

		if ( !request()->has('email') ) 
			return redirect()->back()->withErrors(['noemail', 'Please specify E-mail to receive newsletter']);

		Cookie::queue('has_newsletter', 1, 60*24*365);

		$data = [
			'receiver' => request()->get('email')
		];

		if ( config('sanatorium-newsletter.voucher_for_signup') )
			$this->giveDiscountVoucher($user_id);
		else
			Event::fire('sanatorium.newsletter.new', ['object' => $data]);

		return redirect()->back();
	}

	public function giveDiscountVoucher($user_id)
	{
		$receivers->create([
			'email' => request()->get('email'),
			'user_id' => $user_id
			]);

		$vouchers = app('sanatorium.shopdiscounts.voucher');

		$code = $this->generateRandomUniqueString(10);

		list($messages, $voucher) = $vouchers->create([
			'code' => $code,
			'limit' => 1,
			'percentage' => 5
			]);

		$data = [
			'code' => $code,
			'receiver' => request()->get('email')
		];

		Event::fire('sanatorium.newsletter.new', ['object' => $data]);
	}

	public function generateRandomUniqueString($length = 10)
	{
		$code = $this->generateRandomString($length);

		$vouchers = app('sanatorium.shopdiscounts.voucher');

		// If voucher with the same code is found
		// call the function again
		if ( $vouchers->where('code', $code)->count() > 0 )
			return $this->generateRandomUniqueString($length);

		return $code;
	}

	public function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

}
