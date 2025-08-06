@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Billboard Booking</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<style>
    .fc {
        font-size: 20px !important;
    }

    .fc-toolbar-title {
        font-size: 20px !important;
        font-weight: bold !important;
    }

    .fc-daygrid-day-number {
        font-size: 20px !important;
    }

    .fc-event-title {
        font-size: 18px !important;
    }
</style>
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Monthly Ongoing
    </h2>
</div>
<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#ECF9FD;">
        <h2 class="text-lg font-medium">
            Monthly Ongoing
        </h2>
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">Monthly Ongoing</i> - Lorem Ipsum.
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
                        <option value="{{ $location->id }}" data-site="{{ $location->site_number }}">{{ $location->name }}</option>
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
            <a href="javascript:;" data-toggle="modal" data-target="#addBookingModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New Job Order
            </a> 
        </div> 
    </div>
    <!-- Filter End -->

    <!-- Monthly Ongoing table -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table mt-5" id="billboard_booking_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th class="whitespace-nowrap">No.</th>
                    <th class="whitespace-nowrap">Site #</th>
                    <th class="whitespace-nowrap">Client Name</th>
                    <th class="whitespace-nowrap">Area</th>
                    <th class="whitespace-nowrap">Start Date</th>
                    <th class="whitespace-nowrap">End Date</th> 
                    <th class="whitespace-nowrap">Duration (Month)</th>
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
    
    <!-- Billboard Booking Calendar -->
    <div class="mb-5 p-5 rounded-md border border-dashed border-theme-1">
        <h2 class="text-base font-bold mb-3 text-theme-1">Calendar View</h2>

        <!-- FullCalendar Container -->
        <div id="billboard-booking-calendar" class="mb-5"></div>

        <!-- ✅ Legend (place this inside the same box) -->
        <div id="calendarLegend" class="flex flex-wrap gap-4 mt-4">
            <!-- Legend items will be injected here -->
        </div>
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- Create Modal -->
    <div class="row flex flex-col sm:flex-row sm:items-end xl:items-start mb-2">
        <div class="modal" id="addBookingModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Add New Job Order</h2>
                </div>
                <form id="inputBookingForm">
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Site Number</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="inputBookingSiteNo" value="" disabled>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Client</label>
                            <select id="inputBookingCompany" class="input w-full border mt-2 select2-client" required>
                                <option value="">-- Select Client --</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>State</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBookingState">
                                <option value="">-- Select State --</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>District</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBookingDistrict">
                                <option value="">-- Select District --</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Area</label>
                            <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputBookingLocation">
                                <option value="">-- Select Area --</option>
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
                        <div class="col-span-12 sm:col-span-12">
                            <label>Status</label>
                            <select id="inputBookingStatus" class="input w-full border mt-2 select" required>
                                <option disabled selected hidden value="">-- Select Status --</option>
                                <option value="pending_payment">Pending Payment</option>
                                <option value="pending_install">Pending Install</option>
                                <option value="ongoing">Ongoing</option>            
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Artwork by</label>
                            <select id="inputBookingArtworkBy" class="input w-full border mt-2 select" required>
                                <option disabled selected hidden value="">-- Select Artwork by --</option>
                                <option value="Client">Client</option>
                                <option value="Bluedale">Bluedale</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>DBP Approval</label>
                            <select id="inputBookingDBPApproval" class="input w-full border mt-2 select" required>
                                <option disabled selected hidden value="">-- Select DBP Approval --</option>
                                <option value="NA">Not Available</option>
                                <option value="In Review">In Review</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label>Remarks</label>
                            <input type="text" class="input w-full border mt-2 flex-1" id="inputBookingRemarks" value="" required>
                        </div>
                    </div>

                    <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="inputBookingSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
<!-- Create Modal End -->


<!-- BEGIN: Billboard Booking Delete Modal -->
<div class="modal" id="billboardBookingDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm delete this Monthly Ongoing? This process cannot be undone.</div>
        </div>

        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="billboardBookingDeleteButton" onclick="billboardBookingDeleteButton()">Delete</button>
        </div>
    </div>
</div>
<!-- END: Service Request Reject Modal -->

<!-- Edit Modal -->
<div class="modal" id="editBookingModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Status</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Status</label>
                    <select id="editBookingStatus" class="input w-full border mt-2 select" required>
                        <option disabled selected hidden value="">-- Select Status --</option>
                        <option value="pending_payment">Pending Payment</option>
                        <option value="pending_install">Pending Install</option>
                        <option value="ongoing">Ongoing</option>            
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Remarks</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Description" id="editBookingRemarks" required>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="editBookingButton">Update</button>
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


<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

    let startPicker, endPicker;

    // init datepicker
    function initDatePickers() {

        const startInput = document.querySelector('#start_date');
        const endInput = document.querySelector('#end_date');

        if (!startInput || !endInput) {
            console.warn("Date inputs not found in DOM.");
            return;
        }

        if (startPicker && typeof startPicker.destroy === 'function') {
            startPicker.destroy();
        }

        if (endPicker && typeof endPicker.destroy === 'function') {
            endPicker.destroy();
        };

        startPicker = flatpickr("#start_date", {
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function (selectedDates, dateStr) {
                if (endPicker) {
                    // Set min date for endPicker
                    endPicker.set('minDate', dateStr);

                    // Auto-clear end date if before new start
                    const endDate = endPicker.selectedDates[0];
                    if (endDate && endDate < selectedDates[0]) {
                        endPicker.clear();
                    }
                }
            }
        });

        endPicker = flatpickr("#end_date", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('addBookingModal');

        if (modal) {
            const observer = new MutationObserver(() => {
                const isVisible = !modal.classList.contains('hidden');
                if (isVisible) {
                    initDatePickers();
                }
            });

            observer.observe(modal, {
                attributes: true,
                attributeFilter: ['class'],
            });
        }
    });


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

        // Global variables
        var filterBillboardBookingCompany;
        var filterBillboardBookingState;
        var filterBillboardBookingDistrict;
        var filterBillboardBookingLocation;
        var filterBillboardBookingStatus;


        var filterServiceRequestStatus;
        var originalServiceRequestId;
        var lastClickedLink;
        

        // Listen to below buttons
        document.getElementById("billboardBookingDeleteButton").addEventListener("click", billboardBookingDeleteButton);
        document.getElementById("inputBookingSubmit").addEventListener("click", inputBookingSubmit);
        // document.getElementById("openWorkOrderDetailButton").addEventListener("click", openWorkOrderDetail);

        // When "State" is changed in add form
        $('#inputBookingState').on('change', function () {
            let stateId = $(this).val();

            // Reset District and Location dropdowns
            $('#inputBookingDistrict').empty().append('<option value="">-- Select District --</option>');
            $('#inputBookingLocation').empty().append('<option value="">-- Select Location --</option>');

            if (stateId !== '') {
                $.ajax({
                    url: '{{ route("location.getDistricts") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        state_id: stateId
                    },
                    success: function (districts) {
                        districts.forEach(function (district) {
                            $('#inputBookingDistrict').append(`<option value="${district.id}">${district.name}</option>`);
                        });
                    },
                    error: function () {
                        alert('Failed to load districts.');
                    }
                });
            }
        });

        // When "District" is changed in add form
        $('#inputBookingDistrict').on('change', function () {
            let districtId = $(this).val();

            // Reset Location dropdown
            $('#inputBookingLocation').empty().append('<option value="">-- Select Location --</option>');

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
                            $('#inputBookingLocation').append(`<option value="${location.id}">${location.name}</option>`);
                        });
                    },
                    error: function () {
                        alert('Failed to load locations.');
                    }
                });
            }
        });

        
        $('#inputBookingForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
            inputBookingSubmit(); // Call your AJAX function
        });

        $('.select2-client').select2({
            placeholder: "Select a client",
            allowClear: true,
            width: '100%'
        });


        

        // Billboard Booking Calendar
        let calendar = null;

        function initBookingCalendar() {
            const calendarEl = document.getElementById('billboard-booking-calendar');

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
                            // ✅ Return only the events to FullCalendar
                            successCallback(response.events || []);

                            // ✅ Render the legend
                            const legendWrapper = $('#calendarLegend');
                            legendWrapper.empty();

                            if (response.legend && Array.isArray(response.legend)) {
                                response.legend.forEach(item => {
                                    legendWrapper.append(`
                                        <div class="flex items-center space-x-4 mr-4 mb-2">
                                            <span class="w-4 h-4 inline-block rounded-sm" style="background-color:${item.color}"></span>
                                            <span class="text-sm text-gray-700">${item.label}</span>
                                        </div>
                                    `);
                                });
                            }
                        },
                        error: function(err) {
                            console.error("Calendar load error:", err);
                            failureCallback(err);
                        }
                    });
                }
            });

            calendar.render();
        }


        initBookingCalendar();

        $('#filterBillboardBookingCompany, #filterBillboardBookingState, #filterBillboardBookingDistrict, #filterBillboardBookingLocation, #filterBillboardBookingStatus').on('change', function () {
            if (calendar) {
                calendar.refetchEvents(); // reload calendar bookings with new filter
            }
        });


        

        $('[data-toggle="modal"][data-target="#addBookingModal"]').on('click', function () {
            setTimeout(() => {
                initDatePickers(); // Ensure date pickers are freshly initialized
            }, 200);
        });


        // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();

        // When any submit button is clicked
        (function() {
            var billboard_booking_table = $('#billboard_booking_table')[0].altEditor;

            document.getElementById('inputBookingSubmit').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('billboardBookingDeleteButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();
            });

            document.getElementById('editBookingButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit SR
                editBooking();
            });
        })();

        // Add New Billboard
        function inputBookingSubmit() {
            const start_date = startPicker?.input?.value || '';
            const end_date = endPicker?.input?.value || '';

            if (!start_date || !end_date) {
                alert("Please select both Start and End dates.");
                return;
            }

            document.getElementById("inputBookingSubmit").disabled = true;
            document.getElementById('inputBookingSubmit').style.display = 'none';

            $.ajax({
                type: 'POST',
                url: "{{ route('billboard.booking.create') }}",
                data: {
                    _token          : $('meta[name="csrf-token"]').attr('content'),
                    company         : document.getElementById("inputBookingCompany").value,
                    state           : document.getElementById("inputBookingState").value,
                    district        : document.getElementById("inputBookingDistrict").value,
                    location        : document.getElementById("inputBookingLocation").value,
                    start_date      : start_date,
                    end_date        : end_date,
                    status          : document.getElementById("inputBookingStatus").value,
                    artwork_by      : document.getElementById("inputBookingArtworkBy").value,
                    dbp_approval    : document.getElementById("inputBookingDBPApproval").value,
                    remarks         : document.getElementById("inputBookingRemarks").value,
                },
                success: function(response) {
                    // Close modal
                    const element = "#addBookingModal";
                    closeAltEditorModal(element);

                    // Success toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clear inputs
                    $('#inputBookingCompany').val('').trigger('change');
                    $('#inputBookingSiteNo').val('');
                    document.getElementById("inputBookingState").value = "";
                    document.getElementById("inputBookingDistrict").value = "";
                    document.getElementById("inputBookingLocation").value = "";
                    document.getElementById("inputBookingStatus").value = "";
                    document.getElementById("inputBookingArtworkBy").value = "";
                    document.getElementById("inputBookingDBPApproval").value = "";
                    document.getElementById("inputBookingRemarks").value = "";
                    if (startPicker) startPicker.clear();
                    if (endPicker) endPicker.clear();

                    // Reload table
                    $('#billboard_booking_table').DataTable().ajax.reload();

                    // Reset button
                    document.getElementById("inputBookingSubmit").disabled = false;
                    document.getElementById('inputBookingSubmit').style.display = 'inline-block';
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    const error = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");

                    document.getElementById("inputBookingSubmit").disabled = false;
                    document.getElementById('inputBookingSubmit').style.display = 'inline-block';
                }
            });
        }

        $('#inputBookingLocation').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const siteNumber = selectedOption.data('site_number') || '';
            $('#inputBookingSiteNo').val(siteNumber);
        });

        // Edit Billboard Booking
        function editBooking() {
            var status = document.getElementById("editBookingStatus").value;
            var remarks = document.getElementById("editBookingRemarks").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('billboard.booking.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status,
                    remarks: remarks,
                    booking_id: booking_id,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#editBookingModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully updated.", "#91C714");

                    // Clean fields
                    document.getElementById("editBookingStatus").value = "";
                    document.getElementById("editBookingRemarks").value = "";

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












































        // Open modal
        function openAltEditorModal(element) {
            cash(element).modal('show');
        }
        // Close modal
        function closeAltEditorModal(element) {
            cash(element).modal('hide');
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
                                <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#billboardBookingDeleteModal" id="delete-` + data + `">
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
            editBookingModal();
        };

        initBillboardBookingDatatable();
        setupAutoFilter();





















        // Open modal to edit Billboard Booking
        function editBookingModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='billboard_booking_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='billboard_booking_table'] tbody tr td:not(:last-child)", function() {

                // Grab row client company id
                booking_id = $(event.target).closest('tr').find('td:nth-last-child(1) a').attr('id').split('-')[1];

                // Place values to edit form fields in the modal
                document.getElementById("editBookingStatus").value = $(event.target).closest('tr').find('td:nth-child(' + '8' + ')').text();
                document.getElementById("editBookingRemarks").value = $(event.target).closest('tr').find('td:nth-child(' + '9' + ')').text();

                // Open modal
                var element = "#editBookingModal";
                openAltEditorModal(element);
            });
        }

        // Delete billboard ID
        function billboardBookingDeleteButton() {
            var id = lastClickedLink.split("-")[1];

            $.ajax({
                type: 'POST',
                url: "{{ route('billboard.booking.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#billboardBookingDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#billboard_booking_table').DataTable().ajax.reload();

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

        var table = $('#table').DataTable({
            "dom": 'rtip',
            "paging":   false,
            "ordering": false,
            "info":     false
        });
    });

</script>
@endsection('script')