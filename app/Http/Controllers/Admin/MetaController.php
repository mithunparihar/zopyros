<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meta;

class MetaController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Meta::get();
            return $this->dataTable($data);
        }
        return view('admin.meta.lists');
    }
    public function edit(Meta $metum)
    {
        return view('admin.meta.edit', compact('metum'));
    }

    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('page', function ($row) {
                return $html = '<div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                        <h6 class="mb-0">' . $row->page . '</h6>
                        </div>
                    </div>';
            })
            ->addColumn('title', function ($row) {
                return $html = '<div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                        <h6 class="mb-0">' . $row->title . '</h6>
                        </div>
                    </div>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.meta.edit', ['metum' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'page', 'title'])
            ->make(true);
    }
}
