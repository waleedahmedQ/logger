<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Edit time log') }}
        </h2>
    </header>
    <form method="post" action="{{ route('logs.update',$log->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="start-time" />
            <x-text-input id="start_time" name="start_time" type="datetime-local" value="{{$log->start_time}}"  class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
        </div>
        <x-text-input id="id" name="id" type="hidden" value="{{$log->id}}" class="mt-1 block w-full" required />
        <div>
            <x-input-label for="end_time" />
            <x-text-input id="end-time" name="end_time" type="datetime-local" value="{{$log->end_time}}" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
        </div>

        <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Update') }}</x-primary-button>
        </div>
    </form>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</section>
