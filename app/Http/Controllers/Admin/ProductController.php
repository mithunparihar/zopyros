<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\ComponentAttributeBag;

class ProductController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Product::latest();
            $data = $data->get();
            return $this->dataTable($data);
        }
        return view('admin.product.lists');
    }
    public function create()
    {
        return view('admin.product.create');
    }
    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }
    public function publish(Product $product)
    {
        $product->update(['is_publish' => request('publish')]);
        return response()->json(['status' => 200]);
    }

     public function destory()
    {
        $data = Product::findOrFail(request('id'));
        $data->images()->delete();
        $data->categories()->delete();
        $data->lowestPrice()->delete();
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
        // }
    }

    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('s_no', function ($row) {
                return '<input type="checkbox" class="dt-checkboxes form-check-input" name="check[' . $row->id . ']">';
            })
            ->addColumn('info', function ($row) {
                $colorInfo = $row->lowestPrice[0]->colorInfo ?? '';
                
                $image                     = $row->images[0]->image ?? '';
                $imageComponent            = new \App\View\Components\ImagePreview('product', $image);
                $imageComponent->pathName  = 'product';
                $imageComponent->imageName = $image;

                $attributes = new ComponentAttributeBag(['class' => 'me-2 border', 'width' => '100', 'style' => 'width:60px!important']);
                $imageComponent->withAttributes($attributes->getAttributes());

                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= $imageComponent->render()->with($imageComponent->data());
                $html .= '<div class="d-flex flex-column align-items-start gap-0">';
                $html .= '<h6 class="mb-0" style="display:-webkit-box;overflow:hidden;-webkit-box-orient:vertical;-webkit-line-clamp:2">' . $row->title . '</h6>';
                $html .= '<small class="text-body">';

                $categoryTitles = [];
                foreach ($row->categories as $categories) {
                    if (!empty($categories->categoryInfo->title)) {
                        $categoryTitles[] = $categories->categoryInfo->title;
                    }
                }
                $html .= implode(', ', $categoryTitles);
                $html .= '</small>';
                // $html .= '<small class="text-body">Starting from <b>'.\Content::Currency().' '.(number_format($row->lowestPrice[0]->price ?? 0)).'</b></small>';

                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('category', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . ($row->categoryInfo->title ?? '') . '</h6>';
                if (! empty($row->categoryInfo->parent)) {
                    $html .= '<small class="text-body">Parent : ' . ($row->categoryInfo->parent->title ?? '') . '</small>';
                }
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('colors', function ($row) {
                $html = '';
                if (count($row->colors) > 0) {
                    $html .= '<ul class="list-unstyled users-list d-flex align-items-center avatar-group mt-2 me-2">';
                    foreach ($row->colors as $key => $colors) {
                        $html .= '<li data-title="' . $colors->name . '" style="background:' . $colors->hex . ';width:23px;height:23px;border-radius:50%;margin-left:-.7rem!important;    cursor: pointer;" class="border pull-up sws-bounce sws-top">';
                        $html .= '</li>';
                    }
                    $html .= '</ul>';

                }
                return $html;

            })
            ->addColumn('is_publish', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.products.publish', ['product' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.products.edit', ['product' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'info', 'category', 'is_publish', 'colors', 's_no'])
            ->make(true);
    }
}
