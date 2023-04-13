<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        // return response("Hello World");
        return Inertia::render("Chirps/Index", [
            "chirps" => Chirp::with("user:id,name")->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "message" => ["required", "max:255", "string"],
        ]);

        $request->user()->chirps()->create($validated);

        return redirect()->route("chirps.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chirp $chirp) : RedirectResponse
    {
        $this->authorize("update", $chirp);

				$validated = $request->validate([
						"message" => ["required", "max:255", "string"],
				]);

				$chirp->update($validated);

				return redirect()->route("chirps.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chirp $chirp):RedirectResponse
		{
				$this->authorize("delete", $chirp);

				$chirp->delete();

				return redirect()->route("chirps.index");
		}
}
