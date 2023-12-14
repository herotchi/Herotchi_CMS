<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Media;

class TopController extends Controller
{
    //
    public function top()
    {
        $mediaModel = new Media();
        $carousels = $mediaModel->getCarousels();
        $pickUps = $mediaModel->getPickUps();

        return view('top', compact(['carousels', 'pickUps']));
    }
}
