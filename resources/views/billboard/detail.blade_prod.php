@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Billboard Details</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<style>
  .dz-remove {
    display: inline-block;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #f87171;
    cursor: pointer;
  }
  .dz-remove:hover {
    color: #b91c1c;
  }
</style>

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Billboard Detail
    </h2>
</div>

<!-- BEGIN: Profile Info -->
<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">

        <!-- Billboard Details -->
        <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
            <div class="text-center lg:text-left" id="billboard" data-id="{{ $billboard_detail->id }}">
                <div class="font-bold text-2xl mt-5">Billboard Details</div><br>
                <div class="text-gray-600">Site Number: {{ $billboard_detail->site_number }} </div>
                <div class="text-gray-600">Location: {{ $billboard_detail->location_name }} </div>
                <div class="text-gray-600">District/State: {{ $billboard_detail->district_name }}, {{ $billboard_detail->state_name }} </div>
                <div class="text-gray-600">Council: {{ $billboard_detail->council_abbrv }} - {{ $billboard_detail->council_name }} </div>
                <div class="text-gray-600">GPS Coordinate: {{ $billboard_detail->gps_latitude }}, {{ $billboard_detail->gps_longitude }}</div>
                <div class="text-gray-600">Traffic Volume: {{ $billboard_detail->traffic_volume }} </div>
                <div class="text-gray-600">Billboard Type: {{ $billboard_detail->prefix }} - {{ $billboard_detail->type }} </div>
                <div class="text-gray-600">Size: {{ $billboard_detail->size }} </div>
                <div class="text-gray-600">Status: {{ $billboard_detail->status == 1 ? 'Active' : 'Inactive' }} </div>
                <div class="text-gray-600">Date Registered: {{ $billboard_detail->created_at }} </div>
            </div>
            <br>
            <div class="mt-2 xl:mt-0">
                <a href="{{ route('billboard.download', $billboard_detail->id) }}" class="button bg-theme-9 text-black">Download PDF [INTERNAL]</a>
                <a href="{{ route('billboard.download.client', $billboard_detail->id) }}" class="button bg-theme-12 text-black">Download PDF [CLIENT]</a>
                @php
                    $mapUrl = !empty($billboard_detail->gps_url)
                        ? $billboard_detail->gps_url
                        : "https://www.google.com/maps?q={$billboard_detail->gps_latitude},{$billboard_detail->gps_longitude}";
                @endphp

                <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer" 
                class="button bg-theme-1 text-white">Show on Maps</a>
            </div>
        </div>
    </div>
</div>

<div class="intro-y box px-5 pt-5 mt-5">
    <h2 class="intro-y font-medium text-xl sm:text-2xl">
        Billboard Site Images
    </h2>
    @php
        $imageBasePath = '/home/bluedale2/public_html/bgocoutdoor.bluedale.com.my/images/billboards/';
        $image1Path = $imageBasePath . $billboard_detail->site_number . '_1.png';
        $image2Path = $imageBasePath . $billboard_detail->site_number . '_2.png';

        $image1Exists = file_exists($image1Path);
        $image2Exists = file_exists($image2Path);
    @endphp

    <div class="intro-y mt-6">
        <div class="flex gap-4">
            <!-- Image 1 Slot -->
            <div class="flex-1 relative group h-48 overflow-hidden rounded-lg shadow bg-gray-100">
                @if($image1Exists)
                    <button 
                        onclick="deleteImage('{{ $billboard_detail->site_number }}_1.png', this)" 
                        class="absolute top-2 right-2 text-white bg-theme-6 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                        X
                    </button>
                    <img src="{{ url('images/billboards/' . $billboard_detail->site_number . '_1.png') }}?v={{ time() }}" 
                        alt="{{ $billboard_detail->location_name }}" 
                        class="w-full h-full object-cover">
                @endif
            </div>

            <!-- Image 2 Slot -->
            <div class="flex-1 relative group h-48 overflow-hidden rounded-lg shadow bg-gray-100">
                @if($image2Exists)
                    <button 
                        onclick="deleteImage('{{ $billboard_detail->site_number }}_2.png', this)" 
                        class="absolute top-2 right-2 text-white bg-theme-6 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                        X
                    </button>
                    <img src="{{ url('images/billboards/' . $billboard_detail->site_number . '_2.png') }}?v={{ time() }}" 
                        alt="{{ $billboard_detail->location_name }}" 
                        class="w-full h-full object-cover">
                @endif
            </div>
        </div>
    </div>

    <div class="intro-y mt-5 pt-5 border-t border-gray-200 dark:border-dark-5">
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5" id="fileUpload">
            <div class="mt-5">
                <div class="mt-3">
                    <div class="flex items-center">
                        <label class="font-medium">Upload Image</label>
                    </div>
                    <form id="fileUploadForm" action="{{ route('billboard.uploadImage') }}" method="POST" enctype="multipart/form-data" class="dropzone border-gray-200 border-dashed">
                        @csrf
                        <input type="hidden" name="site_number" value="{{ $billboard_detail->site_number }}">
                        <div class="fallback">
                            <input name="files[]" id="fileInput" type="file" multiple />
                        </div>
                        <div class="dz-message" data-dz-message>
                            <div class="text-lg font-medium">Drop files here or click to upload.</div>
                            <div class="text-gray-600">Only 2 images per site are allowed.</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection('app_content')

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    Dropzone.options.fileUploadForm = {
        paramName: "file",
        maxFiles: 2,
        acceptedFiles: 'image/*',
        maxFilesize: 10,
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        dictMaxFilesExceeded: "You can only upload 2 images per site.",

        init: function () {
            let dz = this;

            let existingImages = [
                @if($image1Exists)
                    { name: "{{ $billboard_detail->site_number }}_1.png", url: "{{ url('images/billboards/' . $billboard_detail->site_number . '_1.png') }}" },
                @endif
                @if($image2Exists)
                    { name: "{{ $billboard_detail->site_number }}_2.png", url: "{{ url('images/billboards/' . $billboard_detail->site_number . '_2.png') }}" }
                @endif
            ];

            existingImages.forEach(function(file) {
                dz.emit("addedfile", file);
                dz.emit("thumbnail", file, file.url);
                dz.emit("complete", file);
            });

            dz.options.maxFiles = dz.options.maxFiles - existingImages.length;

            dz.on("removedfile", function(file) {
                if (file.name) {
                    axios.post("{{ route('billboard.deleteImage') }}", {
                        filename: file.name,
                        _token: "{{ csrf_token() }}"
                    })
                    .then(response => {
                        alert(response.data.message);
                        dz.options.maxFiles++; 
                        window.location.reload();
                    })
                    .catch(error => {
                        alert(error.response?.data?.message || "Failed to delete image");
                    });
                }
            });
        },

        sending: function(file, xhr, formData) {
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("site_number", "{{ $billboard_detail->site_number }}");
        },

        success: function(file, response) {
            alert(response.message);

            // Update image directly without full reload
            let imgSelector = `img[src*='${response.filename.split('.')[0]}']`;
            let img = document.querySelector(imgSelector);

            if (img) {
                img.src = response.url; // already has ?v=timestamp
            } else {
                window.location.reload(); // fallback
            }
        },

        error: function(file, response) {
            console.error("❌ Dropzone error:", response);
            this.removeFile(file);
        }
    };

    function deleteImage(filename, button) {
        if(!confirm('Are you sure you want to delete this image?')) return;

        fetch('{{ route("billboard.deleteImage") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ filename: filename })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            window.location.reload();
        })
        .catch(err => {
            console.error(err);
            alert('Error deleting image.');
        });
    }
</script>
@endsection
