<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userTest;
use Illuminate\Http\RedirectResponse;

class userTestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $user = userTest::create($request->all());
        return redirect()->route('userTest.index');
    }
}
