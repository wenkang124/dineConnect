<?php

namespace App\Http\Controllers\Admin;

use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\MerchantPdfMenu;
use App\Traits\MediaTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class MerchantPdfMenuController extends Controller
{
    use MediaTrait;

    public function index($merchant_id)
    {
        return view('admin.merchants.pdf_menus.index', compact('merchant_id'));
    }

    public function dataTable($merchant_id)
    {
        $items = MerchantPdfMenu::query()->where('merchant_id', $merchant_id);

        return Datatables::of($items)
            ->editColumn('pdf', function ($item) {
                return '<a href="' . $item->pdf_full_path . '" target="_blank">View PDF</a>';
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at_ymd_hia;
            })
            ->editColumn('active', function ($item) {
                return $item->status_name;
            })
            ->addColumn('actions', function ($item) {
                return '
                            <a href="' . route('admin.merchant_pdf_menus.edit', ['merchant_id' => $item->merchant_id, 'item' => $item]) . '" class="btn btn-xs btn-warning mx-1 my-1"><i class="fa fa-edit"></i></a>
                            <a href="' . route('admin.merchant_pdf_menus.destroy', ['merchant_pdf_menu' => $item]) . '" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this?" data-redirect="' . route('admin.merchant_pdf_menus.index', ['merchant_id' => $item->merchant_id]) . '"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['pdf', 'actions'])
            ->make(true);
    }

    public function create($merchant_id)
    {
        return view('admin.merchants.pdf_menus.create', compact('merchant_id'));
    }

    public function store($merchant_id, Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:pdf',
            'name' => 'required',
            'sequence' => 'required|numeric|min:1',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $merchant = Merchant::where('id', $merchant_id)->first();

            if ($merchant->merchantPdfMenus()->count() >= 1) {
               $merchant->merchantPdfMenus()->get()->each->delete();
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = MerchantPdfMenu::UPLOAD_PATH;
                $prefix_name = MerchantPdfMenu::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $pdf = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }

            $item = new MerchantPdfMenu([
                'name' => $request->get('name'),
                'sequence' => $request->get('sequence'),
                'active' => $request->get('active'),
                'pdf' => $pdf ?? null,
            ]);

            $merchant->merchantPdfMenus()->save($item);

            DB::commit();
            Session::flash("success", "New PDF Menu successfully created.");

            return redirect()->route('admin.merchant_pdf_menus.index', $merchant_id);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. ' . $e->getMessage(),
            ]]);
        }
    }


    public function edit($merchant_id, MerchantPdfMenu $item)
    {
        return view('admin.merchants.pdf_menus.edit', compact('merchant_id', 'item'));
    }

    public function update(MerchantPdfMenu $item, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'sequence' => 'required|numeric|min:1',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'name' => $request->get('name'),
                'sequence' => $request->get('sequence'),
                'active' => $request->get('active'),
            ];

            $item->update($data);

            $item->save();

            DB::commit();
            Session::flash("success", "PDF Menu details successfully updated.");

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to update. ' . $e->getMessage(),
            ]]);
        }
    }

    public function destroy(MerchantPdfMenu $merchantPdfMenu)
    {
        //
        if (empty($merchantPdfMenu)) {
            return response()->json(['success' => false, 'message' => 'PDF Menu not found.']);
        }

        $merchantPdfMenu->delete();

        Session::flash("success", "PDF Menu has been successfully deleted.");

        return response()->json(['success' => true]);
    }
}
