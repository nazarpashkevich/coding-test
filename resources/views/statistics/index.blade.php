<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="flex-1 flex flex-col lg:flex-row overflow-hidden p-4 lg:p-12">
        <div class="bg-white w-full lg:w-8/12 overflow-y-auto p-6 rounded-xl shadow-lg">
            <statistic-user-table />
        </div>

        <div class="w-full lg:w-4/12 flex flex-col">
            <statistic-cards />
        </div>
    </div>
</x-app-layout>
