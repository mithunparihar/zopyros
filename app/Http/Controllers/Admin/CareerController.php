<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CareerController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = Career::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.career.lists');
    }
    public function create(){
        return view('admin.career.create');
    }
    public function edit(Career $career)
    {
        return view('admin.career.edit',compact('career'));
    }
    function publish(Career $career){
        $career->update(['is_publish'=>request('publish')]);
        return response()->json(['status'=>200]);
    }
    function destory(){
        $data = Career::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status'=>200
        ]);
    }
    function sequence(Request $request){
        $categoryData = Career::findOrFail(key($request->sequence));
        $request->validate([
            'sequence'=>'required',
            'sequence.*'=>[
                'nullable',
                'integer',
                Rule::unique('careers','sequence')->withoutTrashed()->ignore(key($request->sequence),'id'),
            ]
        ],[],['sequence.*'=>'sequence']);
        foreach($request->sequence as $key => $sequence){
            $service = Career::findOrFail($key);
            $service->sequence = $sequence;
            $service->save();
        }
        return response()->json([
            'status'=>200,
            'message'=>'Sequence has been updated!'
        ]);
    }
    protected function dataTable($data){
        return \DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('user',function($row){
            $html = '';
            $html .= '<div class="d-flex align-items-center">';
            $html .= '<div class="d-flex flex-column">';
            $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
            $html .= '<span class="text-body small"><b>Designation</b> : '.$row->designation.'</span>';
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        })
        ->addColumn('is_publish',function($row){
            $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
            $switchButton->checked = $row->is_publish;
            $switchButton->value = $row->id;
            $switchButton->url = route('admin.career.publish',['career'=>$row->id]);
            return $switchButton->render()->with($switchButton->data());
        })
        ->addColumn('sequence', function ($row) {
            $html = '';
            $html .= '<form class="sequenceForm" id="sequenceForm' . $row->id . '">';
            $html .= ' <div class="d-flex gap-2 ">';
            $html .= '<input type="text" name="sequence[' . $row->id . ']" value="' . $row->sequence . '" class="form-control seqFocus" onkeypress="return isOnlyNumber(event)" placeholder="Sequence here...">';
            $html .= '<button class="btn btn-primary btn-sm sws-bounce sws-top" data-title="Update Sequence"><i class="fas fa-save"></i></button>';
            $html .= '</div>';
            $html .= '<small class="text-danger text-wrap lh-normal Err"></small>';
            $html .= '</form>';
            return $html;
        })
        ->addColumn('action', function($row){
            $actionBtn = '<div class="dropdown">';
            $actionBtn .='<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .='<div class="dropdown-menu" style="">';
                    $actionBtn .='<a class="dropdown-item" href="'.route('admin.career.edit',['career'=>$row->id]).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                    $actionBtn .='<a class="dropdown-item text-danger" data-delete-id="'.$row->id.'" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .='</div>';
            $actionBtn .='</div>';
            return $actionBtn;
        })
        ->rawColumns(['action','user','sequence','is_publish'])
        ->make(true);
    }
}
