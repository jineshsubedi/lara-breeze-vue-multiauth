<?php

namespace Hris\Attendance\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleMonthlyAttendance implements WithMultipleSheets
{
    use Exportable;

    protected $datas;
    
    public function __construct(array $datas)
    {
        $this->datas = $datas;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        foreach($this->datas['staffs'] as $staff)
        {
            $datas['staff'] = $staff;
            $datas['attendance'] = $this->datas['attendance'][$staff->name];
            // $sheets[] = (new StaffMonthlyAttendance)->forRequest($staff, $this->datas['end_day'], $this->datas['filter_year'], $this->datas['filter_month']);
            $sheets[] = (new MonthlyAttendanceExport)->forRequest($datas);
        }
        return $sheets;
    }
}
