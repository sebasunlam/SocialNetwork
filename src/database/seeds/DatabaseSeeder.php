<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('sexo')->insert([
            'descripcion' => 'Masculino',
            'enum' => 1
        ]);

        DB::table('sexo')->insert([
            'descripcion' => 'Femenino',
            'enum' => 1
        ]);

        DB::table('provincia')->insert([
            'descripcion' => 'Buenos Aires'
        ]);

        DB::table('provincia')->insert([
            'descripcion' => 'La Pampa'
        ]);

        DB::table('departamento')->insert([
            'descripcion' => 'La Matanza',
            'provincia_id' => 1
        ]);

        DB::table('departamento')->insert([
            'descripcion' => 'Moron',
            'provincia_id' => 1
        ]);

        DB::table('departamento')->insert([
            'descripcion' => 'Capital',
            'provincia_id' => 2
        ]);

        DB::table('departamento')->insert([
            'descripcion' => 'La Adela',
            'provincia_id' => 2
        ]);

        DB::table('localidad')->insert([
            'descripcion' => 'Ramos Mejia',
            'departamento_id' => 1
        ]);

        DB::table('localidad')->insert([
            'descripcion' => 'San Justo',
            'departamento_id' => 1
        ]);

        DB::table('localidad')->insert([
            'descripcion' => 'Moron',
            'departamento_id' => 2
        ]);

        DB::table('localidad')->insert([
            'descripcion' => 'Haedo',
            'departamento_id' => 2
        ]);

        DB::table('localidad')->insert([
            'descripcion' => 'Santa Rosa',
            'departamento_id' => 3
        ]);
        DB::table('localidad')->insert([
            'descripcion' => 'La Adela',
            'departamento_id' => 4
        ]);



    }
}
