<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
  protected $fillable = [
    'user_id',
    'subject_specialty',
    'date_of_birth',
    'gender'
  ];
  
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}

?>