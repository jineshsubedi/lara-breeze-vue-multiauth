<?php

namespace Hris\Training\Http\Controllers\Staff;

use Hris\Training\Requests\TrainerRequest;
use App\Http\Controllers\Controller;
use Hris\Training\Models\Trainer;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TrainerController extends Controller
{
    protected $disk = 'public';
    protected $path = 'training/trainer';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Trainer::query();
        $filter = $this->filterQuery($query);
        $trainers = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Staff/Trainers/Index', [
            'trainers' => $trainers,
            'filters' => request()->only(['name'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Trainers/Create',[
            'types' => config('trainingConstant.types')
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Trainer\TrainerRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TrainerRequest $request)
    {
        $document_path = '';
        if($request->hasFile('docfile'))
        {
            $document_path = $request->file('docfile')->store($this->path, $this->disk);
        }
        Trainer::create($request->validated() + [
            'cv' => $document_path
        ]);
        return redirect()->route('staffs.trainers.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)
    {
        return Inertia::render('Staff/Trainers/Show', [
            'trainer' => $trainer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TrainerRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer)
    {
        return Inertia::render('Staff/Trainers/Edit', [
            'trainer' => $trainer,
            'types' => config('trainingConstant.types')
        ]);
    }

    public function update(TrainerRequest $request, Trainer $trainer)
    {
        $document_path = $trainer->cv;
        if($request->hasFile('docfile'))
        {
            if($trainer->cv != '')
                $this->deleteFile($trainer->getRawOriginal('cv'));
            $document_path = $request->file('docfile')->store($this->path, $this->disk);
        }
        $trainer->update($request->validated() + [
            'cv' => $document_path
        ]); 
        return redirect()->route('staffs.trainers.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer)
    {
        if($trainer->cv != '')
            $this->deleteFile($trainer->getRawOriginal('cv'));
        $trainer->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function deleteFile($document_path)
    {
        if(Storage::exists($document_path))
            Storage::delete($document_path);
    }

    private function filterQuery($query)
    {
        if(request()->filled('name')) {
            $query->where('name', 'LIKE', '%'.request()->name.'%');
        }
        return $query;
    }

}

