<?php

namespace App\Http\Controllers;

use App\Models\Typology;
use Illuminate\Http\Request;

class TypologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typologies = Typology::paginate(25);

        return view('admin.typology.index', compact('typologies'));
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
    public function store(Request $request)
    {
        $typology = new Typology();

        $typology->name = $request->get('name');

        $typology->save();

        return redirect()->route('typologies')->with('success','Typology added succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Typology  $typology
     * @return \Illuminate\Http\Response
     */
    public function show(Typology $typology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Typology  $typology
     * @return \Illuminate\Http\Response
     */
    public function edit(Typology $typology)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Typology  $typology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $typology = Typology::find($id);

        $typology->name = $request->get('name');

        $typology->save();

        return redirect()->route('typologies')->with('success','Typology updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Typology  $typology
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $typology = Typology::find($id);

        $typology->delete();

        return redirect()->route('typologies')->with('success', 'Typology deleted!');
    }
}
