<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{route('withdraw')}}" method="post">
                @csrf

                <label for="amount">Amount: </label>
                <input type="number" name="amount"  required id="amount">
                <br> <br>

                <x-primary-button class="ml-4">
                    {{ __('Withdraw') }}
                </x-primary-button>
            </form>

        </div>
    </div>
</x-app-layout>
