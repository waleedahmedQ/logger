<?php

namespace App\Http\DTO;

use App\Http\Requests\CreateTimeLogRequest;
use App\Models\User;

class TimeLogDto
{

    private string $startTime;

    private string $endTime;

    private User $user;

    private int $durationInMinutes;

    private ?int $projectId = null;


    public function __construct(CreateTimeLogRequest $request)
    {

    }

}
