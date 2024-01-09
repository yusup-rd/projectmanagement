<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = true;
    use HasFactory;
    
    protected $fillable = [
        'project_name',
        'business_unit_name',
        'start_date',
        'duration',
        'pic_id',
        'lead_developer_id',
        'status',
        'end_date',
        'development_methodology',
        'system_platform',
        'deployment_type',
        'last_report',
        'description',
    ];

    public function leadDeveloper()
    {
        return $this->belongsTo(User::class, 'lead_developer_id');
    }

    public function developers()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class,'pic_id');
    }
}
