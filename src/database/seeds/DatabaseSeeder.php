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

        DB::table('tamanio')->insert([
            'descripcion' => 'Grande',
            'enum' => 1
        ]);

        DB::table('tamanio')->insert([
            'descripcion' => 'Mediano',
            'enum' => 2
        ]);

        DB::table('tamanio')->insert([
            'descripcion' => 'Chico',
            'enum' => 3
        ]);


        DB::table('tipo')->insert([
            'descripcion' => 'Perro',
            'like_text' => 'perro.png'
        ]);

        DB::table('tipo')->insert([
            'descripcion' => 'Gato',
            'like_text' => 'gato.png'
        ]);

        DB::table('tipo')->insert([
            'descripcion' => 'Pez',
            'like_text' => 'pez.png'
        ]);

        DB::table('tipo')->insert([
            'descripcion' => 'Ave',
            'like_text' => 'ave.png'
        ]);

        DB::table('tipo')->insert([
            'descripcion' => 'Granja',
            'like_text' => 'pollo.png'
        ]);

        DB::table('tipo')->insert([
            'descripcion' => 'Otros',
            'like_text' => 'otros.png'
        ]);


        DB::table('raza')->insert([
            'descripcion' => 'Doberman',
            'tipo_id'=> 1
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Ovejero aleman',
            'tipo_id'=> 1
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Buldog',
            'tipo_id'=> 1
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Buldog Frances',
            'tipo_id'=> 1
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Otros',
            'tipo_id'=> 1
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Persa',
            'tipo_id'=> 2
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Angora',
            'tipo_id'=> 2
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Siames',
            'tipo_id'=> 2
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Otros',
            'tipo_id'=> 2
        ]);


        DB::table('raza')->insert([
            'descripcion' => 'Agua fria',
            'tipo_id'=> 3
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Agua calida',
            'tipo_id'=> 3
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Otros',
            'tipo_id'=> 3
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Paloma',
            'tipo_id'=> 4
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Loro',
            'tipo_id'=> 4
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Otros',
            'tipo_id'=> 4
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Pollito',
            'tipo_id'=> 5
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Gallina',
            'tipo_id'=> 5
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Otros',
            'tipo_id'=> 5
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Iguana',
            'tipo_id'=> 6
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Hamster',
            'tipo_id'=> 6
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Cobayo',
            'tipo_id'=> 6
        ]);

        DB::table('raza')->insert([
            'descripcion' => 'Otros',
            'tipo_id'=> 6
        ]);

    }
}
