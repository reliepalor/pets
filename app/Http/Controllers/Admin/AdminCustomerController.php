<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminCustomerController extends Controller
{
    /**
     * Display a listing of the registered users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all users
        $users = User::all();

        // Return the view with users data
        return view('admin.customer.index', compact('users'));
    }
}
