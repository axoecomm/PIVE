<?php

namespace App\Imports;

use App\Models\Empleados_archivo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class EmpleadosArchivo implements ToModel, WithUpserts
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
        } else if ($row[2] == 'nombre') {
            return null;
        }


        return new Empleados_archivo([
            'operacion' => $row[0],
            'email' => $row[1],
            'nombre' => $row[2],
            'apellidos' => $row[3],
            
        ]);

        $email = new Empleados_archivo();
        // row[0] is the ID
        $email = $email->find($row[1]);
        // if product exists and the value also exists
        if ($email) {
            $email->update([
                'operacion' => $row[0],
                'email' => $row[1],
                'nombre' => $row[2],
                'apellidos' => $row[3],
                
            ]);
            return $email;
        }
    }

    public function uniqueBy()
    {
        return 'email';
    }
}
