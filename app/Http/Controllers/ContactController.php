<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:50',
            'email'   => 'nullable|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactInquiry::create($validated);

        return redirect()->back()->with('success', __('messages.contact_success'));
    }
}
