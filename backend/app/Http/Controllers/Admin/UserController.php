<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users (non-admin customers).
     */
    public function index(): View
    {
        $users = User::where('is_admin', false)
            ->withCount('orders')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $user->load(['orders' => function ($q) {
            $q->latest()->limit(10);
        }]);

        return view('admin.users.show', compact('user'));
    }
}
