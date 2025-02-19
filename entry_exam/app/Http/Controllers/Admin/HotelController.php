<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveHotelRequest;
use App\Http\Requests\SearchHotelRequest;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Hotel;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(): View
    {
        return view('admin.hotel.search');
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit($id): View
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return redirect()->route('top');
        }

        return view('admin.hotel.edit', compact('hotel'));
    }

    public function showCreate(): View
    {
        return view('admin.hotel.create');
    }

    /**
     * @param SearchHotelRequest $request
     * @return View
     */
    public function searchResult(SearchHotelRequest $request): View
    {
        $var = [];

        $hotelList = Hotel::getHotelListByCondition($request);

        $var['hotelList'] = $hotelList;

        return view('admin.hotel.result', $var);
    }

    /**
     * @param SaveHotelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(SaveHotelRequest $request)
    {
        try {
            DB::beginTransaction();

            $formData = $request->all();
            $file = $request->file('image');

            // check if exist file upload -> upload to storage & save database
            if ($file) {
                $fileName = 'hotel_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $pathImg = Storage::disk('assets_public')->putFileAs('hotel', $file, $fileName);

                if (!$pathImg) {
                    return redirect()->back()->with('error', 'Upload image error.')->withInput();
                }

                // $fullUrlImg = asset("assets/img" . DIRECTORY_SEPARATOR . $pathImg);
                $formData['file_path'] = $pathImg;
            }

            // create new hotel
            $hotel = Hotel::find($formData['hotel_id']);
            $hotel->fill($formData);
            $hotel->save();

            DB::commit();

            return redirect()->back()->with('success', '正常に更新されました。。');
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error($exception);
            return redirect()->back()->with('error', 'アップデートに失敗しました。');
        }
    }

    /**
     * @param SaveHotelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(SaveHotelRequest $request)
    {
        try {
            DB::beginTransaction();

            $formData = $request->all();
            $file = $request->file('image');

            // check if exist file upload -> upload to storage & save database
            if ($file) {
                $fileName = 'hotel_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $pathImg = Storage::disk('assets_public')->putFileAs('hotel', $file, $fileName);

                if (!$pathImg) {
                    return redirect()->back()->with('error', 'Upload image error.')->withInput();
                }

                // $fullUrlImg = asset("assets/img" . DIRECTORY_SEPARATOR . $pathImg);
                $formData['file_path'] = $pathImg;
            }

            // create new hotel
            Hotel::create($formData);

            DB::commit();

            return redirect()->back()->with('success', '正常に作成されました。');
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error($exception);
            return redirect()->back()->with('error', '失敗を生み出す。');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            Hotel::destroy($id);

            return redirect()->back()->with('success', '正常に削除されました。');
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', '削除に失敗しました。');
        }
    }
}
