<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ResultExport implements FromView
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }


    public function view(): View
    {
        $res = DB::table('results')
            ->where('block_id', $this->id)
            ->orderBy('correct', 'desc')
            ->get();

        return view('export', [
            'results' => $res,
        ]);
    }
}
