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
        <hr>
        <div class="search-hotel-name">
{{--                Step 1 show data edit --}}
            <form id="step-1" action="{{ route('adminHotelEditProcess') }}" method="POST" enctype="multipart/form-data">
                <h2 class="title label-step-1">ホテル情報を編集する</h2>
                @csrf
                @method('PUT')

                @if(session('error'))
                    <p class="error-message">{{ session('error') }}</p>
                @elseif(session('success'))
                    <p class="success-message">{{ session('success') }}</p>
                @endif

                @error('hotel_id')
                <p class="error-message">{{ $message }}</p>
                @enderror

                <input type="hidden" name="hotel_id" value="{{ $hotel?->hotel_id }}">
                <div class="form-group">
                    <label for="hotel_name">ホテル名</label>
                    <input type="text" name="hotel_name" id="hotel_name" value="{{ $hotel?->hotel_name }}"
                           placeholder="ホテル名" class="form-control">
                    @error('hotel_name')
                    <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prefecture_id">都道府県</label>
                    <select name="prefecture_id" id="prefecture_id" class="form-control">
                        <option value="">都道府県</option>
                        @foreach(getAllPrefectures() as $p)
                            <option
                                value="{{ $p->prefecture_id }}" {{ $hotel?->prefecture_id === $p->prefecture_id ? 'selected' : '' }}>
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
                    <input type="hidden" id="image-inpt-text" name="file_path" value="{{ $hotel?->file_path }}" alt="Hotel Image">
                    <div class="d-flex">
                        <input type="file" id="image" name="image">
                        <button id="btnRemoveImage" type="button" class="{{ !$hotel?->file_path ? 'd-none' : '' }}">Delete File </button>
                    </div>
                    @error('image')
                    <br>
                    <small class="error-message">{{ $message }}</small>
                    @enderror
                    <div style="margin-top: 10px">
                        <img style="display: {{ !$hotel?->file_path ? 'none' : 'block' }}; width: 200px" id="img-preview" src="{{ $hotel?->file_path ? asset('assets/img/' . $hotel?->file_path) : '' }}">
                    </div>
                </div>

                <br>
                <button class="btn btn-primary d-none" type="submit" id="btn-submit">検索</button>
            </form>

{{--               Overview data edit --}}
            <div id="step-2" class="d-none">
                <h2 class="title label-step-2">Confirmation</h2>
                <div>
                    <p class="label-overview">ホテル名</p>
                    <p class="hotel_name overview"></p>
                </div>
                <div>
                    <p class="label-overview">都道府県</p>
                    <p class="prefecture_name overview"></p>
                </div>
                <div>
                    <p class="label-overview">画像</p>
                    <img style="width: 200px; display: none" id="img-overview" alt="Hotel Image">
                </div>
            </div>

{{--            button action --}}
            <div class="d-flex">
                <button class="btn btn-primary" type="button" id="btn-next-step">Confirm</button>
                <button class="btn btn-primary d-none" type="button" id="btn-prev-step">Continue Edit</button>
                <button class="btn btn-primary d-none" type="button" id="btn-submit-fake">Submit</button>
            </div>
        </div>
        <hr>
    </div>
@endsection

@section('page_js')
    <script>
        const btnSubmit = document.querySelector('button#btn-submit');
        const btnSubmitFake = document.querySelector('button#btn-submit-fake');
        const btnNextStep = document.querySelector('button#btn-next-step');
        const btnPrevStep = document.querySelector('button#btn-prev-step');
        const stepEditEl = document.querySelector('#step-1');
        const stepOverviewEl = document.querySelector('#step-2');

        btnNextStep.addEventListener('click', nextStepOverview)
        btnPrevStep.addEventListener('click', prevStepOverview)
        btnSubmitFake.addEventListener('click', triggerSubmitForm)

        // function handle next to step overview
        function nextStepOverview() {
            // show content step 2 , hide step 1
            stepOverviewEl.style.display = 'block';
            stepEditEl.style.display = 'none';
            // show btn prev, hide btn next step
            btnNextStep.style.display = 'none';
            btnPrevStep.style.display = 'block';
            // show btn submit
            btnSubmitFake.style.display = 'block';

            // get input data
            const hotelNameInpt = document.querySelector('input[name=hotel_name]').value;
            const prefectureInpt = document.querySelector('select[name=prefecture_id]');
            let imgInpt = document.querySelector('#image-inpt-text')?.value;
            const selectedPrefectureOption = prefectureInpt.options[prefectureInpt.selectedIndex]?.text;

            // fill current data edit to preview block
            document.querySelector('p.hotel_name.overview').innerText = hotelNameInpt;
            document.querySelector('p.prefecture_name.overview').innerText = selectedPrefectureOption;
            console.log(imgInpt)
            if(imgInpt){
                document.querySelector('img#img-overview').style.display = 'block';
                document.querySelector('img#img-overview').src = imgInpt;
            }else{
                document.querySelector('img#img-overview').style.display = 'none';
            }
        }

        // function handle prev to step edit
        function prevStepOverview() {
            // show content step 2 , hide step 1
            stepOverviewEl.style.display = 'none';
            stepEditEl.style.display = 'block';
            // show btn prev, hide btn next step
            btnNextStep.style.display = 'block';
            btnPrevStep.style.display = 'none';
            btnSubmitFake.style.display = 'none';
        }

        function triggerSubmitForm() {
            btnSubmit.click();
        }
    </script>

    <script>
        const img = document.querySelector('#img-preview');
        const imgFile = document.querySelector('input[name=image]');
        let btnRemove = document.querySelector('button#btnRemoveImage');

        imgFile.addEventListener('change', (event) => previewImg(event, img));
        btnRemove.addEventListener('click',  removeImage);

        // preview image upload
        function previewImg(event, elPreview) {
            let file = event.target.files[0];

            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    elPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
                elPreview.style.display = "block";
            }
        }

        // delete image
        function removeImage() {
            console.log('delete img')
            let inputFile = document.querySelector('input[name=image]');
            let inputFileHide = document.querySelector('#image-inpt-text');
            let elPreview = document.getElementById('img-preview');

            inputFileHide.value = '';
            inputFile.value = '';
            elPreview.src = '';
            elPreview.style.display = "none";
            btnRemove.style.display = "none";
            document.querySelector('img#img-overview').style.display = 'none'; // hide img preview
        }
    </script>
@endsection
