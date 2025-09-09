@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Billboard Details</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('modal_content')
<!-- Create Modal -->
    <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
        <div class="modal" id="addBillboardBookingModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Add New Billboard Booking</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Site Number</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="SEL-0001" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Location</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="LDP Taman Mayang 1" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>District</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="Petaling Jaya" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="Selangor" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Client</label>
                            <select id="ServiceRequestAddClient" class="input w-full border mt-2 select2-client" required>
                                <option disabled selected hidden value="">Select a client</option>
                                <option value="1">ABC Corporation</option>
                                <option value="2">BlueTech Solutions</option>
                                <option value="3">GreenField Ltd</option>
                                <option value="4">Visionary Co</option>
                                <option value="5">Skyline Advertising</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="text" id="start_date" class="input border mt-2" placeholder="Select start date">
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="text" id="end_date" class="input border mt-2" placeholder="Select end date">
                        </div>
                    </div>

                    <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="ServiceRequestAddButton">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <!-- Modal End -->
@endsection('modal_content')

@section('app_content')

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
            <!-- <div class="mt-2 xl:mt-0">
                <button type="button" class="button w-full sm:w-32 bg-theme-32 text-white" id="billboardBookingForm">Download</button>
            </div> -->
            <div class="mt-2 xl:mt-0">
                <a href="{{ route('billboard.download', $billboard_detail->id) }}" class="button bg-theme-9 text-white">Download PDF</a>
            </div>

            <!-- <div class="text-center"> 
                <a href="javascript:;" data-toggle="modal" data-target="#addBillboardBookingModal" class="button w-full sm:w-32 bg-theme-32 text-white">
                    Add New Billboard Booking
                </a> 
            </div>  -->
        </div>
    </div>
</div>


<div class="intro-y box px-5 pt-5 mt-5">
    <!-- BEGIN: Blog Layout -->
    <h2 class="intro-y font-medium text-xl sm:text-2xl">
        Billboard Site Images
    </h2>
    <!-- <div class="intro-y text-gray-700 dark:text-gray-600 mt-3 text-xs sm:text-sm"> {{ $billboard_detail->created_at }} </div> -->
    <div class="intro-y mt-6">
        <div class="flex gap-4">
            <div class="flex-1">
                <img src="{{ asset('images/billboards/' . $billboard_detail->site_number . '_1.png') }}"
                    alt="{{ $billboard_detail->location_name }}"
                    class="w-full h-auto object-contain rounded-lg shadow">
            </div>
            <div class="flex-1">
                <img src="{{ asset('images/billboards/' . $billboard_detail->site_number . '_2.png') }}"
                    alt="{{ $billboard_detail->location_name }}"
                    class="w-full h-auto object-contain rounded-lg shadow">
            </div>
        </div>
    </div>




    <!-- <div class="intro-y flex relative pt-16 sm:pt-6 items-center pb-6">
    </div> -->
    <div class="intro-y flex text-xs sm:text-sm flex-col sm:flex-row items-center mt-5 pt-5 border-t border-gray-200 dark:border-dark-5">
        <div class="flex items-center">
            <!-- <div class="w-12 h-12 flex-none image-fit">
                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-10.jpg">
            </div> -->
            <div class="ml-3 mr-auto">
                <a href="" class="font-medium">Uploaded by:</a>
                <div class="text-gray-600">{{ $billboard_detail->createed_by }}</div>
                <div class="text-gray-600"> {{ $billboard_detail->created_at }} </div>
            </div>
        </div>
    </div>
    <div class="intro-y mt-5 pt-5 border-t border-gray-200 dark:border-dark-5">
        <!-- <div class="text-base sm:text-lg font-medium">2 Responses</div> -->
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5" id="fileUpload">
            <div class="mt-5">
                <div class="mt-3">
                    <div class="flex items-center">
                        <label class="font-medium">Upload Image</label>
                    </div>
                    <form id="fileUploadForm" action="{{ route('tempUpload') }}" method="POST" enctype="multipart/form-data" class="dropzone border-gray-200 border-dashed">
                        @csrf
                        <div class="fallback">
                            <input name="files[]" id="fileInput" type="file" multiple />
                        </div>
                        <div class="dz-message" data-dz-message>
                            <div class="text-lg font-medium">Drop files here or click to upload.</div>
                            <div class="text-gray-600"> This is just a demo dropzone. Selected files are <span class="font-medium">not</span> actually uploaded. </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="news__input relative mt-5">
            <div class="pt-5">
                <div class="px-5 py-3 text-left dark:border-dark-5">
                    <form id="mainForm" action="{{ route('workOrderProfile.create') }}" method="POST">
                        @csrf
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="WOAddButton" required>Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection('app_content')

@section('modal_content')
@endsection('modal_content')


@section('script')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-client').select2({
            placeholder: "Select a client",
            allowClear: true,
            width: '100%'
        });
    });
    
    $(document).ready(function() {
        // Global variables
        var lastClickedLink;
        let startPicker = null;
        let endPicker = null;

        document.getElementById("ServiceRequestAddButton").addEventListener("click", ServiceRequestAddButton);

        // Init Flatpickr only once when modal is opened
        $('[data-target="#addBillboardBookingModal"]').on('click', function () {
            setTimeout(() => {
                if (!startPicker) {
                    startPicker = flatpickr("#start_date", {
                        dateFormat: "Y-m-d",
                        onChange: function (selectedDates, dateStr) {
                            if (endPicker) {
                                endPicker.set('minDate', dateStr);
                            }
                        }
                    });
                }

                if (!endPicker) {
                    endPicker = flatpickr("#end_date", {
                        dateFormat: "Y-m-d"
                    });
                }
            }, 200); // slight delay after modal opens
        });

        // Listen to below buttons
        document.getElementById("WOActivityDeleteButton").addEventListener("click", WOActivityDeleteButton);

        // Open modal
        function openAltEditorModal(element) {
            cash(element).modal('show');
        }

        // Close modal
        function closeAltEditorModal(element) {
            cash(element).modal('hide');
        }

 
        $('#filterOnGoingWorkOrderButton').on('click', function() {
            var sort = document.getElementById("inputOnGoingWorkOrderStatus").value;
            var workOrderId = $('#workOrder').data('id');
            filterWorkOrders(sort, workOrderId);
        });
    });

    // Close modal
    function closeAltEditorModal(element) {
        cash(element).modal('hide');
    }

    // Store the ID of the last clicked moda when it's triggered
    (function() {

        document.getElementById('ServiceRequestAddButton').addEventListener('click', function(e) {
            // Prevent the default form submission behavior
            e.preventDefault();
        });

        $(document).on('click', "[data-toggle='modal']", function() {
            lastClickedLink = $(this).attr('id').split("-")[1];
            console.log(lastClickedLink);
        });
    })();

    // Add New Service Request
    function ServiceRequestAddButton() {

        document.getElementById("ServiceRequestAddButton").disabled = true;
        document.getElementById('ServiceRequestAddButton').style.display = 'none';
        client_id: document.getElementById("ServiceRequestAddClient").value,

        $.ajax({
            type: 'POST',
            url: "{{ route('serviceRequest.create') }}",
            data: {
                _token      : $('meta[name="csrf-token"]').attr('content'),
                project     : document.getElementById("ServiceRequestAddProject").value,
                description : document.getElementById("ServiceRequestAddDescription").value,
                remarks     : document.getElementById("ServiceRequestAddClientRemark").value,
                priority    : document.getElementById("ServiceRequestAddPriority").value,
                category    : document.getElementById("ServiceRequestAddCategory").value,
                subcategory : document.getElementById("ServiceRequestAddSubCategory").value,
            },
            success: function(response) {
                // Close modal after successfully edited
                var element = "#addServiceRequestModal";
                closeAltEditorModal(element);

                // Show successful toast
                window.showSubmitToast("Successfully added.", "#91C714");

                // Clean fields
                document.getElementById("ServiceRequestAddProject").value = "";
                document.getElementById("ServiceRequestAddDescription").value = "";
                document.getElementById("ServiceRequestAddClientRemark").value = "";
                document.getElementById("ServiceRequestAddPriority").value = "";
                document.getElementById("ServiceRequestAddCategory").value = "";
                document.getElementById("ServiceRequestAddSubCategory").value = "";

                // Reload table
                $('#service_request_table').DataTable().ajax.reload();
                
                // Reset the button visibility and enable it for next submission
                document.getElementById("ServiceRequestAddButton").disabled = false;
                document.getElementById('ServiceRequestAddButton').style.display = 'inline-block';  // Shows the button again
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


    // Delete Comment
    function WOActivityDeleteButton() {
        var deleteCommentId = lastClickedLink;
        // console.log(lastClickedLink.split("-")[1]);

        $.ajax({
            type: 'POST',
            url: "{{ route('workOrderProfile.deleteComment') }}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                delete_comment_id: deleteCommentId
            },
            success: function (response) {
                // Close modal after successfully deleted
                var element = "#WOActivityDeleteModal";
                closeAltEditorModal(element);

                // Show successful toast
                window.showSubmitToast("Successfully deleted.", "#91C714");

                // Reload the specific table using Ajax
                $('#WOActivityList').load(window.location.href + ' #WOActivityList');

                // Reload the entire page
                // location.reload();
            },
            error: function (xhr, status, error) {
                // Display the validation error message
                var response = JSON.parse(xhr.responseText);
                var error = "Error: " + response.error;

                // Show fail toast
                window.showSubmitToast(error, "#D32929");
            }
        });
    }

</script>
@endsection