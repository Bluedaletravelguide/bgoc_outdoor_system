@extends('layouts.main')

@section('title')
<title>Chulia Middle East - PurchaseOrder</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Purchase Order
    </h2>
</div>

<div class="intro-y box p-5 mt-5">
    <!-- BEGIN: Filter & Add New Purchase Order-->
    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
        <!-- BEGIN: Filter -->
        <form class="xl:flex sm:mr-auto">
            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Supplier</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputSupplierId">
                    <option value="all">ALL</option>
                    
                    @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row sm:flex items-center sm:mr-4">
                <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Warranty <br> Status</label>
                <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputWarrantyStatus">
                    <option value="all">ALL</option>
                    <option value="valid">VALID</option>
                    <option value="expired">EXPIRED</option>
                </select>
            </div>

            <div class="mt-2 xl:mt-0">
                <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterPurchaseOrderButton">Filter</button>
            </div>
        </form>          
        <!-- END: Filter -->

        <!-- BEGIN: Add New Purchase Order Button -->
        <div class="text-center"> 
            <a href="javascript:;" data-toggle="modal" data-target="#purchaseOrderAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white" id="purchaseOrderAddModalButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New Purchase Order
            </a> 
        </div>
        <!-- END: Add New Purchase Order Button -->
    </div>
    <!-- END: Filter & Add New Purchase Order -->

    <!-- BEGIN: Purchase Order List -->
    <div class="overflow-x-auto scrollbar-hidden">
        <table class="table table-report mt-5" id="purchaseOrder_table">
            <thead>
                <tr class="bg-theme-1 text-white">
                    <th>#</th>
                    <th>Receipt Reference ID</th>
                    <th>Price</th>
                    <th>Purchase Date</th> 
                    <th>Warranty From</th>
                    <th>Warranty Until</th>
                    <th class="dt-no-sort">Warranty Status</th>
                    <th>Description</th>
                    <th class="dt-exclude-export dt-no-sort">Actions</th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>
    <!-- END: Purchase Order List -->
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Purchase Order Add Modal -->
<div class="modal rounded-sm" id="purchaseOrderAddModal"> 
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5"> 
            <h2 class="font-medium text-base mr-auto">Add New Purchase Order</h2>
        </div>
        
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">    
                    <label>Receipt Reference Number</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Receipt Reference Number" id="purchaseOrderAddReceiptReferenceNumber" required>
                </div>

                <div class="col-span-12 sm:col-span-12">    
                    <label>Price</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Price" id="purchaseOrderAddPrice" required>
                </div>

                <div class="col-span-12 sm:col-span-12">    
                    <label>Purchase Date</label>
                    <input class="datepicker input w-full border mt-2 flex-1" id="purchaseOrderAddPurchaseDate" required>
                </div>
                
                <div class="col-span-12 sm:col-span-12">    
                    <label>Warranty</label>
                    <input class="datepicker input w-full border mt-2 flex-1" id="purchaseOrderAddWarranty" required>
                </div>

                <div class="col-span-12 sm:col-span-12">    
                    <label>Supplier</label>
                    <select class="input w-full border mt-2 flex-1" placeholder="Supplier ID" id="purchaseOrderAddSupplierID" required>
                        <option disabled selected hidden>Select an option</option>

                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-span-12 sm:col-span-12">    
                    <label>Description  (Optional)</label>
                    <textarea class="input w-full border mt-2 flex-1" placeholder="Description" id="purchaseOrderAddDescription"></textarea>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="purchaseOrderAddButton">Save</button>
            </div>
        </form>    
    </div> 
</div>
<!-- END: Purchase Order Add Modal -->

<!-- BEGIN: Purchase Order Edit Modal -->
<div class="modal" id="purchaseOrderEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Purchase Order</h2>
        </div>

        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Receipt Reference Number</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Receipt Reference Number" id="purchaseOrderEditReceiptReferenceNumber" required>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>Price</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Price" id="purchaseOrderEditPrice" required>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label>Purchase Date</label>
                    <input class="datepicker input w-full border mt-2 flex-1" id="purchaseOrderEditPurchaseDate" required>
                </div>

                <div class="col-span-12 sm:col-span-12">    
                    <label>Warranty</label>
                    <input class="datepicker input w-full border mt-2 flex-1" id="purchaseOrderEditWarranty" required>
                </div>

                <div class="col-span-12 sm:col-span-12">    
                    <label>Supplier</label>
                    <select class="input w-full border mt-2 flex-1" placeholder="Supplier ID" id="purchaseOrderEditSupplierID" required>
                        <option disabled selected hidden>Select an option</option>

                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-12 sm:col-span-12">    
                    <label>Description  (Optional)</label>
                    <textarea class="input w-full border mt-2 flex-1" placeholder="Description" id="purchaseOrderEditDescription"></textarea>
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="purchaseOrderEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Purchase Order Edit Modal -->

<!-- BEGIN: Purchase Order Delete Modal -->
<div class="modal" id="purchaseOrderDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting this purchase order? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="purchaseOrderDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Purchase Order Delete Modal -->
@endsection('modal_content')

@section('script')
<script src="{{ asset('/dist/js/dayjs.min.js')}}"></script>

<script>  	
    $(document).ready(function() {
        //Global variable
        var inputSupplierId ;
        var inputWarrantyStatus ;
        var delete_purchaseOrder_id ;
        var original_purchaseOrder_id ;
        var purchaseOrderAddPurchaseDateCalendar ;
        var purchaseOrderAddWarrantyCalendar ;
        var purchaseOrderEditPurchaseDateCalendar ;
        var purchaseOrderEditWarrantyCalendar ;

        //Date variables 
        var dateNow         = dayjs().format('D MMM, YYYY');
        var dateNextMonth   = dayjs().add(1, 'M').format('D MMM, YYYY');

        // Listen to below buttons
        document.getElementById("filterPurchaseOrderButton").addEventListener("click", filterPurchaseOrderButton);
        document.getElementById("purchaseOrderAddButton").addEventListener("click", purchaseOrderAddButton);
        document.getElementById("purchaseOrderDeleteButton").addEventListener("click", purchaseOrderDeleteButton);
        document.getElementById('purchaseOrderAddModalButton').addEventListener('click', purchaseOrderAddModalButton);

        //When page first loads, load the purchase order table
        filterPurchaseOrderButton() ;

        function filterVendorCompanyButton(){
            vendorCompanyDatatable();
            deleteAltEditorModal();
        };

        function filterPurchaseOrderButton() {
            inputSupplierId     = document.getElementById("inputSupplierId").value ;
            inputWarrantyStatus = document.getElementById("inputWarrantyStatus").value ;

            purchaseOrderDatatable() ;
        };

        //When any sumbit button is clicked
        (function(){
            var purchaseOrder_table = $('#purchaseOrder_table')[0].altEditor ;

            document.getElementById('purchaseOrderAddButton').addEventListener('click', function(e) {
                // Prevent the default from submission behavior
                e.preventDefault();
            });

            document.getElementById('purchaseOrderEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit purchase order
                editPurchaseOrder();
            });
        })();

        // When any delete button is clicked
        (function() {
            var lastClickedLink;

            // Store the ID of the last clicked link when it's triggered and stored id in delete button
            $(document).on('click', "[data-target='#purchaseOrderDeleteModal']", function() {
                lastClickedLink = $(this).attr('id');
                delete_purchaseOrder_id = lastClickedLink.split("-")[2];
            });
        })();

        //Adjust the litepicker settings 
        function purchaseOrderAddModalButton() {
            //Get the current date
            let currentDate = new Date();

            //Create a new calendar for purchase date in add function if not exists. 
            if(purchaseOrderAddPurchaseDateCalendar) {
                purchaseOrderAddPurchaseDateCalendar.setDate(dateNow);

            } else {
                document.getElementById("purchaseOrderAddPurchaseDate").value = dateNow ;

                purchaseOrderAddPurchaseDateCalendar = new Litepicker({
                    element: document.getElementById("purchaseOrderAddPurchaseDate"),
                    autoApply: false,
                    singleMode: true,
                    numberOfColumns: 1,
                    numberOfMonths: 1,
                    showWeekNumbers: true,
                    allowRepick: true,
                    autoRefresh: true,
                    format: "D MMM, YYYY",
                    dropdowns: {
                        minYear: currentDate.getFullYear() - 30,
                        maxYear: currentDate.getFullYear() + 30,
                        months: true,
                        years: true,
                    },
                });
            }

            //Create a new calendar for warranty in add function if not exists.
            if(purchaseOrderAddWarrantyCalendar) {
                purchaseOrderAddWarrantyCalendar.setDateRange(dateNow, dateNextMonth);

            } else {
                document.getElementById("purchaseOrderAddWarranty").value = dateNow + ' - ' + dateNextMonth ;

                purchaseOrderAddWarrantyCalendar = new Litepicker({
                    element: document.getElementById("purchaseOrderAddWarranty"),
                    autoApply: false,
                    singleMode: false,
                    numberOfColumns: 2,
                    numberOfMonths: 2,
                    showWeekNumbers: true,
                    allowRepick: true,
                    autoRefresh: true,
                    format: "D MMM, YYYY",
                    dropdowns: {
                        minYear: currentDate.getFullYear() - 30,
                        maxYear: currentDate.getFullYear() + 30,
                        months: true,
                        years: true,
                    },
                });
            }

            //Adjust the margin of modal
            modalMarginFunction('purchaseOrderAddModal');

            //Adjust the XY position of litepicker when scrolling
            litepickerPositioinAdjustion('purchaseOrderAddModal', ['purchaseOrderAddPurchaseDate', 'purchaseOrderAddWarranty']);
        };

        // Initiate altEditor for purchase order datatable
        function initAltEditorEditPurchaseOrder() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='purchaseOrder_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='purchaseOrder_table'] tbody tr td:not(:last-child)", function() {
                //Get the current date. 
                let currentDate = new Date();
                
                let referenceNumber = $(event.target).closest('tr').find('td:nth-child(' + '2' + ')').text();
                let price           = $(event.target).closest('tr').find('td:nth-child(' + '3' + ')').text();
                let purchaseDate    = $(event.target).closest('tr').find('td:nth-child(' + '4' + ')').text();
                let warrantyFrom    = $(event.target).closest('tr').find('td:nth-child(' + '5' + ')').text();
                let warrantyTo      = $(event.target).closest('tr').find('td:nth-child(' + '6' + ')').text();
                let supplierID      = $(event.target).closest('tr').find('td:nth-child(' + '1' + ') p').attr('id').split('-')[1];
                let description     = !$(event.target).closest('tr').find('td:nth-child(' + '8' + ') p').hasClass('italic') ? $(event.target).closest('tr').find('td:nth-child(' + '8' + ')').text() : "" ;

                // Assign original id to global variable
                original_purchaseOrder_id = $(event.target).closest('tr').find('td:nth-child(' + '1' + ') p').attr('id').split('-')[0];

                // Place values to edit form fields in the modal
                document.getElementById("purchaseOrderEditReceiptReferenceNumber").value    = referenceNumber ;
                document.getElementById("purchaseOrderEditPrice").value                     = price ;
                document.getElementById("purchaseOrderEditPurchaseDate").value              = purchaseDate ;
                document.getElementById("purchaseOrderEditWarranty").value                  = warrantyFrom + " - " + warrantyTo ;
                document.getElementById("purchaseOrderEditSupplierID").value                = supplierID ;
                document.getElementById("purchaseOrderEditDescription").value               = description ;

                //Create a new calendar for purchase date in edit function if not exists. 
                if(purchaseOrderEditPurchaseDateCalendar) {
                    purchaseOrderEditPurchaseDateCalendar.setDate(purchaseDate);

                } else {
                    purchaseOrderEditPurchaseDateCalendar = new Litepicker({
                        element: document.getElementById("purchaseOrderEditPurchaseDate"),
                        autoApply: false,
                        singleMode: true,
                        numberOfColumns: 1,
                        numberOfMonths: 1,
                        showWeekNumbers: true,
                        allowRepick: true,
                        autoRefresh: true,
                        format: "D MMM, YYYY",
                        dropdowns: {
                            minYear: currentDate.getFullYear() - 30,
                            maxYear: currentDate.getFullYear() + 30,
                            months: true,
                            years: true,
                        },
                    });
                }

                //Create a new calendar for warranty in edit function if not exists.
                if(purchaseOrderEditWarrantyCalendar) {
                    purchaseOrderEditWarrantyCalendar.setDateRange(warrantyFrom, warrantyTo);

                } else {
                    purchaseOrderEditWarrantyCalendar = new Litepicker({
                        element: document.getElementById("purchaseOrderEditWarranty"),
                        autoApply: false,
                        singleMode: false,
                        numberOfColumns: 2,
                        numberOfMonths: 2,
                        showWeekNumbers: true,
                        allowRepick: true,
                        autoRefresh: true,
                        format: "D MMM, YYYY",
                        dropdowns: {
                            minYear: currentDate.getFullYear() - 30,
                            maxYear: currentDate.getFullYear() + 30,
                            months: true,
                            years: true,
                        },
                    });
                }

                // Open modal
                var element = "#purchaseOrderEditModal";
                openAltEditorModal(element);

                //Adjust the margin of modal
                modalMarginFunction('purchaseOrderEditModal');

                //Adjust the XY position of litepicker when scrolling
                litepickerPositioinAdjustion('purchaseOrderEditModal', ['purchaseOrderEditPurchaseDate', 'purchaseOrderEditWarranty']);
            });
        }

        // Delete altEditor modal
        function deleteAltEditorModal() {
            // Replace "altEditor-modal-" with the known part of the ID
            var pattern = "altEditor-modal-";

            // Find all elements whose IDs match the pattern
            var elementsToDelete = document.querySelectorAll('[id^="' + pattern + '"]');

            // Loop through the matched elements and delete them
            if (elementsToDelete.length > 0) {
                // Remove the element
                elementsToDelete.forEach(function(element) {
                    element.remove();
                });
            }
        };
        
        // Open altEditor modal
        function openAltEditorModal(element) {
            cash(element).modal('show');
        };

        // Close altEditor modal
        function closeAltEditorModal(element) {
            cash(element).modal('hide');
        };

        // Function to adjust the margin modal to fit litepicker
        function modalMarginFunction(modal) {
            setTimeout(() => {
                if(document.getElementById(modal).classList.contains('show')) {
                    //Reset the margin back to auto
                    cash('.modal__content').css({'margin-left' : 'auto', 'margin-right' : 'auto'});

                    let modalMarginLeft     = parseFloat(cash('.modal__content').css('margin-left'));
                    let overflowLitepicker  = modalMarginLeft - 220 ;

                    if(!(overflowLitepicker > 0)) {
                        //Increase the margin of modal if litepicker is too big 
                        cash('.modal__content').css({'margin-left' : '', 'margin-right' : ''});
                        cash('.modal__content').css({'margin-left' : modalMarginLeft + 'px', 'margin-right' : (modalMarginLeft - overflowLitepicker) + 'px'});
                    }
                }
            }, 400);
        };

        // Function to adjust the XY position of litepicker when scrolling
        function litepickerPositioinAdjustion(modal, litepicker) {
            let closestLitepicker ;
            let scrollFunction ;
            let litepickerCurrentX ;
            let litepickerCurrentY ;
            let modalCurrentX ;
            let modalCurrentY ;
            let modalNewX ;
            let modalNewY ;

            document.getElementById(modal).removeEventListener("scroll", scrollFunction);

            litepicker.forEach((element) => {
                document.getElementById(element).addEventListener("click", () => {
                    closestLitepicker = $('.litepicker').filter(function() {
                        return $(this).css('display') === 'block';
                    });

                    litepickerCurrentX  = parseFloat(closestLitepicker.css('left'));
                    litepickerCurrentY  = parseFloat(closestLitepicker.css('top'));
                    modalCurrentX       = document.getElementById(modal).scrollLeft ;
                    modalCurrentY       = document.getElementById(modal).scrollTop ;
                        
                    document.getElementById(modal).addEventListener("scroll", scrollFunction);
                });
            })

            //Adjust the litepicker position when scrolling
            scrollFunction = () => {
                modalNewX = document.getElementById(modal).scrollLeft ;
                modalNewY = document.getElementById(modal).scrollTop ;

                closestLitepicker.css('left', litepickerCurrentX - (modalNewX - modalCurrentX) + 'px');
                closestLitepicker.css('top', litepickerCurrentY - (modalNewY - modalCurrentY) + 'px');
            };
        }
        
        // Setup the purchase order datatable
        function purchaseOrderDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName     = `Purchase_Order_List_${formattedDate}_${formattedTime}`;

            const table = $('#purchaseOrder_table').DataTable({
                altEditor   : true, // Enable altEditor
                autoWidth   : false,
                destroy     : true,
                debug       : true,
                processing  : true,
                scrollX     : true,
                searching   : true,
                serverSide  : true,
                ordering    : true,
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
                    url      : "{{ route('purchaseOrder.list') }}",
                    dataType : "json",
                    type     : "POST",
                    data: function(d) {
                        d._token         = $('meta[name="csrf-token"]').attr('content');
                        d.supplierId     = inputSupplierId ;
                        d.warrantyStatus = inputWarrantyStatus ;

                        return d;
                    },
                    dataSrc: function(json) {
                        //console.log(json);
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
                            columns: ":not(.dt-exclude-export)",
                            stripHtml: false,
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                ],
                drawCallback: function(settings){
                    //Fix the length of description column
                    $(this.api().column(6).nodes()).css('max-width', '450px');
                    $(this.api().column(6).nodes()).css('word-wrap', 'break-word');
                },
                columns: [
                    {
                        data: {
                            "id"          : "id",
                            "supplier_id" : "supplier_id",
                        },
                        render: function(data, type, row) {
                            //Combine the "id" of purchase order and "supplier_id" assigned into the "id" field.
                            element = `<p id=`+ data.id +`-`+ data.supplier_id +`>`+ data.id +`</p>` ;
                            
                            return element ;
                        }
                    },                    
                    {
                        data: "receipt_reference_number",
                    },
                    {
                        data: "price",
                    },
                    {
                        data: "purchase_date",
                    },
                    {
                        data: "warranty_from",
                    },
                    {
                        data: "warranty_until",
                    },
                    {
                        data: "warranty_status",
                        render: function(data, type, row) {
                            let element ;

                            if(data == 'VALID') {
                                element = `<a class="px-2 py-1 rounded-full mr-1 mb-2 bg-theme-9 text-xs font-medium text-center text-white">` + data + `</a>` ;
                            } else {
                                element = `<a class="px-2 py-1 w-24 rounded-full mr-1 mb-2 bg-theme-6 text-xs font-medium text-center text-white">` + data + `</a>` ;
                            }

                            return element ;
                        }
                    },
                    {
                        data: "description",
                        render: function(data, type, row) {
                            let element ;

                            if(data) {
                                element = data ;
                            }else {
                                element = `<p class="italic text-gray-600">[ NO DATA ]</p>` ;
                            }
                            
                            return element ;
                        }
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                                <a class="button w-24 inline-block mr-1 mb-2 border border-theme-6 flex items-center justify-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#purchaseOrderDeleteModal" id="delete-vendorCompany-` + data + `">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg> 
                                    Delete
                                </a>
                            `;
                            
                            return element;
                        }
                    },
                ],
                columnDefs: [{
                    targets: 'dt-no-sort',
                    orderable: false
                }],
            });

            // Add classes to the "dt-buttons" div
            var dtButtonsDiv = document.querySelector(".dt-buttons");
            if (dtButtonsDiv) {
                dtButtonsDiv.classList.add("mt-2");
            }

            // Update styling for the filter input
            var filterDiv = document.getElementById("purchaseOrder_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("purchaseOrder_table_info");
            var paginateDiv = document.getElementById("purchaseOrder_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "vendorCompany_table_length" div and its select element
            var existingDiv = document.getElementById("purchaseOrder_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Update styling for the first "dataTables_scrollBody" if enable the scrollX feature for DataTable
            var existingScrollBody = document.querySelector("div.dataTables_scrollBody")
            if(existingScrollBody){
                existingScrollBody.style.marginTop = "-20px";
            };

            // AltEditor
            initAltEditorEditPurchaseOrder();
        };

        // Add New Purchase Order
        function purchaseOrderAddButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('purchaseOrder.create') }}",
                data: {
                    _token                      : $('meta[name="csrf-token"]').attr('content'),
                    receipt_reference_number    : document.getElementById("purchaseOrderAddReceiptReferenceNumber").value,
                    price                       : document.getElementById("purchaseOrderAddPrice").value,
                    purchase_date               : document.getElementById("purchaseOrderAddPurchaseDate").value,
                    warranty                    : document.getElementById("purchaseOrderAddWarranty").value,
                    supplier_id                 : document.getElementById("purchaseOrderAddSupplierID").value,
                    description                 : document.getElementById("purchaseOrderAddDescription").value,
                },

                success: function(response) {
                    console.log(response) ;
                    // Close modal after successfully edited
                    var element = "#purchaseOrderAddModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("purchaseOrderAddReceiptReferenceNumber").value = "" ;
                    document.getElementById("purchaseOrderAddPrice").value                  = "" ;
                    document.getElementById("purchaseOrderAddPurchaseDate").value           = dateNow ;
                    document.getElementById("purchaseOrderAddWarranty").value               = dateNow + ' - ' + dateNextMonth ;
                    document.getElementById("purchaseOrderAddSupplierID").value             = "" ;
                    document.getElementById("purchaseOrderAddDescription").value            = "" ;

                    // Reload table
                    $('#purchaseOrder_table').DataTable().ajax.reload();
                },

                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response = JSON.parse(xhr.responseText);
                    var error    = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        };

        //Edit purchase order
        function editPurchaseOrder(){
            $.ajax({
                type: 'POST',
                url: "{{ route('purchaseOrder.edit') }}",
                data: {
                    _token                      : $('meta[name="csrf-token"]').attr('content'),
                    original_purchaseOrder_id   : original_purchaseOrder_id, 
                    receipt_reference_number    : document.getElementById("purchaseOrderEditReceiptReferenceNumber").value,
                    price                       : document.getElementById("purchaseOrderEditPrice").value,
                    purchase_date               : document.getElementById("purchaseOrderEditPurchaseDate").value,
                    warranty                    : document.getElementById("purchaseOrderEditWarranty").value,
                    supplier_id                 : document.getElementById("purchaseOrderEditSupplierID").value,
                    description                 : document.getElementById("purchaseOrderEditDescription").value,
                },
                success: function(response) {
                    console.log(response);
                    // Close modal after successfully edited
                    var element = "#purchaseOrderEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully edited.", "#91C714");

                    // Clean fields
                    document.getElementById("purchaseOrderEditReceiptReferenceNumber").value = "";
                    document.getElementById("purchaseOrderEditPrice").value                  = "";
                    document.getElementById("purchaseOrderEditPurchaseDate").value           = "";
                    document.getElementById("purchaseOrderEditWarranty").value               = "";
                    document.getElementById("purchaseOrderEditSupplierID").value             = "";
                    document.getElementById("purchaseOrderEditDescription").value            = "";

                    // Reload table
                    $('#purchaseOrder_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response    = JSON.parse(xhr.responseText);
                    var error       = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        };

        // Delete Purchase Order
        function purchaseOrderDeleteButton() {
            $.ajax({
                type: 'POST',
                url: "{{ route('purchaseOrder.delete') }}",
                data: {
                    _token                  : $('meta[name="csrf-token"]').attr('content'),
                    delete_purchaseOrder_id : delete_purchaseOrder_id,
                },
                success: function(response) {
                    // Close modal after successfully deleted
                    var element = "#purchaseOrderDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#purchaseOrder_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // Display the validation error message
                    var response = JSON.parse(xhr.responseText);
                    var error    = "Error: " + response.error;

                    // Show fail toast
                    window.showSubmitToast(error, "#D32929");
                }
            });
        };
    })
</script>
@endsection('script')