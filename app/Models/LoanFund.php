<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanFund extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_amount',
        'amount',
        'is_delete'
    ];

    public function notifys(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NotifyLoan::class,'loan_id','id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Gaza')->format('Y-m-d H:i');
    }


    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Gaza')->format('Y-m-d H:i');
    }

}
