<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    // Landing page for image uploading
    public function create(Listing $listing)
    {

        $listing->load(['images']);

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
            // validate images
            $request->validate([
                'images.*' => 'mimes:jpg,png,jpeg,webp'
            ], [
                'images.*.mimes' => 'Invalid file type present in selection, please upload a png, jpg , jpeg, webp',
            ]);

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

    // destroy resource
    public function destroy(Listing $listing, ListingImage $image)
    {
        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return redirect()->back()->with('success', 'Image was deleted!');
    }
}
