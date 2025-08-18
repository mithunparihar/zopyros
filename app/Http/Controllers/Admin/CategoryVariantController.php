<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryVariant;

class CategoryVariantController extends Controller
{
    public function index(Category $category)
    {
        if (\request()->ajax()) {
            $data = CategoryVariant::latest();
            $data = $data->get();
            return $this->dataTable($data);
        }
        return view('admin.categories.variants.lists', compact('category'));
    }

    public function create(Category $category)
    {
        return view('admin.categories.variants.create', compact('category'));
    }

    public function edit(Category $category, CategoryVariant $variant)
    {
        return view('admin.categories.variants.edit', compact('category', 'variant'));
    }

    public function publish(Category $category, CategoryVariant $variant)
    {
        $variant->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    function destory(Category $category){
        $data = CategoryVariant::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status'=>200
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
            ->addColumn('type', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->variantInfo->title . '</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.categories.variants.publish', ['variant' => $row->id, 'category' => $row->category_id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.categories.variants.edit', ['variant' => $row->id, 'category' => $row->category_id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'type', 'is_publish'])
            ->make(true);
    }
}
