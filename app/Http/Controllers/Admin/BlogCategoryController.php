<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = BlogCategory::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.blog.category.lists');
    }
    public function create(){
        return view('admin.blog.category.create');
    }
    public function edit(BlogCategory $blog_category)
    {
        return view('admin.blog.category.edit',compact('blog_category'));
    }
    function publish(BlogCategory $blog_category){
        $blog_category->update(['is_publish'=>request('publish')]);
        return response()->json(['status'=>200]);
    }
    function destory(){
        $data = BlogCategory::findOrFail(request('id'));
        $blogs = \App\Models\Blog::whereCategoryId($data->id)->count();
        if($blogs==0){
            $data->delete();
            return response()->json([
                'status'=>200
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'You can`t remove category becuase blogs are mapped in this category.'
            ],422);
        }

    }
    protected function dataTable($data){
        return \DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('category',function($row){
            return $html ='<div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                        <h6 class="mb-0">'.$row->title.'</h6>
                        </div>
                    </div>';
        })
        ->addColumn('is_publish',function($row){
            $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
            $switchButton->checked = $row->is_publish;
            $switchButton->value = $row->id;
            $switchButton->url = route('admin.blog-category.publish',['blog_category'=>$row->id]);
            return $switchButton->render()->with($switchButton->data());
        })
        ->addColumn('action', function($row){
            $actionBtn = '<div class="dropdown">';
            $actionBtn .='<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .='<div class="dropdown-menu" style="">';
                    $actionBtn .='<a class="dropdown-item" href="'.route('admin.blog-category.edit',['blog_category'=>$row->id]).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                    $actionBtn .='<a class="dropdown-item text-danger" data-delete-id="'.$row->id.'" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .='</div>';
            $actionBtn .='</div>';
            return $actionBtn;
        })
        ->rawColumns(['action','category','is_publish'])
        ->make(true);
    }
}
