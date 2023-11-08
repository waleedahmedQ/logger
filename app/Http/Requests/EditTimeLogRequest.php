<?php

namespace App\Http\Requests;

use App\Rules\NoOverlapWithDatabaseRecords;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditTimeLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()){
            return true;
        }
        return false;
    }

    public function rules(): array
    {
        return [
            'start_time' => ['required','date'],
            'end_time' => [
                'required',
                'date',
                'after:start_time',
                'before:tomorrow',
                new NoOverlapWithDatabaseRecords(
                    $this->request->get('start_time'),
                    $this->request->get('end_time'),
                    $this->request->get('id')
                )
            ]
        ];
    }
}
