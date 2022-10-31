@component('mail::message')

    <h1>Hi, {{$name}}</h1>
    <p>You have got mail!</p>

    @component('mail::button', ['url'=>'www.google.com'])
        Click Here
    @endcomponent
@endcomponent
