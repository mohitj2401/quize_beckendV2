<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param Collection $collection
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'dob'              =>  ['required'],

        ];
    }

    public function model(array $row)
    {

        if (auth()->user()->usertype_id == 1) {
            $user_type_id = 2;
        } else {
            $user_type_id = 3;
        }
        // dd(Carbon::parse($row['pass']));
        // dd(!Question::where('title', $row['title'])->where('quiz_id', 22)->count() > 0);
        if (!User::where('email', $row['email'])->count() > 0) {
            return new User([
                'name' => $row['name'],
                'password' => Hash::make(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dob'])->format('d/m/Y')),
                'email' => $row['email'],
                'usertype_id' => $user_type_id,
                'api_token' => time() . Str::random(30),
            ]);
        }
    }
}
