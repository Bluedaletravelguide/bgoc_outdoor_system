@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Billboard Availability</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<style>
    table td, table th {
        white-space: nowrap;
    }

    thead th {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Ensure sticky header works and aligns */
    .monthly-booking-table-wrapper {
        max-height: 400px;
        overflow: auto; /* scroll both vertically & horizontally */
    }

    #monthly-booking-table {
        border-collapse: collapse;
        min-width: 1200px; /* adjust based on column count */
    }

    #monthly-booking-table th,
    #monthly-booking-table td {
        border: 1px solid #d1d5db; /* Tailwind border-gray-300 */
        padding: 4px 8px;
        white-space: nowrap;
    }

    #monthly-booking-table thead th {
        position: sticky;
        top: 0;
        background-color: #f3f4f6; /* bg-gray-100 */
        z-index: 1;
    }
</style>

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Billboard Availability
    </h2>
</div>
<div class="intro-y box p-5 mt-5">
    <div class="mb-5 p-5 rounded-md" style="background-color:#ECF9FD;">
        <h2 class="text-lg font-medium">
            Check Billboard Availability
        </h2>
        <p class="w-12 flex-none xl:w-auto xl:flex-initial ml-2">
            <i class="font-bold">Billboard Availability</i> - Lorem Ipsum.
        </p>
    </div>

    <!-- Billboard Booking Calendar Filter -->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
        <form class="xl:flex sm:mr-auto">
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">State</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterAvailabilityState">
                    <option value="" selected="">-- Select State --</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">District</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterAvailabilityDistrict">
                    <option value="" selected="">-- Select State --</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Location</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="filterAvailabilityLocation">
                    <option value="" selected="">-- Select State --</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="filterAvailabilityType">
                    <option value="" selected="">-- Select Type --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->prefix }}">{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Status</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterAvailabilityStatus">
                    <option value="" selected="">All</option>
                    <option value="true">Available</option>
                    <option value="false">Not Available</option>
                </select>
            </div>
        </form> 
    </div>
    <!-- Filter End -->

    
     <!-- Billboard Availability Date Filter -->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
        <form class="xl:flex flex-wrap items-end space-y-4 xl:space-y-0 xl:space-x-4 mb-4">
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-24 text-gray-700">Start Date</label>
                <input type="date" id="filterAvailabilityStart" class="input border w-48" />
            </div>

            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-24 text-gray-700">End Date</label>
                <input type="date" id="filterAvailabilityEnd" class="input border w-48" />
            </div>
        </form>
    </div>
    <!-- Filter End -->

    <!-- Availability Year Filter -->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
        <form class="xl:flex flex-wrap items-end space-y-4 xl:space-y-0 xl:space-x-4 mb-4">
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Year</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterAvailabilityYear">
                    @for ($y = 2023; $y <= now()->year + 2; $y++)
                        <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </form>
    </div>
    <!-- Filter End -->

    <!-- billboard availability calendar table -->
    <div class="shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="monthly-booking-table-wrapper">
            <table id="monthly-booking-table" class="w-full text-sm text-left">
                @php
                    $year = request('year', now()->year);
                    $months = [
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ];
                @endphp
                <thead id="monthly-booking-head">
                    <!-- Populated by JS -->
                </thead>
                <tbody id="monthly-booking-body">
                    <!-- Populated by JS -->
                </tbody>
            </table>
        </div>
    </div>



    <!-- Check Availability table -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table mt-5" id="billboard_availability_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th class="whitespace-nowrap w-12">No.</th>
                    <th class="whitespace-nowrap w-24">Site #</th>
                    <th class="whitespace-nowrap">Location</th>
                    <th class="whitespace-nowrap">State</th>
                    <th class="whitespace-nowrap w-24">Status</th>
                    <th class="whitespace-nowrap w-24">Next Available</th> 
                    <th class="whitespace-nowrap flex flex-row">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- Table End -->
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

<!-- searchable dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    
    // <!-- BEGIN: Billboard Booking List Filter -->
    $('#filterAvailabilityState').on('change', function () {
        let stateId = $(this).val();

        const $districtSelect = $('#filterAvailabilityDistrict');
        const $locationSelect = $('#filterAvailabilityLocation');

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
                    $('#billboard_availability_table').DataTable().ajax.reload();
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
                    $('#billboard_availability_table').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Failed to load districts.');
                }
            });
        }
    });

    // When "District" is changed in add form
    $('#filterAvailabilityDistrict').on('change', function () {
        let districtId = $(this).val();

        // Reset Location dropdown
        $('#filterAvailabilityLocation').empty().append('<option value="">-- Select Location --</option>');

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
                        $('#filterAvailabilityLocation').append(`<option value="${location.id}">${location.name}</option>`);
                    });

                    // ✅ Reload table after loading filtered districts
                    $('#billboard_availability_table').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Failed to load locations.');
                }
            });
        }
    });
    // <!-- END: Billboard Booking List Filter -->

    document.addEventListener('DOMContentLoaded', function () {
        const startInput = document.getElementById('filterAvailabilityStart');
        const endInput = document.getElementById('filterAvailabilityEnd');

        // When start date changes
        startInput.addEventListener('change', function () {
            const startDate = startInput.value;

            if (startDate) {
                // Set the min for end date
                endInput.min = startDate;

                // Optional: clear end date if it is before start date
                if (endInput.value && endInput.value < startDate) {
                    endInput.value = '';
                }
            } else {
                endInput.min = ''; // Reset if start date cleared
            }
        });
    });

    


    	
    $(document).ready(function() {

        // Global variables
        var filterAvailabilityState;
        var filterAvailabilityDistrict;
        var filterAvailabilityLocation;
        var filterAvailabilityType;
        var filterAvailabilityStatus;


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

        $('.select2-client').select2({
            placeholder: "Select a client",
            allowClear: true,
            width: '100%'
        });

        // Function to reload the DataTable when any filter changes
        function setupAutoFilter() {
            const tableElement = $('#billboard_availability_table');

            // Reload DataTable
            if ($.fn.DataTable.isDataTable(tableElement)) {
                const table = tableElement.DataTable();

                $('#filterAvailabilityCompany, #filterAvailabilityState, #filterAvailabilityDistrict, #filterAvailabilityLocation, #filterAvailabilityType, #filterAvailabilityStatus, #filterAvailabilityStart, #filterAvailabilityEnd, #filterAvailabilityYear')
                    .on('change', function () {
                        const selectedYear = $('#filterAvailabilityYear').val();

                        table.ajax.reload();
                        buildMonthlyBookingTableHead(selectedYear);
                        loadMonthlyAvailability();
                    });
            }

            // Also reload monthly table if only it exists
            $('#filterAvailabilityCompany, #filterAvailabilityState, #filterAvailabilityDistrict, #filterAvailabilityLocation, #filterAvailabilityType, #filterAvailabilityStatus, #filterAvailabilityStart, #filterAvailabilityEnd, #filterAvailabilityYear')
                .on('change', function () {
                    const selectedYear = $('#filterAvailabilityYear').val();
                    buildMonthlyBookingTableHead(selectedYear);
                    loadMonthlyAvailability(); // <-- add this in case DataTable not initialized
                });
        }


        function setupMonthlyAvailabilityFilter() {
            const filterSelectors = '#filterAvailabilityState, #filterAvailabilityDistrict, #filterAvailabilityLocation, #filterAvailabilityStatus, #filterAvailabilityStart, #filterAvailabilityEnd, #filterAvailabilityYear';

            $(filterSelectors).on('change', function () {
                const selectedYear = $('#filterAvailabilityYear').val();
                buildMonthlyBookingTableHead(selectedYear);
                loadMonthlyAvailability(); // this function contains your $.ajax code
            });
        }

        function buildMonthlyBookingTableHead(selectedYear) {
            const shortYear = String(selectedYear).slice(-2);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            let headerHtml = '<tr>';
            headerHtml += '<th>No</th>';
            headerHtml += '<th>Site No</th>';
            headerHtml += '<th>Location</th>';
            headerHtml += '<th>Size</th>';

            months.forEach(month => {
                headerHtml += `<th>${month} '${shortYear}</th>`;
            });

            headerHtml += '</tr>';
            $('#monthly-booking-head').html(headerHtml);
        }


        function loadMonthlyAvailability() {
            
            $.ajax({
                url: '{{ route("billboard.monthly.availability") }}',
                method: 'GET',
                data: {
                    start_date: $('#filterAvailabilityStart').val(),
                    end_date: $('#filterAvailabilityEnd').val(),
                    year: $('#filterAvailabilityYear').val(),
                    type: $('#filterAvailabilityType').val(),
                    state: $('#filterAvailabilityState').val(),
                    district: $('#filterAvailabilityDistrict').val(),
                    location: $('#filterAvailabilityLocation').val(),
                    status: $('#filterAvailabilityStatus').val()
                },
                success: function (response) {
                    const tbody = $('#monthly-booking-body');
                    tbody.empty();

                    if (!response.data || response.data.length === 0) {
                        tbody.append(`<tr><td colspan="16" class="text-center p-4">No data available</td></tr>`);
                        return;
                    }

                    response.data.forEach((row, index) => {
                        let html = `<tr>
                            <td class="border border-gray-300">${index + 1}</td>
                            <td class="border border-gray-300">${row.site_number}</td>
                            <td class="border border-gray-300">${row.location}</td>
                            <td class="border border-gray-300">${row.size}</td>`;

                        row.months.forEach(month => {
                            let cellClass = `border border-gray-300 ${month.color} text-white font-semibold`;
                            html += `<td colspan="${month.span}" class="${cellClass}">${month.text}</td>`;
                        });

                        html += `</tr>`;
                        tbody.append(html);
                    });
                },
                error: function (xhr) {
                    console.error("AJAX error:", xhr.responseText);
                }
            });
        }

        $(document).ready(function () {
            const selectedYear = $('#filterAvailabilityYear').val();
            setupAutoFilter(); // your existing DataTable filter
            setupMonthlyAvailabilityFilter(); // new for monthly table
            buildMonthlyBookingTableHead(selectedYear);
            loadMonthlyAvailability(); // load once on page load
        });



        /**
         * Escape HTML to avoid XSS
         */
        function escapeHtml(text) {
            return $('<div>').text(text).html();
        }



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

        // When any submit button is clicked
        (function() {
            var billboard_availability_table = $('#billboard_availability_table')[0].altEditor;

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

        


        
    
        // Setup billboard availability datatable
        function initBillboardAvailabilityDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Billboard_Availability_List_${formattedDate}_${formattedTime}`;

            const table = $('#billboard_availability_table').DataTable({
                // altEditor: true,
                destroy: true,
                debug: true,
                processing: true,
                searching: true,
                serverSide: true,
                ordering: true,
                order: [
                    [0, 'asc']
                ],
                pagingType: 'full_numbers',
                pageLength: 25,
                aLengthMenu: [
                    [25, 50, 75, -1],
                    [25, 50, 75, "All"]
                ],
                iDisplayLength: 25,
                ajax: {
                    url: "{{ route('billboard.checkAvailability') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token        = $('meta[name="csrf-token"]').attr('content');
                        d.start_date    = $('#filterAvailabilityStart').val();
                        d.end_date      = $('#filterAvailabilityEnd').val();
                        d.type          = $('#filterAvailabilityType').val(),
                        d.status        = $('#filterAvailabilityStatus').val();
                        d.state         = $('#filterAvailabilityState').val();
                        d.district      = $('#filterAvailabilityDistrict').val();
                        d.location      = $('#filterAvailabilityLocation').val();
                    },
                    dataSrc: function(json) {
                        json.recordsTotal = json.recordsTotal;
                        json.recordsFiltered = json.recordsFiltered;

                        // If no filters, return empty array to show "No data"
                        const noFilters =
                            !$('#filterAvailabilityStart').val() &&
                            !$('#filterAvailabilityEnd').val() &&
                            !$('#filterAvailabilityType').val() &&
                            !$('#filterAvailabilityState').val() &&
                            !$('#filterAvailabilityDistrict').val() &&
                            !$('#filterAvailabilityLocation').val() &&
                            !$('#filterAvailabilityStatus').val();

                        return json.data;
                    }
                },
                 language: {
                    emptyTable: "No records found. Please apply at least one filter."
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
                        data: "location_name",
                    },
                    {
                        data: null,
                        name: 'district_state',
                        render: function (data, type, row) {
                            const district = row.district_name || '';
                            const state = row.state_name || '';
                            return `${district}, ${state}`; // Or use template style if preferred
                        }
                    },
                    {
                        data: "is_available",
                        type: "readonly",
                        render: function(data, type, row) {
                            let element = ``
                            if (data == false){
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-6 text-white">Not Available</a>`;
                            } else if (data == true) {
                                element = `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-18 text-black">Available</a>`;
                            }
                            
                            return element;
                        }
                    },
                    {
                        data: "next_available",
                    },
                    {
                        data: "WO_detail",
                        render: function(data, type, row) {
                            if (!data) return ''; // prevent undefined from causing crash
                            const url = "{{ route('billboard.booking.index', ['id'=>':data']) }}".replace(':data', data);
                            return `
                                <div class="flex flex-row">
                                    <a href="javascript:;" id="profile-${data}"
                                        class="button w-24 inline-block mr-2 mb-2 bg-theme-9 text-white"
                                        onclick="window.open('${url}')">
                                        View Detail
                                    </a>
                                </div>`;
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
            var filterDiv = document.getElementById("billboard_availability_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("billboard_availability_table_info");
            var paginateDiv = document.getElementById("billboard_availability_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "billboard_availability_table_length" div and its select element
            var existingDiv = document.getElementById("billboard_availability_table_length");
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

        initBillboardAvailabilityDatatable();
        setupAutoFilter();





















        
        
        
        
        
        
        
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
                    $('#billboard_availability_table').DataTable().ajax.reload();
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
        
        
        // Open modal to edit SR
        function serviceRequestEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='billboard_availability_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='billboard_availability_table'] tbody tr td:not(:last-child)", function() {

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