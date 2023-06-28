<?php

namespace Hris\Outsource\Imports;

use Hris\Outsource\Models\OutsourceStaffs;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OutSourceStaffImport implements ToModel, WithStartRow, WithHeadingRow
{
    protected $project_id;
    public function  __construct($id)
    {
        $this->project_id = $id;
    }
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return OutsourceStaffs::create([
            'outsource_id' => $this->project_id,
            'staff_code' => $row['staff_code'] ? $row['staff_code'] : '',
            'status' => $row['status'] ? $row['status'] : '',
            'name' => $row['name'] ? $row['name'] : '',
            'email' => $row['email'] ? $row['email'] : '',
            'designation' => $row['designation'] ? $row['designation'] : '',
            'department' => $row['department'] ? $row['department'] : '',
            'temporary_address' => $row['temporary_address'] ? $row['temporary_address'] : '',
            'phone_number' => $row['phone_number'] ? $row['phone_number'] : '',
            'citizenship' => $row['citizenship'] ? $row['citizenship'] : '',
            'sex' => $row['sex'] ? $row['sex'] : '',
            'dob' => $row['dob'] ? $row['dob'] : '',
            'age' => $row['age'] ? $row['age'] : '',
            'education' => $row['education'] ? $row['education'] : '',
            'pan_number' => $row['pan_number'] ? $row['pan_number'] : '',
            'ssf_number' => $row['ssf_number'] ? $row['ssf_number'] : '',
            'cit_number' => $row['cit_number'] ? $row['cit_number'] : '',
            'account_name' => $row['account_name'] ? $row['account_name'] : '',
            'account_number' => $row['account_number'] ? $row['account_number'] : '',
            'join_date' => $row['join_date'] ? $row['join_date'] : '',
            'contract_start' => $row['contract_start'] ? $row['contract_start'] : '',
            'contract_end' => $row['contract_end'] ? $row['contract_end'] : '',
            'emergency_name' => $row['emergency_name'] ? $row['emergency_name'] : '',
            'emergency_relation' => $row['emergency_relation'] ? $row['emergency_relation'] : '',
            'emergency_number' => $row['emergency_number'] ? $row['emergency_number'] : '',
            'emergency_other_number' => $row['emergency_other_number'] ? $row['emergency_other_number'] : '',
        ]);
    }
}
