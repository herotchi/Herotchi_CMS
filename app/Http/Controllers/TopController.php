<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\News;
use App\Models\Media;

class TopController extends Controller
{
    //
    public function top()
    {
        $newsModel = new News();
        $news = $newsModel->getTopNews();

        $mediaModel = new Media();
        $carousels = $mediaModel->getCarousels();
        $pickUps = $mediaModel->getPickUps();

        return view('top', compact(['news', 'carousels', 'pickUps']));
    }
}
