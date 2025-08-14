<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\ComponentAttributeBag;

class MaterialController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Material::orderBy('sequence', 'DESC')->get();
            return $this->dataTable($data);
        }
        return view('admin.materials.lists');
    }
    public function create()
    {
        return view('admin.materials.create');
    }
    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }
    public function publish(Material $material)
    {
        if (request('publish') == 0) {
            $material->update(['is_publish' => request('publish'), 'is_home' => request('publish')]);
        } else {
            $material->update(['is_publish' => request('publish')]);
        }

        return response()->json(['status' => 200]);
    }
    public function homepublish(Material $material)
    {
        $checkCount = Material::whereIsHome(1)->count();
        if ($checkCount > 5 && request('publish') == 1) {
            return response()->json([
                'status' => 422,
                'message' => 'Oops! You can only show up to 5 records on the footer section. Try removing one before adding a new one.',
            ], 422);
        }
        $material->update(['is_home' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = Material::findOrFail(request('id'));
        \Image::removeFile('materials/', $data->image);
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    public function sequence(Request $request)
    {
        $categoryData = Material::findOrFail(key($request->sequence));
        $request->validate([
            'sequence' => 'required',
            'sequence.*' => [
                'nullable',
                'integer',
                Rule::unique('materials', 'sequence')->withoutTrashed()->ignore(key($request->sequence), 'id'),
            ],
        ], [], ['sequence.*' => 'sequence']);
        foreach ($request->sequence as $key => $sequence) {
            $service = Material::findOrFail($key);
            $service->sequence = $sequence;
            $service->save();
        }
        return response()->json([
            'status' => 200,
            'message' => 'Sequence has been updated!',
        ]);
    }
    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('info', function ($row) {
                $imageComponent = new \App\View\Components\ImagePreview('materials', $row->image);
                $imageComponent->pathName = 'materials';
                $imageComponent->imageName = $row->image;

                $attributes = new ComponentAttributeBag(['class' => 'me-2 rounded-2', 'width' => '200', 'style' => 'width:80px!important']);
                $imageComponent->withAttributes($attributes->getAttributes());

                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= $imageComponent->render()->with($imageComponent->data());
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
                $html .= '<small class="text-body">' . $row->heading . '</small>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_home', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_home;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.materials.home.publish', ['material' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.materials.publish', ['material' => $row->id]);
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
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.materials.edit', ['material' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'image', 'info', 'is_home', 'is_publish', 'sequence'])
            ->make(true);
    }
}
