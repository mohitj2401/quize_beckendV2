@component('mail::message')
# Hi,

Thank you for choosing {{ config('app.name') }}. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes

@component('mail::button', ['url' => ''])
{{$otp}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
