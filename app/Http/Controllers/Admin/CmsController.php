<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Cms;

class CmsController extends Controller
{
    public function edit(Cms $cm)
    {
        return view('admin.cms.edit', compact('cm'));
    }

    function publish(Cms $cm){
        $cm->update(['is_publish'=>request('publish')]);
        return response()->json(['status'=>200]);
    }

    function sequence(Request $request){
        $categoryData = Cms::findOrFail(key($request->sequence));
        $request->validate([
            'sequence'=>'required',
            'sequence.*'=>[
                'nullable',
                'integer',
                Rule::unique('cms','sequence')->ignore(key($request->sequence),'id'),
            ]
        ],[],['sequence.*'=>'sequence']);
        foreach($request->sequence as $key => $sequence){
            $service = Cms::findOrFail($key);
            $service->sequence = $sequence;
            $service->save();
        }
        return response()->json([
            'status'=>200,
            'message'=>'Sequence has been updated!'
        ]);
    }

    public function betterTomorrow()
    {
        if (\request()->ajax()) {
            $data = Cms::whereIn('id', [17, 18, 19, 20, 21, 22])->latest('sequence')->get();
            return $this->dataTable($data);
        }
        return view('admin.cms.better-tomorrow');
    }

    public function spirituality()
    {
        if (\request()->ajax()) {
            $data = Cms::whereIn('id', [6, 7, 8, 9])->get();
            return $this->dataTable($data);
        }
        return view('admin.cms.spirituality');
    }

    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($row) {
                $imageComponent = new \App\View\Components\ImagePreview('cms', $row->image);
                $imageComponent->pathName = 'cms';
                $imageComponent->imageName = $row->image;
                $imageComponent->widthName = "width='40'";
                $imageComponent->heightName = "height='40'";
                $imageComponent->className = "class='me-2 rounded-circle'";

                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                if(!empty($row->image)){
                    $html .= $imageComponent->render()->with($imageComponent->data());
                }
                
                $html .= '<div class="d-flex flex-column">';
                if(in_array($row->id,[17,18,19,20,21,22])){
                    $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
                }else{
                    $html .= '<h6 class="mb-0">' . $row->heading . '</h6>';
                }
                
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.cms.publish', ['cm' => $row->id]);
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
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.cms.edit', ['cm' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'is_publish','sequence'])
            ->make(true);
    }
}
