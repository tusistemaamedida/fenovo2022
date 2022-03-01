<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class MovementsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't2.movement_id', '=', 't1.id')
            ->select('t2.id')
            ->orderBy('t1.created_at', 'ASC')
            ->whereBetween(DB::raw('DATE(t1.date)'), [$this->request['desde'], $this->request['hasta']])
            ->get();
    }
}
