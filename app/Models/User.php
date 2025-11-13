<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','password','role','company_id','employee_id'];
    protected $hidden = ['password','remember_token'];

    public function company() {
        return $this->belongsTo(Company::class);
    }
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
