<?php

namespace App\Exports;

use App\Models\Result;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResultsExport implements FromCollection
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Result::where('user_id', $this->user->id)->get()->map(function ($result) {
            return [
                'Utilisateur' => $this->user->name,
                'Score' => $result->score,
                'Date' => $result->created_at->format('d/m/Y'),
            ];
        });
    }
}
