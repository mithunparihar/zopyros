<?php
namespace App\Http\Controllers\Admin;

use App\Enums\AlertMessage;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\ComponentAttributeBag;

class CategoroyController extends Controller
{
    public function index()
    {
        $parentInfo = '';
        if (\request()->ajax()) {
            $data = Category::latest('sequence');
            $data = $data->parent(request('parent'));
            $data = $data->get();
            return $this->dataTable($data);
        }
        $level = 1;
        if (request('parent')) {
            $parentInfo = Category::findOrFail(request('parent'));
            $level      = ($parentInfo->level + 1);
        }
        return view('admin.categories.lists', compact('parentInfo', 'level'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function publish(Category $categories)
    {
        if (request('publish') == 0) {
            $categories->update([
                'is_publish' => request('publish'),
                'is_home'    => request('publish'),
                'is_footer'  => request('publish'),
            ]);
        } else {
            $categories->update(['is_publish' => request('publish')]);
        }

        return response()->json(['status' => 200]);
    }

    public function parentData($categories)
    {
        $categories = Category::find($categories);
        $parentInfo = $categories->parentInfo ?? 0;
        if ($parentInfo->parent_id ?? 0 > 0) {
            return $parentInfo = $this->parentData($categories->parentInfo->id);
        }
        return $parentInfo;
    }
    public function footerPublish(Category $categories)
    {
        $check = Category::footer()->count();
        if ($check > 6 && request('publish') > 0) {
            return response()->json(['status' => 422, 'message' => 'You can`t add more than 6 records in footer'], 422);
        } else {
            $categories->update(['is_footer' => request('publish')]);
            return response()->json(['status' => 200]);
        }
    }

    public function homePublish(Category $categories)
    {
        $check = Category::home()->count();
        if ($check > 10 && request('publish') > 0) {
            return response()->json(['status' => 422, 'message' => 'You can`t add more than 10 records in home page'], 422);
        } else {
            $categories->update(['is_home' => request('publish')]);
            return response()->json(['status' => 200]);
        }
    }
    public function destory()
    {
        $data = Category::findOrFail(request('id'));
        if ($data->childs()->count() > 0) {
            return response()->json([
                'status'  => false,
                'message' => AlertMessage::CHECKREMOVECHILDCATEGORY,
            ], 422);
        } else {
            if ($data->image) {
                \Image::removeFile('categories/', $data->image);
            }
            if ($data->banner) {
                \Image::removeFile('categories/banner/', $data->banner);
            }
            $data->delete();
            return response()->json([
                'status' => 200,
            ]);
        }
    }

    public function sequence(Request $request)
    {
        $categoryData = Category::findOrFail(key($request->sequence));
        $request->validate([
            'sequence'   => 'required',
            'sequence.*' => [
                'nullable',
                'integer',
                Rule::unique('categories', 'sequence')->withoutTrashed()->where('parent_id', $categoryData->parent_id)->ignore(key($request->sequence), 'id'),
            ],
        ], [], ['sequence.*' => 'sequence']);
        foreach ($request->sequence as $key => $sequence) {
            $service           = Category::findOrFail($key);
            $service->sequence = $sequence;
            $service->save();
        }
        return response()->json([
            'status'  => 200,
            'message' => 'Sequence has been updated!',
        ]);
    }

    public function bulkdestroy(Request $request)
    {
        if (empty($request->check)) {
            flash()->error('Please select at least one item to proceed.');
            return back();
        } else {
            $removeData = 0;
            $skipData   = '';
            foreach ($request->check as $key => $check) {
                $data = Category::findOrFail($key);
                if ($data->childs()->count() == 0) {
                    if ($data->image) {
                        \Image::removeFile('categories/', $data->image);
                    }
                    if ($data->banner) {
                        \Image::removeFile('categories/banner/', $data->banner);
                    }
                    $data->delete();
                    $removeData++;
                } else {
                    if (empty($skipData)) {
                        if (! empty($data->title)) {
                            $skipData = $data->title;
                        }
                    } else {
                        $skipData .= ', ' . $data->title;
                    }
                }
            }
            if ($skipData > 0) {
                flash()->success('Successfully removed ' . $removeData . ' categories and skip categories name is ' . $skipData);
            } else {
                flash()->success('Successfully removed ' . $removeData . ' categories.');
            }

            return back();
        }
    }

    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
        // ->addColumn('s_no', function ($row) {
        //     // return '<input type="checkbox" class="dt-checkboxes form-check-input" name="check[' . $row->id . ']">';
        // })
            ->addColumn('title', function ($row) {
                $imageComponent            = new \App\View\Components\ImagePreview('categories', $row->image);
                $imageComponent->pathName  = 'categories';
                $imageComponent->imageName = $row->image;

                $attributes = new ComponentAttributeBag(['class' => 'me-2 rounded-2', 'width' => '200', 'style' => 'width:50px!important;height:50px!important']);
                $imageComponent->withAttributes($attributes->getAttributes());

                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= $imageComponent->render()->with($imageComponent->data());
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0 text-wrap">' . $row->title . '</h6>';
                $html .= '<span class="text-body small">' . ($row->heading) . '</span>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('childs', function ($row) {
                $html = '';
                if ($row->variants()->count() > 0) {
                    $html .= '<span style="cursor:no-drop;" class="d-inline-block sws-bounce sws-top" data-title="' . AlertMessage::CATEGORYNOLONGER->value . '">';
                    $html .= '<a class="disabled btn btn-icon rounded-pill btn-label-slack">';
                    $html .= 0;
                    $html .= '</a>';
                    $html .= '<span>';
                } else {
                    $html .= '<a href="' . route('admin.categories.index', ['parent' => $row->id]) . '" class="btn btn-icon sws-bounce sws-top rounded-pill btn-label-slack" data-title="'.AlertMessage::CATEGORYVARIANT->value.'" >';
                    $html .= $row->childs()->count();
                    $html .= '</a>';
                }
                return $html;
            })
            ->addColumn('variants', function ($row) {
                $html      = '';
                $dataTitle = '';
                $childs    = $row->childs()->count();

                if ($childs > 0) {
                    $html .= '<span style="cursor:no-drop;" class="d-inline-block sws-bounce sws-top" data-title="' . AlertMessage::VARIANTNOLONGER->value . '">';
                    $html .= '<a class="disabled btn btn-icon rounded-pill btn-label-slack">';
                    $html .= 0;
                    $html .= '</a>';
                    $html .= '<span>';
                } else {
                    if ($row->level == 1) {
                        $dataTitle = ' data-title="' . AlertMessage::VARIANTCATEGORY->value . '"';
                    }
                    $html .= '<a href="' . route('admin.categories.variants.index', ['category' => $row->id]) . '" class="btn btn-icon ' . ($row->level == 1 ? 'sws-bounce sws-top' : '') . ' rounded-pill btn-label-slack" ' . $dataTitle . ' >';
                    $html .= $row->variants()->count();
                    $html .= '</a>';
                }
                return $html;
            })
            ->addColumn('set_home', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_home;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.categories.home.publish', ['categories' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('set_footer', function ($row) {
                // if(!in_array($row->id,[2,3,4])){  }
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_footer;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.categories.footer.publish', ['categories' => $row->id]);
                if ($row->hide_information_page == 1) {
                    return '<span class="badge bg-label-danger">Info Page Disabled</span>';
                } else {
                    return $switchButton->render()->with($switchButton->data());
                }

            })
            ->addColumn('is_publish', function ($row) {
                $switchButton          = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value   = $row->id;
                $switchButton->url     = route('admin.categories.publish', ['categories' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('sequence', function ($row) {
                $html = '';
                $html .= '<form class="sequenceForm" id="sequenceForm' . $row->id . '">';
                $html .= ' <div class="d-flex gap-2 ">';
                $html .= '<input type="text" name="sequence[' . $row->id . ']" value="' . $row->sequence . '" class="form-control seqFocus" onkeypress="return isOnlyNumber(event)" placeholder="Sequence here...">';
                $html .= '<button class="btn btn-primary btn-sm sws-dark sws-bounce sws-top" data-title="Update Sequence"><i class="fas fa-save"></i></button>';
                $html .= '</div>';
                $html .= '<small class="text-danger text-wrap lh-normal Err"></small>';
                $html .= '</form>';
                return $html;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.categories.edit', ['category' => $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';

                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.categories.faq.index', ['categories' => $row->id]) . '"><i class="bx bx-sitemap me-1"></i> FAQs (' . $row->faqs()->count() . ')</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';

                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'variants', 'childs', 'set_home', 'set_footer', 'is_publish', 'sequence', 's_no'])
            ->make(true);
    }
}
