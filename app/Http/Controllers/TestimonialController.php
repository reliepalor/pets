<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial = new Testimonial();
        $testimonial->user_id = Auth::id();
        $testimonial->comment = $request->comment;
        $testimonial->rating = $request->rating;
        $testimonial->save();

        return redirect()->back()->with('success', 'Thank you for your testimonial!');
    }

    /**
     * Display a listing of testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::with('user')->latest()->get();
        return view('testimonials.index', compact('testimonials'));
    }
}
