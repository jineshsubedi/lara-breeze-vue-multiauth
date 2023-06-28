<?php

namespace Hris\Attendance\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class MonthlyAttendanceExport implements FromView
{
    use Exportable;

    public function forRequest($datas)
    {
        $this->datas = $datas;

        return $this;
    }
    public function view(): View
    {
        return view('attendance::monthly_attendance', [
            'datas' => $this->datas
        ]);
    }
}
