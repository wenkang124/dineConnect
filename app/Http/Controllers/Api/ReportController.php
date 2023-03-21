<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Report;
use App\Models\ReportReason;
use App\Models\Review;
use App\Traits\Helpers;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    use Helpers, MediaTrait;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required',
            'report_reason_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $model = app()->make('App\Models\\' . $request->type);

        $report = new Report();
        $report->user_id = Auth::user()->id;
        $report->itemable_type  = $model::class;
        $report->itemable_id   = $request->id;
        $report->remarks = $request->remarks;
        $report->other = $request->other;
        $report->report_reason_id = $request->report_reason_id;
        $report->save();


        return $this->__apiSuccess(
            'Report Successful.',
            $report,
        );
    }

    public function getReportReason(Request $request)
    {
        $lists = ReportReason::active()->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $lists,
        );
    }
}
