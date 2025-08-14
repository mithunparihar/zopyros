<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\ComponentAttributeBag;

class ProjectController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Project::latest('id')->get();
            return $this->dataTable($data);
        }
        return view('admin.projects.lists');
    }
    public function create()
    {
        return view('admin.projects.create');
    }
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }
    public function publish(Project $project)
    {
        if(request('publish')==0){
            $project->update(['is_publish' => request('publish'),'is_home' => request('publish')]);
        }else{
            $project->update(['is_publish' => request('publish')]);
        }
        return response()->json(['status' => 200]);
    }
    public function homepublish(Project $project)
    {
        $checkCount = Project::home()->count();
        if ($checkCount > 6 && request('publish')==1){
            return response()->json([
                'status' => 422,
                'message'=> 'Oops! You can only show up to 6 records on the homepage. Try removing one before adding a new one.'
            ], 422);
        }
        $project->update(['is_home' => request('publish')]);
        return response()->json(['status' => 200]);
    }
    public function destory()
    {
        $data = Project::findOrFail(request('id'));
        foreach ($data->images as $images) {
            \Image::removeFile('projects/', $images->image);
            $images->delete();
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
            ->addColumn('lists', function ($row) {
                $html = '';
                $html .= '<div class="d-flex align-items-center">';
                $html .= '<div class="d-flex ms-2 flex-column">';
                $html .= '<h6 class="mb-0">' . $row->title . '</h6>';
                $html .= '</div>';
                $html .= '</div>';

                return $html;
            })
            ->addColumn('gallery', function ($row) {
                $html = '';
                $html .= '<div class="d-flex flex-wrap align-items-center">';
                $html .= '<ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">';
                foreach ($row->images as $key => $images) {
                    $imageComponent = new \App\View\Components\ImagePreview('projects', $images->image);
                    $imageComponent->pathName = 'projects';
                    $imageComponent->imageName = $images->image;

                    $attributes = new ComponentAttributeBag(['class' => 'rounded-circle', 'width' => '500']);
                    $imageComponent->withAttributes($attributes->getAttributes());
                    $html .= '<li style="cursor:auto!important" class="avatar sws-bounce sws-top sws-dark pull-up" data-title="Image ' . ($key + 1) . '">';
                    $html .= $imageComponent->render()->with($imageComponent->data());
                    $html .= '</li>';
                    if ($key == 3 && count($row->images) > 4 ) {
                        $html .= '<li class="avatar">';
                        $html .= '<a href="' . route('admin.projects.edit', ['project' => $row->id]) . '" class="avatar-initial rounded-circle pull-up text-heading sws-bounce sws-dark sws-top" data-title="' . (count($row->images) - 4) . ' more">+' . (count($row->images) - 4) . '</a>';
                        $html .= '</li>';
                        break;
                    }


                }

                $html .= '</ul>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('is_home',function($row){
                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_home;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.projects.home.publish',['project'=>$row->id]);
                return $switchButton->render()->with($switchButton->data());
            })
            ->addColumn('is_publish', function ($row) {

                $switchButton = new \App\View\Components\Admin\Button\SwitchButton();
                $switchButton->checked = $row->is_publish;
                $switchButton->value = $row->id;
                $switchButton->url = route('admin.projects.publish', ['project' =>  $row->id]);
                return $switchButton->render()->with($switchButton->data());

            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown">';
                $actionBtn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>';
                $actionBtn .= '<div class="dropdown-menu" style="">';
                $actionBtn .= '<a class="dropdown-item" href="' . route('admin.projects.edit', ['project' =>  $row->id]) . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $actionBtn .= '<a class="dropdown-item text-danger" data-delete-id="' . $row->id . '" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn .= '</div>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'gallery','is_home', 'lists', 'is_publish'])
            ->make(true);
    }
}
