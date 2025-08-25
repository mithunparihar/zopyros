<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Variant::latest();
            $data = $data->parent(request('parent'));
            $data = $data->get();
            return $this->dataTable($data);
        }
        return view('admin.variant.lists');
    }

    public function create()
    {
        return view('admin.variant.create');
    }
    public function edit(Variant $variant)
    {
        return view('admin.variant.edit', compact('variant'));
    }
    public function publish(Variant $variant)
    {
        $variant->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = Variant::findOrFail(request('id'));
        $data->categories()->delete();
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('lists', function ($row) {

                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('types', function ($row) {
                $html = '';
                $html .= '<span class="d-inline-block">';
                $html .= '<a href="' . route('admin.variants.index', ['parent' => $row->id]) . '" class="btn btn-icon rounded-pill btn-label-slack">';
                $html .= $row->childs()->count();
                $html .= '</a>';
                $html .= '<span>';
                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.variants.publish', ['variant' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.variants.edit', ['variant' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'types', 'lists', 'is_publish'])
            ->make(true);
    }
}
