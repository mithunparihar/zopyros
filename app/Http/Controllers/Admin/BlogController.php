<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\View\ComponentAttributeBag;

class BlogController extends Controller
{

    public function index()
    {
        if(\request()->ajax()){
            $data = Blog::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.blog.lists');
    }

    public function create(){
        return view('admin.blog.create');
    }
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit',compact('blog'));
    }
    function publish(Blog $blog){
        $blog->update(['is_publish'=>request('publish')]);
        return response()->json(['status'=>200]);
    }
    function destory(){
        $data = Blog::findOrFail(request('id'));
        \Image::removeFile('blog/',$data->image);
        \Image::removeFile('blog/banner/',$data->banner);
        $data->delete();
        return response()->json([
            'status'=>200
        ]);
    }

    protected function dataTable($data){
        return \DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('image', function($row){
            $imageComponent = new \App\View\Components\ImagePreview('blog',$row->image);
            $imageComponent->pathName = 'blog';
            $imageComponent->imageName = $row->image;

            $attributes = new ComponentAttributeBag(['class' => 'defaultimg','width'=>'300','style'=>'width:80px!important;height:85px!important']);
            $imageComponent->withAttributes($attributes->getAttributes());

            return $imageComponent->render()->with($imageComponent->data());
        })
        ->addColumn('banner', function($row){
            $imageComponent = new \App\View\Components\ImagePreview('blog_banner',$row->banner);
            $imageComponent->pathName = 'blog_banner';
            $imageComponent->imageName = $row->banner;

            $attributes = new ComponentAttributeBag(['class' => 'defaultimg','width'=>'300','style'=>'height:85px!important']);
            $imageComponent->withAttributes($attributes->getAttributes());

            return $imageComponent->render()->with($imageComponent->data());
        })
        ->addColumn('title',function($row){
            return $html ='<div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                        <h6 class="mb-0">'.$row->name.'</h6>
                        <span class="text-body small"><b>Post Date : </b>'.\CommanFunction::dateformat($row->post_date).'</span>
                        <span class="text-body small"><b>Category</b> : '.($row->categoryInfo->title ?? '').'</span>
                        </div>
                    </div>';
        })
        ->addColumn('is_publish',function($row){
            $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
            $switchButton->checked = $row->is_publish;
            $switchButton->value = $row->id;
            $switchButton->url = route('admin.blog.publish',['blog'=>$row->id]);
            return $switchButton->render()->with($switchButton->data());
        })
        ->addColumn('action', function($row){
            $actionBtn = '<div class="dropdown">';
            $actionBtn .='<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .='<div class="dropdown-menu" style="">';
                    $actionBtn .='<a class="dropdown-item" href="'.route('admin.blog.edit',['blog'=>$row->id]).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                    $actionBtn .='<a class="dropdown-item text-danger" data-delete-id="'.$row->id.'" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .='</div>';
            $actionBtn .='</div>';
            return $actionBtn;
        })
        ->rawColumns(['action','title','banner','is_publish'])
        ->make(true);
    }
}
