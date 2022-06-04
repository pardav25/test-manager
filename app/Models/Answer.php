<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'answers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'text',
        'type_id',
        'question_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}