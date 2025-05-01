<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OfficeSpaceResource;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;

class OfficeSpaceController extends Controller
{
    public function index() // overview semua officeSpace beserta kota
    {
        $officeSpaces = OfficeSpace::with(['city'])->get();
        return OfficeSpaceResource::collection($officeSpaces);
    }

    public function show(OfficeSpace $officeSpace) // spesifik detail officeSpace kotanya apa, foto dan benefitnya apa 
    {
        $officeSpace->load(['city', 'photos', 'benefits']);
        return new OfficeSpaceResource($officeSpace);
    }
}
