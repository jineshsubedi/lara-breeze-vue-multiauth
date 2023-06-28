<?php

namespace Hris\Training\Http\Controllers\Staff;

use Hris\Training\Requests\TrainingRequest;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Hris\Training\Models\Trainer;
use Hris\Training\Models\Training;
use Hris\Training\Models\TrainingAttachment;
use Hris\Training\Models\TrainingCost;
use Hris\Training\Models\TrainingItinery;
use Hris\Training\Models\TrainingNotice;
use Hris\Training\Models\TrainingParticipant;
use Hris\Training\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TrainingController extends Controller
{
    protected $disk = 'public';
    protected $path = 'training';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Training::query();
        $query->with(['branch:id,name', 'trainer:id,name', 'program:id,title']);
        $query->withCount(['participant as active_participant' => function($query){
            $query->where('status', 1);
        }, 'participant as all_participant']);
        $filter = $this->filterQuery($query);
        $trainings = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        // return $trainings;
        return Inertia::render('Staff/Trainings/Index', [
            'trainings' => $trainings,
            'branches' => Branch::branchList(),
            'datas' => $this->getData(),
            'filters' => request()->only(['status', 'branch', 'program', 'trainer', 'from', 'to'])
        ]);
    }
    private function getData()
    {
        $data['trainers'] = Trainer::orderBy('name')->get(['id', 'name']);
        $data['programs'] = TrainingProgram::orderBy('title')->get(['id', 'title']);
        $data['status'] = config('trainingConstant.status');
        $data['level'] = config('trainingConstant.level');
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Trainings/Create',[
            'datas' => $this->getData()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Training\TrainingRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingRequest $request)
    {
        DB::beginTransaction();
        try {
            $training = Training::create($request->validated() + [
                'branch_id' => auth()->user()->branch_id
            ]);
            if(isset($request->category)) {
                $res = [];
                foreach($request->category as $category)
                {
                    $res = [
                        'training_id' => $training->id,
                        'idate' => $category['idate'],
                        'topic' => $category['topic'],
                        'start_time' => $category['start_time'],
                        'end_time' => $category['end_time'],
                        'duration' => $category['duration'],
                    ];
                    TrainingItinery::create($res);
                }
            }
            $document_path = '';
            if($request->hasFile('documentFile'))
            {
                $document_path = $request->file('documentFile')->store($this->path.'/notice', $this->disk);
            }
            TrainingNotice::create([
                'branch_id' => auth()->user()->branch_id,
                'training_program_id' => $training->training_program_id,
                'training_id' => $training->id,
                'notice_date' => $request->notice_date,
                'submit_date' => $request->submit_date,
                'description' => $request->description,
                'document' => $document_path
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return back()->with('danger', $th->getMessage());
        }

        return redirect()->route('staffs.trainings.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        $training->load(['category', 'notice', 'program', 'trainer'])
            ->loadCount(['participant as active_participant' => function($query){
                $query->where('status', 1);
            }, 'participant as all_participant']);

        $participants = TrainingParticipant::with(['user:id,name'])
            ->where('training_id', $training->id)
            // ->where('status', 1)
            ->latest()
            ->get();
        return Inertia::render('Staff/Trainings/Show', [
            'training' => $training,
            'participants' => $participants,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TrainingRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        $training->load(['category','notice']);
        return Inertia::render('Staff/Trainings/Edit', [
            'training' => $training,
            'category' => $training->category,
            'notice' => $training->notice,
            'datas' => $this->getData()
        ]);
    }

    public function update(TrainingRequest $request, Training $training)
    {
        DB::beginTransaction();
        try {
            $training->update($request->validated());
            $training->load(['category', 'notice']);
            if(isset($request->category)) {
                $res = [];
                if(count($request->category))
                    TrainingItinery::where('training_id', $training->id)->delete();

                foreach($request->category as $category)
                {
                    $res = [
                        'training_id' => $training->id,
                        'idate' => $category['idate'],
                        'topic' => $category['topic'],
                        'start_time' => $category['start_time'],
                        'end_time' => $category['end_time'],
                        'duration' => $category['duration'],
                    ];
                    TrainingItinery::create($res);
                }
            }
            $document_path = $training->getRawOriginal('document');
            if($request->hasFile('documentFile'))
            {
                if($document_path != '')
                {
                    if(Storage::exists($document_path))
                        Storage::delete($document_path);
                }
                $document_path = $request->file('documentFile')->store($this->path.'/notice', $this->disk);
            }
            TrainingNotice::updateOrCreate([
                'branch_id' => auth()->user()->branch_id,
                'training_program_id' => $training->training_program_id,
                'training_id' => $training->id,
            ],[
                'branch_id' => auth()->user()->branch_id,
                'training_program_id' => $training->training_program_id,
                'training_id' => $training->id,
                'notice_date' => $request->notice_date,
                'submit_date' => $request->submit_date,
                'description' => $request->description,
                'document' => $document_path
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return back()->with('danger', $th->getMessage());
        }
        return redirect()->route('staffs.trainings.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        $training->load(['notice']);
        $document_path = $training->notice ? $training->notice->getRawOriginal('document') : '';
        if($document_path != '')
        {
            if(Storage::exists($document_path))
                Storage::delete($document_path);
        }
        $training->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }else{
            if(request()->filled('branch')) {
                $query->where('branch_id', request()->branch);
            }
        }
        if(request()->filled('program')) {
            $query->where('training_program_id', request()->program);
        }
        if(request()->filled('trainer')) {
            $query->where('trainer_id', request()->trainer);
        }
        if(request()->filled('status')) {
            $query->where('status', request()->status);
        }
        if(request()->filled('from')) {
            $query->whereDate('from', '>=', request()->from);
        }
        if(request()->filled('to')) {
            $query->whereDate('to', '<=', request()->to);
        }
        return $query;
    }

    public function apply_training($id, Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:500'
        ]);
        $training = Training::findOrFail($id);
        if($training->status != 1)
            return back()->with('danger', 'Training is not Active');
        $training->load(['notice']);
        if($training->notice->notice_date > date('Y-m-d') && $training->submit_date < date('Y-m-d'))
            return back()->with('warning', 'Please Submit your application at '.$training->notice->notice_date.' - '.$training->notice->submit_date);

        if(TrainingParticipant::where('training_id', $training->id)->where('user_id', auth()->id())->first())
        {
            return back()->with('info', 'You have Already Applied For This Training');
        }
        TrainingParticipant::create([
            'training_id' => $training->id,
            'user_id' => auth()->id(),
            'status' => 0,
            'description' => $request->description
        ]);
        return back()->with('success', 'You Applied For This Training');
        
    }
    // participant section 
    public function participants($id)
    {
        $training = Training::select('id', 'total_participant')->findOrFail($id);
        $participants = TrainingParticipant::with(['user:id,name'])
            ->where('training_id', $training->id)
            ->latest()
            ->paginate(50);

        return Inertia::render('Staff/Trainings/Participant', [
            'training' => $training,
            'participants' => $participants
        ]);
    }
    public function actionParticipants($id, Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'status' => 'required|integer',
        ]);
        $training = Training::select('id', 'total_participant')->findOrFail($id);
        $countParticipant = TrainingParticipant::where('training_id', $training->id)->where('status', 1)->count();
        if($countParticipant > $training->total_participant)
            return back()->with('danger', 'Participant for this Training has Reached');
        
        $participant = TrainingParticipant::where('training_id', $training->id)->where('user_id', $request->user_id)->first();
        if(!isset($participant->id))
            return back()->with('warning', 'Not A Participant');

        $participant->update([
            'status' => $request->status
        ]);
        return back()->with('success', 'User Participation Updated');
    }
    // atachment section 
    public function getMaterials($id)
    {
        $training = Training::with(['program:id,title'])->findOrFail($id);
        $materials = TrainingAttachment::where('training_id',$training->id)->paginate(50);
        return Inertia::render('Staff/Trainings/Attachment', [
            'training' => $training,
            'materials' => $materials,
        ]);
    }
    public function saveMaterials($id, Request $request)
    {
        $this->validate($request, [
            'attach.*.title' => 'required|max:100',
            'attach.*.attachmentFile' => 'required|max:2048|mimes:png,jpg,jpeg,webp,pdf,docx,doc,xlsx,xls'
        ]);
        $training = Training::findOrFail($id);
        foreach($request->attach as $fm)
        {
            $file = $fm['attachmentFile'];
            TrainingAttachment::create([
                'training_id' => $training->id,
                'title' => $fm['title'],
                'attachment' => $file->store($this->path.'/material', $this->disk),
                'extension' => $file->getClientOriginalExtension()
            ]);
        }
        return back()->with('success', 'Training Attachments are Added Successfully');
    }
    public function deleteMaterials($id, $material_id)
    {
        $training = Training::select('id', 'status')->findOrFail($id);
        $material = TrainingAttachment::findOrFail($material_id);
        if($material->attachment != '')
        {
            if(Storage::exists($material->getRawOriginal('attachment')))
                Storage::delete($material->getRawOriginal('attachment'));
        }
        $material->delete();
        return back()->with('success', 'Attachment Deleted');
    }

    //  cost section
    public function getCosts($id)
    {
        $training = Training::with(['program:id,title'])->findOrFail($id);
        $costs = TrainingCost::where('training_id',$training->id)->paginate(50);
        return Inertia::render('Staff/Trainings/Cost', [
            'training' => $training,
            'costs' => $costs,
        ]);
    }
    public function saveCosts($id, Request $request)
    {
        $this->validate($request, [
            'attach.*.title' => 'required|max:100',
            'attach.*.quantity' => 'required|numeric',
            'attach.*.total_cost' => 'required|numeric',
        ]);
        $training = Training::findOrFail($id);
        foreach($request->attach as $cost)
        {
            TrainingCost::create([
                'training_id' => $training->id,
                'title' => $cost['title'],
                'quantity' => $cost['quantity'],
                'total_cost' => $cost['total_cost'],
            ]);
        }
        return back()->with('success', 'Training Costs Added');
    }
    public function deleteCosts($id, $cost_id)
    {
        $training = Training::select('id', 'status')->findOrFail($id);
        $material = TrainingCost::findOrFail($cost_id);
        $material->delete();
        return back()->with('success', 'Costs Deleted');
    }
}

