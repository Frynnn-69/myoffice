<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index() // Menampilkan semua kota beserta jumlah officeSpace di setiap kota
    {    
        $cities = City::withCount('officeSpaces')->get();
        return CityResource::collection($cities);
    }

    public function show(City $city) // Menampilkan detail satu kota (berdasarkan model binding), termasuk data officeSpace & fotonya + jumlah officeSpace nya
    {
        $city->load(['officeSpaces.city', 'officeSpaces.photos'/*, 'officeSpaces.benefits'*/]);
        $city->loadCount('officeSpaces');
        return new CityResource($city);
    }
}

// Example: 
// index()
// [
//     {
//       "id": 1,
//       "name": "Jakarta",
//       "office_space_count": 12
//     },
//     {
//       "id": 2,
//       "name": "Bandung",
//       "office_space_count": 5
//     }
//   ]
  

// show()
// {
//     "id": 1,
//     "name": "Jakarta",
//     "office_space_count": 12,
//     "office_spaces": [
//       {
//         "id": 101,
//         "name": "Coworking Space A",
//         "photo_url": "/storage/photoA.jpg"
//       },
//       {
//         "id": 102,
//         "name": "Office Suite B",
//         "photo_url": "/storage/photoB.jpg"
//       }
//     ]
//   }
  
