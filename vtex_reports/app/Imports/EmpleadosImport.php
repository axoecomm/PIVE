<?php

namespace App\Imports;

use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class EmpleadosImport implements ToModel, WithUpserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if (!isset($row[1])) {

            return null;
        } else if ($row[1] == 'nombre') {
            return null;
        }


        return new Empleado([
            'operacion' => $row[0],
            'email' => $row[1],
            'nombre' => $row[2],
            'apellidos' => $row[3],
            'estado' => $row[4],
            
        ]);

        $email = new Empleado();
        // row[0] is the ID
        $email = $email->find($row[4]);
        // if product exists and the value also exists
        if ($email) {
            $email->update([
                'operacion' => $row[0],
                'email' => $row[1],
                'nombre' => $row[2],
                'apellidos' => $row[3],
                'estado' => $row[4],
                
            ]);
            return $email;
        }
    }

    public function uniqueBy()
    {
        return 'email';
    }
}
