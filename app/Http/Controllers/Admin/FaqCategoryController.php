<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $parentInfo = '';
        if (\request()->ajax()) {
            $data = FaqCategory::latest();
            $data = $data->parent(request('parent') ?? 0);
            $data = $data->get();
            return $this->dataTable($data);
        }
        if (!empty($_GET['parent'])) {
            $parentInfo = FaqCategory::find($_GET['parent']);
        }
        return view('admin.faq.category.lists', compact('parentInfo'));
    }
    public function create()
    {
        $parentInfo = '';
        if (!empty($_GET['parent'])) {
            $parentInfo = FaqCategory::find($_GET['parent']);
        }
        return view('admin.faq.category.create', compact('parentInfo'));
    }
    public function edit(FaqCategory $faq_category)
    {
        return view('admin.faq.category.edit', compact('faq_category'));
    }
    public function publish(FaqCategory $faq_category)
    {
        $faq_category->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = FaqCategory::findOrFail(request('id'));
        $data->faqs()->delete();
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('category', function ($row) {
                return $html = '<div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                        <h6 class="mb-0">' . $row->title . '</h6>
                        </div>
                    </div>';
            })
            ->addColumn('childs', function ($row) {
                $html = '';
                $html .= '<a href="' . route('admin.faq-category.index', ['parent' => $row->id]) . '" class="btn btn-icon rounded-pill btn-label-slack">';
                $html .= $row->childs()->count();
                $html .= '</a>';
                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.faq-category.publish', ['faq_category' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.faq-category.edit', ['faq_category' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';

                    $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';

                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'category', 'childs', 'is_publish'])
            ->make(true);
    }
}
