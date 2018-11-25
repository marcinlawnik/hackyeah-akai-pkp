<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class MessageController extends Controller
{
    public function store(Request $request)
    {

        $message = new Message;

        $message->message = $request->request->get('data');
        $message->save();
        return response('', 201)
            ->header('Content-Type', 'text/plain');

    }
}

