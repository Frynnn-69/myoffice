<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'booking_trx_id',
        'is_paid',
        'started_date',
        'total_amount',
        'duration',
        'ended_date',
        'office_space_id',
    ];

    public function officeSpace(): BelongsTo
    {
        return $this->belongsTo(OfficeSpace::class, 'office_space_id');
    }

    static function generateUniqeTrxId()
    {
        $prefix = 'MO';
        do{
            $randomString = $prefix . mt_rand(100000, 999999);
        } while(self::where('booking_trx_id', $randomString)->exists());
        
        return $randomString;
    }
}
