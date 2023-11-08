<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\FeatureCategory;
use App\Models\Merchant;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;
use Image;

class FeatureController extends Controller
{
    use MediaTrait;
    
    public function index()
    {
        return view('admin.features.index');
    }

    public function dataTable()
    {
        $items = FeatureCategory::query();

        return Datatables::of($items)
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->addColumn('actions', function ($item) {
                    return '<a href="'.route('admin.features.show', [$item]).'" class="btn btn-xs btn-primary mx-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.features.edit', [$item]).'" class="btn btn-xs btn-warning mx-1"><i class="fa fa-edit"></i></a>
                            <a href="'.route('admin.features.destroy', ['feature_category'=>$item]).'" class="btn btn-xs btn-danger mx-1 delete-btn" data-confirm="Are you sure you want to delete this mood?" data-redirect="'.route('admin.features.index').'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
    }

    public function show(FeatureCategory $item) {
        $merchants = Merchant::where('active', 1)->get();
        return view('admin.features.show', compact('item', 'merchants'));
    }

    public function create() {
        $merchants = Merchant::where('active', 1)->get();
        return view('admin.features.create', compact('merchants'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'sequence' => 'required|numeric',
            'active' => 'required|numeric',
            'merchants' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $item = new FeatureCategory();

            $item->name = $request->get('name');
            $item->active = $request->get('active');
            $item->sequence = $request->get('sequence');

            $item->save();

            
            $merchant_ids = [];
            if($request->get('merchants')) {
                foreach($request->get('merchants') as $merchant) {
                    $exist_merchant = Merchant::find($merchant);
                    if($exist_merchant) {
                        $merchant_ids[] = $merchant;
                    }
                }
            }
            $item->merchants()->sync($merchant_ids);

            DB::commit();
            Session::flash("success", "New Feature successfully created.");

            return redirect()->route('admin.features.index');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit(FeatureCategory $item) {
        $merchants = Merchant::where('active', 1)->get();
        return view('admin.features.edit', compact('item', 'merchants'));
    }

    public function update(FeatureCategory $item, Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'sequence' => 'required|numeric',
            'active' => 'required|numeric',
            'merchants' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $item->name = $request->get('name');
            $item->active = $request->get('active');
            $item->sequence = $request->get('sequence');

            $item->save();

            $merchant_ids = [];
            if($request->get('merchants')) {
                foreach($request->get('merchants') as $merchant) {
                    $exist_merchant = Merchant::find($merchant);
                    if($exist_merchant) {
                        $merchant_ids[] = $merchant;
                    }
                }
            }
            $item->merchants()->sync($merchant_ids);

            DB::commit();
            Session::flash("success", "Feature details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to update. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(FeatureCategory $feature_category) {
        //
        if(empty($feature_category)){
            return response()->json(['success' => false, 'message' => 'Feature not found.']);
        }
 
        $feature_category->delete();
 
        Session::flash("success", "Feature has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
