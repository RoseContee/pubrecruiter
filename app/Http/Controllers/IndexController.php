<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function mask($code) {
        $temp = decrypt_affiliate($code);
        $code = $temp['code']; $userId = $temp['userId'];
        $user = User::find($userId);
        if (!$user) abort(404);
        $contact = Contact::brand()->where('code', $code)->first();
        if (!$contact) abort(404);
        $link = str_replace('{USERID}', $user['id'], $contact['exclusive_deal']);
        if (!$link) abort(404);
        return redirect()->away($link);
    }
}
