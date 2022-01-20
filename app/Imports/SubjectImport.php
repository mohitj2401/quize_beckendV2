<?php

namespace App\Imports;

use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'code'            => ['required', 'string', 'max:255', 'unique:subjects'],

        ];
    }

    public function model(array $row)
    {

        // dd($row);
        // dd(!Question::where('title', $row['title'])->where('quiz_id', 22)->count() > 0);
        if (!Subject::where('name', $row['name'])->whereOr('code', $row['code'])->count() > 0) {
            return new Subject([
                'name' => $row['name'],
                'code' => $row['code'],
                'user_id' => auth()->user()->id
            ]);
        }
    }
}
