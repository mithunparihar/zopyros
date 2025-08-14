<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\View\ComponentAttributeBag;
class TeamController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = Team::orderBy('sequence','DESC')->get();
            return $this->dataTable($data);
        }
        return view('admin.team.lists');
    }
    public function create(){
        return view('admin.team.create');
    }
    public function edit(Team $team)
    {
       return view('admin.team.edit',compact('team'));
    }
    function publish(Team $team){
        if(request('publish')==0){
            $team->update(['is_publish'=>request('publish'),'is_home'=>0]);
        }else{
            $team->update(['is_publish'=>request('publish')]);
        }

        return response()->json(['status'=>200]);
    }
    function homepublish(Team $team){
        $team->update(['is_home'=>request('publish')]);
        return response()->json(['status'=>200]);
    }
    function destory(){
        $data = Team::findOrFail(request('id'));
        \Image::removeFile('team/',$data->image);
        $data->delete();
        return response()->json([
            'status'=>200
        ]);
    }
    function sequence(Request $request){
        $categoryData = Team::findOrFail(key($request->sequence));
        $request->validate([
            'sequence'=>'required',
            'sequence.*'=>[
                'nullable',
                'integer',
                Rule::unique('teams','sequence')->withoutTrashed()->ignore(key($request->sequence),'id'),
            ]
        ],[],['sequence.*'=>'sequence']);
        foreach($request->sequence as $key => $sequence){
            $service = Team::findOrFail($key);
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
        ->addColumn('partner_name',function($row){
            $imageComponent = new \App\View\Components\ImagePreview('team', $row->image);
            $imageComponent->pathName = 'team';
            $imageComponent->imageName = $row->image;

            $attributes = new ComponentAttributeBag(['class' => 'me-2 rounded-2','width'=>'80','style'=>"width:50px;height:50px;"]);
            $imageComponent->withAttributes($attributes->getAttributes());


            $html = '';
            $html .= '<div class="d-flex align-items-center">';
            $html .= $imageComponent->render()->with($imageComponent->data());
            $html .= '<div class="d-flex flex-column">';
            $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
            $html .= '<span class="text-body small"><b>Designation</b> : '.($row->designation ?? '').'</span>';
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        })
        ->addColumn('is_publish',function($row){
            $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
            $switchButton->checked = $row->is_publish;
            $switchButton->value = $row->id;
            $switchButton->url = route('admin.team.publish',['team'=>$row->id]);
            return $switchButton->render()->with($switchButton->data());
        })
        ->addColumn('is_home',function($row){
            $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
            $switchButton->checked = $row->is_home;
            $switchButton->value = $row->id;
            $switchButton->url = route('admin.team.home.publish',['team'=>$row->id]);
            return $switchButton->render()->with($switchButton->data());
        })
        ->addColumn('sequence', function ($row) {
            $html = '';
            $html .= '<form class="sequenceForm" id="sequenceForm' . $row->id . '">';
            $html .= ' <div class="d-flex gap-2 ">';
            $html .= '<input type="text" name="sequence[' . $row->id . ']" value="' . $row->sequence . '" class="form-control seqFocus" onkeypress="return isOnlyNumber(event)" placeholder="Sequence here...">';
            $html .= '<button class="btn btn-primary btn-sm sws-dark sws-bounce sws-top" data-title="Update Sequence"><i class="fas fa-save"></i></button>';
            $html .= '</div>';
            $html .= '<small class="text-danger text-wrap lh-normal Err"></small>';
            $html .= '</form>';
            return $html;
        })
        ->addColumn('action', function($row){
            $actionBtn = '<div class="dropdown">';
            $actionBtn .='<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .='<div class="dropdown-menu" style="">';
                    $actionBtn .='<a class="dropdown-item" href="'.route('admin.team.edit',['team'=>$row->id]).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                    $actionBtn .='<a class="dropdown-item text-danger" data-delete-id="'.$row->id.'" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .='</div>';
            $actionBtn .='</div>';
            return $actionBtn;
        })
        ->rawColumns(['action','image','partner_name','is_publish','sequence','is_home'])
        ->make(true);
    }
}
