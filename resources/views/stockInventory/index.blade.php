@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Stock Inventory</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<style>
    #inventory_table {
        border-collapse: collapse !important; /* merge borders */
    }

    #inventory_table th,
    #inventory_table td {
        border: 1px solid #ddd !important; /* light gray border */
        padding: 6px 10px;
    }

    #inventory_table thead th {
        border-bottom: 2px solid #bbb !important;
    }
</style>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Stock Inventory
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Client -->
        <div>
            <!-- BEGIN: Filter & Add Client -->
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <!-- BEGIN: Filter -->
                <form class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Company Name</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="fliterClient">
                        <option selected value="">Select an option</option>
                        @foreach ($clientcompany as $clientcomp)
                            <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterClientButton">Filter</button>
                    </div>
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add Stock Inventory -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#inventoryAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Stock Inventory
                    </a>
                </div>
                <!-- END: Add Stock Inventory -->
            </div>
            <!-- END: Filter & Add Stock Inventory -->

            <!-- BEGIN: Stock Inventory List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table table-report mt-5" id="inventory_table">
                    <thead>
                        <tr class="bg-theme-1 text-white">
                            <th width="5%">No.</th>
                            <th class="bg-orange-500 text-white">Contractor</th>
                            <!-- stock inventory IN section -->
                            <th class="bg-orange-500 text-white">Client</th>
                            <th class="bg-orange-500 text-white">Site</th>
                            <!-- <th class="bg-orange-500 text-white">Type</th> -->
                            <!-- <th class="bg-orange-500 text-white">Size</th> -->
                            <th class="bg-orange-500 text-white">Quantity</th>
                            <th class="bg-orange-500 text-white">Remarks</th>
                            <th class="bg-orange-500 text-white">Date In</th>
                            <th class="bg-yellow-400 text-black">Bal - Contractor</th>
                            <!-- stock inventory OUT section -->
                            <th class="bg-yellow-400 text-black">Bal - BGOC</th>
                            <th class="bg-green-600 text-white">Date Out</th>
                            <th class="bg-green-600 text-white">Quantity</th>
                            <!-- <th class="bg-green-600 text-white">Size</th> -->
                            <!-- <th class="bg-green-600 text-white">Type</th> -->
                            <th class="bg-green-600 text-white">Site</th>
                            <th class="bg-green-600 text-white">Client</th>
                            <th class="bg-green-600 text-white">Remarks</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Stock Inventory List -->
        </div>
        <!-- END: Client -->
    </div>
</div>

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Stock Inventory Transactions
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <!-- <div class="pos col-span-12 lg:col-span-4"> -->
        <!-- BEGIN: Client -->
        <!-- <div> -->

            <!-- BEGIN: Stock Inventory List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table table-report mt-5" id="inventory_trxn_table">
                    <thead>
                        <tr class="bg-theme-1 text-white">
                            <th width="5%">No.</th>
                            <th class="bg-orange-500 text-white">Contractor</th>
                            <!-- stock inventory IN section -->
                            <th class="bg-orange-500 text-white">Client</th>
                            <th class="bg-orange-500 text-white">Site</th>
                            <th class="bg-orange-500 text-white">Type</th>
                            <th class="bg-orange-500 text-white">Size</th>
                            <th class="bg-orange-500 text-white">Quantity</th>
                            <th class="bg-orange-500 text-white">Remarks</th>
                            <th class="bg-orange-500 text-white">Date In</th>
                            <th class="bg-yellow-400 text-black">Bal - Contractor</th>
                            <!-- stock inventory OUT section -->
                            <th class="bg-yellow-400 text-black">Bal - BGOC</th>
                            <th class="bg-green-600 text-white">Date Out</th>
                            <th class="bg-green-600 text-white">Quantity</th>
                            <th class="bg-green-600 text-white">Size</th>
                            <th class="bg-green-600 text-white">Type</th>
                            <th class="bg-green-600 text-white">Site</th>
                            <th class="bg-green-600 text-white">Client</th>
                            <th class="bg-green-600 text-white">Remarks</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Stock Inventory List -->
        <!-- </div> -->
        <!-- END: Client -->
    <!-- </div> -->
</div>

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Stock Inventory History
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <!-- <div class="pos col-span-12 lg:col-span-4"> -->
        <!-- BEGIN: Client -->
        <!-- <div> -->

            <!-- BEGIN: Stock Inventory List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table table-report mt-5" id="inventory_history_table">
                    <thead>
                        <tr class="bg-theme-1 text-white">
                            <th width="5%">No.</th>
                            <th class="bg-orange-500 text-white">Contractor</th>
                            <th class="bg-orange-500 text-white">Client</th>
                            <th class="bg-orange-500 text-white">Type</th>
                            <th class="bg-orange-500 text-white">Site</th>
                            <th class="bg-orange-500 text-white">Remarks</th>
                            <th class="bg-orange-500 text-white">Size</th>
                            <th class="bg-orange-500 text-white">Quantity</th>
                            <th class="bg-orange-500 text-white">Date In</th>
                            <th class="bg-yellow-400 text-black">Bal - Contractor</th>
                            <th class="bg-yellow-400 text-black">Bal - BGOC</th>
                            <th class="bg-green-600 text-white">Date Out</th>
                            <th class="bg-green-600 text-white">Quantity</th>
                            <th class="bg-green-600 text-white">Size</th>
                            <th class="bg-green-600 text-white">Client</th>
                            <th class="bg-green-600 text-white">Site</th>
                            <th class="bg-green-600 text-white">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Stock Inventory List -->
        <!-- </div> -->
        <!-- END: Client -->
    <!-- </div> -->
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Inventory Add Modal -->
<div class="modal items-center justify-center" id="inventoryAddModal">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-7xl p-6">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b pb-3 mb-4">
            <h2 class="text-lg font-semibold">Add Stock Inventory</h2>
            <!-- <button type="button" onclick="closeInventoryModal()">✖</button> -->
        </div>
        <form id="addStockInventoryForm">
            <div class="mb-4">
                <label class="block font-medium">Contractor</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputContractorName" required>
                        <option selected value="">Select an option</option>
                        @foreach ($contractors as $contractor)
                            <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                        @endforeach
                        </select>
            </div>
            <div class="grid grid-cols-2 gap-8">
                
                <!-- LEFT COLUMN: IN INVENTORY -->
                <div class="bg-orange-50 p-4 rounded-lg">
                    <h3 class="font-bold text-orange-600 mb-3">In Inventory</h3>

                    <div class="mb-3">
                        <label class="block">Balance - Contractor</label>
                        <input type="number" class="input w-full border mt-1" id="balContractor" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="block">Date In</label>
                        <input type="date" class="input w-full border mt-1" id="inputDateIn">
                    </div>
                    
                    <div class="mb-3">
                        <label class="block">Remarks</label>
                        <input type="text" class="input w-full border mt-1" id="inputRemarksIn">
                    </div>
                    <div class="flex items-center sm:py-3 border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">Add Sites</h2>
                    </div>
                    <div id="siteInContainer">
                        <div class="siteIn">
                            <div class="mb-3">
                                <label class="block">Client</label>
                                <select class="input w-full border mt-2 select2" name="clients_in[]">
                                <option selected value="">Select an option</option>
                                @foreach ($clientcompany as $clientcomp)
                                    <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block">Site</label>
                                <select class="input w-full border mt-2 select2" id="inputBillboardIn" name="sites_in[]">
                                    <option selected value="">Select an option</option>
                                    @foreach ($billboards as $billboard)
                                        <option 
                                            value="{{ $billboard->id }}" 
                                            data-type="{{ $billboard->type }}" 
                                            data-size="{{ $billboard->size }}">
                                            {{ $billboard->site_number }} - {{ $billboard->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block">Type</label>
                                <input type="text" class="input w-full border mt-1" name="types_in[]" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="block">Size</label>
                                <input type="text" class="input w-full border mt-1" name="sizes_in[]" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="block"><strong>Quantity In</strong></label>
                                <input type="number" class="input w-full border mt-1" name="qtys_in[]">
                            </div>
                            <div class="mb-3">
                                <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteIn(this)">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="siteInAdd()" class="bg-blue-600 text-white px-4 py-2 rounded">Add Site</button>
                </div>

                <!-- RIGHT COLUMN: OUT INVENTORY -->
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-bold text-green-600 mb-3">Out Inventory</h3>

                    <div class="mb-3">
                        <label class="block">Bal - BGOC</label>
                        <input type="number" class="input w-full border mt-1" id="balBgoc" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="block">Date Out</label>
                        <input type="date" class="input w-full border mt-1" id="inputDateOut">
                    </div>
                    
                    <div class="mb-3">
                        <label class="block">Remarks</label>
                        <input type="text" class="input w-full border mt-1" id="inputRemarksOut">
                    </div>
                    <div class="flex items-center sm:py-3 border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">Add Sites</h2>
                    </div>
                    <div id="siteOutContainer">
                        <div class="siteOut">
                            <div class="mb-3">
                                <label class="block">Client</label>
                                <select class="input w-full border mt-2 select2" name="clients_out[]">
                                <option selected value="">Select an option</option>
                                @foreach ($clientcompany as $clientcomp)
                                    <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block">Site</label>
                                <select class="input w-full border mt-2 select2" id="inputBillboardOut" name="sites_out[]">
                                    <option selected value="">Select an option</option>
                                    @foreach ($billboards as $billboard)
                                        <option 
                                            value="{{ $billboard->id }}" 
                                            data-type="{{ $billboard->type }}" 
                                            data-size="{{ $billboard->size }}">
                                            {{ $billboard->site_number }} - {{ $billboard->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block">Type</label>
                                <input type="text" class="input w-full border mt-1" name="types_out[]" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="block">Size</label>
                                <input type="text" class="input w-full border mt-1" name="sizes_out[]" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="block"><strong>Quantity Out</strong></label>
                                <input type="number" class="input w-full border mt-1" name="qtys_out[]">
                            </div>
                            <div class="mb-3">
                                <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteOut(this)">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="siteOutAdd()" class="bg-blue-600 text-white px-4 py-2 rounded">Add Site</button>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-right">
                <button type="submit" id="inventoryAddButton" class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Inventory Add Modal -->

<!-- BEGIN: Inventory Edit Modal -->
<div class="modal items-center justify-center" id="inventoryEditModal">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-7xl p-6">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b pb-3 mb-4">
            <h2 class="text-lg font-semibold">Edit Stock Inventory</h2>
            <!-- <button type="button" onclick="closeInventoryModal()">✖</button> -->
        </div>

        <form>
            <div class="mb-4">
                <label class="block font-medium">Contractor</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editContractorName">
                        <option selected value="">Select an option</option>
                        @foreach ($contractors as $contractor)
                            <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                        @endforeach
                        </select>
            </div>
            <div class="grid grid-cols-2 gap-8">
                
                <!-- LEFT COLUMN: IN INVENTORY -->
                <div class="bg-orange-50 p-4 rounded-lg">
                    <h3 class="font-bold text-orange-600 mb-3">In Inventory</h3>

                    <div class="mb-3">
                        <label class="block">Bal - Contractor</label>
                        <input type="number" class="input w-full border mt-1" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="block">Date In</label>
                        <input type="date" class="input w-full border mt-1">
                    </div>
                    <div class="mb-3">
                        <label class="block">Client</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editClientIn">
                        <option selected value="">Select an option</option>
                        @foreach ($clientcompany as $clientcomp)
                            <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block">Remarks</label>
                        <input type="text" class="input w-full border mt-1">
                    </div>
                    <div class="flex items-center py-3 border-b border-gray-200">
                        <h2 class="font-medium text-base mr-auto">Sites</h2>
                    </div>

                    <div id="siteInEditContainer">
                        <div class="siteInEdit">
                            <div class="mb-3">
                                <label class="block">Site</label>
                                <select class="input w-full border mt-2 select2" id="inputBillboardInEdit" name="sites_in_edit[]">
                                    <option selected value="">Select an option</option>
                                    @foreach ($billboards as $billboard)
                                        <option 
                                            value="{{ $billboard->id }}" 
                                            data-type="{{ $billboard->type }}" 
                                            data-size="{{ $billboard->size }}">
                                            {{ $billboard->site_number }} - {{ $billboard->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block">Type</label>
                                <input type="text" class="input w-full border mt-1" name="types_in_edit[]" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="block">Size</label>
                                <input type="text" class="input w-full border mt-1" name="sizes_in_edit[]" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="block"><strong>Quantity In</strong></label>
                                <input type="number" class="input w-full border mt-1" name="qtys_in_edit[]">
                            </div>
                            <div class="mb-3">
                                <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteInEdit(this)">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="siteInEditAdd()" class="bg-blue-600 text-white px-4 py-2 rounded">Add Site</button>
                </div>

                <!-- RIGHT COLUMN: OUT INVENTORY -->
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-bold text-green-600 mb-3">Out Inventory</h3>

                    <div class="mb-3">
                        <label class="block">Bal - BGOC</label>
                        <input type="number" class="input w-full border mt-1" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="block">Date Out</label>
                        <input type="date" class="input w-full border mt-1">
                    </div>
                    <div class="mb-3">
                        <label class="block">Client</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="editClientOut">
                        <option selected value="">Select an option</option>
                        @foreach ($clientcompany as $clientcomp)
                            <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block">Remarks</label>
                        <input type="text" class="input w-full border mt-1">
                    </div>
                    <div class="flex items-center py-3 border-b border-gray-200">
                        <h2 class="font-medium text-base mr-auto">Sites</h2>
                    </div>

                    <div id="siteOutEditContainer">
                        <div class="siteOutEdit">
                            <div class="mb-3">
                                <label class="block">Site</label>
                                <select class="input w-full border mt-2 select2" id="inputBillboardOutEdit" name="sites_out_edit[]">
                                    <option selected value="">Select an option</option>
                                    @foreach ($billboards as $billboard)
                                        <option 
                                            value="{{ $billboard->id }}" 
                                            data-type="{{ $billboard->type }}" 
                                            data-size="{{ $billboard->size }}">
                                            {{ $billboard->site_number }} - {{ $billboard->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block">Type</label>
                                <input type="text" class="input w-full border mt-1" name="types_out_edit[]" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="block">Size</label>
                                <input type="text" class="input w-full border mt-1" name="sizes_out_edit[]" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="block"><strong>Quantity Out</strong></label>
                                <input type="number" class="input w-full border mt-1" name="qtys_out_edit[]">
                            </div>
                            <div class="mb-3">
                                <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteOutEdit(this)">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="siteOutEditAdd()" class="bg-blue-600 text-white px-4 py-2 rounded">Add Site</button>
                    
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-right">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Inventory Edit Modal -->

<!-- BEGIN: Inventory Delete Modal -->
<div class="modal" id="contractorDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the client? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="contractorDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Inventory Delete Modal -->
@endsection

@section('script')

<!-- searchable dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    // Add site to In Inventory
    function siteInAdd() {
        let html = `
            <br><div class="siteIn">
                <div class="mb-3">
                    <label class="block">Client</label>
                    <select class="input w-full border mt-2 select2" name="clients_in[]">
                    <option selected value="">Select an option</option>
                    @foreach ($clientcompany as $clientcomp)
                        <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Site</label>
                    <select class="input w-full border mt-2 select2" name="sites_in[]">
                        <option selected value="">Select an option</option>
                        @foreach ($billboards as $billboard)
                            <option 
                                value="{{ $billboard->id }}" 
                                data-type="{{ $billboard->type }}" 
                                data-size="{{ $billboard->size }}">
                                {{ $billboard->site_number }} - {{ $billboard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Type</label>
                    <input type="text" class="input w-full border mt-1" name="types_in[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block">Size</label>
                    <input type="text" class="input w-full border mt-1" name="sizes_in[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block"><strong>Quantity In</strong></label>
                    <input type="number" class="input w-full border mt-1" name="qtys_in[]">
                </div>
                <div class="mb-3">
                    <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteIn(this)">
                        Remove
                    </a>
                </div>
            </div>`;

        // Append
        $("#siteInContainer").append(html);

        // Re-init select2 for all .select2 (new + old)
        $("#siteInContainer .select2").select2({
            width: '100%'
        });

        updateTotalIn();
    }

    function removeSiteIn(el) {
        el.closest(".siteIn").remove();
        updateTotalIn();
    }

    // Add site to Out Inventory
    function siteOutAdd() {
        let html = `
            <br><div class="siteOut">
                <div class="mb-3">
                    <label class="block">Client</label>
                    <select class="input w-full border mt-2 select2" name="clients_out[]">
                    <option selected value="">Select an option</option>
                    @foreach ($clientcompany as $clientcomp)
                        <option value="{{ $clientcomp->id }}">{{ $clientcomp->name }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Site</label>
                    <select class="input w-full border mt-2 select2" name="sites_out[]" required>
                        <option selected value="">Select an option</option>
                        @foreach ($billboards as $billboard)
                            <option 
                                value="{{ $billboard->id }}" 
                                data-type="{{ $billboard->type }}" 
                                data-size="{{ $billboard->size }}">
                                {{ $billboard->site_number }} - {{ $billboard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Type</label>
                    <input type="text" class="input w-full border mt-1" name="types_out[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block">Size</label>
                    <input type="text" class="input w-full border mt-1" name="sizes_out[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block"><strong>Quantity Out</strong></label>
                    <input type="number" class="input w-full border mt-1" name="qtys_out[]" required>
                </div>
                <div class="mb-3">
                    <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteOut(this)">
                        Remove
                    </a>
                </div>
            </div>`;
        
        $("#siteOutContainer").append(html);

        // Re-init select2
        $("#siteOutContainer .select2").select2({
            width: '100%'
        });

        updateTotalOut();
    }

    function removeSiteOut(el) {
        el.closest(".siteOut").remove();
        updateTotalOut();
    }

    // Add In Site (Edit)
    function siteInEditAdd() {
        let html = `
            <div class="siteInEdit">
                <div class="mb-3">
                    <label class="block">Site</label>
                    <select class="input w-full border mt-2 select2" name="sites_in_edit[]">
                        <option selected value="">Select an option</option>
                        @foreach ($billboards as $billboard)
                            <option 
                                value="{{ $billboard->id }}" 
                                data-type="{{ $billboard->type }}" 
                                data-size="{{ $billboard->size }}">
                                {{ $billboard->site_number }} - {{ $billboard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Type</label>
                    <input type="text" class="input w-full border mt-1" name="types_in_edit[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block">Size</label>
                    <input type="text" class="input w-full border mt-1" name="sizes_in_edit[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block"><strong>Quantity In</strong></label>
                    <input type="number" class="input w-full border mt-1" name="qtys_in_edit[]">
                </div>
                <div class="mb-3">
                    <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteInEdit(this)">
                        Remove
                    </a>
                </div>
            </div>`;
        
        $("#siteInEditContainer").append(html);

        // Re-init select2
        $("#siteInEditContainer .select2").select2({
            width: '100%'
        });
    }

    function removeSiteInEdit(el) {
        el.closest(".siteInEdit").remove();
    }

    // Add Out Site (Edit)
    function siteOutEditAdd() {
        let html = `
            <div class="siteOutEdit">
                <div class="mb-3">
                    <label class="block">Site</label>
                    <select class="input w-full border mt-2 select2" name="sites_out_edit[]">
                        <option selected value="">Select an option</option>
                        @foreach ($billboards as $billboard)
                            <option 
                                value="{{ $billboard->id }}" 
                                data-type="{{ $billboard->type }}" 
                                data-size="{{ $billboard->size }}">
                                {{ $billboard->site_number }} - {{ $billboard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block">Type</label>
                    <input type="text" class="input w-full border mt-1" name="types_out_edit[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block">Size</label>
                    <input type="text" class="input w-full border mt-1" name="sizes_out_edit[]" readonly>
                </div>
                <div class="mb-3">
                    <label class="block"><strong>Quantity Out</strong></label>
                    <input type="number" class="input w-full border mt-1" name="qtys_out_edit[]">
                </div>
                <div class="mb-3">
                    <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteOutEdit(this)">
                        Remove
                    </a>
                </div>
            </div>`;

        $("#siteOutEditContainer").append(html);

        // Re-init select2
        $("#siteOutEditContainer .select2").select2({
            width: '100%'
        });
    }

    function removeSiteOutEdit(el) {
        el.closest(".siteOutEdit").remove();
    }

    // Handle auto-fill Type & Size for ADD modal
    $(document).on('change', '#siteInContainer .select2, #siteOutContainer .select2', function() {
        let selected = $(this).find(':selected');
        let type = selected.data('type') || '';
        let size = selected.data('size') || '';

        // find the nearest .siteIn or .siteOut row
        let row = $(this).closest('.siteIn, .siteOut');
        row.find('input[name="types_in[]"], input[name="types_out[]"]').val(type);
        row.find('input[name="sizes_in[]"], input[name="sizes_out[]"]').val(size);
    });

    // Handle auto-fill Type & Size for EDIT modal
    $(document).on('change', '#siteInEditContainer .select2, #siteOutEditContainer .select2', function() {
        let selected = $(this).find(':selected');
        let type = selected.data('type') || '';
        let size = selected.data('size') || '';

        let row = $(this).closest('.siteInEdit, .siteOutEdit');
        row.find('input[name="types_in_edit[]"], input[name="types_out_edit[]"]').val(type);
        row.find('input[name="sizes_in_edit[]"], input[name="sizes_out_edit[]"]').val(size);
    });

    // Function to calculate total In
    function updateTotalIn() {
        let total = 0;
        document.querySelectorAll("input[name='qtys_in[]']").forEach(function(input) {
            let val = parseInt(input.value) || 0;
            total += val;
        });
        document.getElementById("balContractor").value = total;
    }

    // Function to calculate total Out
    function updateTotalOut() {
        let total = 0;
        document.querySelectorAll("input[name='qtys_out[]']").forEach(function(input) {
            let val = parseInt(input.value) || 0;
            total += val;
        });
        document.getElementById("balBgoc").value = total;
    }

    // Attach events when typing in Quantity fields
    $(document).on("input", "input[name='qtys_in[]']", function() {
        updateTotalIn();
    });

    $(document).on("input", "input[name='qtys_out[]']", function() {
        updateTotalOut();
    });

    function openInventoryEditModal(inventoryId) {
    $.get(`/stock-inventory/${inventoryId}/edit`, function(res) {
        const inventory = res.inventory;

        // Set main fields
        $('#editContractorName').val(inventory.contractor_pic).trigger('change');
        $('#editClientIn').val(inventory.client_in).trigger('change');
        $('#editClientOut').val(inventory.client_out).trigger('change');
        $('#siteInEditContainer').empty();
        $('#siteOutEditContainer').empty();

        // Add IN sites
        res.sites_in.forEach(site => {
            const row = `
                <div class="siteInEdit">
                    <div class="mb-3">
                        <label>Site</label>
                        <select class="input w-full border mt-2 select2" name="sites_in_edit[]">
                            <option value="${site.billboard_id}" selected>${site.billboard.site_number} - ${site.billboard.name}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Type</label>
                        <input type="text" class="input w-full border mt-1" name="types_in_edit[]" value="${site.type}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Size</label>
                        <input type="text" class="input w-full border mt-1" name="sizes_in_edit[]" value="${site.billboard.size}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" class="input w-full border mt-1" name="qtys_in_edit[]" value="${site.quantity}">
                    </div>
                    <div class="mb-3">
                        <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteInEdit(this)">Remove</a>
                    </div>
                </div>`;
            $('#siteInEditContainer').append(row);
        });

        // Add OUT sites
        res.sites_out.forEach(site => {
            const row = `
                <div class="siteOutEdit">
                    <div class="mb-3">
                        <label>Site</label>
                        <select class="input w-full border mt-2 select2" name="sites_out_edit[]">
                            <option value="${site.billboard_id}" selected>${site.billboard.site_number} - ${site.billboard.name}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Type</label>
                        <input type="text" class="input w-full border mt-1" name="types_out_edit[]" value="${site.type}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Size</label>
                        <input type="text" class="input w-full border mt-1" name="sizes_out_edit[]" value="${site.billboard.size}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" class="input w-full border mt-1" name="qtys_out_edit[]" value="${site.quantity}">
                    </div>
                    <div class="mb-3">
                        <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteOutEdit(this)">Remove</a>
                    </div>
                </div>`;
            $('#siteOutEditContainer').append(row);
        });

        $('#inventoryEditModal').addClass('flex').removeClass('hidden');
    });
}



    $(document).ready(function() {
        
        // Global variables
        var filterClientCompany;
        var inventoryId;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterClientButton").addEventListener("click", filterClientButton);
        document.getElementById("inventoryAddButton").addEventListener("click", inventoryAddButton);
        document.getElementById("contractorDeleteButton").addEventListener("click", contractorDeleteButton);

        // When "filterClientButton" button is clicked, initiate initClientCompanyDatatable
        function filterClientButton() {
            filterClientCompany = document.getElementById("fliterClient").value;
            // initStockInventoryDatatable(filterClientCompany);
        };

        // When page first loads, load table
        filterClientButton();

        

        // When any submit button is clicked
        // (function() {
        //     var inventory_table = $('#inventory_table')[0].altEditor;

        //     $(document).on("click", "#inventoryAddButton", function (e) {
        //         e.preventDefault();
        //         inventoryAddButton();
        //     });

            // document.getElementById('inventoryEditButton').addEventListener('click', function(e) {
            //     // Prevent the default form submission behavior
            //     e.preventDefault();

            //     // Edit client
            //     editContractor();
            // });
        // })();

        // Initialize Select2 with search
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true,
            width: '100%'
        });

        // Open modal
        function openAltEditorModal(element) {
            console.log('disini pak');
            cash(element).modal('show');
        }

        // Close modal
        function closeAltEditorModal(selector) {
            $(selector).addClass('hidden').removeClass('flex');
        }

        // Add New Inventory
        function inventoryAddButton() {
            // Gather basic fields
            let contractor_id = $("#inputContractorName").val();
            let date_in = $("#inputDateIn").val();
            let date_out = $("#inputDateOut").val();
            let remarks_in = $("#inputRemarksIn").val();
            let remarks_out = $("#inputRemarksOut").val();
            let bal_contractor = $("#balContractor").val();
            let bal_bgoc = $("#balBgoc").val();

            // Gather site IN rows
            let sites_in = [];
            $("#siteInContainer .siteIn").each(function () {
                let siteId = $(this).find("select[name='sites_in[]']").val();
                let clientId = $(this).find("select[name='clients_in[]']").val(); // attach client per site
                if (!siteId) return; // skip empty

                sites_in.push({
                    id: siteId,
                    client_id: clientId || null,
                    type: $(this).find("input[name='types_in[]']").val(),
                    size: $(this).find("input[name='sizes_in[]']").val(),
                    qty: parseInt($(this).find("input[name='qtys_in[]']").val()) || 0
                });
            });
            
            // Gather site OUT rows
            let sites_out = [];
            $("#siteOutContainer .siteOut").each(function () {
                let siteId = $(this).find("select[name='sites_out[]']").val();
                let clientId = $(this).find("select[name='clients_out[]']").val(); // attach client per site
                if (!siteId) return; // skip empty

                sites_out.push({
                    id: siteId,
                    client_id: clientId || null,
                    type: $(this).find("input[name='types_out[]']").val(),
                    size: $(this).find("input[name='sizes_out[]']").val(),
                    qty: parseInt($(this).find("input[name='qtys_out[]']").val()) || 0
                });
            });

            // Send request
            $.ajax({
                type: 'POST',
                url: "{{ route('stockInventory.create') }}",
                data: JSON.stringify({
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    contractor_id: contractor_id,
                    date_in: date_in,
                    date_out: date_out,
                    remarks_in: remarks_in,
                    remarks_out: remarks_out,
                    sites_in: sites_in,   // ✅ contains client + site info
                    sites_out: sites_out, // ✅ contains client + site info
                    bal_contractor: bal_contractor,
                    bal_bgoc: bal_bgoc
                }),
                contentType: "application/json",   // 👈 send JSON
                dataType: "json",
                success: function(response) {
                    // Close modal after successfully edited
                    closeAltEditorModal("#inventoryAddModal");

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Reset form
                    $('#inventoryAddModal input[type="text"], #inventoryAddModal input[type="number"], #inventoryAddModal input[type="date"]').val('');
                    $('#inventoryAddModal select').val('').trigger('change');
                    $('#siteInContainer').empty();
                    $('#siteOutContainer').empty();

                    // Reload table
                    $('#inventory_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    var error = "Error: " + response.error;
                    window.showSubmitToast(error, "#D32929");
                }
            });
        }


        // Edit Client 
        function editContractor() {
            var company = document.getElementById("contractorEditCompanyName").value;
            var name = document.getElementById("contractorEditPICName").value;
            var phone = document.getElementById("contractorEditPhone").value;

            $.ajax({
                type: 'POST',
                url: "{{ route('contractors.edit') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    company: company,
                    name: name,
                    phone: phone,
                    id: inventoryId,
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#inventoryEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully updated.", "#91C714");

                    // Clean fields
                    document.getElementById("contractorEditCompanyName").value = "";
                    document.getElementById("contractorEditPICName").value = "";
                    document.getElementById("contractorEditPhone").value = "";

                    // Reload table
                    $('#inventory_table').DataTable().ajax.reload();
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

        // // Setup the contractors datatable
        // function initStockInventoryDatatable() {
        //     const dt = new Date();
        //     const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
        //     const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
        //     const $fileName = `Stock_Inventory_List_${formattedDate}_${formattedTime}`;

        //     const table = $('#inventory_table').DataTable({
        //         altEditor: true, // Enable altEditor
        //         destroy: true,
        //         debug: true,
        //         processing: true,
        //         searching: true,
        //         serverSide: true,
        //         ordering: true,
        //         order: [
        //             [0, 'desc']
        //         ],
        //         pagingType: 'full_numbers',
        //         pageLength: 25,
        //         aLengthMenu: [
        //             [25, 50, 75, -1],
        //             [25, 50, 75, "All"]
        //         ],
        //         iDisplayLength: 25,
        //         ajax: {
        //             url: "{{ route('stockInventory.list') }}",
        //             dataType: "json",
        //             type: "POST",
        //             data: function(d) {
        //                 d._token = $('meta[name="csrf-token"]').attr('content');
        //                 d.company = filterClientCompany;
        //                 return d;
        //             },
        //             dataSrc: function(json) {
        //                 json.recordsTotal = json.recordsTotal;
        //                 json.recordsFiltered = json.recordsFiltered;
        //                 return json.data;
        //             }
        //         },
        //         dom: "lBfrtip",
        //         buttons: [{
        //                 extend: "csv",
        //                 className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
        //                 title: $fileName,
        //                 exportOptions: {
        //                     columns: ":not(.dt-exclude-export)"
        //                 },
        //                 init: function(api, node, config) {
        //                     $(node).removeClass('dt-button');
        //                     $(node).removeClass('buttons-html5');
        //                 },
        //             },
        //             {
        //                 extend: "excel",
        //                 className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
        //                 title: $fileName,
        //                 exportOptions: {
        //                     columns: ":not(.dt-exclude-export)"
        //                 },
        //                 init: function(api, node, config) {
        //                     $(node).removeClass('dt-button');
        //                     $(node).removeClass('buttons-html5');
        //                 },
        //             },
        //             {
        //                 extend: "print",
        //                 className: "button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white",
        //                 title: $fileName,
        //                 // including printing image
        //                 exportOptions: {
        //                     stripHtml: false,
        //                 },
        //                 init: function(api, node, config) {
        //                     $(node).removeClass('dt-button');
        //                     $(node).removeClass('buttons-html5');
        //                 },
        //             },
        //         ],
        //         columns: [
        //             {
        //                 data: null,
        //                 name: 'no',
        //                 orderable: false,
        //                 searchable: false,
        //                 render: function (data, type, row, meta) {
        //                     return meta.row + meta.settings._iDisplayStart + 1;
        //                 }
        //             },
        //             { data: "contractor", name: "contractor" },          // Contractor
        //             { data: "client_in_name", name: "client_in_name" },  // Client In
        //             { data: "billboard_in_site", name: "billboard_in_site" }, // Site
        //             // { data: "billboard_in_type", name: "billboard_in_type" }, // Type
        //             // { data: "billboard_in_size", name: "billboard_in_size" }, // Size In
        //             { data: "quantity_in", name: "quantity_in" },        // Quantity In
        //             { data: "remarks_in", name: "remarks_in" },          // Remarks In
        //             { data: "date_in", name: "date_in" },                // Date In
        //             { data: "balance_contractor", name: "balance_contractor" }, // Bal Contractor
        //             { data: "balance_bgoc", name: "balance_bgoc" },      // Bal BGOC
        //             { data: "date_out", name: "date_out" },              // Date Out
        //             { data: "quantity_out", name: "quantity_out" },      // Quantity Out
        //             // { data: "billboard_out_size", name: "billboard_out_size" }, // Size Out
        //             // { data: "billboard_out_size", name: "billboard_out_type" }, // type Out
        //             { data: "billboard_out_site", name: "billboard_out_site" }, // Site Out
        //             { data: "client_out_name", name: "client_out_name" }, // Client Out
        //             { data: "remarks_out", name: "remarks_out" },        // Remarks Out
        //             {
        //                 data: "id",
        //                 orderable: false,
        //                 render: function(data) {
        //                     return `
        //                         <div class="flex items-center justify-center space-x-3">
        //                             <a href="javascript:;" class="text-theme-6" 
        //                             data-toggle="modal" data-target="#contractorDeleteModal" 
        //                             id="delete-${data}" title="Delete">
        //                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" 
        //                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
        //                                     <polyline points="3 6 5 6 21 6"></polyline>
        //                                     <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
        //                                         a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        //                                     <line x1="10" y1="11" x2="10" y2="17"></line>
        //                                     <line x1="14" y1="11" x2="14" y2="17"></line>
        //                                 </svg>
        //                             </a>
        //                         </div>`;
        //                 }
        //             },
        //         ],

        //     });

        //     // Add classes to the "dt-buttons" div
        //     var dtButtonsDiv = document.querySelector(".dt-buttons");
        //     if (dtButtonsDiv) {
        //         dtButtonsDiv.classList.add("mt-2");
        //     }

        //     // Update styling for the filter input
        //     var filterDiv = document.getElementById("inventory_table_filter");
        //     if (filterDiv) {
        //         filterDiv.style.float = "right";
        //         filterDiv.classList.remove('dataTables_filter');

        //         var inputElement = filterDiv.querySelector("label input");
        //         if (inputElement) {
        //             inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
        //         }
        //     }

        //     // Update styling for the info and paginate elements
        //     var infoDiv = document.getElementById("inventory_table_info");
        //     var paginateDiv = document.getElementById("inventory_table_paginate");

        //     if (infoDiv) {
        //         infoDiv.style.float = "left";
        //         infoDiv.classList.add("mt-5");
        //     }

        //     if (paginateDiv) {
        //         paginateDiv.style.float = "right";
        //         paginateDiv.classList.add("mt-5");
        //     }

        //     // Update styling for the "client_users_table_length" div and its select element
        //     var existingDiv = document.getElementById("inventory_table_length");
        //     if (existingDiv) {
        //         existingDiv.classList.remove('dataTables_length');
        //         existingDiv.classList.add('mt-2', 'mb-1');

        //         var existingSelect = existingDiv.querySelector('select');
        //         if (existingSelect) {
        //             existingSelect.className = 'input sm:w-auto border';
        //         }
        //     }

        //     // Open modal to edit client
        //     inventoryEditModal();
        // };

        // stock inventory datatable
        $('#inventory_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('stockInventory.list') }}",
                type: "POST",
                data: function (d) {
                    d._token = "{{ csrf_token() }}";
                    // add extra filters if needed
                    d.company = filterClientCompany;
                    return d;
                }
            },
            columns: [
                {
                    data: null,
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'contractor', name: 'contractors.name' }, // Contractor
                { data: 'client_in_name', name: 'client_companies.name' }, // Client
                { data: 'site_in', name: 'site_in.name' }, // Site
                { data: 'quantity_in', name: 'transactions_in.quantity' }, // Quantity In
                { data: 'remarks_in', name: 'transactions_in.remarks' }, // Remarks In
                { data: 'date_in', name: 'transactions_in.transaction_date' }, // Date In
                { data: 'balance_contractor', name: 'stock_inventories.balance_contractor' }, // Bal - Contractor
                { data: 'balance_bgoc', name: 'stock_inventories.balance_bgoc' }, // Bal - BGOC
                { data: 'date_out', name: 'transactions_out.transaction_date' }, // Date Out
                { data: 'remarks_out', name: 'transactions_out.remarks' }, // Remarks Out
                { data: 'quantity_out', name: 'transactions_out.quantity' }, // Quantity Out
                { data: 'site_out', name: 'site_out.name' }, // Site Out
                { data: 'client_out', name: 'client_companies.name' }, // Client Out
                { data: 'action', name: 'action', orderable: false, searchable: false } // Action
            ],
            order: [[0, 'asc']], // sort by No.
            
            // 👇 This is where we merge Contractor + Bal-Contractor + Bal-BGOC
            drawCallback: function(settings) {
                let api = this.api();
                let rows = api.rows({ page: 'current' }).nodes();
                let lastContractor = null;
                let lastBalanceContractor = null;
                let lastBalanceBgoc = null;
                let groupStart = 0;

                api.column(1, { page: 'current' }).data().each(function(contractor, i) {
                    let balanceContractor = api.cell(i, 7).data();
                    let balanceBgoc = api.cell(i, 8).data();

                    if (contractor !== lastContractor || balanceContractor !== lastBalanceContractor || balanceBgoc !== lastBalanceBgoc) {
                        if (i > groupStart) {
                            let rowCount = i - groupStart;
                            $('td:eq(1)', rows[groupStart]).attr('rowspan', rowCount);
                            $('td:eq(7)', rows[groupStart]).attr('rowspan', rowCount);
                            $('td:eq(8)', rows[groupStart]).attr('rowspan', rowCount);

                            // hide duplicate cells instead of removing
                            for (let j = groupStart + 1; j < i; j++) {
                                $('td:eq(1)', rows[j]).css('display', 'none');
                                $('td:eq(7)', rows[j]).css('display', 'none');
                                $('td:eq(8)', rows[j]).css('display', 'none');
                            }
                        }
                        groupStart = i;
                        lastContractor = contractor;
                        lastBalanceContractor = balanceContractor;
                        lastBalanceBgoc = balanceBgoc;
                    }
                });

                // handle last group
                let totalRows = api.rows({ page: 'current' }).data().length;
                if (groupStart < totalRows) {
                    let rowCount = totalRows - groupStart;
                    $('td:eq(1)', rows[groupStart]).attr('rowspan', rowCount);
                    $('td:eq(7)', rows[groupStart]).attr('rowspan', rowCount);
                    $('td:eq(8)', rows[groupStart]).attr('rowspan', rowCount);

                    for (let j = groupStart + 1; j < totalRows; j++) {
                        $('td:eq(1)', rows[j]).css('display', 'none');
                        $('td:eq(7)', rows[j]).css('display', 'none');
                        $('td:eq(8)', rows[j]).css('display', 'none');
                    }
                }
            }

        });


        // Open modal to edit client
        function inventoryEditModal() {
            $(document).off('click', "#inventory_table tbody tr td:not(:last-child)");

            $(document).on('click', "#inventory_table tbody tr td:not(:last-child)", function (e) {
                const $row = $(this).closest('tr');
                const rowData = $('#inventory_table').DataTable().row($row).data();

                if (!rowData) return;

                // Optional: grab ID from last column (if needed)
                const btn = $row.find('td:last-child a[id^="delete-"]');
                if (btn.length) {
                    inventoryId = btn.attr('id').split('-')[1];
                }

                // Populate modal fields
                populateInventoryEditModal(rowData);

                // Open modal
                openAltEditorModal("#inventoryEditModal");
            });
        }

        function populateInventoryEditModal(data) {
            // Contractor
            $('#editContractorName').val(data.contractor_id);

            // Client In / Out
            $('#editClientIn').val(data.client_in_id);
            $('#editClientOut').val(data.client_out_id);

            // Dates & Remarks
            $('#inventoryEditModal input[name="date_in"]').val(data.date_in);
            $('#inventoryEditModal input[name="date_out"]').val(data.date_out);
            $('#inventoryEditModal input[name="remarks_in"]').val(data.remarks_in);
            $('#inventoryEditModal input[name="remarks_out"]').val(data.remarks_out);

            // Clear existing site rows
            $('#siteInEditContainer').empty();
            $('#siteOutEditContainer').empty();

            // Populate In Sites
            (data.sites_in || []).forEach(site => {
                const row = `
                <div class="siteInEdit">
                    <div class="mb-3">
                        <label class="block">Site</label>
                        <select class="input w-full border mt-2 select2" name="sites_in_edit[]">
                            <option value="${site.id}" selected>${site.site_number} - ${site.name}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block">Type</label>
                        <input type="text" class="input w-full border mt-1" name="types_in_edit[]" value="${site.type}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="block">Size</label>
                        <input type="text" class="input w-full border mt-1" name="sizes_in_edit[]" value="${site.size}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="block"><strong>Quantity In</strong></label>
                        <input type="number" class="input w-full border mt-1" name="qtys_in_edit[]" value="${site.qty}">
                    </div>
                    <div class="mb-3">
                        <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteInEdit(this)">Remove</a>
                    </div>
                </div>`;
                $('#siteInEditContainer').append(row);
            });

            // Populate Out Sites
            (data.sites_out || []).forEach(site => {
                const row = `
                <div class="siteOutEdit">
                    <div class="mb-3">
                        <label class="block">Site</label>
                        <select class="input w-full border mt-2 select2" name="sites_out_edit[]">
                            <option value="${site.id}" selected>${site.site_number} - ${site.name}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block">Type</label>
                        <input type="text" class="input w-full border mt-1" name="types_out_edit[]" value="${site.type}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="block">Size</label>
                        <input type="text" class="input w-full border mt-1" name="sizes_out_edit[]" value="${site.size}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="block"><strong>Quantity Out</strong></label>
                        <input type="number" class="input w-full border mt-1" name="qtys_out_edit[]" value="${site.qty}">
                    </div>
                    <div class="mb-3">
                        <a href="javascript:void(0);" class="button bg-theme-6 text-white" onclick="removeSiteOutEdit(this)">Remove</a>
                    </div>
                </div>`;
                $('#siteOutEditContainer').append(row);
            });

            // Reinitialize Select2
            $('.select2').select2();
        }


        var filterClientCompany;

        // When "filterClientButton" button is clicked, initiate filterClientCompany
        function filterClientButton() {
            filterClientCompany = document.getElementById("fliterClient").value;
            // initStockInventoryDatatable(filterClientCompany);
        };

        // When page first loads, load tables
        filterClientButton();

        // Store the ID of the last clicked modal when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();

        // Delete Client Company
        function contractorDeleteButton() {
            var id = lastClickedLink.split("-")[1];

            $.ajax({
                type: 'POST',
                url: "{{ route('stockInventory.delete') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#contractorDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#inventory_table').DataTable().ajax.reload();
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
    })
</script>
@endsection('script')