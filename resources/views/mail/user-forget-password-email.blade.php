{{-- <x-mail::message>
    # Welcome ,{{$name}}

    You Have Requested To Reset Your Password .

    <x-mail::panel>
        Reset Code is : {{$code}}
        </x-mail::button>

        Thanks,<br>
        {{ config('app.name') }}
</x-mail::message> --}}

@component('mail::message')
# Welcome ,{{$name}}

You Have Requested To Reset Your Password .
@component('mail::panel')
Reset Code is : {{$code}}
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
