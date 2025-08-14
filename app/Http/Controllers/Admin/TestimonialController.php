<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\ComponentAttributeBag;

class TestimonialController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Testimonial::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.testimonial.lists');
    }
    public function create()
    {
        return view('admin.testimonial.create');
    }
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }
    public function publish(Testimonial $testimonial)
    {
        if (request('publish') == 0) {
            $testimonial->update(['is_publish' => request('publish'), 'is_home' => 0]);
        } else {
            $testimonial->update(['is_publish' => request('publish')]);
        }

        return response()->json(['status' => 200]);
    }
    public function homePublish(Testimonial $testimonial)
    {
        $checkHome = Testimonial::where('is_home', 1)->count();
        if ($checkHome >= 3 && request('publish') == 1) {
            return response()->json([
                'message' => 'You can only publish 3 testimonials on home page.'
            ], 422);
        }
        $testimonial->update(['is_home' => request('publish')]);
        return response()->json(['status' => 200]);
    }

    public function destory()
    {
        $data = Testimonial::findOrFail(request('id'));
        \Image::removeFile('testimonial/', $data->image);
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                $imageComponent            = new \App\View\Components\ImagePreview('testimonial', $row->image);
                $imageComponent->pathName  = 'testimonial';
                $imageComponent->imageName = $row->image;

                $attributes = new ComponentAttributeBag(['class' => 'me-2 rounded-2', 'width' => '70']);
                $imageComponent->withAttributes($attributes->getAttributes());

                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= $imageComponent->render()->with($imageComponent->data());
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
                $html .= ' <span class="text-body small"><b>Rating : </b>' . $row->designation . ' Star</span>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('is_home', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_home;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.testimonial.home.publish', ['testimonial' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.testimonial.publish', ['testimonial' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.testimonial.edit', ['testimonial' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'image', 'user', 'is_home', 'is_publish'])
            ->make(true);
    }
}
