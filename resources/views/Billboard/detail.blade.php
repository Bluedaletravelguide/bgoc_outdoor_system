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
    color: #f87171; /* red-400 */
    cursor: pointer;
  }
  .dz-remove:hover {
    color: #b91c1c; /* red-700 */
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
                <a href="https://www.google.com/maps?q={{ $billboard_detail->gps_latitude }},{{ $billboard_detail->gps_longitude }}" target="_blank" class="button bg-theme-1 text-white">Show on Maps</a>
                <a href="javascript:void(0)" onclick="populateBillboardEditModal({{ json_encode($billboard_detail) }})" class="button bg-theme-1 text-white">Edit</a>
            </div>
        </div>
    </div>
</div>


<div class="intro-y box px-5 pt-5 mt-5">
    <!-- BEGIN: Blog Layout -->
    <h2 class="intro-y font-medium text-xl sm:text-2xl">
        Billboard Site Images
    </h2>
    @php
        $image1Exists = Storage::exists('public/billboards/' . $billboard_detail->site_number . '_1.png');
        $image2Exists = Storage::exists('public/billboards/' . $billboard_detail->site_number . '_2.png');
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
                    <img src="{{ asset('storage/billboards/' . $billboard_detail->site_number . '_1.png') }}" 
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
                    <img src="{{ asset('storage/billboards/' . $billboard_detail->site_number . '_2.png') }}" 
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

@section('modal_content')
<!-- Edit Billboard Modal -->
<div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
    <div class="modal" id="billboardEditModal">
        <div class="modal__content">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">Edit Stock</h2>
            </div>
            <form>
                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <input type="hidden" id="editBillboardModalId" name="id">
                        <label>Outdoor Type <span style="color: red;">*</span></label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardType" disabled>
                            <option value="">-- Select Outdoor Type --</option>
                            <option value="BB">Billboard</option>
                            <option value="TB">Tempboard</option>
                            <option value="BU">Bunting</option>
                            <option value="BN">Banner</option>
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Billboard Size <span style="color: red;">*</span></label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardSize" required>
                            <option value="">-- Select Size --</option>
                            <option value="15x10">15x10</option>
                            <option value="30x20">30x20</option>
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Lighting <span style="color: red;">*</span></label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardLighting" required>
                            <option value="">-- Select Lighting --</option>
                            <option value="None">None</option>
                            <option value="TNB">TNB</option>
                            <option value="SOLAR">SOLAR</option>
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>State <span style="color: red;">*</span></label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardState"  disabled>
                            <option value="">-- Select State --</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>District <span style="color: red;">*</span></label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardDistrict" disabled>
                            <option value="">-- Select District --</option>
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Council <span style="color: red;">*</span></label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardCouncil" disabled>
                            <option value="">-- Select Council --</option>
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Location <span style="color: red;">*</span></label>
                        <input type="text" class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardLocation" placeholder="Enter location name">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="editGPSCoordinate" class="form-label">GPS Coordinate <span style="color: red;">*</span></label>
                        <input 
                            type="text" 
                            class="input w-full border mt-2 flex-1" 
                            id="editGPSCoordinate" 
                            name="gpsCoordinate"
                            placeholder="e.g. 3.1390, 101.6869" 
                            required
                        >
                        <small class="text-gray-500">Format: latitude, longitude</small>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Traffic Volume</label>
                        <input type="text" class="input w-full border mt-2 flex-1" id="editBillboardTrafficVolume" value="" required>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Site Type</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardSiteType">
                            <option value="">-- Select option --</option>
                            <option value="new">New</option>
                            <option value="existing">Existing</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label>Status</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editBillboardStatus">
                            <option value="">-- Select option --</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                    <button type="submit" class="button w-20 bg-theme-1 text-white" id="billboardEditButton">Submit</button>
                </div>
            </form>
        </div>
    </div> 
</div>
<!-- Edit Modal End -->
@endsection('modal_content')


@section('script')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    Dropzone.options.fileUploadForm = {
        paramName: "file",
        maxFiles: 2,
        acceptedFiles: 'image/*',
        maxFilesize: 10, // allow 10 MB
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        dictMaxFilesExceeded: "You can only upload 2 images per site.",

        init: function () {
            let dz = this;

            let siteNumber = "{{ $billboard_detail->site_number }}";
            let existingImages = [
                @if(Storage::exists('public/billboards/' . $billboard_detail->site_number . '_1.png'))
                    { name: "{{ $billboard_detail->site_number }}_1.png", url: "{{ asset('storage/billboards/' . $billboard_detail->site_number . '_1.png') }}" },
                @endif
                @if(Storage::exists('public/billboards/' . $billboard_detail->site_number . '_2.png'))
                    { name: "{{ $billboard_detail->site_number }}_2.png", url: "{{ asset('storage/billboards/' . $billboard_detail->site_number . '_2.png') }}" }
                @endif
            ];

            existingImages.forEach(function(file) {
                dz.emit("addedfile", file);
                dz.emit("thumbnail", file, file.url);
                dz.emit("complete", file);
            });

            dz.options.maxFiles = dz.options.maxFiles - existingImages.length;

            // Handle remove file
            dz.on("removedfile", function(file) {
                if (file.name) {
                    axios.post("{{ route('billboard.deleteImage') }}", {
                        filename: file.name,
                        _token: "{{ csrf_token() }}"
                    })
                    .then(response => {
                        console.log(response.data.message);
                        dz.options.maxFiles++; // free up a slot
                    })
                    .catch(error => {
                        console.error(error.response.data.message || error);
                        alert(error.response.data.message || "Failed to delete image");
                    });
                }
            });
        },

        sending: function(file, xhr, formData) {
            formData.append("_token", "{{ csrf_token() }}"); // 🔑 Add CSRF
            formData.append("site_number", "{{ $billboard_detail->site_number }}");
        },

        success: function(file, response) {
            alert(data.message);
        },


        error: function(file, response) {
            console.error("❌ Dropzone error:", response);
            // Don’t use dz here, just remove the file safely
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
        .then(response => {
            if(response.ok) return response.json();
            throw new Error('File not found');
        })
        .then(data => {
            button.closest('.flex-1').remove();
            alert(data.message);
            window.location.reload(); // Refresh to update Dropzone state
        })
        .catch(err => {
            console.error(err);
            alert('Error deleting image.');
        });
    }

    // Open modal
    function openAltEditorModal(element) {
        cash(element).modal('show');
    }
    // Close modal
    function closeAltEditorModal(element) {
        cash(element).modal('hide');
    }

    function populateBillboardEditModal(data) {
        // IDs
        let stateID    = data.state_id;
        let districtID = data.district_id;
        let councilID  = data.council_id;

        // Fill form fields
        $('#editBillboardModalId').val(data.id);
        $('#editBillboardType').val(data.prefix);
        $('#editBillboardSize').val(data.size);
        $('#editBillboardLighting').val(data.lighting);
        $('#editGPSCoordinate').val(data.gps_latitude + ', ' + data.gps_longitude);
        $('#editBillboardTrafficVolume').val(data.traffic_volume);
        $('#editBillboardStatus').val(data.status);
        $('#editBillboardSiteType').val(data.site_type);
        $('#editBillboardLocation').val(data.location_name);

        // Populate dependent dropdowns
        $('#editBillboardState').val(stateID).trigger('change');

        // Load Districts
        $.post('{{ route("location.getDistricts") }}', {
            _token: '{{ csrf_token() }}',
            state_id: stateID
        }, function (districts) {
            $('#editBillboardDistrict').empty().append(`<option value="">-- Select District --</option>`);
            districts.forEach(function (d) {
                $('#editBillboardDistrict').append(`<option value="${d.id}">${d.name}</option>`);
            });
            $('#editBillboardDistrict').val(districtID).trigger('change');

            // Load Councils
            $.post('{{ route("location.getCouncils") }}', {
                _token: '{{ csrf_token() }}',
                state_id: stateID
            }, function (councils) {
                $('#editBillboardCouncil').empty().append(`<option value="">-- Select Council --</option>`);
                councils.forEach(function (c) {
                    $('#editBillboardCouncil').append(`<option value="${c.id}">${c.name} (${c.abbreviation})</option>`);
                });
                $('#editBillboardCouncil').val(councilID).trigger('change');
            });
        });

        // Open modal
        openAltEditorModal('#billboardEditModal');
    }

$(document).ready(function () {

    document.getElementById("billboardEditButton").addEventListener("click", function (e) {
        e.preventDefault();
        billboardEditButton();
    });

    function billboardEditButton() {
        console.log("Submitting edit form...");
        // e.preventDefault();

        $.ajax({
            url: '{{ route("billboard.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: $('#editBillboardModalId').val(),
                type: $('#editBillboardType').val(),
                size: $('#editBillboardSize').val(),
                lighting: $('#editBillboardLighting').val(),
                state_id: $('#editBillboardState').val(),
                district_id: $('#editBillboardDistrict').val(),
                council_id: $('#editBillboardCouncil').val(),
                location_name: $('#editBillboardLocation').val(), // 👈 send as name
                gpsCoordinate: $('#editGPSCoordinate').val(),
                traffic_volume: $('#editBillboardTrafficVolume').val(),
                status: $('#editBillboardStatus').val(),
                site_type: $('#editBillboardSiteType').val(),      
            },
            success: function(response) {
                // Close modal after successfully edited
                var element = "#billboardEditModal";
                closeAltEditorModal(element);

                // Show successful toast
                window.showSubmitToast("Successfully added.", "#91C714");

                // Clean fields
                document.getElementById("editBillboardModalId").value = "";
                document.getElementById("editBillboardType").value = "";
                document.getElementById("editBillboardSize").value = "";
                document.getElementById("editBillboardLighting").value = "";
                document.getElementById("editBillboardState").value = "";
                document.getElementById("editBillboardDistrict").value = "";
                document.getElementById("editBillboardCouncil").value = "";
                document.getElementById("editBillboardLocation").value = "";
                document.getElementById("editGPSCoordinate").value = "";
                document.getElementById("editBillboardTrafficVolume").value = "";
                document.getElementById("editBillboardStatus").value = "";
                document.getElementById("editBillboardSiteType").value = "";
                
                
                // Reset the button visibility and enable it for next submission
                document.getElementById("billboardEditButton").disabled = false;
                document.getElementById('billboardEditButton').style.display = 'inline-block';  // Shows the button again
            },
            error: function(xhr, status, error) {
                // Display the validation error message
                var response = JSON.parse(xhr.responseText);
                var error = "Error: " + response.error;

                // Show fail toast
                window.showSubmitToast(error, "#D32929");
            }
        });
    };
});



</script>
@endsection