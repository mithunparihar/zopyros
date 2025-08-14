<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;

class StateController extends Controller
{
    public function index(Country $countries)
    {
        if (\request()->ajax()) {
            $data = State::country($countries->id)->orderBy('name')->distinct()->get();
            return $this->dataTable($data);
        }
        return view('admin.country.state.lists',compact('countries'));
    }
    function publish(Country $countries,State $states){
        $states->update(['status'=>request('publish')]);
        return response()->json(['status'=>200]);
    }
    protected function dataTable($data)
    {
        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($row) {
                
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<img src="'.asset('admin/flags/'.strtolower($row->countryinfo->sortname).'.svg').'" alt="Oneplus" height="32" width="32" class="me-3">';
                $html .= '<div class="d-flex flex-column">';
                $html .= '<h6 class="mb-0">' . $row->name . '</h6>';
                $html .= '<small class="text-body">'.$row->countryinfo->name.'</small>';
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('cities', function ($row) {
                $html ='';
                $html .= '<a href="'.route('admin.cities.index',['states'=>$row->id,'countries'=>$row->countryinfo->id]).'" class="btn btn-icon rounded-pill btn-label-slack">';
                $html .= $row->cities()->count();
                $html .= '</a>';
                return $html;
            })
            ->addColumn('is_publish', function ($row) {
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->status;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.states.publish', ['countries'=>$row->countryinfo->id,'states'=>$row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->rawColumns(['action', 'title', 'cities', 'is_publish'])
            ->make(true);
    }
}
