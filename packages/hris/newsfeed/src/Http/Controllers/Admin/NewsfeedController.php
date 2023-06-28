<?php

namespace Hris\Newsfeed\Http\Controllers\Admin;

use Hris\Newsfeed\Requests\NewsfeedRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hris\Newsfeed\Enums\NewsfeedEvent;
use Hris\Newsfeed\Models\Newsfeed;
use Hris\Newsfeed\Models\NewsfeedComment;
use Hris\Newsfeed\Models\NewsfeedLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class NewsfeedController extends Controller
{
    protected $disk = 'public';
    protected $path = 'newsfeed';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Newsfeeds/Index', [
            'event_categories' => config('newsfeedConstant.event_category'),
            'staffs' => User::active()->branchId()->get(['id', 'name'])
        ]);
    }
    public function getAll()
    {
        $query = Newsfeed::query();
        $query->with(['user:id,name,avatar', 'branch:id,name', 'comment' => function($q){
                $q->with(['user:id,name,avatar'])
                    ->orderBy('id', 'desc');
            }])
            ->withCount(['comment', 'like']);
        $filter = $this->filterQuery($query);
        $newsfeeds = $filter->latest('id', 'desc')
                        ->paginate(10)
                        ->withQueryString();
        return $newsfeeds;
    }
    public function hitlike($id)
    {
        $feed = Newsfeed::findOrFail($id);
        $like = NewsfeedLike::where('newsfeed_id', $feed->id)
            ->where('user_id', auth()->id())
            ->first();
        if ($like) {
            $like->delete();
            return ;
        }
        NewsfeedLike::create([
            'newsfeed_id' => $feed->id,
            'user_id' => auth()->id(),
        ]);
        return ;
    }
    public function comment($id, Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:500'
        ]);
        $feed = Newsfeed::findOrFail($id);
        NewsfeedComment::create([
            'newsfeed_id' => $feed->id,
            'user_id' => auth()->id(),
            'description' => nl2br($request->description)
        ]);
        return ;
    }
    public function deleteComment($id)
    {
        $comment = NewsfeedComment::findOrFail($id);
        $comment->delete();
        return ;
    }
    public function event(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:1000',
            'to_staff' => 'required|integer',
            'event_category' => 'required|integer'
        ]);
        $staff = User::select('id', 'name', 'avatar')->find($request->to_staff);
        if($request->event_category == NewsfeedEvent::BIRTHDAY->value){
            $title = 'HAPPY BIRTHDAY';
            $background = asset("images/newsfeed/birthday.jpg");
        }
        elseif($request->event_category == NewsfeedEvent::ACHIEVEMENT->value){
            $title = 'CONGRATULATION!!!';
            $background = asset("images/newsfeed/achievement.jpg");
        }
        elseif($request->event_category == NewsfeedEvent::PROMOTION->value){
            $title = 'CONGRATULATION';
            $background = asset("images/newsfeed/promotion.jpg");
        }
        elseif($request->event_category ==  NewsfeedEvent::MARRIAGE->value){
            $title = 'HAPPY MARRIED LIFE';
            $background = asset("images/newsfeed/wedding.jpg");
        }
        elseif($request->event_category ==  NewsfeedEvent::ANNIVERSARY->value){
            $title = 'WORK ANNIVERSARY';
            $background = asset("images/newsfeed/anniversary.jpg");
        }
        else{
            $title = $request->title ? $request->title : '';
            $background = asset("images/newsfeed/others.jpg");
        }
        $html = '<div style="width:100%; background-image: url('.$background.'); background-repeat: no-repeat; background-size: cover;margin-top:5px;">
        <div class="text-center" style="padding-top: 50px;padding-bottom: 50px;">
            <h3>'.$title.'</h3>
            <div style="display:flex; justify-content: center; align-items: center;">
            <img alt="profile picture" class="img-circle" src="'.$staff->avatar_path.'" style="width: 100px; height: 100px; object-fit:contain; border: 1px solid #9f9fd2;"></div>
            <div>
                <span style="font-size: 30px; font-family: cursive; padding: 5px;">'.$staff->name.'</span>
                <br>
                <span style="font-size: 20px; font-family: cursive; text-align: center; padding: 5px; line-height: 1.9;">'.$request->description.'</span>
            </div>
        </div>
        </div>';
        Newsfeed::create([
            'to_staff'=>$staff->id,
            'event' => $html,
            'event_category' => $request->event_category
        ]);
        return ;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Newsfeed\NewsfeedRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NewsfeedRequest $request)
    {
        $image = '';
        if($request->hasFile('imageFile'))
        {
            $image = $request->file('imageFile')->store($this->path, $this->disk);
        }
        Newsfeed::create([
            'description' => nl2br($request->description),
            'image' => $image,
            'video' => $request->video,
        ]);
        return redirect()->route('admin.newsfeeds.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return \Illuminate\Http\Response
     */
    public function show(Newsfeed $newsfeed)
    {
        $newsfeed->load(['user:id,name,avatar', 'branch:id,name', 'comment' => function($q){
                $q->with(['user:id,name,avatar'])
                    ->orderBy('id', 'desc');
            }])
            ->loadCount(['comment', 'like']);
        return Inertia::render('Admin/Newsfeeds/Show', [
            'newsfeed' => $newsfeed
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsfeed $newsfeed)
    {
        $image = $newsfeed->getRawOriginal('image');
        if($image != null && Storage::exists($image))
            Storage::delete($image);
        $newsfeed->delete();
        return redirect()->route('admin.newsfeeds.index')->with('success', 'Record Deleted');
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
        return $query;
    }

}

