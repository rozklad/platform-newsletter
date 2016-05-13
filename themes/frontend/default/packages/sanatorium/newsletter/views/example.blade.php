@if ( Cookie::get('has_newsletter') )
    <p class="alert alert-success">
        {{ trans('sanatorium/newsletter::messages.subscribed') }}
    </p>
@else
    <form method="POST" action="{{ route('sanatorium.newsletter.subscribe') }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="email" name="email" class="form-control" placeholder="{{ trans('sanatorium/newsletter::common.email.placeholder') }}">

        <button type="submit" class="btn btn-success">
            {{ trans('sanatorium/newsletter::common.actions.subscribe') }}
        </button>

    </form>
@endif