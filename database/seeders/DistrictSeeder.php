<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $district = [
            [
                'province_id' => 1,
                'title' => 'Bhojpur'
            ],
            [
                'province_id' => 1,
                'title' => 'Dhankuta'
            ],
            [
                'province_id' => 1,
                'title' => 'Illam'
            ],
            [
                'province_id' => 1,
                'title' => 'Jhapa'
            ],
            [
                'province_id' => 1,
                'title' => 'Khotang'
            ],
            [
                'province_id' => 1,
                'title' => 'Morang'
            ],
            [
                'province_id' => 1,
                'title' => 'Okhaldhunga'
            ],
            [
                'province_id' => 1,
                'title' => 'Panchthar'
            ],
            [
                'province_id' => 1,
                'title' => 'Sankhuwasabha'
            ],
            [
                'province_id' => 1,
                'title' => 'Solukhumbu'
            ],
            [
                'province_id' => 1,
                'title' => 'Taplejung'
            ],
            [
                'province_id' => 1,
                'title' => 'Terhathum'
            ],
            [
                'province_id' => 1,
                'title' => 'Udayapur'
            ],
            [
                'province_id' => 2,
                'title' => 'Bara'
            ],
            [
                'province_id' => 2,
                'title' => 'Dhanusa'
            ],
            [
                'province_id' => 2,
                'title' => 'Mahottari'
            ],
            [
                'province_id' => 2,
                'title' => 'Parsa'
            ],
            [
                'province_id' => 2,
                'title' => 'Rautahat'
            ],
            [
                'province_id' => 2,
                'title' => 'Saptari'
            ],
            [
                'province_id' => 2,
                'title' => 'Sarlahi'
            ],
            [
                'province_id' => 2,
                'title' => 'Siraha'
            ],
            [
                'province_id' => 3,
                'title' => 'Bhaktapur'
            ],
            [
                'province_id' => 3,
                'title' => 'Chitwan'
            ],
            [
                'province_id' => 3,
                'title' => 'Dhanding'
            ],
            [
                'province_id' => 3,
                'title' => 'Dolakha'
            ],
            [
                'province_id' => 3,
                'title' => 'Kathmandu'
            ],
            [
                'province_id' => 3,
                'title' => 'Kavrepalanchok'
            ],
            [
                'province_id' => 3,
                'title' => 'Lalitpur'
            ],
            [
                'province_id' => 3,
                'title' => 'Makawanpur'
            ],
            [
                'province_id' => 3,
                'title' => 'Nuwakot'
            ],
            [
                'province_id' => 3,
                'title' => 'Ramechhap'
            ],
            [
                'province_id' => 3,
                'title' => 'Rasuwa'
            ],
            [
                'province_id' => 3,
                'title' => 'Sindhuli'
            ],
            [
                'province_id' => 3,
                'title' => 'Sindhupalchok'
            ],
            [
                'province_id' => 4,
                'title' => 'Baglung'
            ],
            [
                'province_id' => 4,
                'title' => 'Gorkha'
            ],
            [
                'province_id' => 4,
                'title' => 'Kaski'
            ],
            [
                'province_id' => 4,
                'title' => 'Lamjung'
            ],
            [
                'province_id' => 4,
                'title' => 'Manang'
            ],
            [
                'province_id' => 4,
                'title' => 'Mustang'
            ],
            [
                'province_id' => 4,
                'title' => 'Myadi'
            ],
            [
                'province_id' => 4,
                'title' => 'Nawalpur'
            ],
            [
                'province_id' => 4,
                'title' => 'Parbat'
            ],
            [
                'province_id' => 4,
                'title' => 'Syangja'
            ],
            [
                'province_id' => 4,
                'title' => 'Tanahu'
            ],
            [
                'province_id' => 5,
                'title' => 'Arghakhanchi'
            ],
            [
                'province_id' => 5,
                'title' => 'Banke'
            ],
            [
                'province_id' => 5,
                'title' => 'Bardiya'
            ],
            [
                'province_id' => 5,
                'title' => 'Dang'
            ],
            [
                'province_id' => 5,
                'title' => 'Gulmi'
            ],
            [
                'province_id' => 5,
                'title' => 'Kapilvastu'
            ],
            [
                'province_id' => 5,
                'title' => 'Parasi'
            ],
            [
                'province_id' => 5,
                'title' => 'Palpa'
            ],
            [
                'province_id' => 5,
                'title' => 'Pyuthan'
            ],
            [
                'province_id' => 5,
                'title' => 'Rolpa'
            ],
            [
                'province_id' => 5,
                'title' => 'Rukum'
            ],
            [
                'province_id' => 5,
                'title' => 'Rupandehi'
            ],
            [
                'province_id' => 6,
                'title' => 'Dailekh'
            ],
            [
                'province_id' => 6,
                'title' => 'Dolpa'
            ],
            [
                'province_id' => 6,
                'title' => 'Humla'
            ],
            [
                'province_id' => 6,
                'title' => 'Jajarkot'
            ],
            [
                'province_id' => 6,
                'title' => 'Jumla'
            ],
            [
                'province_id' => 6,
                'title' => 'Kalikot'
            ],
            [
                'province_id' => 6,
                'title' => 'Mugu'
            ],
            [
                'province_id' => 6,
                'title' => 'Rukum Paschim'
            ],
            [
                'province_id' => 6,
                'title' => 'Salyan'
            ],
            [
                'province_id' => 6,
                'title' => 'Surkhet'
            ],
            [
                'province_id' => 7,
                'title' => 'Achham'
            ],
            [
                'province_id' => 7,
                'title' => 'Baitadi'
            ],
            [
                'province_id' => 7,
                'title' => 'Bajhang'
            ],
            [
                'province_id' => 7,
                'title' => 'Bajura'
            ],
            [
                'province_id' => 7,
                'title' => 'Dadeldhura'
            ],
            [
                'province_id' => 7,
                'title' => 'Darchula'
            ],
            [
                'province_id' => 7,
                'title' => 'Doti'
            ],
            [
                'province_id' => 7,
                'title' => 'Kailali'
            ],[
                'province_id' => 7,
                'title' => 'Kanchanpur'
            ]
        ];
        District::insert($district);
    }
}
