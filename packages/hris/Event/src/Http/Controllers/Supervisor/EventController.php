<?php

namespace Hris\Event\Http\Controllers\Supervisor;

use Hris\Event\Requests\EventRequest;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Hris\Event\Models\Event;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventController extends Controller
{
    protected $disk = 'public';
    protected $path = 'events';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Event::query();
        $filter = $this->filterQuery($query);
        $events = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        return Inertia::render('Supervisor/Events/Index', [
            'events' => $events,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Events/Create', [
            'defBranch' => auth()->user()->branch_id,
            'branches' => Branch::branchList(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Event\EventRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = Event::create($request->validated());
        $this->updateAttachments($event);
        return redirect()->route('supervisor.events.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return Inertia::render('Supervisor/Events/Show', [
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EventRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return Inertia::render('Supervisor/Events/Edit', [
            'event' => $event,
            'branches' => Branch::branchList(),
        ]);
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->validated());
        $this->updateAttachments($event);
        return redirect()->route('supervisor.events.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if($event->document != '')
        {
            if(Storage::exists($event->document))
                Storage::delete($event->document);
        }
        if($event->banner != '')
        {
            if(Storage::exists($event->banner))
                Storage::delete($event->banner);
        }
        $event->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        if(request()->filled('title')) {
            $query->where('title', 'LIKE', '%'.request()->title.'%');
        }
        if(request()->filled('start_date')) {
            $query->where('start_date', '>=', request()->start_date);
        }
        if(request()->filled('end_date')) {
            $query->where('end_date', '<=', request()->end_date);
        }
        return $query->whereJsonContains('branch', auth()->user()->branch_id);
    }

    public function updateAttachments($event)
    {
        $document = $event->document;
        $banner = $event->banner;
        if(request()->hasFile('docFile'))
        {
            if($document != '')
            {
                if(Storage::exists($document))
                Storage::delete($document);
            }
            $document = request()->file('docFile')->store($this->path, $this->disk);
        }
        if(request()->hasFile('bannerFile'))
        {
            if($banner != '')
            {
                if(Storage::exists($banner))
                    Storage::delete($banner);
            }
            $banner = request()->file('bannerFile')->store($this->path, $this->disk);
        }
        $event->update([
            'document' => $document,
            'banner' => $banner,
        ]);
    }
}

