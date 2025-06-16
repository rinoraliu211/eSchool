<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = ['name'];

     public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student', 'class_id', 'student_id');
    }

    

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

   
}


?>