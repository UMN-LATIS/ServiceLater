<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\AssignmentGroup;
use Illuminate\Http\Request;

class AssignmentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $assignmentgroup = AssignmentGroup::where('group_name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $assignmentgroup = AssignmentGroup::paginate($perPage);
        }

        return view('admin.assignment-group.index', compact('assignmentgroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.assignment-group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        AssignmentGroup::create($requestData);

        return redirect('admin/assignment-group')->with('flash_message', 'AssignmentGroup added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $assignmentgroup = AssignmentGroup::findOrFail($id);

        return view('admin.assignment-group.show', compact('assignmentgroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $assignmentgroup = AssignmentGroup::findOrFail($id);

        return view('admin.assignment-group.edit', compact('assignmentgroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $assignmentgroup = AssignmentGroup::findOrFail($id);
        $assignmentgroup->update($requestData);

        return redirect('admin/assignment-group')->with('flash_message', 'AssignmentGroup updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        AssignmentGroup::destroy($id);

        return redirect('admin/assignment-group')->with('flash_message', 'AssignmentGroup deleted!');
    }
}
