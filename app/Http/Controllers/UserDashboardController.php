<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard with testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::with('user')->latest()->get();

        return view('user.dashboard', compact('testimonials'));
    }
}
