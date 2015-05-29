<?php namespace App\Http\Controllers\Admin;

use App\Commands\Admin\SyncStudentDataCenterToLocal;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class SyncStudentDataController extends Controller {
    
    public function index()
    {
        $title = trans('sync-student-data.title');

        return view('admin.sync-student-data.index', compact('title'));
    }
    
    public function execute(Requests\Admin\SyncStudentDataRequest $request)
    {
        switch ($request->input('sync_type'))
        {
            case 'local_to_center_all_override':
                break;
            case 'local_to_center_specific':
                break;
            case 'center_to_local_all':
                //Queue::push(new SyncStudentDataCenterToLocal(false, false, null));
                break;
            case 'center_to_local_all_override':
                Queue::push(new SyncStudentDataCenterToLocal(true, false, null));
                break;
            case 'center_to_local_specific':
                Queue::push(new SyncStudentDataCenterToLocal(true, true, $request->input('center_to_local_specific_username')));
                //$this->dispatch(new SyncStudentDataCenterToLocal(true, true, $request->input('center_to_local_specific_username')));
                break;
        }

        flash()->info(trans('sync-student-data.queue.success'));

        return redirect()->route('admin.sync-student-data.index');
    }

}