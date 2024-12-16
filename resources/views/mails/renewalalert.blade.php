@component('mail::message')

{!! __('Dear :name, :__:', ['name' => $data['name'], '__' => __('Thanks for using ')]) !!} <strong>{{ $data['plan_name'] }}</strong>.
{{ __('Your subscription will ending soon the last due date is ') }} <strong>{{ $data['will_expire'] }}</strong>.
{{ __('Please renew your subscription') }}

@component('mail::table')
| {{ __('Description') }} | {{ __('Amount') }}  |
| :---------------------- | :------------------ |
@foreach ($data['contents'] ?? [] as $key => $content)
| {{$key}} | {{$content}} |
@endforeach

@endcomponent

@component('mail::button', ['url' => url($data['link']) ])
{{ __('Renew Subscription Now') }}
@endcomponent


{!! __('Thanks,<br> :config', ['config' => config('app.name')]) !!}
@endcomponent
