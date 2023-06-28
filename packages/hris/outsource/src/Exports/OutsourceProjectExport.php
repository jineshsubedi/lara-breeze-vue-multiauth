<?php

namespace Hris\Outsource\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class OutsourceProjectExport implements FromView
{
    use Exportable;

    protected $datas;
    
    public function __construct(array $datas)
    {
        $this->datas = $datas;
    }

    public function view(): View
    {
        return view('outsource::projects', [
            'datas' => $this->datas
        ]);
    }
}
