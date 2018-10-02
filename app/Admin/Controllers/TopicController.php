<?php
namespace App\Admin\Controllers;

use App\Topic;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::paginate(10);
        return view('admin.topic.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.topic.add');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);

        Topic::create(['name' => request('name')]);

        return redirect('/admin/topics');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}