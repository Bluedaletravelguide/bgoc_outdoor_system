@extends('layouts.main')

@section('title')
<title>Chulia Middle East - Service Category</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('app_content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Service Category
    </h2>
</div>

<div class="intro-y box p-5 mt-5">

    <!-- BEGIN: User Status Info -->
    <div class="rounded-md px-5 py-4 mb-2 bg-gray-200 text-gray-600">
        <ul>
            <li> <b> Category </b> - Main category.</li>
            <li> <b> Sub-category </b> - Sub-category</li>
        </ul>
    </div>
    <!-- END: User Status Info -->

    <div class="pos col-span-12 lg:col-span-4">
        <!-- BEGIN: Category -->
        <div class="tab-content__pane mt-4 active" id="category_list">
            <!-- BEGIN: Filter & Add New User -->
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <!-- BEGIN: Filter -->
                <form class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Role</label>
                        <select class="input w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto border" id="inputCategoryStatus">
                            <option value="all">All</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="employee_occ_admin">OCC Admin</option>
                            <option value="employee_occ_operator">OCC Operator</option>
                            <option value="employee_supervisor">In-House Supervisor</option>
                            <option value="employee_technician">In-House Technician</option>
                        </select>
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button type="button" class="button w-full sm:w-16 bg-theme-32 text-white" id="filterServiceCategoryButton">Filter</button>
                    </div>
                </form>
                <!-- END: Filter -->

                <!-- BEGIN: Add New User -->
                <div class="text-center">
                    <a href="javascript:;" data-toggle="modal" data-target="#categoryAddModal" class="button w-50 mr-2 mb-2 flex items-center justify-center bg-theme-32 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Service Category
                    </a>
                </div>
                <!-- END: Add New User -->
            </div>
            <!-- END: Filter & Add New User -->

            <!-- BEGIN: Categories List -->
            <div class="overflow-x-auto scrollbar-hidden">
                <table class="table table-report table mt-5" id="categories_table">
                    <thead>
                        <tr class="bg-theme-32 text-white">
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- END: Categories List -->
        </div>
        <!-- END: Category -->
    </div>
</div>
@endsection('app_content')

@section('modal_content')
<!-- BEGIN: Category Edit Modal -->
<div class="modal" id="categoryEditModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Edit Category</h2>
        </div>
        <form>
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Category Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Category Name" id="categoryEditName" required>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Sub Categories</label>
                    <div id="subCategoryContainer"></div>
                    
                </div>
            </div>

            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="button" onclick="editSubCategoryAdd()" class="button w-20 bg-theme-1 text-white mt-2">Add</button>
                <button type="submit" class="button w-20 bg-theme-1 text-white" id="categoryEditButton">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Category Edit Modal -->

<!-- BEGIN: Category Add Modal -->
<div class="modal" id="categoryAddModal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Add Category</h2>
        </div>
        <form action="{{ route('serviceRequest.category.store') }}" method="POST" id="categoryForm">
            @csrf
            <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Name</label>
                    <input type="text" class="input w-full border mt-2 flex-1" placeholder="Lighting/Plumbing/HVAC/etc..." name="category_name" id="category_name" required>
                </div>
            </div>
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">Sub Categories</h2>
            </div>
            <div id="subCategoriesContainer">
                <!-- Initial subcategory input field -->
                <div class="sub-category">
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label>Name</label>
                            <div class="flex items-center mt-2">
                                <input type="text" class="input w-full border flex-1" placeholder="Subcategory" name="sub_categories[]" required>
                                <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeSubCategory(this)">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                <button type="button" onclick="addSubCategory()" class="button w-20 bg-theme-1 text-white">Add</button>
                <button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Category Add Modal -->

<!-- BEGIN: Category Delete Modal -->
<div class="modal" id="categoryDeleteModal">
    <div class="modal__content">
        <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Confirm deleting the category? This process cannot be undone.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white" id="serviceCategoryDeleteButton">Delete</button>
        </div>
    </div>
</div>
<!-- END: Category Delete Modal -->




@endsection('modal_content')

@section('script')
<script>
$(document).ready(function() {
        // Global variables
        var filterCategoryStatus;
        var originalCompanyId;
        var lastClickedLink;

        // Listen to below buttons
        document.getElementById("filterServiceCategoryButton").addEventListener("click", filterClientCompanyButton);
        document.getElementById("serviceCategoryDeleteButton").addEventListener("click", serviceCategoryDeleteButton);

        // When "filterClientCompanyButton" button is clicked, initiate initServiceCategoryDatatable
        function filterClientCompanyButton() {
            filterCategoryStatus = document.getElementById("inputCategoryStatus").value;
            initServiceCategoryDatatable(filterCategoryStatus);
        };

        // When page first loads, load table
        filterClientCompanyButton();

        // When any submit button is clicked
        (function() {
            var service_category_table = $('#categories_table')[0].altEditor;

            document.getElementById('categoryEditButton').addEventListener('click', function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Edit service category
                editServiceCategory(event);
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

        // Setup the client company datatable
        function initServiceCategoryDatatable() {
            const dt = new Date();
            const formattedDate = `${dt.getFullYear()}${(dt.getMonth() + 1).toString().padStart(2, '0')}${dt.getDate().toString().padStart(2, '0')}`;
            const formattedTime = `${dt.getHours()}:${dt.getMinutes()}:${dt.getSeconds()}`;
            const $fileName = `Service_Category${formattedDate}_${formattedTime}`;

            const table = $('#categories_table').DataTable({
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
                    url: "{{ route('serviceRequest.category.get') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.status = filterCategoryStatus;
                        return d;
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
                            columns: ":not(.dt-exclude-export)",
                            stripHtml: false,
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button');
                            $(node).removeClass('buttons-html5');
                        },
                    },
                ],
                columnDefs: [{
                    targets: 'dt-no-sort',
                    orderable: false
                }],
                columns: [{
                        data: "service_category_name",
                    },
                    {
                        data: "sub_categories",
                        render: function (data, type, row) {
                            if (Array.isArray(data) && data.length > 0) {
                                let subCategoryList = data.map(subCategory => {
                                    return `<li class="cursor-pointer text-xs list-disc">${subCategory}</li>`;
                                });

                                return `<ul class="pl-4">${subCategoryList.join('')}</ul>`;
                            } else {
                                return ''; // Return an empty string if there are no sub_categories
                            }
                        }
    
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            let element = `
                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#categoryDeleteModal" id="delete-` + data + `">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg> 
                            </a>`;

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
            var filterDiv = document.getElementById("client_company_table_filter");
            if (filterDiv) {
                filterDiv.style.float = "right";
                filterDiv.classList.remove('dataTables_filter');

                var inputElement = filterDiv.querySelector("label input");
                if (inputElement) {
                    inputElement.classList.add("input", "border", "mt-2", "ml-2", "mr-1", "mb-5");
                }
            }

            // Update styling for the info and paginate elements
            var infoDiv = document.getElementById("client_company_table_info");
            var paginateDiv = document.getElementById("client_company_table_paginate");

            if (infoDiv) {
                infoDiv.style.float = "left";
                infoDiv.classList.add("mt-5");
            }

            if (paginateDiv) {
                paginateDiv.style.float = "right";
                paginateDiv.classList.add("mt-5");
            }

            // Update styling for the "client_company_table_length" div and its select element
            var existingDiv = document.getElementById("client_company_table_length");
            if (existingDiv) {
                existingDiv.classList.remove('dataTables_length');
                existingDiv.classList.add('mt-2', 'mb-1');

                var existingSelect = existingDiv.querySelector('select');
                if (existingSelect) {
                    existingSelect.className = 'input sm:w-auto border';
                }
            }

            // Open modal to edit client company
            serviceCategoryEditModal();
        };

        // Open modal to edit client company
        function serviceCategoryEditModal() {
            // Remove previous click event listeners
            $(document).off('click', "[id^='categories_table'] tbody tr td:not(:last-child)");

            $(document).on('click', "[id^='categories_table'] tbody tr td:not(:last-child)", function(event) {
                // Assign original username to a global variable
                original_employee_username = $(event.target).closest('tr').find('ul li:nth-child(' + '2' + ')').text();

                // Grab row client company id
                categoryOriginalId = $(event.target).closest('tr').find('td:nth-child(3) a').attr('id').split('-')[1];

                var listItemValues = [];
                $(event.target).closest('tr').find('ul li').each(function() {
                    listItemValues.push($(this).text());
                });

                // Place values to edit form fields in the modal
                var categoryName = document.getElementById("categoryEditName").value = $(event.target).closest('tr').find('td:nth-child(' + '1' + ')').text();

                // Remove any existing subcategory input fields
                $("#subCategoryContainer").empty();

                // Dynamically create input fields for each subcategory
                for (let i = 0; i < listItemValues.length; i++) {
                    let subCategoryTemplate = `
                        <div class="col-span-12 sm:col-span-12 sub-category">
                            <div class="flex items-center mt-2">
                                <input type="text" class="input w-full border flex-1" value="${listItemValues[i]}"  id="sub_category" name="sub_categories[]" required>
                                <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeSubCategoryField(this)">
                                    Remove
                                </a>
                            </div>
                        </div>
                    `;
                    $("#subCategoryContainer").append(subCategoryTemplate);
                }

                // Grab row client company id
                console.log("original category ID:", categoryOriginalId);

                // Display values in the console
                console.log('Category Name:', categoryName);
                console.log('Sub Category List:', listItemValues);

                // Open modal
                var element = "#categoryEditModal";
                openAltEditorModal(element);
            });
        }

        // Edit Client Company
        function editServiceCategory() {

            var categoryName = document.getElementById("categoryEditName").value;
            // Collect values from all subcategory input fields
            var subCategories = [];
            var subCategoryInputs = document.querySelectorAll("[id^='sub_category']");

            subCategoryInputs.forEach(function(subCategoryInput) {
                subCategories.push(subCategoryInput.value);
            });


            console.log("Category to edit:", categoryName);
            console.log("Sub Category to edit:", subCategories);

            $.ajax({
                type: 'POST',
                url: "{{ route('serviceRequest.category.update') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    categoryName: categoryName,
                    subCategories: subCategories,
                    categoryOriginalId: categoryOriginalId
                },
                success: function(response) {
                    // Close modal after successfully edited
                    var element = "#categoryEditModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully added.", "#91C714");

                    // Clean fields
                    document.getElementById("categoryEditName").value = "";
                    // Clear subcategory input fields
                    subCategoryInputs.forEach(function(subCategoryInput) {
                        subCategoryInput.value = "";
                    });

                    // Reload table
                    $('#categories_table').DataTable().ajax.reload();
                }
                // ,
                // error: function(xhr, status, error) {
                //     // Display the validation error message
                //     var response = JSON.parse(xhr.responseText);
                //     var error = "Error: " + response.error;

                //     // Show fail toast
                //     window.showSubmitToast(error, "#D32929");
                // }
            });
        }

        // Store the ID of the last clicked moda when it's triggered
        (function() {
            $(document).on('click', "[data-toggle='modal']", function() {
                lastClickedLink = $(this).attr('id');
            });
        })();

        // Delete Category and Sub-Categories
        function serviceCategoryDeleteButton() {
            var deleteCategory = lastClickedLink.split("-")[1];
            console.log("delete category ID:", deleteCategory);

            $.ajax({
                type: 'POST',
                url: "{{ route('serviceRequest.category.destroy') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    delete_category_id: deleteCategory
                },
                success: function (response) {
                    // Close modal after successfully deleted
                    var element = "#categoryDeleteModal";
                    closeAltEditorModal(element);

                    // Show successful toast
                    window.showSubmitToast("Successfully deleted.", "#91C714");

                    // Reload table
                    $('#categories_table').DataTable().ajax.reload();
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
// <!-- This is to add more subcategory while Creation of Service Category -->
<script>
    // Add a new subcategory input field
    function addSubCategory() {
        var subCategoryTemplate = `
            <div class="sub-category">
                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <div class="flex items-center mt-2">
                            <input type="text" class="input w-full border flex-1" placeholder="Subcategory" name="sub_categories[]" required>
                            <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeSubCategory(this)">
                                Remove
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $("#subCategoriesContainer").append(subCategoryTemplate);
    }

    function editSubCategoryAdd() {
        var subCategoryTemplate = `
            <div class="flex items-center mt-2 sub-category">
                <input type="text" class="input w-full border flex-1" placeholder="Subcategory" id="sub_category" name="sub_categories[]" required>
                <a href="javascript:void(0);" class="button bg-theme-1 text-white ml-2" onclick="removeSubCategoryField(this)">
                    Remove
                </a>
            </div>
        `;

        $("#subCategoryContainer").append(subCategoryTemplate);
    }

    // Remove a subcategory input field in edit modal
    function removeSubCategoryField(button) {
        var container = $(button).closest('.sub-category');
        var inputField = container.find('input');
        var hasData = inputField.val();

        console.log("data:", inputField);

        // Remove the subcategory field
        container.remove();

        // If it had existing data, remove it from the modal
        if (hasData) {
            inputField.remove();
        }
    }
    // Remove a subcategory input field in add modal
    function removeSubCategory(button) {
        $(button).closest('.sub-category').remove();
    }
</script>
@endsection('script')