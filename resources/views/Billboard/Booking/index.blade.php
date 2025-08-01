@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Billboard Booking</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Billboard Booking
    </h2>
</div>
<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#ECF9FD;">
        <h2 class="text-lg font-medium">
            Billboard Booking
        </h2>
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">Billboard Booking</i> - Lorem Ipsum.
        </p>
    </div>

    <!-- Billboard Booking Calendar Filter -->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
        <form class="xl:flex sm:mr-auto" id="employee_table">
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Client</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardBookingCompany">
                    <option value="">All</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">State</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardBookingState">
                    <option value="" selected="">-- Select State --</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">District</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardBookingDistrict">
                    <option value="" selected="">-- Select State --</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Area</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardBookingLocation">
                    <option value="" selected="">-- Select State --</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Status</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterBillboardBookingStatus">
                    <option value="" selected="">-- Select Status --</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="pending_install">Pending Install</option>
                    <option value="pending_payment">Pending Payment</option>
                </select>
            </div>
        </form> 

        <div class="text-center"> 
            <a href="javascript:;" data-toggle="modal" data-target="#addBillboardBookingModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New Billboard Job Order
            </a> 
        </div> 
    </div>
    <!-- Filter End -->
    
    <!-- Billboard Booking Calendar -->
    <div class="mb-5 p-5 rounded-md border border-dashed border-theme-1">
        <h2 class="text-base font-bold mb-3 text-theme-1">Calendar View</h2>
        <div id="billboard-booking-calendar" class="mb-5"></div>
    </div>

    <div class="mb-5 p-5 rounded-md" style="background-color:#ECF9FD;">
        <h2 class="text-lg font-medium">
            Billboard Booking List
        </h2>
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">Billboard Booking List</i> - Lorem Ipsum.
        </p>
    </div>

    <!-- Service Request table -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table mt-5" id="billboard_booking_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th class="whitespace-nowrap">No.</th>
                    <th class="whitespace-nowrap">Site Number</th>
                    <th class="whitespace-nowrap">Client Name</th>
                    <th class="whitespace-nowrap">Location</th>
                    <th class="whitespace-nowrap">Start Date</th>
                    <th class="whitespace-nowrap">End Date</th> 
                    <th class="whitespace-nowrap">Duration</th>
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Remarks</th>
                    <th class="whitespace-nowrap">Calendar</th>
                    <th class="whitespace-nowrap flex flex-row">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- Table End -->
    <!-- TODO: add logics here to view list of srevice requests for destroy|update|edit included within a modal -->
</div>
@endsection('app_content')

@section('modal_content')
<!-- Create Modal -->
    <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
        <div class="modal" id="addBillboardBookingModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Add New Job Order</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Site Number</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="SEL-0001" disabled>
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
                        <div class="col-span-12 sm:col-span-12">
                            <label>Location</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>District</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" required>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="text" id="start_date" class="input border mt-2" placeholder="Select start date">
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="text" id="end_date" class="input border mt-2" placeholder="Select end date">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Artwork by</label>
                            <select id="ServiceRequestAddClient" class="input w-full border mt-2 select" required>
                                <option disabled selected hidden value="">Select an option</option>
                                <option value="1">Client</option>
                                <option value="2">Bluedale</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>DBP Approval</label>
                            <select id="ServiceRequestAddClient" class="input w-full border mt-2 select" required>
                                <option disabled selected hidden value="">Select an option</option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Remarks</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" required>
                        </div>
                    </div>

                    <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="ServiceRequestAddButton">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
<!-- Create Modal End -->

<!-- View Job Order Modal -->
    <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
        <div class="modal" id="viewBillboardJobOrderModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Job Order Detail</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Site Number</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="SEL-0001" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Client</label>
                            <select id="ServiceRequestAddClient" class="input w-full border mt-2 select2-client" disabled>
                                <option disabled selected hidden value="">Select a client</option>
                                <option value="1">ABC Corporation</option>
                                <option value="2">BlueTech Solutions</option>
                                <option value="3">GreenField Ltd</option>
                                <option value="4">Visionary Co</option>
                                <option value="5">Skyline Advertising</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Location</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>District</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="text" id="start_date" class="input border mt-2" placeholder="Select start date" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="text" id="end_date" class="input border mt-2" placeholder="Select end date" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Artwork by</label>
                            <select id="ServiceRequestAddClient" class="input w-full border mt-2 select" disabled>
                                <option disabled selected hidden value="">Select an option</option>
                                <option value="1">Client</option>
                                <option value="2">Bluedale</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>DBP Approval</label>
                            <select id="ServiceRequestAddClient" class="input w-full border mt-2 select" disabled>
                                <option disabled selected hidden value="">Select an option</option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Remarks</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="ServiceRequestAddDescription" value="" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div> 
    </div>
<!-- View Modal End -->

<!-- BEGIN: Service Request Reject Modal -->
<div class="modal" id="serviceRequestRejectModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm rejecting this service request? This process cannot be undone.</div>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Reject Reason</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Reject Reason" id="serviceRequestRejectReason" required>
                </div>
            </div>

            <!-- <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="serviceRequestEditButton">Update</button>
            </div> -->
        </form>

        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="serviceRequestRejectButton" onclick="serviceRequestRejectButton()">Reject</button>
        </div>
    </div>
</div>
<!-- END: Service Request Reject Modal -->

<!-- BEGIN: Service Request Delete Modal -->
<div class="modal" id="serviceRequestDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm delete this service request? This process cannot be undone.</div>
        </div>

        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="serviceRequestDeleteButton" onclick="serviceRequestDeleteButton()">Delete</button>
        </div>
    </div>
</div>
<!-- END: Service Request Reject Modal -->

<!-- BEGIN: SR Edit Modal -->
<div class="modal" id="serviceRequestEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Service Request</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Description</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Description" id="serviceRequestEditDescription" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Client Remark</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Client Remark" id="serviceRequestEditClientRemark" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="serviceRequestEditButton">Update</button>
            </div>
        </form>
    </div>
</div>
<!-- END: SR Edit Modal -->
@endsection('modal_content')

@section('script')

<!-- FullCalendar v5.11.3 - Includes global `FullCalendar` object -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<!-- searchable dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // const allDistricts = @json($districts);
</script>

<script>
    
    // <!-- BEGIN: Billboard Booking List Filter -->
    $('#filterBillboardBookingState').on('change', function () {
        let stateId = $(this).val();

        const $districtSelect = $('#filterBillboardBookingDistrict');
        const $locationSelect = $('#filterBillboardBookingLocation');

        $districtSelect.empty().append('<option value="">-- Select District --</option>');
        $locationSelect.empty().append('<option value="">-- Select Location --</option>');

        if (stateId === '' || stateId === 'all') {
            // Load all districts if no specific state is selected
            $.ajax({
                url: '{{ route("location.getAllDistricts") }}',
                type: 'GET',
                success: function (districts) {
                    districts.forEach(function (district) {
                        $districtSelect.append(`<option value="${district.id}">${district.name}</option>`);
                    });

                    // ✅ Reload table after loading all districts
                    $('#billboard_booking_table').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Failed to load all districts.');
                }
            });
        } else {
            // Load filtered districts
            $.ajax({
                url: '{{ route("location.getDistricts") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    state_id: stateId
                },
                success: function (districts) {
                    districts.forEach(function (district) {
                        $districtSelect.append(`<option value="${district.id}">${district.name}</option>`);
                    });

                    // ✅ Reload table after loading filtered districts
                    $('#billboard_booking_table').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Failed to load districts.');
                }
            });
        }
    });

    // When "District" is changed in add form
    $('#filterBillboardBookingDistrict').on('change', function () {
        let districtId = $(this).val();

        // Reset Location dropdown
        $('#filterBillboardBookingLocation').empty().append('<option value="">-- Select Location --</option>');

        if (districtId !== '') {
            $.ajax({
                url: '{{ route("location.getLocations") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    district_id: districtId
                },
                success: function (locations) {
                    locations.forEach(function (location) {
                        $('#filterBillboardBookingLocation').append(`<option value="${location.id}">${location.name}</option>`);
                    });

                    // ✅ Reload table after loading filtered districts
                    $('#billboard_booking_table').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Failed to load locations.');
                }
            });
        }
    });
    // <!-- END: Billboard Booking List Filter -->

    function reloadBookingData() {
        // Reload calendar
        if (calendar) {
            calendar.refetchEvents();
        }

        // Reload DataTable
        if ($.fn.DataTable.isDataTable('#billboard_booking_table')) {
            $('#billboard_booking_table').DataTable().ajax.reload();
        }
    }

    // Function to reload the DataTable when any filter changes
    function setupAutoFilter() {
        const tableElement = $('#billboard_booking_table');
        if (!$.fn.DataTable.isDataTable(tableElement)) {
            console.warn("DataTable is not yet initialized.");
            return;
        }

        const table = tableElement.DataTable();

        $('#filterBillboardBookingCompany, #filterBillboardBookingState, #filterBillboardBookingDistrict, #filterBillboardBookingLocation, #filterBillboardBookingStatus').on('change', function () {
            table.ajax.reload();
        });
    }

    $(document).ready(function() {
        $('.select2-client').select2({
            placeholder: "Select a client",
            allowClear: true,
            width: '100%'
        });
    });
    	
    $(document).ready(function() {

        // Global variables
        var filterBillboardBookingCompany;
        var filterBillboardBookingState;
        var filterBillboardBookingDistrict;
        var filterBillboardBookingLocation;
        var filterBillboardBookingStatus;


        var filterServiceRequestStatus;
        var originalServiceRequestId;
        var lastClickedLink;
        let startPicker = null;
        let endPicker = null;

        // Listen to below buttons
        document.getElementById("serviceRequestRejectButton").addEventListener("click", serviceRequestRejectButton);
        document.getElementById("serviceRequestDeleteButton").addEventListener("click", serviceRequestDeleteButton);
        document.getElementById("ServiceRequestAddButton").addEventListener("click", ServiceRequestAddButton);
        // document.getElementById("openWorkOrderDetailButton").addEventListener("click", openWorkOrderDetail);

        

        // Billboard Booking Calendar
        let calendar = null;

        function initBookingCalendar() {
            let calendarEl = document.getElementById('billboard-booking-calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 600,
                events: function(fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '{{ route("billboard.booking.calendar") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            company: $('#filterBillboardBookingCompany').val(),
                            state: $('#filterBillboardBookingState').val(),
                            district: $('#filterBillboardBookingDistrict').val(),
                            location: $('#filterBillboardBookingLocation').val(),
                            status: $('#filterBillboardBookingStatus').val(),
                            start: fetchInfo.startStr,
                            end: fetchInfo.endStr
                        },
                        success: function(response) {
                            successCallback(response);
                        },
                        error: function() {
                            failureCallback();
                        }
                    });
                }
            });

            calendar.render();
        }

        initBookingCalendar();

        // $('#filterBookingCalendarState').on('change', handleBookingFilterChange);
        // $('#filterBookingCalendarDistrict').on('change', handleDistrictChange);
        // $('#filterBookingCalendarLocation').on('change', reloadBookingData);


        $('#filterBillboardBookingCompany, #filterBillboardBookingState, #filterBillboardBookingDistrict, #filterBillboardBookingLocation, #filterBillboardBookingStatus').on('change', function () {
            if (calendar) {
                calendar.refetchEvents(); // reload calendar bookings with new filter
            }
        });


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

        // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();

        $(document).ready(function() {
            $('#ServiceRequestAddCategory').on('change', function() {
                var sr_category_id = $(this).val();
                if(sr_category_id) {
                    $.ajax({
                        url: '/get-subcategories/'+sr_category_id,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('#ServiceRequestAddSubCategory').empty();
                            $('#ServiceRequestAddSubCategory').append('<option disabled selected hidden value>Select a sub category</option>');
                            $.each(data, function(key, value) {
                                $('#ServiceRequestAddSubCategory').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }
                    });
                } else {
                    $('#ServiceRequestAddSubCategory').empty();
                    $('#ServiceRequestAddSubCategory').append('<option disabled selected hidden value>Select a category first</option>');
                }
            });
        });

        // When any submit button is clicked
        (function() {
            var billboard_booking_table = $('#billboard_booking_table')[0].altEditor;

            document.getElementById('ServiceRequestAddButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('serviceRequestRejectButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('serviceRequestDeleteButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('serviceRequestEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit SR
                editServiceRequest();
            });
        })();

        // Open modal
        function openAltEditorModal(element) {
            cash(element).modal('show');
        }
        // Close modal
        function closeAltEditorModal(element) {
            cash(element).modal('hide');
        }

        // Edit SR 
        function editServiceRequest() {
            var description = document.getElementById("serviceRequestEditDescription").value;
            var client_remark = document.getElementById("serviceRequestEditClientRemark").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('serviceRequest.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    desc: description,
                    client_remark: client_remark,
                    id: originalServiceRequestId,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#serviceRequestEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully updated.", "#91C714");

                    // Clean fields
                    document.getElementById("serviceRequestEditDescription").value = "";
                    document.getElementById("serviceRequestEditClientRemark").value = "";

                    // Reload table
                    $('#billboard_booking_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response = JSON.parse(xhr.responseText);
                    var error = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        }
    
        // Setup the in-house users datatable
        function initBillboardBookingDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Billboard_Booking_List_${formattedDate}_${formattedTime}`;

            const table = $('#billboard_booking_table').DataTable({
                altEditor: true,
                destroy: true,
                debug: true,
                processing: true,
                searching: true,
                serverSide: true,
                ordering: true,
                order: [
                    [0, 'desc']
                ],
                pagingType: 'full_numbers',
                pageLength: 25,
                aLengthMenu: [
                    [25, 50, 75, -1],
                    [25, 50, 75, "All"]
                ],
                iDisplayLength: 25,
                ajax: {
                    url: "{{ route('billboard.booking.list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token    = $('meta[name="csrf-token"]').attr('content');
                        d.company  = $('#filterBillboardBookingCompany').val();
                        d.status    = $('#filterBillboardBookingStatus').val();
                        d.state     = $('#filterBillboardBookingState').val();
                        d.district  = $('#filterBillboardBookingDistrict').val();
                        d.location  = $('#filterBillboardBookingLocation').val();
                    },
                    dataSrc: function(json) {
                        json.recordsTotal = json.recordsTotal;
                        json.recordsFiltered = json.recordsFiltered;
                        return json.data;
                    }
                },
                dom: "lBfrtip",
                buttons: [{
                        extend: "csv",
                        className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
                        title: $fileName,
                        exportOptions: {
                            columns: ":not(.dt-exclude-export)"
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                    {
                        extend: "excel",
                        className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
                        title: $fileName,
                        exportOptions: {
                            columns: ":not(.dt-exclude-export)"
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                    {
                        extend: "print",
                        className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
                        title: $fileName,
                        // including printing image
                        exportOptions: {
                            stripHtml: false,
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                ],
                
                columns: [
                    {
                        data: null, // <-- important
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "site_number",
                    },
                    {
                        data: "company_name",
                    },
                    {
                        data: "location_name",
                    },
                    {
                        data: "start_date",
                    },
                    {
                        data: "end_date",
                    },
                    {
                        data: "duration",
                    },
                    {
                        data: "status",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = ``
                            if (data == 'pending_payment'){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-6 text-white">` + data + `</a>`;
                            } else if (data == 'ongoing') {
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-18 text-black">` + data + `</a>`;
                            } else if (data == 'pending_install'){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-1 text-white">` + data + `</a>`;
                            }
                            
                            return element;
                        }
                    },
                    {
                        data: "remarks",
                    },
                    {
                        data: "WO_detail",
                        render: function(data, type, row) {
                            var a = "{{ route('billboard.booking.index', ['id'=>':data'] )}}".replace(':data', data);
                            let element = 
                            `<div class="flex flex-row">
                                <a href="javascript:;" id="profile-` + data + `"
                                    class="button w-24 inline-block mr-2 mb-2 bg-theme-9 text-white" data-toggle="button" onclick="window.open('${a}')" >
                                    View Detail
                                </a>
                            </div>`;

                            return element;
                        }
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <div class="flex items-center space-x-2">
                                <!-- Edit Button -->
                                <a href="javascript:;" id="profile-` + data + `"
                                    class="button w-24 inline-block mr-2 mb-2 bg-theme-1 text-white" data-toggle="button"" >
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#clientUsersDeleteModal" id="delete-client-` + data + `">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg> 
                                </a>
                            </div>`;

                            return element;
                        }
                    },
                    // {
                    //     data: "action",
                    //     render: function(data, type, row) {
                    //         let element = ``;
                            
                    //         // Check if the status is 'NEW'
                    //         if (row.status === 'NEW') {
                    //             // Show "Reject" button if the user is superadmin or teamleader
                    //             element = `@if (Auth::guard('web')->user()->hasRole(['superadmin', 'team_leader']))
                    //                         <a href="javascript:;" data-toggle="modal" data-target="#serviceRequestRejectModal" 
                    //                         id="reject-` + data + `"
                    //                         class="button w-24 inline-block mr-2 mb-2 bg-theme-6 text-white">
                    //                         Reject
                    //                         </a>
                    //                         @elseif (Auth::guard('web')->user()->hasRole('client_user'))
                    //                         <a href="javascript:;" data-toggle="modal" data-target="#serviceRequestDeleteModal" 
                    //                         id="delete-` + data + `"
                    //                         class="button w-24 inline-block mr-2 mb-2 bg-theme-6 text-white">
                    //                         Delete
                    //                         </a>
                    //                         @endif`;
                    //         }

                    //         return element;
                    //     }
                    // },
                ],
            });

            // Add classes to the "dt-buttons" div
            var dtButtonsDiv = document.querySelector(".dt-buttons");
            if (dtButtonsDiv) {
                dtButtonsDiv.classList.add("mt-2");
            }

            // Update styling for the filter input
            var filterDiv = document.getElementById("billboard_booking_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("billboard_booking_table_info");
            var paginateDiv = document.getElementById("billboard_booking_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "billboard_booking_table_length" div and its select element
            var existingDiv = document.getElementById("billboard_booking_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit SR
            serviceRequestEditModal();
        };

        initBillboardBookingDatatable();
        setupAutoFilter();

        // Open modal to edit SR
        function serviceRequestEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='billboard_booking_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='billboard_booking_table'] tbody tr td:not(:last-child)", function() {

                // Grab row client company id
                originalServiceRequestId = $(event.target).closest('tr').find('td:nth-last-child(2) a').attr('id').split('-')[1];

                // Place values to edit form fields in the modal
                document.getElementById("serviceRequestEditDescription").value = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                document.getElementById("serviceRequestEditClientRemark").value = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();

                // Open modal
                var element = "#serviceRequestEditModal";
                openAltEditorModal(element);
            });
        }

        var table = $('#table').DataTable({
            "dom": 'rtip',
            "paging":   false,
            "ordering": false,
            "info":     false
        });
    });

</script>
@endsection('script')