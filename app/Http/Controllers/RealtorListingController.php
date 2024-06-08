<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtorListingController extends Controller
{
    
    public function __construct()
    {
        // check if user is authorized to interact with a listing
        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // set - filters
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])

        ];

        return inertia(
            'Realtor/Index', 
            [
                'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    ->filter($filters)
                    ->withCount('images')
                    ->withCount('offers')
                    ->paginate(5)
                    ->withQueryString()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia(
            'Realtor/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Listing::create( // removed this because we want to associate the listing with user

        $request->user()->listings()->create(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000000',
            ])
        );

        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing was created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return inertia(
            'Realtor/Show', 
            [
                'listing' => $listing->load('offers', 'offers.bidder')
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return inertia(
            'Realtor/Edit',
            [
                'listing' => $listing
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000000',
            ])
        );

        // redirect
        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        // delete
        $listing->deleteOrFail();

        // redirect
        return redirect()->back()
            ->with('success', 'Listing was deleted!');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Listing $listing)
    {
        // delete
        $listing->restore();

        // redirect
        return redirect()->back()
            ->with('success', 'Listing was restored!');
    }
}
