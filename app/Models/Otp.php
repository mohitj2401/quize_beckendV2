<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected  $appends = ['isValidOTPTime'];

    public function getIsValidOTPTimeAttribute()
    {

        $timenow = Carbon::now();
        return $timenow->diffInMinutes($this->created_at)  <= 5;
    }
}
