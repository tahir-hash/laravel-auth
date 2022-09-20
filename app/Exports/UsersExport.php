<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements  WithMapping,WithHeadings,FromQuery
{

    function __construct($debut,$fin) {
        $this->debut = $debut;
        $this->fin = $fin;
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at
        ];
    }
    public function headings():array{
        return  [
            'id',
            'Name',
            "Email",
            'created_at'
        ];
    }

    public function query()
    {
        return User::query()
        ->whereBetween('created_at',[ $this->debut,$this->fin]);
    }
   
}
