<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',

        // ]);

        DB::table('users')->insert([
            [
                'name' => 'Ariel Eliezer Leyva Gutiérrez',
                'avatar' => 'admin_1.jpg',
                'email' => 'arieleliezer@gmail.com',
                'username' => 'ArielEliezer',
                'password' => bcrypt('gWCXR3Y8'),
                'state' => 'Activa'
            ],
            [
                'name' => 'Ayrton López',
                'avatar' => '2.jpg',
                'email' => 'ayrtonlopez@gmail.com',
                'username' => 'AyrtonLopez',
                'password' => bcrypt('gWCXR3Y8'),
                'state' => 'Activa'
            ]
        ]);

        DB::table('addresses')->insert([
            [
                'number' => '1639',
                'street' => 'Wilhelm Route',
                'apartment' => 'Apt. 773',
                'postal_code' => '62542-3316',
                'city' => 'West Hoyt',
                'state' => 'Idaho'
            ],
            [
                'number' => '576',
                'street' => 'Reinhold Canyon',
                'apartment' => 'Apt. 592',
                'postal_code' => '42320-9514',
                'city' => 'North Estefania',
                'state' => 'Idaho'
            ],
            [
                'number' => '329',
                'street' => 'Bailey Heights',
                'apartment' => 'Suite 706',
                'postal_code' => '66714',
                'city' => 'New Mary',
                'state' => 'New Mexico'
            ],
            [
                'number' => '337',
                'street' => 'Hansen Hills',
                'apartment' => 'Apt. 383',
                'postal_code' => '69222',
                'city' => 'Lake Valentine',
                'state' => 'Kansas'
            ],
            [
                'number' => '811',
                'street' => 'Smitham Forks',
                'apartment' => 'Apt. 023',
                'postal_code' => '75508',
                'city' => 'Lake Arch',
                'state' => 'Hawaii'
            ],
            [
                'number' => '337',
                'street' => 'Hansen Hills',
                'apartment' => 'Apt. 383',
                'postal_code' => '69222',
                'city' => 'Lake Valentine',
                'state' => 'Kansas'
            ],
            [
                'number' => '64355',
                'street' => 'Boyle Landing',
                'apartment' => 'Apt. 846',
                'postal_code' => '84432',
                'city' => 'West Annaside',
                'state' => 'Nevada'
            ],
            [
                'number' => '75203',
                'street' => 'Harber Vista',
                'apartment' => 'Suite 221',
                'postal_code' => '82181-7603',
                'city' => 'Port Melyssamouth',
                'state' => 'Massachusetts'
            ],
            [
                'number' => '01427',
                'street' => 'Okey Way',
                'apartment' => 'Suite 221',
                'postal_code' => '82181-7603',
                'city' => 'Port Melyssamouth',
                'state' => 'Massachusetts'
            ],
            [
                'number' => '65896',
                'street' => 'Harber Vista',
                'apartment' => 'Suite 365',
                'postal_code' => '82181-7603',
                'city' => 'Port Melyssamouth',
                'state' => 'Massachusetts'
            ],
            [
                'number' => '2547',
                'street' => 'Boyle Landing',
                'apartment' => 'Apt. 256',
                'postal_code' => '84432',
                'city' => 'West Annaside',
                'state' => 'Nevada'
            ],
            [
                'number' => '298',
                'street' => 'Hansen Hills',
                'apartment' => 'Apt. 325',
                'postal_code' => '69222',
                'city' => 'Lake Valentine',
                'state' => 'Kansas'
            ],
            [
                'number' => '3254',
                'street' => 'Wilhelm Route',
                'apartment' => 'Apt. 635',
                'postal_code' => '62542-3316',
                'city' => 'West Hoyt',
                'state' => 'Idaho'
            ],
            [
                'number' => '85877',
                'street' => 'Reinhold Canyon',
                'apartment' => 'Apt. 458',
                'postal_code' => '42320-9514',
                'city' => 'North Estefania',
                'state' => 'Idaho'
            ],
            [
                'number' => '65894',
                'street' => 'Harber Vista',
                'apartment' => 'Suite 365',
                'postal_code' => '82181-7603',
                'city' => 'Port Melyssamouth',
                'state' => 'Massachusetts'
            ],
        ]);

        DB::table('clients')->insert([
            [
                'name' => 'Ana Maris López Gallardo',
                'avatar' => 'users/1.jpg',
                'address_id' => 1,
                'dni' => '00110381328',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1986-02-05',
            ],
            [
                'name' => 'Prof. Mervin Bergnaum',
                'avatar' => 'users/2.jpg',
                'address_id' => 2,
                'dni' => '32589621478',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1758-05-04',
            ],
            [
                'name' => 'Mr. Hal Gerlach',
                'avatar' => 'users/3.jpg',
                'address_id' => 3,
                'dni' => '36521478965',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1998-11-03',
            ],
            [
                'name' => 'Murray Homenick',
                'avatar' => 'users/4.jpg',
                'address_id' => 4,
                'dni' => '36521478963',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1998-11-03',
            ],
            [
                'name' => 'Roman Renner',
                'avatar' => 'users/5.jpg',
                'address_id' => 5,
                'dni' => '25893781963',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1965-12-23',
            ],
            [
                'name' => 'Mr. Ike Grimes DVM',
                'avatar' => 'users/6.jpeg',
                'address_id' => 6,
                'dni' => '54193852147',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1955-05-30',
            ],
            [
                'name' => 'Greyson Hammes',
                'avatar' => 'users/7.jpeg',
                'address_id' => 7,
                'dni' => '25893781963',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1985-05-10',
            ],
            [
                'name' => 'Mr. Jamie Kshlerin',
                'avatar' => 'users/8.jpeg',
                'address_id' => 8,
                'dni' => '23658965853',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1993-01-01',
            ],
            [
                'name' => 'Dr. Stefanie Gibson',
                'avatar' => 'users/9.jpg',
                'address_id' => 9,
                'dni' => '23658963257',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1975-03-02',
            ],
            [
                'name' => 'Dr. Dillon Kilback',
                'avatar' => 'users/10.jpg',
                'address_id' => 10,
                'dni' => '32589687452',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1976-03-03',
            ],
            [
                'name' => 'Alfonso Zarza Izalde',
                'avatar' => 'users/11.jpg',
                'address_id' => 11,
                'dni' => '3256985874',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1965-09-23',
            ],
            [
                'name' => 'Reinaldo Tamayo Álvarez',
                'avatar' => 'users/12.jpg',
                'address_id' => 12,
                'dni' => '23658758961',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1984-10-22',
            ],
            [
                'name' => 'Fernanda María Hernández López',
                'avatar' => 'users/13.jpg',
                'address_id' => 13,
                'dni' => '3256985874',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1965-09-23',
            ],
            [
                'name' => 'Pedro Armando Matute Rodríguez',
                'avatar' => 'users/14.jpg',
                'address_id' => 14,
                'dni' => '365897741',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1978-09-02',
            ],
            [
                'name' => 'Elena Quevent Godinez',
                'avatar' => 'users/15.jpg',
                'address_id' => 15,
                'dni' => '32569878852',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '1985-09-23',
            ],
        ]);

        DB::table('telephone_numbers')->insert([
            ['number' => '+57 54523985', 'client_id' => 1],
            ['number' => '+57 56478951', 'client_id' => 2],
            ['number' => '+57 56032110', 'client_id' => 3],
            ['number' => '+57 58963690', 'client_id' => 4],
            ['number' => '+57 56963258', 'client_id' => 5],
            ['number' => '+57 59966254', 'client_id' => 6],
            ['number' => '+57 56969258', 'client_id' => 7],
            ['number' => '+57 58963250', 'client_id' => 8],
            ['number' => '+57 56963653', 'client_id' => 9],
            ['number' => '+57 58993658', 'client_id' => 10],
            ['number' => '+57 58963253', 'client_id' => 11],
            ['number' => '+57 56969658', 'client_id' => 12],
            ['number' => '+57 59963954', 'client_id' => 13],
            ['number' => '+57 58966950', 'client_id' => 14],
            ['number' => '+57 56963253', 'client_id' => 15],
            ['number' => '+57 58962541', 'client_id' => 1],
            ['number' => '+57 58745895', 'client_id' => 2],
            ['number' => '+57 58365012', 'client_id' => 4],
            ['number' => '+57 57145896', 'client_id' => 5],
            ['number' => '+57 56369854', 'client_id' => 6],
            ['number' => '+57 56437643', 'client_id' => 7],
            ['number' => '+57 57946836', 'client_id' => 10],
            ['number' => '+57 58964300', 'client_id' => 11],
            ['number' => '+57 58940564', 'client_id' => 15],
        ]);

        DB::table('buttons')->insert([
            ['number' => 'alert001', 'state' => 'Connected', 'client_id' => 1, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert002', 'state' => 'Connected', 'client_id' => 2, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert003', 'state' => 'Disconnected', 'client_id' => 3, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert004', 'state' => 'Connected', 'client_id' => 4, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert005', 'state' => 'Connected', 'client_id' => 5, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert006', 'state' => 'Disconnected', 'client_id' => 6, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert007', 'state' => 'Disconnected', 'client_id' => 7, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert008', 'state' => 'Connected', 'client_id' => 8, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert009', 'state' => 'Connected', 'client_id' => 9, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert010', 'state' => 'Connected', 'client_id' => 10, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert011', 'state' => 'Connected', 'client_id' => 11, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert012', 'state' => 'Connected', 'client_id' => 12, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert013', 'state' => 'Connected', 'client_id' => 13, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert014', 'state' => 'Disconnected', 'client_id' => 14, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert015', 'state' => 'Connected', 'client_id' => 15, 'last_connection' => now()->toDateTimeString()],
            ['number' => 'alert016', 'state' => 'Disconnected', 'client_id' => null, 'last_connection' => now()->toDateTimeString()],
        ]);

        DB::table('alerts')->insert([
            ['client_id' => 2, 'type' => 'Health', 'state' => 'Pendiente', 'created_at' => '2023-03-4 12:40:00'],
            ['client_id' => 4, 'type' => 'Health', 'state' => 'Pendiente', 'created_at' => '2023-03-4 10:17:00'],
            ['client_id' => 5, 'type' => 'Police', 'state' => 'Vista', 'created_at' => '2023-03-3 01:24:00'],
            ['client_id' => 7, 'type' => 'Health', 'state' => 'Pendiente', 'created_at' => '2023-03-2 16:10:00'],
            ['client_id' => 8, 'type' => 'Police', 'state' => 'Vista', 'created_at' => '2023-03-2 14:11:00'],
            ['client_id' => 3, 'type' => 'Police', 'state' => 'Vista', 'created_at' => '2023-03-1 08:32:00'],
            ['client_id' => 1, 'type' => 'Police', 'state' => 'Vista', 'created_at' => '2023-02-28 07:10:00'],
        ]);

        DB::table('notifications')->insert([
            ['client_id' => 2, 'title' => 'Alerta presionada', 'content' => '%client% ha presionado su botón de pánico con una aperta médica.', 'created_at' => '2023-03-4 12:40:00'],
            ['client_id' => 4, 'title' => 'Alerta presionada', 'content' => '%client% ha presionado su botón de pánico con una aperta médica.', 'created_at' => '2023-03-4 10:17:00'],
            ['client_id' => 5, 'title' => 'Alerta presionada', 'content' => '%client% ha presionado su botón de pánico con una aperta médica.', 'created_at' => '2023-03-3 01:24:00'],
            ['client_id' => 7, 'title' => 'Alerta presionada', 'content' => '%client% ha presionado su botón de pánico con una aperta médica.', 'created_at' => '2023-03-2 16:10:00'],
            ['client_id' => 8, 'title' => 'Alerta presionada', 'content' => '%client% ha presionado su botón de pánico con una aperta médica.', 'created_at' => '2023-03-2 14:11:00'],
            ['client_id' => 3, 'title' => 'Alerta presionada', 'content' => '%client% ha presionado su botón de pánico con una aperta médica.', 'created_at' => '2023-03-1 08:32:00'],
            ['client_id' => 1, 'title' => 'Alerta presionada', 'content' => '%client% ha presionado su botón de pánico con una aperta médica.', 'created_at' => '2023-02-28 07:10:00'],
            ['client_id' => 11, 'title' => 'Alerta presionada', 'content' => '%client% ha presionado su botón de pánico con una aperta médica.', 'created_at' => '2023-02-4 4:11:00'],
        ]);
    }
}
