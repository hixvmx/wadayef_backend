<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function get() {
        return Category::select('id','token','name')->get();
    }

    public function categoryJobs($token) {
        $category = Category::where('token', $token)
                            ->select('id','name')
                            ->with([
                                'jobs' => function ($qry) {
                                    $qry->select('token','title','description','publisher_id','created_at')
                                        ->with([
                                            'publisher' => function ($qry) {
                                                $qry->select('id','token','image');
                                            }
                                        ])
                                        ->orderBy('created_at', 'DESC');
                                }
                            ])
                            ->first();

        return response()->json($category);
    }
}
