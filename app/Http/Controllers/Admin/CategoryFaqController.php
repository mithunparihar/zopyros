<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryFaq as Faq;

class CategoryFaqController extends Controller
{
    public function index(Category $categories)
    {
        if(\request()->ajax()){
            $data = Faq::category($categories->id)->latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.categories.faq.lists',compact('categories'));
    }
    public function create(Category $categories){
        return view('admin.categories.faq.create',compact('categories'));
    }
    public function edit(Category $categories,Faq $faq)
    {
        return view('admin.categories.faq.edit',compact('faq','categories'));
    }
    function publish(Category $categories,Faq $faq){
        $faq->update(['is_publish'=>request('publish')]);
        return response()->json(['status'=>200]);
    }
    function destory(Category $categories){
        $data = Faq::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status'=>200
        ]);
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
            $switchButton->url = route('admin.categories.faq.publish',['categories'=>$row->category_id,'faq'=>$row->id]);
            return $switchButton->render()->with($switchButton->data());
        })
        ->addColumn('action', function($row){
            $actionBtn = '<div class="dropdown">';
            $actionBtn .='<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .='<div class="dropdown-menu" style="">';
                    $actionBtn .='<a class="dropdown-item" href="'.route('admin.categories.faq.edit',['categories'=>$row->category_id,'faq'=>$row->id]).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                    $actionBtn .='<a class="dropdown-item text-danger" data-delete-id="'.$row->id.'" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .='</div>';
            $actionBtn .='</div>';
            return $actionBtn;
        })
        ->rawColumns(['action','category','is_publish'])
        ->make(true);
    }
}
