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
                    <th scope="col">Duration</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>`
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                    @foreach($logs as $counter =>  $log)
                        <tr>
                            <th scope="row">{{++$counter}}</th>
                            <td>{{$log->start_time}}</td>
                            <td>{{$log->end_time}}</td>
                            <td>{{$log->duration_in_minutes}} Minutes</td>
                            <td>
                                <a href="{{ route('logs.edit',$log->id) }}"> <button type="button" class="btn btn-primary" style="background-color: #2563eb">Edit</button></a>
                                <a href="{{ route('logs.destroy',$log->id) }}"  data-method="delete">  <button type="button" class="btn btn-danger" style="background-color: red">Delete</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

{{--    </form>--}}
</section>
