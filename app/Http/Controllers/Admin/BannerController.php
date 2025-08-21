<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\View\ComponentAttributeBag;

class BannerController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Banner::latest()->whereNotIn('id', [3,4]);
            $data = $data->get();
            return $this->dataTable($data);
        }
        return view('admin.banner.lists');
    }
    public function create()
    {
        return view('admin.banner.create');
    }
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }
    public function publish(Banner $banner)
    {
        $banner->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = Banner::findOrFail(request('id'));
        \Image::removeFile('banner/', $data->image);
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image_alt', function ($row) {
                $html = '';

                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->image_alt . '</h6>';
                $html .= '<span class="small">' . $row->short_description . '</span>';

                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('image', function ($row) {
                $imageComponent            = new \App\View\Components\ImagePreview('banner', $row->image);
                $imageComponent->pathName  = 'banner';
                $imageComponent->imageName = $row->image;

                $attributes = new ComponentAttributeBag(['class' => 'defaultimg', 'width' => '150', 'style' => 'height:62px!important']);
                $imageComponent->withAttributes($attributes->getAttributes());

                return $imageComponent->render()->with($imageComponent->data());
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.banner.publish', ['banner' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $url = route('admin.banner.edit', ['banner' => $row->id]);

                $actionBtn .= '<a class="dropdown-item" href="' . $url . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';

                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';

                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'image', 'image_alt', 'is_publish'])
            ->make(true);
    }
}
