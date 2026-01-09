<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class NavigationController extends Controller
{

    public function redirectToBack(Request $request)
    {
        $previousUrl = $request->headers->get('referer');

        if ($previousUrl) {
            return redirect($previousUrl);
        } else {
            // Fallback URL when previous URL is not available
            return redirect('/fallback-url');
        }
    }



}
