<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['class_id', 'subject_id', 'teacher_id', 'day_of_week', 'start_time', 'end_time'];

     public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}

?>