<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SubController extends Controller
{
    private $menu = 'SUB';

    public function __construct() {
        View::share('menu', $this->menu);
    }

    public function index() {
        $records = SubRecord::query()
            ->with(['user', 'contact', 'contact.user'])
            ->has('user')
            ->has('contact.user')
            ->get();
        return view('admin.sub.index', [
            'records' => $records
        ]);
    }

    public function destroy($id) {
        $record = SubRecord::query()->find($id);
        if (!$record) {
            return back()->with('error_message', 'Cannot find sub record information.');
        }
        $record->delete();
        return back()->with('info_message', 'SUB record information has been deleted.');
    }
}
