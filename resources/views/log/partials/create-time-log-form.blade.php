<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Create time log') }}
        </h2>
    </header>

    <form method="post" action="{{ route('logs.store') }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label for="start-time" />
            <x-text-input id="start_time" name="start_time" type="datetime-local" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
        </div>

        <div>
            <x-input-label for="end_time" />
            <x-text-input id="end-time" name="end_time" type="datetime-local" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'log-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</section>
