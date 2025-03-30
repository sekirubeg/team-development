<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function sampleShow(SampleFormRequest $request)
{

    $validated = $request->validated();
    return redirect('index');

}
}

