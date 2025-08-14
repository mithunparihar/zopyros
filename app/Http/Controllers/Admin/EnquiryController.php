<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerEnquiry;
use App\Models\ContactEnquiry as Enquiry;
use App\Models\QuoteRequest;
use App\Models\Subscribe as Newsletter;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /// GET IN TOUCH
    public function contactEnquiry()
    {
        if (\request()->ajax()) {
            $data = Enquiry::latest()->get();
            return $this->dataTable($data);
        }
        $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Contact')->count();
        if ($checkNoti > 0) {
            \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Contact')->markAsRead();
        }
        return view('admin.enquiry.contact');
    }
    public function destoryContactEnquiry()
    {
        $data = Enquiry::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    public function bulkdestroyContactEnquiry(Request $request)
    {
        if (empty($request->check)) {
            flash()->error('Please select at least one record to proceed.');
            return back();
        } else {
            $removeProduct = 0;
            $skipProduct = '';
            foreach ($request->check as $key => $check) {
                $data = Enquiry::findOrFail($key);
                $data->delete();
            }
            $msg = 'Successfully removed!';
            flash()->success($msg);
            return back();
        }
    }
    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('s_no', function ($row) {
                return '<input type="checkbox" class="dt-checkboxes form-check-input" name="check[' . $row->id . ']">';
            })
            ->addColumn('updated_at', function ($row) {
                return \CommanFunction::datetimeformat($row->updated_at);
            })
            ->addColumn('title', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->name . '</h6>';
                $html .= '<span class="text-body small"><b>Phone : </b>' . $row->phone . '</span>';
                $html .= '<span class="text-body small"><b>Email : </b>' . $row->email . '</span>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('message', function ($row) {
                $html = '';
                $html .= '<small><b>Subject:</b> ' . $row->subject . ' </small><br>';
                $html .= '<a role="button" class="d-inline-flex align-items-center sws-bounce sws-top" data-title="Message: ' . $row->message . '">';
                $html .= '<u>View Message</u>';
                $html .= '</a>';

                return $html;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'message', 's_no'])
            ->make(true);
    }

    /// SUBSCRIBE
    public function subscribeEnquiry()
    {
        if (\request()->ajax()) {
            $data = Newsletter::latest()->get();
            return $this->dataTable2($data);
        }
        $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\SubscribeNotification')->count();
        if ($checkNoti > 0) {
            \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\SubscribeNotification')->markAsRead();
        }
        return view('admin.enquiry.subscribe');
    }
    public function destorySubscribeEnquiry()
    {
        $data = Newsletter::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    public function bulkdestroySubscribeEnquiry(Request $request)
    {
        if (empty($request->check)) {
            flash()->error('Please select at least one record to proceed.');
            return back();
        } else {
            $removeProduct = 0;
            $skipProduct = '';
            foreach ($request->check as $key => $check) {
                $data = Newsletter::findOrFail($key);
                $data->delete();
            }
            $msg = 'Successfully removed!';
            flash()->success($msg);
            return back();
        }
    }
    protected function dataTable2($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('s_no', function ($row) {
                return '<input type="checkbox" class="dt-checkboxes form-check-input" name="check[' . $row->id . ']">';
            })
            ->addColumn('updated_at', function ($row) {
                return \CommanFunction::datetimeformat($row->updated_at);
            })
            ->addColumn('title', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->email . '</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 's_no'])
            ->make(true);
    }

    /// Career
    public function careerEnquiry()
    {
        if (\request()->ajax()) {
            $data = CareerEnquiry::latest()->get();
            return $this->dataTable4($data);
        }
        return view('admin.enquiry.career');
    }
    public function destoryCareerEnquiry()
    {
        $data = CareerEnquiry::findOrFail(request('id'));
        \Image::removeFile('resume/', $data->resume);
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    public function bulkdestroyCareerEnquiry(Request $request)
    {
        if (empty($request->check)) {
            flash()->error('Please select at least one record to proceed.');
            return back();
        } else {
            $removeProduct = 0;
            $skipProduct = '';
            foreach ($request->check as $key => $check) {
                $data = CareerEnquiry::findOrFail($key);
                \Image::removeFile('resume/', $data->resume);
                $data->delete();
            }
            $msg = 'Successfully removed!';
            flash()->success($msg);
            return back();
        }
    }
    protected function dataTable4($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('s_no', function ($row) {
                return '<input type="checkbox" class="dt-checkboxes form-check-input" name="check[' . $row->id . ']">';
            })
            ->addColumn('updated_at', function ($row) {
                return \CommanFunction::datetimeformat($row->updated_at);
            })
            ->addColumn('title', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->name . '</h6>';
                $html .= '<span class="text-body small"><b>Phone : </b><span class="sws-bounce sws-top">' . $row->phone . '</span></span>';
                $html .= '<span class="text-body small"><b>Email : </b>' . $row->email . '</span>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('message', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<span class="text-body small"><b>Resume : </b><a href="' . \Image::showFile('resume', 0, ($row->resume ?? '')) . '" download >Download Resume</a></span>';
                $html .= '<span class="text-body small"><b>Message : </b>' . $row->message . '</span>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'message', 's_no'])
            ->make(true);
    }

    /// Other
    public function quoteEnquiry()
    {
        if (\request()->ajax()) {
            $data = QuoteRequest::latest();
            $data = $data->get();
            return $this->dataTable3($data);
        }
        return view('admin.enquiry.other');
    }
    public function destoryQuoteEnquiry()
    {
        $data = QuoteRequest::findOrFail(request('id'));
        $data->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
    public function bulkdestroyQuoteEnquiry(Request $request)
    {
        if (empty($request->check)) {
            flash()->error('Please select at least one record to proceed.');
            return back();
        } else {
            $removeProduct = 0;
            $skipProduct = '';
            foreach ($request->check as $key => $check) {
                $data = QuoteRequest::findOrFail($key);
                $data->delete();
            }
            $msg = 'Successfully removed!';
            flash()->success($msg);
            return back();
        }
    }
    protected function dataTable3($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('s_no', function ($row) {
                return '<input type="checkbox" class="dt-checkboxes form-check-input" name="check[' . $row->id . ']">';
            })
            ->addColumn('updated_at', function ($row) {
                $html = '';
                $html .= \CommanFunction::datetimeformat($row->updated_at);
                return $html;
            })
            ->addColumn('title', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->name . '</h6>';
                $html .= '<span class="text-body small"><b>Phone : </b> <span class="sws-bounce sws-top">' . $row->phone . '</span> </span>';
                $html .= '<span class="text-body small"><b>Email : </b>' . $row->email . '</span>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('message', function ($row) {
                $html = '';
                $html .= '<small class="d-flex align-items-center">';
                $html .= $row->message;
                $html .= '</small>';

                return $html;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'title', 'message', 'updated_at', 's_no'])
            ->make(true);
    }
}
