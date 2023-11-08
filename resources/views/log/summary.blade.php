<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Summary Of Logded Time') }}
        </h2>
    </x-slot>
    <form method="get" action="{{ route('log.summary') }}" class="mt-6 space-y-6">
{{--        @csrf--}}
        <div class="py-12">
            <div>
                <x-input-label for="start-time" />
                <x-text-input id="start_time" name="start_time" type="datetime-local"  class="mt-1 block w-full"  />
                <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
            </div>
            <div>
                <x-input-label for="end_time" />
                <x-text-input id="end-time" name="end_time" type="datetime-local" class="mt-1 block w-full"  />
                <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Serach') }}</x-primary-button>
            </div>
         <div>
             <div class="flex items-center gap-4">
                 <a href="{{ route('log.download') }}"> <button type="button" class="btn btn-primary" style="background-color: #2563eb">Download Report</button></a>

             </div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('log.partials.logs-summary-table')
                        </div>
                    </div>
                </div>
            </div>
    </form>
</x-app-layout>
