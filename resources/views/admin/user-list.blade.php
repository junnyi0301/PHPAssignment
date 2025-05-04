<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users List') }}
        </h2>
    </x-slot>

    <div class="p-4">
        {{-- Inject XSLT-transformed HTML from the controller --}}
        {!! $transformed !!}
    </div>
</x-admin-layout>