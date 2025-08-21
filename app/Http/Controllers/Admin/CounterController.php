<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;

class CounterController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Counter::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.counter.lists');
    }

    public function create()
    {
        return view('admin.counter.create');
    }
    public function edit(Counter $counter)
    {
        return view('admin.counter.edit', compact('counter'));
    }
    public function publish(Counter $counter)
    {
        $counter->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = Counter::findOrFail(request('id'));
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
            ->addColumn('counter', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->counter . '+</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.counter.publish', ['counter' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.counter.edit', ['counter' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                // $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'counter', 'is_publish'])
            ->make(true);
    }
}
