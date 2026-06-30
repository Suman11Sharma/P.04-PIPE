<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show a paginated list of all platform users for admin management.
     */
    public function index()
    {
        $users = User::query()
            ->with('constituency')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }
}
