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
        </form> 
    </div>
    <!-- Filter End -->

    <!-- Billboard Booking Calendar Filter -->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-2 mt-2">
        <form class="xl:flex sm:mr-auto">
            
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
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">New/Existing</label>
                <select class="input w-full mt-2 sm:mt-0 sm:w-auto border" id="filterAvailabilitySiteType">
                    <option value="" selected="">All</option>
                    <option value="new">New</option>
                    <option value="existing">Existing</option>
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
        <div class="modal" id="editAvailabilityModal">
            <div class="modal__content">
                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Billboard Availability</h2>
                </div>
                <form>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Availability Status</label>
                            <select id="editAvailability" class="input w-full border mt-2 select">
                                <option disabled selected hidden value="">Select an option</option>
                                <option value="1">Available</option>
                                <option value="2">Not Available</option>
                            </select>
                        </div>
                    </div>
                    <div class="px-5 py-3 border-t border-gray-200 dark:border-dark-5 text-right">
                        <button type="submit" class="button w-20 bg-theme-1 text-white" id="saveAvailabilityButton">Save</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
<!-- View Modal End -->
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
        var filterAvailabilitySiteType;
        var filterAvailabilityStatus;


        var filterServiceRequestStatus;
        var originalServiceRequestId;
        var lastClickedLink;
        let startPicker = null;
        let endPicker = null;

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

                $('#filterAvailabilityCompany, #filterAvailabilityState, #filterAvailabilityDistrict, #filterAvailabilityLocation, #filterAvailabilityType, #filterAvailabilitySiteType, #filterAvailabilityStatus, #filterAvailabilityStart, #filterAvailabilityEnd, #filterAvailabilityYear')
                    .on('change', function () {
                        const selectedYear = $('#filterAvailabilityYear').val();

                        table.ajax.reload();
                        buildMonthlyBookingTableHead(selectedYear);
                        loadMonthlyAvailability();
                    });
            }

            // Also reload monthly table if only it exists
            $('#filterAvailabilityCompany, #filterAvailabilityState, #filterAvailabilityDistrict, #filterAvailabilityLocation, #filterAvailabilityType, #filterAvailabilitySiteType, #filterAvailabilityStatus, #filterAvailabilityStart, #filterAvailabilityEnd, #filterAvailabilityYear')
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
            headerHtml += '<th>New/Existing</th>';
            headerHtml += '<th>Type</th>';
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
                    site_type: $('#filterAvailabilitySiteType').val(),
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
                            <td class="border border-gray-300">${row.site_type}</td>
                            <td class="border border-gray-300">${row.type}</td>
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

        // Edit Billboard Availability
        function editAvailability() {
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
                    var element = "#editAvailabilityModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully updated.", "#91C714");

                    // Clean fields
                    document.getElementById("editBookingStatus").value = "";
                    document.getElementById("editBookingRemarks").value = "";

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
                        d.type          = $('#filterAvailabilityType').val();
                        d.site_type     = $('#filterAvailabilitySiteType').val();
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
                            !$('#filterAvailabilitySiteType').val() &&
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
                        data: "status_label", // <-- use clean label for raw data
                        render: function(data, type, row) {
                            if (row.is_available == false) {
                                return `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-6 text-white">${data}</a>`;
                            } else {
                                return `<a class="p-2 w-24 rounded-full mr-1 mb-2 bg-theme-18 text-black">${data}</a>`;
                            }
                        }
                    },
                    {
                        data: "next_available",
                    },
                    {
                        data: "id",
                        render: (data) => `
                            <div class="flex justify-center items-center gap-3">
                                <!-- Edit Button -->
                                <a href="javascript:;" 
                                    class="button w-24 inline-block mr-2 mb-2 bg-theme-1 text-white edit-availability" 
                                    data-id="${data}"
                                >
                                    Edit
                                </a>

                                <!-- Delete Icon -->
                                <a href="javascript:;" 
                                class="client-company-delete flex items-center justify-center w-8 h-8 text-theme-6 rounded hover:bg-gray-100" 
                                data-id="${data}" 
                                title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="w-5 h-5" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
                                                a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </a>
                            </div>
                        `
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
            editAvailabilityModal();
        };

        initBillboardAvailabilityDatatable();
        setupAutoFilter();

        $(document).off('click', '.edit-availability').on('click', '.edit-availability', function() {
            const table = $('#billboard_availability_table').DataTable();
            const rowData = table.row($(this).closest('tr')).data(); // full row

            // Map boolean to select value
            if (rowData.is_available) {
                $('#editAvailability').val('1'); // Available
            } else {
                $('#editAvailability').val('2'); // Not Available
            }

            openAltEditorModal('#editAvailabilityModal');
        });


        $('#saveAvailabilityButton').on('click', function (e) {
            e.preventDefault();

            let id = $('#editAvailabilityModal').data('billboard-id');
            let availability = $('#editAvailability').val(); // "1" or "2"

            $.ajax({
                url: '{{ route("billboard.availability.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    is_available: availability
                },
                success: function(response) {
                    // Close modal
                    closeAltEditorModal("#editAvailabilityModal");

                    // Show toast
                    window.showSubmitToast("Availability updated.", "#91C714");

                    // Reload table
                    $('#billboard_availability_table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    var response = JSON.parse(xhr.responseText);
                    window.showSubmitToast("Error: " + response.error, "#D32929");
                }
            });
        });






















        
        
        
        
        
        
        
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