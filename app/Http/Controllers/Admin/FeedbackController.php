<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('admin.feedbacks.index');
    }

    public function dataTable()
    {
        $items = Feedback::query();

        return Datatables::of($items)
                ->addColumn('user_name', function ($item) {
                    return $item->user? $item->user->name : '';
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->make(true);
    }
}
