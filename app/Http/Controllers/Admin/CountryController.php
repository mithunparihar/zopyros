<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {

        if (\request()->ajax()) {
            $data = Country::whereNotNUll('currency')->whereIn('id',[38])->orderBy('name')->distinct()->get();
            return $this->dataTable($data);
        }
        return view('admin.country.lists');
    }
    public function publish(Country $countries)
    {
        $countries->update(['status' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function activeCurrency(Country $countries)
    {
        $countries->update(['currency_status' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($row) {

                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<img src="' . asset('admin/flags/' . strtolower($row->sortname) . '.svg') . '" alt="Oneplus" height="32" width="32" class="me-3">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->name . '</h6>';
                $html .= '<small class="text-body">Phone code : +' . $row->phonecode . '</small>';
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('rate', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->currency . ' ( '.$row->symbol.' )</h6>';
                // $html .= '<small class="text-body sws-bounce sws-top" data-title="'.$row->currency_name.'">' . $row->symbol . ' ' . $row->currency_rate . '</small>';
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('states', function ($row) {
                $html = '';
                $html .= '<a href="' . route('admin.states.index', ['countries' => $row->id]) . '" class="btn btn-icon rounded-pill btn-label-slack">';
                $html .= $row->states()->count();
                $html .= '</a>';
                return $html;
            })
            ->addColumn('active_currency', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->currency_status;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.countries.active-currency', ['countries' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->status;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.countries.publish', ['countries' => $row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->rawColumns(['action', 'title','active_currency', 'states', 'is_publish', 'rate'])
            ->make(true);
    }
}
