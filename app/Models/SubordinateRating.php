<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubordinateRating extends Model
{
    use HasFactory;

    protected $fillable = array('user_id', 'supervisor_id', 'supervisory','leadership','quality','communication','consistency','independent','proactiveness','creativity','supervisory_detail','leadership_detail','quality_detail','communication_detail','consistency_detail','independent_detail','proactiveness_detail','creativity_detail');
}
