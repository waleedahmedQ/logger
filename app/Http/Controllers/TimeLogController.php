<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTimeLogRequest;
use App\Http\Requests\EditTimeLogRequest;
use App\Http\Services\TimeLogService;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\View\View;


class TimeLogController extends Controller
{

    public function __construct(private TimeLogService $timeLogService )
    {
    }


    public function index()
    {
        return view('log.index')->with(['logs' =>  $this->timeLogService->getUserLogs()]);
    }


    public function create()
    {
        return view('log.create');
    }


    public function store(CreateTimeLogRequest $request)
    {
        $this->timeLogService->createTimeLog($request);

        return Redirect::route('logs.create')->with('success', 'log created Successfully');

    }


    public function show(string $id)
    {
        //
    }


    public function edit(TimeLog $log): View
    {
        return view('log.edit')->with(['log' => $this->timeLogService->parseDateTimeInModel($log)]);
    }


    public function update(EditTimeLogRequest $request, string $id)
    {
        $this->timeLogService->updateTimeLog($request, $id);

        return Redirect::route('logs.index')->with('message', 'log updated Successfully');
    }

    public function destroy(TimeLog $log)
    {
        $log->delete();
        return Redirect::route('logs.index')->with('message', 'log deleted Successfully');
    }


    public function summary(Request $request): View
    {
        return view('log.summary')->with(['logs' =>  $this->timeLogService->timeLogSummary( $request->get('start_time'), $request->get('end_time'))]);
    }

    public function downloadExcel()
    {
        return $this->timeLogService->downloadCsv();
    }
}
