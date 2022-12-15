<?php

namespace Hris\Survey\Imports;

use Hris\Survey\Models\SurveyQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow; 

class SurveyQuestionBulkImport implements ToModel, WithStartRow, WithHeadingRow
{
    public function  __construct($id)
    {
        $this->survey = $id;
    }
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        return new SurveyQuestion([
            'survey_id' => $this->survey,
            'parent_id' => 0,
            'label' => $row['label'],
            'type' => $row['type'],
            'list' => $row['list'],
            'required' => $row['required'],
            'extra' => $row['extra'],
            'sort' => $row['sort'],
        ]);
    }
}
