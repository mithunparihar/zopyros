<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\View\ComponentAttributeBag;

class GalleyController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Gallery::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.gallery.lists');
    }
    public function create()
    {
        return view('admin.gallery.create');
    }
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }
    public function publish(Gallery $gallery)
    {
        $gallery->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = Gallery::findOrFail(request('id'));
        if ($data->type == 1) {
            \Image::removeFile('gallery/', $data->image);
        }
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }

    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('gallery', function ($row) {
                if ($row->type == 1) {
                    $imageComponent            = new \App\View\Components\ImagePreview('gallery', $row->image);
                    $imageComponent->pathName  = 'gallery';
                    $imageComponent->imageName = $row->image;

                    $attributes = new ComponentAttributeBag(['class' => 'defaultimg', 'width' => '200']);
                    $imageComponent->withAttributes($attributes->getAttributes());

                    return $imageComponent->render()->with($imageComponent->data());
                } elseif ($row->type == 2) {
                    return '<a href="' . $row->url . '" data-fancybox="gallery" class="youtubeImg">
                    <img src="https://www.iconpacks.net/icons/1/free-youtube-icon-141-thumb.png" class="youtubeIcon">
                    <img src="https://img.youtube.com/vi/' . \CommanFunction::getYoutubeVideoId($row->url) . '/mqdefault.jpg" class="defaultimg" >
                </a>';
                }
            })
            ->addColumn('is_publish', function ($row) {

                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.gallery.publish', ['gallery' => $row->id]);
                return $switchButton->render()->with($switchButton->data());

            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.gallery.edit', ['gallery' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'gallery', 'is_publish'])
            ->make(true);
    }
}
