<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\LocationPageContent;
use App\Models\LocationService;
use Illuminate\Http\Request;

class LocationPreferenceController extends Controller
{
    public function index()
    {
        $parentInfo = '';
        if (\request()->ajax()) {
            $data = Location::latest();
            $data = $data->city(request('parent') ?? 0);
            $data = $data->get();
            return $this->dataTable($data);
        }
        if (request('parent')) {
            $parentInfo = Location::find(request('parent'));
        }
        return view('admin.location-preference.lists', compact('parentInfo'));
    }
    public function create()
    {
        return view('admin.location-preference.create');
    }
    public function edit(Location $location)
    {
        return view('admin.location-preference.edit', compact('location'));
    }
    public function publish(Location $location)
    {
        $location->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = Location::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }

    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('area', function ($row) {
                $html = '';
                $html .= '<a href="' . route('admin.location.index', ['parent' => $row->id]) . '" class="btn btn-icon rounded-pill btn-label-slack">';
                $html .= $row->childs()->count();
                $html .= '</a>';
                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.location.publish', ['location' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.location.edit', ['location' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                // if($row->city_id==0){
                //     $actionBtn .= '<a class="dropdown-item" href="' . route('admin.location.content', ['location' => $row->id]) . '"><i class="bx bx-file me-1"></i> Content Management</a>';
                // }

                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'is_publish', 'area', 's_no'])
            ->make(true);
    }

    /// SERVICE MANAGEMENT
    public function service()
    {
        $parentInfo = '';
        if (\request()->ajax()) {
            $data = LocationService::latest();
            $data = $data->get();
            return $this->serviceDataTable($data);
        }
        return view('admin.location-preference.service.lists');
    }
    public function createService()
    {
        return view('admin.location-preference.service.create');
    }
    public function editService(LocationService $service)
    {
        return view('admin.location-preference.service.edit', compact('service'));
    }
    public function publishService(LocationService $service)
    {
        $service->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destoryService()
    {
        $data = LocationService::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    protected function serviceDataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . ($row->title ?? '') . '</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.location.service.publish', ['service' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.location.service.edit', ['service' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'is_publish', 'location', 's_no'])
            ->make(true);
    }




    /// CONTENT MANAGEMENT

    public function content()
    {
        $parentInfo = '';
        if (\request()->ajax()) {
            $data = LocationPageContent::latest();
            $data = $data->get();
            return $this->dataTable2($data);
        }
        return view('admin.location-preference.page-content.lists');
    }
    public function createContent()
    {
        return view('admin.location-preference.page-content.create');
    }
    public function editContent(LocationPageContent $content)
    {
        return view('admin.location-preference.page-content.edit', compact('content'));
    }
    public function publishContent(LocationPageContent $content)
    {
        if(request('publish')==0){
            $content->update(['is_publish' => request('publish'),'is_home'=>request('publish')]);
        }else{
            $content->update(['is_publish' => request('publish')]);
        }
        return response()->json(['status' => 200]);
    }

    public function publishHomeContent(LocationPageContent $content)
    {
        $content->update(['is_home' => request('publish')]);
        return response()->json(['status' => 200]);
    }


    public function destoryContent()
    {
        $data = LocationPageContent::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    protected function dataTable2($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . ($row->service->title ?? '') . '</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('location', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . ($row->location->title ?? '') . '</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_home', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_home;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.location.content.home', ['content' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.location.content.publish', ['content' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.location.content.edit', ['content' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'is_publish', 'location', 's_no'])
            ->make(true);
    }

}
