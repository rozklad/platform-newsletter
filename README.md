# sanatorium/newsletter

Newsletter extension for Cartalyst Platform

## Documentation

### Example

The method on "sanatorium.newsletter.subscribe" route takes following parameters:

  - email

Therefore basic subscription form might look like this:

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

## TODO

- cron/button action to transfer contacts to mailchimp
- names to emails

## Changelog

1.0.5 Added readme and example

## Support

Support not available.