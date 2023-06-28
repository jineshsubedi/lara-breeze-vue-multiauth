<?php

namespace Hris\Hrletter\Models;

use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = array('letter_type_id', 'branch_id', 'department_id', 'description', 'handler', 'signature');

    protected $appends = ['signature_path'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function type()
    {
        return $this->belongsTo(LetterType::class, 'letter_type_id');
    }
    public function handler()
    {
        return $this->belongsTo(User::class, 'handler');
    }
    protected function signaturePath(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->signature != '' && Storage::exists($this->signature)) ? Storage::url($this->signature) : '',
        );
    }
}
