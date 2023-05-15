@component('mail::message')
# Login Credentials

<strong>Email:</strong> {{ $email }}<br/>
<strong>Password:</strong> {{ $password }}

@component('mail::button', ['url' => $url])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
