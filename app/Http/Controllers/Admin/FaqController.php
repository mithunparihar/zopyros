<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Faq::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.faq.lists');
    }
    public function create()
    {
        return view('admin.faq.create');
    }
    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }
    public function publish(Faq $faq)
    {
        if (request('publish') == 0) {
            $faq->update(['is_publish' => request('publish'), 'is_home' => 0]);
        } else {
            $faq->update(['is_publish' => request('publish')]);
        }

        return response()->json(['status' => 200]);
    }
    public function homePublish(Faq $faq)
    {
        $faq->update(['is_home' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = Faq::findOrFail(request('id'));
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
                if(!empty($row->categoryInfo)){
                    $html .= '<span class="text-body small"><b>Category</b> : '.$row->categoryInfo->title .'</span>';
                }
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.faq.publish', ['faq' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('is_home', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_home;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.faq.home.publish', ['faq' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.faq.edit', ['faq' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'is_publish', 'is_home'])
            ->make(true);
    }
}
