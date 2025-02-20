<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function showSearch(Request $request)
    {
        $customerNameSearch = $request->customerName;
        $customerContactSearch = $request->customer_contact;
        $checkInSearch = $request->checkin_time ? Carbon::parse($request->checkin_time)->format('Y-m-d H:i:s') : null;
        $checkOutSearch = $request->checkout_time ? Carbon::parse($request->checkout_time)->format('Y-m-d H:i:s') : null;

        $bookings = Booking::when($customerNameSearch, function ($query) use ($customerNameSearch) {
            return $query->where('customer_name', 'like', '%' . $customerNameSearch . '%');
        })
            ->when($customerContactSearch, function ($query) use ($customerContactSearch) {
                return $query->where('customer_contact', 'like', '%' . $customerContactSearch . '%');
            })
            ->when($checkInSearch, function ($query) use ($checkInSearch) {
                return $query->where('checkin_time', 'like', '%' . $checkInSearch . '%');
            })
            ->when($checkOutSearch, function ($query) use ($checkOutSearch) {
                return $query->where('checkout_time', 'like', '%' . $checkOutSearch . '%');
            })
            ->paginate(15);

        return view('admin.booking.search', compact('bookings'));
    }
}
