@extends('layouts/default')

{{-- Page title --}}
@section('title')
@parent
{{{ trans("action.{$mode}") }}} {{ trans('sanatorium/newsletter::newsletterreceivers/common.title') }}
@stop

{{-- Queue assets --}}
{{ Asset::queue('validate', 'platform/js/validate.js', 'jquery') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
@stop

{{-- Inline styles --}}
@section('styles')
@parent
@stop

{{-- Page content --}}
@section('page')

<section class="panel panel-default panel-tabs">

	{{-- Form --}}
	<form id="newsletter-form" action="{{ request()->fullUrl() }}" role="form" method="post" data-parsley-validate>

		{{-- Form: CSRF Token --}}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<header class="panel-heading">

			<nav class="navbar navbar-default navbar-actions">

				<div class="container-fluid">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#actions">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<a class="btn btn-navbar-cancel navbar-btn pull-left tip" href="{{ route('admin.sanatorium.newsletter.newsletterreceivers.all') }}" data-toggle="tooltip" data-original-title="{{{ trans('action.cancel') }}}">
							<i class="fa fa-reply"></i> <span class="visible-xs-inline">{{{ trans('action.cancel') }}}</span>
						</a>

						<span class="navbar-brand">{{{ trans("action.{$mode}") }}} <small>{{{ $newsletterreceiver->exists ? $newsletterreceiver->id : null }}}</small></span>
					</div>

					{{-- Form: Actions --}}
					<div class="collapse navbar-collapse" id="actions">

						<ul class="nav navbar-nav navbar-right">

							@if ($newsletterreceiver->exists)
							<li>
								<a href="{{ route('admin.sanatorium.newsletter.newsletterreceivers.delete', $newsletterreceiver->id) }}" class="tip" data-action-delete data-toggle="tooltip" data-original-title="{{{ trans('action.delete') }}}" type="delete">
									<i class="fa fa-trash-o"></i> <span class="visible-xs-inline">{{{ trans('action.delete') }}}</span>
								</a>
							</li>
							@endif

							<li>
								<button class="btn btn-primary navbar-btn" data-toggle="tooltip" data-original-title="{{{ trans('action.save') }}}">
									<i class="fa fa-save"></i> <span class="visible-xs-inline">{{{ trans('action.save') }}}</span>
								</button>
							</li>

						</ul>

					</div>

				</div>

			</nav>

		</header>

		<div class="panel-body">

			<div role="tabpanel">

				{{-- Form: Tabs --}}
				<ul class="nav nav-tabs" role="tablist">
					<li class="active" role="presentation"><a href="#general-tab" aria-controls="general-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/newsletter::newsletterreceivers/common.tabs.general') }}}</a></li>
					<li role="presentation"><a href="#attributes" aria-controls="attributes" role="tab" data-toggle="tab">{{{ trans('sanatorium/newsletter::newsletterreceivers/common.tabs.attributes') }}}</a></li>
				</ul>

				<div class="tab-content">

					{{-- Tab: General --}}
					<div role="tabpanel" class="tab-pane fade in active" id="general-tab">

						<fieldset>

							<div class="row">

								<div class="form-group{{ Alert::onForm('email', ' has-error') }}">

									<label for="email" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.email_help') }}}"></i>
										{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.email') }}}
									</label>

									<input type="text" class="form-control" name="email" id="email" placeholder="{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.email') }}}" value="{{{ input()->old('email', $newsletterreceiver->email) }}}">

									<span class="help-block">{{{ Alert::onForm('email') }}}</span>

								</div>

								<div class="form-group{{ Alert::onForm('enabled', ' has-error') }}">

									<label for="enabled" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.enabled_help') }}}"></i>
										{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.enabled') }}}
									</label>

									<input type="text" class="form-control" name="enabled" id="enabled" placeholder="{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.enabled') }}}" value="{{{ input()->old('enabled', $newsletterreceiver->enabled) }}}">

									<span class="help-block">{{{ Alert::onForm('enabled') }}}</span>

								</div>

								<div class="form-group{{ Alert::onForm('user_id', ' has-error') }}">

									<label for="user_id" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.user_id_help') }}}"></i>
										{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.user_id') }}}
									</label>

									<input type="text" class="form-control" name="user_id" id="user_id" placeholder="{{{ trans('sanatorium/newsletter::newsletterreceivers/model.general.user_id') }}}" value="{{{ input()->old('user_id', $newsletterreceiver->user_id) }}}">

									<span class="help-block">{{{ Alert::onForm('user_id') }}}</span>

								</div>


							</div>

						</fieldset>

					</div>

					{{-- Tab: Attributes --}}
					<div role="tabpanel" class="tab-pane fade" id="attributes">
						@attributes($newsletterreceiver)
					</div>

				</div>

			</div>

		</div>

	</form>

</section>
@stop
