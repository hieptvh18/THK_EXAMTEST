<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/save.scss')
    @vite('resources/scss/admin/search.scss')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">新しいホテルを作成する</h2>
        <hr>
        <div class="search-hotel-name">
            @if(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @elseif(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif
            <form action="{{ route('adminHotelCreateProcess') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="hotel_name">ホテル名</label>
                    <input type="text" name="hotel_name" id="hotel_name" value="{{ old('hotel_name') }}" placeholder="ホテル名" class="form-control">
                    @error('hotel_name')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prefecture_id">都道府県</label>
                    <select name="prefecture_id" id="prefecture_id" class="form-control">
                        <option value="">都道府県</option>
                        @foreach(getAllPrefectures() as $p)
                            <option value="{{ $p->prefecture_id }}" {{ old('prefecture_id') && old('prefecture_id') == $p->prefecture_id ? 'selected' : '' }}>
                                {{ $p->prefecture_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('prefecture_id')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">画像 (jpeg, png, jpg)</label>
                    <input type="file" id="image" name="image">
                    @error('image')
                        <br>
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                    <div style="margin-top: 10px">
                        <img style="display: none; width: 200px;" id="img-preview">
                    </div>
                </div>

                <br>
                <button class="btn btn-primary" type="submit">検索</button>
            </form>
        </div>
        <hr>
    </div>
@endsection

@section('page_js')
    <script>
        const img = document.querySelector('#img-preview');
        const imgFile = document.querySelector('input[name=image]');

        imgFile.addEventListener('change', (event) => previewImg(event, img));

        function previewImg(event, elPreview) {
            let file = event.target.files[0];

            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    elPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
                elPreview.style.display = "block"; // Tương đương với jQuery .show()
            }
        }
    </script>
@endsection
