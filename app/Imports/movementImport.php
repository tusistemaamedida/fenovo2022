<?php

namespace App\Imports;

use App\Models\Movement;
use Maatwebsite\Excel\Concerns\ToModel;

class movementImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] == 888) {
            return new Movement([
                'date' => $row[4],
                'type' => ($row[9] = 'E') ? 'COMPRA' : 'VENTA',
            ]);
        }
    }
}
