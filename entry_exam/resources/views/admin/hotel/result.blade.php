@extends('admin.hotel.search')

@section('search_results')
    <div class="page-wrapper search-page-wrapper">
        <div class="search-result">
            <h3 class="search-result-title">検索結果</h3>
            @if(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @elseif(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif
            @if (!empty($hotelList))
                <table class="shopsearchlist_table">
                    <tbody>
                    <tr>
                        <td nowrap="" id="hotel_name">
                            ホテル名
                        </td>
                        <td nowrap="" id="pref">
                            都道府県
                        </td>
                        <td nowrap="" id="created_at">
                            登録日
                        </td>
                        <td nowrap="" id="updated_at">
                            更新日
                        </td>
                        <td class="btn_center" id="edit"></td>
                        <td class="btn_center" id="delete"></td>
                    </tr>
                    @foreach($hotelList as $hotel)
                        <tr style="background-color:#BDF1FF">
                            <td>
                                <a href="" target="_blank">{{ $hotel['hotel_name'] }}</a>
                            </td>
                            <td>
                                {{ $hotel['prefecture']['prefecture_name'] }}
                            </td>
                            <td>
                                {{ (string) $hotel['created_at'] }}
                            </td>
                            <td>
                                {{ (string) $hotel['updated_at'] }}
                            </td>
                            <td>
                                <form action="{{ route('adminHotelEditPage', ['hotel_id' => $hotel['hotel_id']]) }}" method="get">
                                    @csrf
                                    <button type="submit">編集</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('adminHotelDeleteProcess', ['hotel_id' => $hotel['hotel_id']]) }}"
                                      method="post">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="hotel_id" value="{{ $hotel['hotel_id'] }}">
                                    <button type="submit" onclick="return confirm('このホテルを削除しますか?')">削除
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>検索結果がありません</p>
            @endif
        </div>
    </div>
@endsection
