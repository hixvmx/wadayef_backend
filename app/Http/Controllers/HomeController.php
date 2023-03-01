<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job;


class HomeController extends Controller
{


    public function get() {
        $categories = Category::select('id','token','name')
                                ->with(['jobs' => function($query1) {
                                    $query1->select('token','title','description','publisher_id','created_at')
                                            ->with(['publisher' => function ($query2) {
                                                $query2->select('id','token','image');
                                            }])
                                            ->orderBy('created_at', 'DESC')
                                            ->Limit(9);
                                }])
                                ->has('jobs')
                                ->get();

        return response()->json($categories);
    }

}
