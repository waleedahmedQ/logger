<?php

namespace App\Http\Services;

use App\Http\Requests\CreateTimeLogRequest;
use App\Http\Requests\EditTimeLogRequest;
use App\Models\TimeLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TimeLogService
{
    public function __construct()
    {
    }

    public function createTimeLog(CreateTimeLogRequest $request): void
    {
        $startTime = Carbon::parse($request->get('start_time'));
        $endTime = Carbon::parse($request->get('end_time'));
        $timeDurationInMinutes = $startTime->diffInMinutes($endTime);
        $timeLog = new TimeLog([
            'start_time' => $startTime->toDateTimeString(),
            'end_time' => $endTime->toDateTimeString(),
            'duration_in_minutes' => $timeDurationInMinutes,
            'user_id' => Auth::id(),
            'project_id' => null
            ]);
        $timeLog->save();
    }

    public function updateTimeLog(EditTimeLogRequest $request, string $id): void
    {
        $log = TimeLog::find($id);
        $log->start_time = Carbon::parse($request->get('start_time'));
        $log->end_Time = Carbon::parse($request->get('end_time'));
        $log->duration_in_minutes = $log->start_time->diffInMinutes($log->end_time);
        $log->save();
    }

    public function getUserLogs(): Collection
    {
        return TimeLog::where('user_id', Auth::id())->get();
    }

    public function parseDateTimeInModel(TimeLog $timeLog): TimeLog
    {

        $startDatetime = Carbon::parse($timeLog->start_time);
        $endDatetime = Carbon::parse($timeLog->end_time);

        $timeLog->start_time  = $startDatetime->format('Y-m-d\TH:i');
        $timeLog->end_time  = $endDatetime->format('Y-m-d\TH:i');

        return  $timeLog;
    }

    public function timeLogSummary(?string $startTime = null, ?string $endTime = null): Collection
    {
        if ($startTime != null && $endTime != null) {
            $startDatetime = Carbon::parse($startTime)->toDateTimeString();
            $endDatetime = Carbon::parse($endTime)->toDateTimeString();

            $records = TimeLog::where('user_id', Auth::id())
                ->whereBetween('start_time', [$startDatetime, $endDatetime])
                ->get();

        } else {
            $records = TimeLog::where('user_id', Auth::id())->get();
        }


        $totalTime = 0 ;
        foreach($records as $record)
        {
            $totalTime +=  $record->duration_in_minutes;
            $record->duration_in_minutes = self::convertMinuteToTime($record->duration_in_minutes);
        }
        $records->totalTime = $this->convertMinuteToTime($totalTime);

        return $records;
    }

    private function convertMinuteToTime(int $minutes): string
    {
        return intdiv($minutes, 60).' Hours:'. ($minutes % 60).'Minutes';
    }


    public function downloadCsv()
    {

        $data = TimeLog::select('start_time', 'end_time', 'duration_in_minutes')->where('user_id',Auth::id(),)->get();
        $csv = "Start Time,End Time,Duration (Minutes)\n";

        foreach ($data as $record) {
            $csv .= "{$record->start_time},{$record->end_time},{$record->duration_in_minutes}\n";
        }

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=timelogs.csv',
        );

        return Response::make($csv, 200, $headers);
    }
}
