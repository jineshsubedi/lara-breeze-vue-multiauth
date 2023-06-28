<?php

namespace Hris\Offboarding\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Hris\Offboarding\Models\DisciplinaryAction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DisciplinaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disciplinarys = DisciplinaryAction::with(['branch:id,name', 'user:id,name', 'isseudby:id,name', 'grounds:id,title'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return Inertia::render('Supervisor/Offboard/Disciplinary/Index', [
            'disciplinaryactions' => $disciplinarys,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disciplinaryaction = DisciplinaryAction::findOrFail($id);
        $disciplinaryaction->load(['branch:id,name','user:id,name','isseudby:id,name', 'grounds:id,title']);
        $justifyBool = false;
        if($disciplinaryaction->justification_deadline >= Date('Y-m-d') && $disciplinaryaction->justification_required == 1 && $disciplinaryaction->justification_date == null )
            $justifyBool = true;
        return Inertia::render('Supervisor/Offboard/Disciplinary/Show', [
            'disciplinaryaction' => $disciplinaryaction,
            'justifyBool' => $justifyBool
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required|max:1000'
        ]);
        $disciplinaryaction = DisciplinaryAction::findOrFail($id);
        $disciplinaryaction->update([
            'justification_description' => $request->description,
            'justification_date' => Date('Y-m-d')
        ]);
        return back()->with('success', 'Justification Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
