<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">検索画面</h2>
        <hr>
        <div class="search-hotel-name">
            <form action="{{ route('adminHotelSearchResult') }}" method="GET">
                @csrf
                <div class="form-search__items">
                    <input type="search" name="hotel_name" value="" placeholder="ホテル名">
                    <select name="prefecture_id">
                        <option value="">都道府県</option>

                        @foreach(getAllPrefectures() as $p)
                            <option value="{{ $p->prefecture_id }}">{{ $p->prefecture_name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">検索</button>
                </div>
                @error('hotel_name')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </form>
        </div>
        <hr>
    </div>
    @yield('search_results')
@endsection
