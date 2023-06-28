<?php

namespace Hris\Outsource\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class OutsourceStaffExport implements FromView
{
    use Exportable;

    protected $staffs;
    
    public function __construct(array $staffs)
    {
        $this->staffs = $staffs;
    }

    public function view(): View
    {
        // dd($this->staffs);
        return view('outsource::staff_projects', [
            'staffs' => $this->staffs
        ]);
    }
}
