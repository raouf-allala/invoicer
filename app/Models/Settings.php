<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
	use HasFactory;
	public $timestamps = false;

	protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'address',
        'logo',
        'rc',
        'nif',
        'ai',
        'nis',
        'capital',
        'bank_account',
        'stamp',
    ];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
