<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertisement;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\User\SendFirebaseNotification;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class NotificationController extends Controller
{
    use MediaTrait;

    public function index()
    {
        return view('admin.notifications.index');
    }

    public function dataTable()
    {
        $items = Notification::query();

        return Datatables::of($items)
            ->editColumn('created_at', function ($item) {
                return $item->created_at_ymd_hia;
            })->editColumn('notifiable.name', function ($item) {
                return $item->notifiable->name;
            })->addColumn('title', function ($item) {
                if ($item->data) {
                    $dataInArray = json_decode($item->data, true);
                    if (isset($dataInArray['title'])) {
                        return $dataInArray['title'];
                    } else {
                        return '-';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('message', function ($item) {
                if ($item->data) {
                    $dataInArray = json_decode($item->data, true);
                    if (isset($dataInArray['message'])) {
                        return $dataInArray['message'];
                    } else {
                        return '-';
                    }
                } else {
                    return '-';
                }
            })
            ->rawColumns(['title', 'message'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'users' => 'required_if:all,false',
        ]);


        if ($request->get('all')) {
            $users = User::all();
            FacadesNotification::send($users, new SendFirebaseNotification($request->title, $request->description, 'From Admin', null));
        } else {
            $users = User::whereIn('id', $request->users)->get();
            FacadesNotification::send($users, new SendFirebaseNotification($request->title, $request->description, 'From Admin', null));
        }

        Session::flash("success", "Notification successfully created.");

        return redirect()->back();
    }
}
