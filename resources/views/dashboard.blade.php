<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           
            <div class="flex space-x-4">
                <a href="{{ route('create.deposit') }}" class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded">
                    {{ __("Deposit") }}
                </a>
            
                <a href="{{ route('create.withdraw') }}" class="bg-green-500 hover:bg-green-600 text-black font-bold py-2 px-4 rounded">
                    {{ __("Withdraw") }}
                </a>

                <a href="{{ route('allTransactions') }}" class="bg-green-500 hover:bg-green-600 text-black font-bold py-2 px-4 rounded">
                    {{ __("All Transactions") }}
                </a>

                <a href="{{ route('currentBalance') }}" class="bg-green-500 hover:bg-green-600 text-black font-bold py-2 px-4 rounded">
                    {{ __("Balance") }}
                </a>

                <a href="{{ route('depositedTransaction') }}" class="bg-green-500 hover:bg-green-600 text-black font-bold py-2 px-4 rounded">
                    {{ __("Deposited-Transactions") }}
                </a>

                <a href="{{ route('withdrawalTransaction') }}" class="bg-green-500 hover:bg-green-600 text-black font-bold py-2 px-4 rounded">
                    {{ __("Withdrawal-Transactions") }}
                </a>
            </div>
            
            
            
            

        </div>
        
    </div>
</x-app-layout>
