<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('All time logs') }}
        </h2>
    </header>

    {{--    <form method="post" action="{{ route('logs.store') }}" class="mt-6 space-y-6">--}}
    <section>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{--    <form method="post" action="{{ route('logs.store') }}" class="mt-6 space-y-6">--}}
        {{--        @csrf--}}

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Duration In H:M</th>
            </tr>
            </thead>
            <tbody>`
            @foreach($logs as $counter =>  $log)
                <tr>
                    <th scope="row">{{++$counter}}</th>
                    <td>{{$log->start_time}}</td>
                    <td>{{$log->end_time}}</td>
                    <td>{{$log->duration_in_minutes}}</td>
                </tr>

            @endforeach


            </tbody>
        </table>
            <h3>Total Time : {{$logs->totalTime}}</h3>
        {{--    </form>--}}
    </section>
