<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'motherboard_uuid',
        'name',
    ];

    /**
     * Kullanıcının aktiviteleri
     */
    public function activities()
    {
        return $this->hasMany(Activity::class, 'username', 'username')
            ->where('motherboard_uuid', $this->motherboard_uuid);
    }
}
