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
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            'name' => 'Ariel Eliezer Leyva Gutiérrez',
            'avatar' => '1.jpg',
            'email' => 'arieleliezer@gmail.com',
            'password' => bcrypt('gWCXR3Y8'),
            'state' => 'Activa'
        ]);

        DB::table('buttons')->insert([
            ['number' => '123245'],
            ['number' => '345365'],
            ['number' => '678852'],
            ['number' => '912365'],
            ['number' => '365458'],
            ['number' => '235235'],
            ['number' => '654157'],
            ['number' => '032953'],
            ['number' => '951423'],
            ['number' => '852905'],
            ['number' => '258147'],
            ['number' => '753124'],
            ['number' => '159435'],
            ['number' => '754087'],
            ['number' => '359325'],
            ['number' => '851126'],
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
                'button_id' => 1,
                'name' => 'Ana Maris López Gallardo',
                'avatar' => '1.jpg',
                'email' => 'anamaris@gmail.com',
                'address_id' => 1,
                'dni' => '00110381328',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '05-02-1986',
            ],
            [
                'button_id' => 2,
                'name' => 'Prof. Mervin Bergnaum',
                'avatar' => '2.jpg',
                'email' => 'mervinberganum@gmail.com',
                'address_id' => 2,
                'dni' => '32589621478',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '04-05-1758',
            ],
            [
                'button_id' => 3,
                'name' => 'Mr. Hal Gerlach',
                'avatar' => '3.jpg',
                'email' => 'hal.gerlach@htomail.com',
                'address_id' => 3,
                'dni' => '36521478965',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '03-11-1998',
            ],
            [
                'button_id' => 4,
                'name' => 'Murray Homenick',
                'avatar' => '4.jpg',
                'email' => 'homenickmurray@htomail.com',
                'address_id' => 4,
                'dni' => '36521478963',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '03-11-1998',
            ],
            [
                'button_id' => 5,
                'name' => 'Roman Renner',
                'avatar' => '5.jpg',
                'email' => 'romanreckner@gmail.com',
                'address_id' => 5,
                'dni' => '25893781963',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '23-12-1965',
            ],
            [
                'button_id' => 6,
                'name' => 'Mr. Ike Grimes DVM',
                'avatar' => '6.jpeg',
                'email' => 'ikegrimes@harvard.com',
                'address_id' => 6,
                'dni' => '54193852147',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '30-05-1955',
            ],
            [
                'button_id' => 7,
                'name' => 'Greyson Hammes',
                'avatar' => '7.jpeg',
                'email' => 'hammes.greyson@gmail.com',
                'address_id' => 7,
                'dni' => '25893781963',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '10-05-1985',
            ],
            [
                'button_id' => 8,
                'name' => 'Mr. Jamie Kshlerin',
                'avatar' => '8.jpeg',
                'email' => 'jamie@msonmium.com',
                'address_id' => 8,
                'dni' => '23658965853',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '01-01-1993',
            ],
            [
                'button_id' => 9,
                'name' => 'Dr. Stefanie Gibson',
                'avatar' => '9.jpg',
                'email' => 'stefanie.gibson@medicalsupport.com',
                'address_id' => 9,
                'dni' => '23658963257',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '02-03-1975',
            ],
            [
                'button_id' => 10,
                'name' => 'Dr. Dillon Kilback',
                'avatar' => '10.jpg',
                'email' => 'kilback.dillon@medicalsupport.com',
                'address_id' => 10,
                'dni' => '32589687452',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '03-03-1976',
            ],
            [
                'button_id' => 11,
                'name' => 'Alfonso Zarza Izalde',
                'avatar' => '11.jpg',
                'email' => 'alfonsozarza@gmail.com',
                'address_id' => 11,
                'dni' => '3256985874',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '23-09-1965',
            ],
            [
                'button_id' => 12,
                'name' => 'Reinaldo Tamayo Álvarez',
                'avatar' => '12.jpg',
                'email' => 'reinaldotamayo@gmail.com',
                'address_id' => 12,
                'dni' => '23658758961',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '22-10-1984',
            ],
            [
                'button_id' => 13,
                'name' => 'Fernanda María Hernández López',
                'avatar' => '13.jpg',
                'email' => 'fernandamariahernandez@hotmail.com',
                'address_id' => 13,
                'dni' => '3256985874',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '23-09-1965',
            ],
            [
                'button_id' => 14,
                'name' => 'Pedro Armando Matute Rodríguez',
                'avatar' => '14.jpg',
                'email' => 'pedromatute@hotmail.com',
                'address_id' => 14,
                'dni' => '365897741',
                'gender' => 'Masculino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '02-09-1978',
            ],
            [
                'button_id' => 15,
                'name' => 'Elena Quevent Godinez',
                'avatar' => '15.jpg',
                'email' => 'elenagodinez00@gmail.com',
                'address_id' => 15,
                'dni' => '32569878852',
                'gender' => 'Femenino',
                'details' => 'Fugiat nulla consequat duis anim pariatur ipsum veniam ad ut sint fugiat nulla sunt veniam.',
                'birthdate' => '23-29-1985',
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

        DB::table('alerts')->insert([
            ['client_id' => 2, 'type' => 'Health'],
            ['client_id' => 4, 'type' => 'Health'],
            ['client_id' => 5, 'type' => 'Police'],
            ['client_id' => 7, 'type' => 'Health'],
            ['client_id' => 8, 'type' => 'Police'],
            ['client_id' => 3, 'type' => 'Police'],
            ['client_id' => 1, 'type' => 'Police'],
        ]);
    }
}
