<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <?= $this->include('partials/toolbar') ?>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-xxl">
                            <!--begin::Products-->
                            <div class="card card-flush">
                                <!--begin::Card header-->
                                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <!--begin::Search-->
                                        <div class="d-flex align-items-center position-relative my-1">
                                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Order">
                                        </div>
                                        <!--end::Search-->
                                    </div>
                                    <!--end::Card title-->
                                    <!--begin::Card toolbar-->
                                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                        <!--begin::Flatpickr-->
                                        <div class="input-group w-250px">
                                            <input class="form-control form-control-solid rounded rounded-end-0 flatpickr-input" placeholder="Pick date range" id="kt_ecommerce_sales_flatpickr" type="hidden"><input class="form-control form-control-solid rounded rounded-end-0 form-control input" placeholder="Pick date range" tabindex="0" type="text" readonly="readonly">
                                            <button class="btn btn-icon btn-light" id="kt_ecommerce_sales_flatpickr_clear">
                                                <i class="ki-duotone ki-cross fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </div>
                                        <!--end::Flatpickr-->
                                        <div class="w-100 mw-150px">
                                            <!--begin::Select2-->
                                            <select class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-order-filter="status" data-select2-id="select2-data-9-5zpt" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                                <option data-select2-id="select2-data-11-wamy"></option>
                                                <option value="all">All</option>
                                                <option value="Cancelled">Cancelled</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Denied">Denied</option>
                                                <option value="Expired">Expired</option>
                                                <option value="Failed">Failed</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Processing">Processing</option>
                                                <option value="Refunded">Refunded</option>
                                                <option value="Delivered">Delivered</option>
                                                <option value="Delivering">Delivering</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-10-39ns" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-oiro-container" aria-controls="select2-oiro-container"><span class="select2-selection__rendered" id="select2-oiro-container" role="textbox" aria-readonly="true" title="Status"><span class="select2-selection__placeholder">Status</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            <!--end::Select2-->
                                        </div>
                                        <!--begin::Add product-->
                                        <a href="../../demo1/dist/apps/ecommerce/catalog/add-product.html" class="btn btn-primary">Add Order</a>
                                        <!--end::Add product-->
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Table-->
                                    <div id="kt_ecommerce_sales_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_ecommerce_sales_table">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"><th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1" aria-label="
                                                    
                                                        
                                                    
                                                " style="width: 29.8906px;">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_sales_table .form-check-input" value="1">
                                                    </div>
                                                </th><th class="min-w-100px sorting" tabindex="0" aria-controls="kt_ecommerce_sales_table" rowspan="1" colspan="1" aria-label="Order ID: activate to sort column ascending" style="width: 110.5px;">Order ID</th><th class="min-w-175px sorting" tabindex="0" aria-controls="kt_ecommerce_sales_table" rowspan="1" colspan="1" aria-label="Customer: activate to sort column ascending" style="width: 225.641px;">Customer</th><th class="text-end min-w-70px sorting" tabindex="0" aria-controls="kt_ecommerce_sales_table" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 80.5781px;">Status</th><th class="text-end min-w-100px sorting" tabindex="0" aria-controls="kt_ecommerce_sales_table" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending" style="width: 110.5px;">Total</th><th class="text-end min-w-100px sorting" tabindex="0" aria-controls="kt_ecommerce_sales_table" rowspan="1" colspan="1" aria-label="Date Added: activate to sort column ascending" style="width: 110.5px;">Date Added</th><th class="text-end min-w-100px sorting" tabindex="0" aria-controls="kt_ecommerce_sales_table" rowspan="1" colspan="1" aria-label="Date Modified: activate to sort column ascending" style="width: 110.5px;">Date Modified</th><th class="text-end min-w-100px sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 112.641px;">Actions</th></tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                        <tr class="odd">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13423</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label">
                                                                    <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Smith</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Completed">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Completed</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$226.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-15">
                                                    <span class="fw-bold">15/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-18">
                                                    <span class="fw-bold">18/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="even">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13424</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label">
                                                                    <img src="assets/media/avatars/300-5.jpg" alt="Sean Bean" class="w-100">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Sean Bean</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Completed">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Completed</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$345.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-13">
                                                    <span class="fw-bold">13/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-17">
                                                    <span class="fw-bold">17/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="odd">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13425</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label">
                                                                    <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Completed">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Completed</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$112.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-13">
                                                    <span class="fw-bold">13/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-16">
                                                    <span class="fw-bold">16/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="even">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13426</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Melody Macy</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Processing">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-primary">Processing</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$265.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-14">
                                                    <span class="fw-bold">14/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-15">
                                                    <span class="fw-bold">15/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="odd">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13427</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label">
                                                                    <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Cancelled">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-danger">Cancelled</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$297.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-08">
                                                    <span class="fw-bold">08/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-14">
                                                    <span class="fw-bold">14/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="even">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13428</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label">
                                                                    <img src="assets/media/avatars/300-9.jpg" alt="Francis Mitcham" class="w-100">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Francis Mitcham</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Completed">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Completed</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$133.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-07">
                                                    <span class="fw-bold">07/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-13">
                                                    <span class="fw-bold">13/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="odd">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13429</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label">
                                                                    <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Completed">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Completed</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$387.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-09">
                                                    <span class="fw-bold">09/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-12">
                                                    <span class="fw-bold">12/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="even">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13430</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label fs-3 bg-light-danger text-danger">E</div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Bold</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Completed">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Completed</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$388.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-04">
                                                    <span class="fw-bold">04/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-11">
                                                    <span class="fw-bold">11/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="odd">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13431</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label">
                                                                    <img src="assets/media/avatars/300-25.jpg" alt="Brian Cox" class="w-100">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Brian Cox</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Refunded">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-info">Refunded</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$23.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-09">
                                                    <span class="fw-bold">09/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-10">
                                                    <span class="fw-bold">10/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr><tr class="even">
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td data-kt-ecommerce-order-filter="order_id">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">13432</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                                <div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Melody Macy</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Cancelled">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-danger">Cancelled</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">$251.00</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-08">
                                                    <span class="fw-bold">08/07/2023</span>
                                                </td>
                                                <td class="text-end" data-order="2023-07-09">
                                                    <span class="fw-bold">09/07/2023</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr></tbody>
                                    </table></div><div class="row"><div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"><div class="dataTables_length" id="kt_ecommerce_sales_table_length"><label><select name="kt_ecommerce_sales_table_length" aria-controls="kt_ecommerce_sales_table" class="form-select form-select-sm form-select-solid"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select></label></div></div><div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"><div class="dataTables_paginate paging_simple_numbers" id="kt_ecommerce_sales_table_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_ecommerce_sales_table_previous"><a href="#" aria-controls="kt_ecommerce_sales_table" data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_ecommerce_sales_table" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_ecommerce_sales_table" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_ecommerce_sales_table" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_ecommerce_sales_table" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_ecommerce_sales_table" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item next" id="kt_ecommerce_sales_table_next"><a href="#" aria-controls="kt_ecommerce_sales_table" data-dt-idx="6" tabindex="0" class="page-link"><i class="next"></i></a></li></ul></div></div></div></div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Products-->
                        </div>
                        <!--end::Content container-->
                    </div>
    </div>
    <!--end::Content-->
</div>
<?= $this->endSection() ?>

