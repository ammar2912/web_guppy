<?php

namespace App\Http\Controllers;

use App\Models\Kualitas;

class HistoryController extends Controller
{
    public function index()
    {
        $data = Kualitas::orderBy('id', 'desc')->paginate(20);

        return view('history', compact('data'));
    }
}
