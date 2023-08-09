<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class RealtorListingImageController extends Controller
{
    // Landing page for image uploading
    public function create(Listing $listing)
    {

        return inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }

    // Store image
    public function store(Listing $listing, Request $request)
    {
        // check if POST request has images
        if ($request->hasFile('images')) {
            // loop - through collection of images
            foreach ($request->file('images') as $file) {
                // store the file in the "images" folder on the public disk
                $path = $file->store('images', 'public');

                // save reference in the database
                $listing->images()->create([
                    'filename' => $path
                ]);
            }
        }

        return redirect()->back()->with('success', 'Images uploaded!');
    }
}
