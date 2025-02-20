@extends('common.admin.base')
<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <div class="search-result">
            <h2 class="title">予約情報検索</h2>
            <hr>
            <form action="{{ route('adminBookingSearchPage') }}" class="form-search__bookings" method="GET" style="padding: 10px 0;">
                <div class="form-search__items">
                    <input type="search" name="customer_name" value="{{ request('customer_name') }}" placeholder="顧客名">
                    <input type="search" name="customer_contact" value="{{ request('customer_contact') }}" placeholder="顧客連絡先">
                    <input type="datetime-local" name="checkin_time" value="{{ request('checkin_time') }}" placeholder="チェックイン日時">
                    <input type="datetime-local" name="checkout_time" value="{{ request('checkout_time') }}" placeholder="チェックアウト日時">

                    <button type="submit">検索</button>
                </div>
                @error('hotel_name')
                <small class="error-message">{{ $message }}</small>
                @enderror
            </form>

            <hr>

            @if(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @elseif(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif
            @if ($bookings->count())
                <table class="shopsearchlist_table">
                    <tbody>
                    <tr>
                        <td nowrap="" id="booking_name">
                            顧客名
                        </td>
                        <td nowrap="" id="pref">
                            顧客連絡先
                        </td>
                        <td nowrap="" id="created_at">
                            チェックイン日時
                        </td>
                        <td nowrap="" id="updated_at">
                            チェックアウト日時
                        </td>
                        <td nowrap="" id="updated_at">
                            予約日時
                        </td>
                        <td nowrap="" id="updated_at">
                            情報更新日時
                        </td>
                    </tr>
                    @foreach($bookings as $booking)
                        <tr style="background-color:#BDF1FF">
                            <td>
                                <a href="" target="_blank">{{ $booking->customer_name }}</a>
                            </td>
                            <td>
                                {{ $booking->customer_contact }}
                            </td>
                            <td>
                                {{ $booking->checkin_time ? \Carbon\Carbon::parse($booking->checkin_time)->format('Y-m-d H:i:s') : '' }}
                            </td>
                            <td>
                                {{ $booking->checkout_time ? \Carbon\Carbon::parse($booking->checkout_time)->format('Y-m-d H:i:s') : '' }}
                            </td>
                            <td>
                                {{ $booking->created_at ? \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d H:i:s') : '' }}
                            </td>
                            <td>
                                {{ $booking->updated_at ? \Carbon\Carbon::parse($booking->updated_at)->format('Y-m-d H:i:s') : '' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $bookings->links() }}
            @else
                <p>検索結果がありません</p>
            @endif
        </div>
    </div>
@endsection
