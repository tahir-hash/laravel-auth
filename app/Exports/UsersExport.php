<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function headings():array{
        return  [
            'Name',
            "Email"
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect(User::getUsers());
        //return User::all();

        //return User::where('role', '=', 'client');
    }
}
