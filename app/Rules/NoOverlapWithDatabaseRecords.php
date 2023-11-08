<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Auth;

class NoOverlapWithDatabaseRecords implements Rule
{
    private $startTime;
    private $endTime;

    private ?int $currentRecordId = null;

    public function __construct(string $startTime, string $endTime, ?int $currentRecord = null)
    {
        $this->startTime = Carbon::parse($startTime);
        $this->endTime = Carbon::parse($endTime);
        $this->currentRecordId = $currentRecord;
    }

    public function passes($attribute, $value): bool
    {
        $query = TimeLog::where('user_id', Auth::id());
        if ($this->currentRecordId !== null) {
            $query->where('id', '!=', $this->currentRecordId);
        }

        $overlappingRecordsExist = $query->where(function ($query) {
            $query->where(function ($q) {
                $q->where('start_time', '<', $this->startTime)
                    ->where('end_time', '>', $this->startTime);
            })->orWhere(function ($q) {
                $q->where('start_time', '<', $this->endTime)
                    ->where('end_time', '>', $this->endTime);
            })->orWhere(function ($q) {
                $q->where('start_time', '>=', $this->startTime)
                    ->where('end_time', '<=', $this->endTime);
            });
        })->exists();

        return !$overlappingRecordsExist;
    }

    public function message()
    {
        return 'The time range overlaps with existing records in the database table.';
    }
}
