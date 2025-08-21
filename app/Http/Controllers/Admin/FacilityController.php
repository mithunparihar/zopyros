<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facilities as Facility;
use Illuminate\Http\Request;
use App\Enums\Permission;
class FacilityController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Facility::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.facility.lists');
    }
    public function create()
    {
        return view('admin.facility.create');
    }
    public function edit(Facility $facility)
    {
        return view('admin.facility.edit', compact('facility'));
    }
    public function publish(Facility $facility)
    {
        $facility->update(['is_publish' => request('publish')]);
        return response()->json(['status'=>200]);
    }
    public function destory()
    {
        $data = Facility::findOrFail(request('id'));
        \CommanFunction::removeFile('facilities/', $data->image);
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }

    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('updated_at', function ($row) {
                return \CommanFunction::datetimeformat($row->updated_at);
            })
            ->addColumn('title', function ($row) {
                $imageComponent = new \App\View\Components\ImagePreview('facilities', $row->image);
                $imageComponent->pathName = 'facilities';
                $imageComponent->imageName = $row->image;
                $imageComponent->widthName = "width='40'";
                $imageComponent->className = "class='me-2 border rounded-2 p-1'";
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= $imageComponent->render()->with($imageComponent->data());
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
                $html .= '<span class="small">' . $row->description . '</span>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                if (! \CommanFunction::adminCanAny([Permission::FACILITY_EDIT->value])) {
                    $switchButton->disabled    = true;
                    $switchButton->tooltipText = \App\Enums\ButtonText::NOTPERMISSION_MESSAGE;
                }
                $switchButton->url = route('admin.facilities.publish', ['facility' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                if (\CommanFunction::adminCanAny([Permission::FACILITY_EDIT->value,Permission::FACILITY_DELETE->value])){
                    $actionBtn = '<div class="dropdown">';
                    $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                    $actionBtn .= '<div class="dropdown-menu" style="">';
                    if (\CommanFunction::adminCanAny([Permission::FACILITY_EDIT->value])) {
                        $actionBtn .= '<a class="dropdown-item" href="' . route('admin.facilities.edit', ['facility' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                    }
                    if (\CommanFunction::adminCanAny([Permission::FACILITY_DELETE->value])) {
                        $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                    }
                    $actionBtn .= '</div>';
                    $actionBtn .= '</div>';
                    return $actionBtn;
                }
            })
            ->rawColumns(['action', 'image', 'title', 'is_publish'])
            ->make(true);
    }
}
