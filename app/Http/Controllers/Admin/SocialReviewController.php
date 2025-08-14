<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialReview;
use Illuminate\Http\Request;
use Illuminate\View\ComponentAttributeBag;

class SocialReviewController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = SocialReview::latest()->get();
            return $this->dataTable($data);
        }
        return view('admin.review.lists');
    }
    public function create()
    {
        return view('admin.review.create');
    }
    public function edit(SocialReview $review)
    {
        return view('admin.review.edit', compact('review'));
    }
    public function publish(SocialReview $review)
    {
        if (request('publish') == 0) {
            $review->update(['is_publish' => request('publish'), 'is_top' => request('publish')]);
        } else {
            $review->update(['is_publish' => request('publish')]);
        }
        return response()->json(['status' => 200]);
    }

    public function topPublish(SocialReview $review)
    {
        $checkTop = SocialReview::whereIsTop(1)->count();
        if ($checkTop > 4 && request('publish')==1) {
            return response()->json([
                'errors'=>'You Can`t set more than 5 image in top section.'
            ],422);
        } else {
            $review->update(['is_top' => request('publish')]);
            return response()->json(['status' => 200]);
        }

    }

    public function destory()
    {
        $data = SocialReview::findOrFail(request('id'));
        \Image::removeFile('review/', $data->image);
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
                $html .= '<div class="d-flex ms-2 flex-column">';
                $html .= '<h6 class="mb-0">Rating: ' . $row->rating . '</h6>';
                $html .= '<span>' . $row->reviews . '+ Reviews</span>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('gallery', function ($row) {
                $html = '';
                $html .= '<div class="d-flex flex-wrap align-items-center">';
                $html .= '<ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">';
                $imageComponent            = new \App\View\Components\ImagePreview('review', $row->image);
                $imageComponent->pathName  = 'review';
                $imageComponent->imageName = $row->image;

                $attributes = new ComponentAttributeBag(['class' => 'me-2', 'width' => '200', 'style' => 'width:100px!important;height:50px!important']);
                $imageComponent->withAttributes($attributes->getAttributes());

                $html = '';
                $html .= $imageComponent->render()->with($imageComponent->data());
                $html .= '<span class="d-block"><a href="' . $row->url_link . '" target="_blank">Click Here</a></span>';
                return $html;
            })
            ->addColumn('is_home', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_top;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.reviews.publish.top', ['review' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('is_publish', function ($row) {

                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.reviews.publish', ['review' => $row->id]);
                return $switchButton->render()->with($switchButton->data());

            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.reviews.edit', ['review' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'gallery', 'is_home', 'lists', 'is_publish'])
            ->make(true);
    }
}
