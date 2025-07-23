<?php

namespace App\Imports;

use App\Models\Code;
use Maatwebsite\Excel\Concerns\ToModel;

class CodeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Code([
            'code' => $row[0],
        ]);
    }
}
