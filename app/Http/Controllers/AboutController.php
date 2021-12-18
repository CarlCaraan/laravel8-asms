<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeAbout;
use App\Models\Multipic;
use Illuminate\Support\Carbon;

class AboutController extends Controller
{
    public function HomeAbout()
    {
        $abouts = HomeAbout::latest()->paginate(5);
        return view('admin.about.index', compact('abouts'));
    }

    public function AddAbout()
    {
        return view('admin.about.create');
    }

    public function StoreAbout(Request $request)
    {
        // ~Validate the request...
        $validatedData = $request->validate(
            [
                'title' => 'required|unique:home_abouts|min:4',
                'short_desc' => 'required|unique:home_abouts|min:4',
                'long_desc' => 'required|unique:home_abouts|min:4',
            ],
            // ~Custom Error messages
            [
                'title.required' => 'Please input about title',
                'short_desc.required' => 'Please input short description',
                'long_desc.required' => 'Please input long description',
            ]
        );

        // ~Inserting data to db
        HomeAbout::insert([
            'title' => $request->title,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('home.about')->with('success', 'About Inserted Successfully');
    }

    public function EditAbout($id)
    {
        $abouts = HomeAbout::find($id); // ~Eloquent method
        return view('admin.about.edit', compact('abouts'));
    }

    public function UpdateAbout(Request $request, $id)
    {
        // ~Validate the request...
        $validatedData = $request->validate(
            [
                'title' => 'required|min:4',
                'short_desc' => 'required|min:4',
                'long_desc' => 'required|min:4',
            ],
            // ~Custom Error messages
            [
                'title.required' => 'Please input about title',
                'short_desc.required' => 'Please input short description',
                'long_desc.required' => 'Please input long description',
            ]
        );

        HomeAbout::find($id)->update([
            'title' => $request->title,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('home.about')->with('success', 'About Updated Successfully');
    }

    public function Delete($id)
    {
        HomeAbout::find($id)->delete();
        return redirect()->back()->with('success', 'About Deleted Successfully');
    }

    public function Portfolio()
    {
        $multipics = Multipic::all();
        return view('pages.portfolio', compact('multipics'));
    }
}
