<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    //
    public function store(Request $request, $id)
    {
        Auth::user()->bookmark($id);
        return back();
    }
    public function destroy(Request $request, $id)
    {
        Auth::user()->unbookmark($id);
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
