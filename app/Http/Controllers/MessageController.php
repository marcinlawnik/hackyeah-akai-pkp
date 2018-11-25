<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;

class MessageController extends Controller
{
    public function store(Request $request)
    {

        $message = new Message;

        $message->text = $request->input('data');
        $message->save();
        return response('halo', 201)
            ->header('Content-Type', 'text/plain');

    }
}

