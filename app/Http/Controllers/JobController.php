<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Job;
use Str;


class JobController extends Controller
{
    public function getjob($token) {
        $job = Job::where('token',$token)
                    ->select('token', 'title', 'description', 'publisher_id', 'skills', 'type_id', 'salary_id', 'created_at')
                    ->with([
                        'publisher' => function ($q) {
                            $q->select('id', 'token', 'first_name', 'last_name', 'image');
                        },
                        'type' => function ($q) {
                            $q->select('id', 'name');
                        },
                        'salary' => function ($q) {
                            $q->select('id', 'name');
                        }
                    ])
                    ->first();
        return response()->json($job);
    }

    public function new(Request $request) {
        $request->validate([
            'title'       =>  "required",
            'category'    =>  "required",
            'type'        =>  "required",
            'salary'      =>  "required",
            'description' =>  "required",
            'skills'      =>  "required"
        ],[],[
            'title'       =>  "العنوان",
            'category'    =>  "التصنيف",
            'type'        =>  "نوع الوظيفة",
            'salary'      =>  "الراتب",
            'description' =>  "الوصف",
            'skills'      =>  "المهارات"
        ]);

        $newJob = Job::create([
            "token"           =>      Str::random(10),
            "title"           =>      $request->title,
            "category_id"     =>      $request->category,
            "type_id"         =>      $request->type,
            "salary_id"       =>      $request->salary,
            "description"     =>      $request->description,
            "skills"          =>      $request->skills,
            "publisher_id"    =>      $request->user()->id,
            "status"          =>      1,
        ]);

        $Category = Category::find($request->category);
        $Category->jobs()->attach($newJob->id);

        return response()->json([
            'status'  =>   1,
            'result'  =>   'تم نشر الوظيفة بنجاح.'
        ]);
    }
}
