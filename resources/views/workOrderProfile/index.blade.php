@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Billboard Details</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Billboard Detail
    </h2>
</div>

<!-- BEGIN: Profile Info -->
<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
        <!-- Service Request Info -->
        <!-- <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="text-center lg:text-left">
                <div class="font-bold text-2xl mt-5">Service Request Details</div>
                <div class="text-gray-600">Service Request No: {{ $open_WO_DetailId->service_request_no }}</div>
                <div class="text-gray-600">Category: {{ $open_WO_DetailId->sr_category_name }} > {{ $open_WO_DetailId->sr_sub_category_name }}</div>
                <div class="text-gray-600">Location: {{ $open_WO_DetailId->service_request_location }}</div>
                <div class="text-gray-600">Status: {{ $open_WO_DetailId->service_request_status }}</div>
            </div>
        </div> -->

        <!-- Work Order Details -->
        <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
            <div class="text-center lg:text-left" id="workOrder" data-id="{{ $open_WO_DetailId->id }}">
                <div class="font-bold text-2xl mt-5">Billboard Details</div>
                <div class="text-gray-600">Site: KL </div>
                <div class="text-gray-600">Road Name: Cheras </div>
                <div class="text-gray-600">GPS Coordinate: 3.138972, 101.721345 - show map</div>
                <div class="text-gray-600">Status: Active </div>
                <div class="text-gray-600">Date Registered: 12/12/2024 </div>
            </div>
        </div>
    </div>
</div>


<div class="intro-y box px-5 pt-5 mt-5">
    <!-- BEGIN: Blog Layout -->
    <h2 class="intro-y font-medium text-xl sm:text-2xl">
        Billboard Site Images
    </h2>
    <!-- <div class="intro-y text-gray-700 dark:text-gray-600 mt-3 text-xs sm:text-sm"> {{ $open_WO_DetailId->created_dt }} </div> -->
        <div class="intro-y mt-6">
            <!-- <div class="news__preview image-fit"> -->
                <img src="{{ asset('images/bluedale_logo_1.png') }}" class="w-[70px] h-auto object-contain mx-auto">
                <img src="{{ asset('images/bluedale_logo_2.png') }}" class="w-[70px] h-auto object-contain mx-auto">
                <img src="{{ asset('images/bluedale_logo_3.png') }}" class="w-[70px] h-auto object-contain mx-auto">
                <img src="{{ asset('images/bluedale_logo_1.png') }}" class="w-[70px] h-auto object-contain mx-auto">
                <img src="{{ asset('images/bluedale_logo_2.png') }}" class="w-[70px] h-auto object-contain mx-auto">
            <!-- </div> -->
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
                <div class="text-gray-600">{{ $open_WO_DetailId->raise_by }}</div>
                <div class="text-gray-600"> {{ $open_WO_DetailId->created_dt }} </div>
            </div>
        </div>
    </div>
    <!-- END: Blog Layout -->
    <!-- BEGIN: Comments -->
    <div class="intro-y mt-5 pt-5 border-t border-gray-200 dark:border-dark-5">
        <!-- <div class="text-base sm:text-lg font-medium">2 Responses</div> -->

        @if($open_WO_DetailId->status != 'COMPLETED')
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
        @endif
    </div>



    <div class="intro-y mt-5 pb-10" id="WOActivityList">
        @foreach($woActivities as $woActivity)
        <div class="mt-5 pt-5 border-t border-gray-200 dark:border-dark-5">
            <div class="flex">
                <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit">
                    <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-4.jpg">
                </div>
                <div class="ml-3 flex-1">
                    <div class="intro-y text-gray-700 dark:text-gray-600 mt-3 text-xs sm:text-sm">
                        <a href="" class="font-medium">{{ $woActivity->name }} </a>
                        <div class="text-gray-600 text-xs sm:text-sm"> {{ $woActivity->created_dt }}</div>
                    </div>
                    
                    <div class="mt-2">{{ $woActivity->comments }}</div>
                    
                    <!-- Attachments Section -->
                    @if($woActivity->attachments->isNotEmpty())
                    <div class="mt-3">
                        <strong>Attachments:</strong>
                        <ul class="list-disc pl-5">
                            @foreach($woActivity->attachments as $attachment)
                            @php
                                $filename = basename($attachment->url);
                            @endphp
                            <li><a href="{{ asset($attachment->url) }}" style="color: blue;" download>{{ $filename }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="intro-y text-gray-700 dark:text-gray-600 mt-3 text-xs sm:text-sm">
                        <a class="font-medium" href="">Edit </a><span class="mx-1">•</span> 
                        <a class="font-medium" href="javascript:;" data-toggle="modal" data-target="#WOActivityDeleteModal" id="delete-{{ $woActivity->comment_id }}">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- END: Comments -->
</div>

@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Vendor Delete Modal -->
<div class="modal" id="WOActivityDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the comment? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <!-- <button type="button" class="button w-24 bg-theme-6 text-white" id="WOActivityDeleteButton">Delete</button> -->
            <button type="button" class="button w-24 bg-theme-6 text-white" id="WOActivityDeleteButton" onclick="WOActivityDeleteButton()">Delete</button>
        </div>
    </div>
</div>
<!-- END: Vendor Delete Modal -->
@endsection('modal_content')


@section('script')
<script>
    
    $(document).ready(function() {
        // Global variables
        var lastClickedLink;

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

        function filterWorkOrders(sort, workOrderId) {
            $.ajax({
                url: "{{ route('workOrderProfile.index', ['id'=>':workOrderId'] ) }}",
                method: 'GET',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    filter: sort,
                    id: workOrderId,
                },
                success: function(response) {

                    var activityList = $(response).find('#WOActivityList').html();
                    $('#WOActivityList').html(activityList);
                    console.log(activityList);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        document.getElementById('WOAddButton').addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default form submission

            var id = "{{ $open_WO_DetailId->id }}";
            var comment = document.getElementById("WOAddComment").value;
            var formData = new FormData();
            
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('id', "{{ $open_WO_DetailId->id }}");
            formData.append('comment', comment);

            $.ajax({
                type: 'POST',
                url: "{{ route('workOrderProfile.create') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    window.showSubmitToast("Successfully added.", "#91C714");
                    document.getElementById("WOAddComment").value = "";
                    // document.getElementById('fileInput').value = "";
                    $('#fileUpload').load(window.location.href + ' #fileUpload > *');
                    $('#WOActivityList').load(window.location.href + ' #WOActivityList');
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    var error = "Error: " + response.error;
                    window.showSubmitToast(error, "#D32929");
                }
            });
        });


    });

    // Close modal
    function closeAltEditorModal(element) {
        cash(element).modal('hide');
    }

    // Store the ID of the last clicked moda when it's triggered
    (function() {
        $(document).on('click', "[data-toggle='modal']", function() {
            lastClickedLink = $(this).attr('id').split("-")[1];
            console.log(lastClickedLink);
        });
    })();


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
@endsection('script')