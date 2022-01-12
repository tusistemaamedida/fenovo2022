@extends('layouts.app')

@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>
<!--end::Subheader-->
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-xl-3">
                        <div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-primary">

                            <div class="card-body">
                                <h3 class="text-body font-weight-bold">Orders</h3>
                                <div class="mt-3">
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark font-weight-bold font-size-h1 mr-3"><span
                                                class="counter" data-target="400">0</span></span>

                                    </div>
                                    <div class="text-black-50 mt-3">Compare to last year (2019)</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle theme-circle-secondary">

                            <div class="card-body">
                                <h3 class="text-body font-weight-bold">Products</h3>
                                <div class="mt-3">
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark font-weight-bold font-size-h1 mr-3"><span
                                                class="counter" data-target="600">0</span></span>

                                    </div>
                                    <div class="text-black-50 mt-3">Compare to last year (2019)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-success">

                            <div class="card-body">
                                <h3 class="text-body font-weight-bold">Users</h3>
                                <div class="mt-3">
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark font-weight-bold font-size-h1 mr-3"><span
                                                class="counter" data-target="1000">0</span></span>

                                    </div>
                                    <div class="text-black-50 mt-3">Compare to last year (2019)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-info">

                            <div class="card-body">
                                <h3 class="text-body font-weight-bold">Sales</h3>
                                <div class="mt-3">
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark font-weight-bold font-size-h1 mr-3">$<span
                                                class="counter" data-target="6800">0</span></span>
                                        <span
                                            class="font-weight-bold font-size-h4 text-danger">8.2</span>
                                        <span class="svg-icon text-danger">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16"
                                                class="bi bi-arrow-up-short" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="text-black-50 mt-3">Compare to last year (2019)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6  col-xl-8">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-header align-items-center  border-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label text-body font-weight-bold mb-0">Users
                                    </h3>
                                </div>

                            </div>
                            <div class="card-body pt-3">
                                <div id="chart-4">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6 col-xl-4">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-header align-items-center  border-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label text-body font-weight-bold mb-0">Last Update
                                    </h3>
                                </div>
                                <div class="card-toolbar">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton1"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="svg-icon">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16"
                                                class="bi bi-three-dots text-body" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0">
                                <ul class="list-group scrollbar-1" style="height: 300px;">
                                  <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2">
                                    <div class="list-left d-flex align-items-center">
                                        <span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-primary text-white mr-2">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-lightning-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                                              </svg>
                                          </span>
                                      <div class="list-content">
                                        <span class="list-title text-body">Total Products</span>
                                        <small class="text-muted d-block">1.2k New Products</small>
                                      </div>
                                    </div>
                                    <span>10.6k</span>
                                  </li>
                                  <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2">
                                    <div class="list-left d-flex align-items-center">
                                        <span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-secondary text-white mr-2">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-bar-chart-line-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z"/>
                                              </svg>
                                          </span>
                                      <div class="list-content">
                                        <span class="list-title text-body">Total Sales</span>
                                        <small class="text-muted d-block">39.4k New Sales</small>
                                      </div>
                                    </div>
                                    <span>26M</span>
                                  </li>
                                  <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2">
                                    <div class="list-left d-flex align-items-center">
                                        <span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-success text-white mr-2">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-credit-card-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4z"/>
                                                <path fill-rule="evenodd" d="M0 7v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H3z"/>
                                              </svg>
                                          </span>
                                      <div class="list-content">
                                        <span class="list-title text-body">Total Revenue</span>
                                        <small class="text-muted d-block">43.5k New Revenue</small>
                                      </div>
                                    </div>
                                    <span>15.89M</span>
                                  </li>

                                  <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2">
                                    <div class="list-left d-flex align-items-center">
                                        <span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-warning text-white mr-2">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-lightning-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                                              </svg>
                                          </span>
                                      <div class="list-content">
                                        <span class="list-title text-body">Total Users</span>
                                        <small class="text-muted d-block">New Users</small>
                                      </div>
                                    </div>
                                    <span>1.2k</span>
                                  </li>
                                  <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2">
                                    <div class="list-left d-flex align-items-center">
                                        <span class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-info text-white mr-2">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-lightning-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                                              </svg>
                                          </span>
                                      <div class="list-content">
                                        <span class="list-title text-body">Total Visits</span>
                                        <small class="text-muted d-block">New Visits</small>
                                      </div>
                                    </div>
                                    <span>4.6k</span>
                                  </li>
                                </ul>
                              </div>
                          </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-xl-4">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-header align-items-center  border-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label font-weight-bold mb-0 text-body">Activity
                                    </h3>
                                </div>
                                <div class="card-toolbar">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton2"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="svg-icon">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16"
                                                class="bi bi-three-dots text-body" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="timeline timeline-6 mt-3">
                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-label font-weight-bold text-black-50 ">08:42</div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-warning icon-xl"></i>
                                        </div>
                                        <div class="font-weight-mormal timeline-content text-muted pl-3">Outlines keep you honest. And keep structure</div>
                                    </div>
                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-label font-weight-bold text-black-50">10:00</div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-success icon-xl"></i>
                                        </div>
                                        <div class="timeline-content d-flex">
                                            <span class="font-weight-bolder text-body pl-3">AEOL meeting</span>
                                        </div>
                                    </div>
                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-label font-weight-bold text-black-50 ">14:37</div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-danger icon-xl"></i>
                                        </div>
                                        <div class="timeline-content font-weight-bold text-body pl-3">Make deposit
                                        <a href="#" class="text-primary">USD 700</a>. to ESL</div>

                                    </div>

                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-label font-weight-bold text-black-50 ">16:50</div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-primary icon-xl"></i>
                                        </div>
                                        <div class="timeline-content font-weight-mormal text-muted pl-3">Indulging in poorly driving and keep structure keep great</div>
                                    </div>
                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-label font-weight-bold text-black-50">21:03</div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-danger icon-xl"></i>
                                        </div>
                                        <div class="timeline-content font-weight-bold text-body pl-3">New order placed
                                        <a href="#" class="text-primary">#XF-2356</a>.</div>
                                    </div>
                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-label font-weight-bold text-black-50">23:07</div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-info icon-xl"></i>
                                        </div>
                                        <div class="timeline-content font-weight-mormal text-muted pl-3">Outlines keep and you honest. Indulging in poorly driving</div>
                                    </div>
                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-label font-weight-bold text-black-50">16:50</div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-primary icon-xl"></i>
                                        </div>
                                        <div class="timeline-content font-weight-mormal text-muted pl-3">Indulging in poorly driving and keep structure keep great</div>
                                    </div>

                                    <div class="timeline-item align-items-start">
                                        <div class="timeline-label font-weight-bold text-black-50">21:03</div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-danger icon-xl"></i>
                                        </div>
                                        <div class="timeline-content font-weight-bold text-body pl-3">New order placed
                                        <a href="#" class="text-primary">#XF-2356</a>.</div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-6 col-xl-8">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-header align-items-center  border-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label font-weight-bold mb-0 text-body">Weekly Sales
                                    </h3>
                                </div>

                            </div>
                            <div class="card-body pt-3">
                                <div id="chart-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-6 col-xl-8">
                        <div class="card card-custom gutter-b bg-white border-0" >
                            <div class="card-header align-items-center  border-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label mb-0 font-weight-bold text-body">New Orders
                                    </h3>
                                </div>
                                <div class="card-toolbar">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton3"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="svg-icon">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16"
                                                class="bi bi-three-dots text-body" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" >
                                <div >
                                    <div class="kt-table-content table-responsive">
                                        <table id="myTable" class="table ">

                                            <thead class="kt-table-thead text-body">
                                                <tr>
                                                    <th class="kt-table-cell">Order ID</th>
                                                    <th class="kt-table-cell">Customer Name</th>
                                                    <th class="kt-table-cell">Amount</th>
                                                    <th class="kt-table-cell">
                                                        <div class="text-right">Status</div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="kt-table-tbody text-dark">
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center">
                                                            <span
                                                                class="ml-2">Clayton Bates</span></div>
                                                    </td>

                                                    <td class="kt-table-cell">$137.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Gabriel Frazier</span>
                                                        </div>
                                                    </td>
                                                    <td class="kt-table-cell">$322.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center">
                                                            <span
                                                                class="ml-2">Debra Hamilton</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$543.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-info">Pending</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Stacey Ward</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$876.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-danger">Rejected</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Troy Alexander</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$241.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Clayton Bates</span></div>
                                                    </td>

                                                    <td class="kt-table-cell">$137.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Gabriel Frazier</span>
                                                        </div>
                                                    </td>
                                                    <td class="kt-table-cell">$322.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Debra Hamilton</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$543.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-info">Pending</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Stacey Ward</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$876.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-danger">Rejected</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Troy Alexander</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$241.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Clayton Bates</span></div>
                                                    </td>

                                                    <td class="kt-table-cell">$137.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Gabriel Frazier</span>
                                                        </div>
                                                    </td>
                                                    <td class="kt-table-cell">$322.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Debra Hamilton</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$543.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-info">Pending</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Stacey Ward</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$876.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-danger">Rejected</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="kt-table-row kt-table-row-level-0">
                                                    <td class="kt-table-cell">#12425</td>
                                                    <td class="kt-table-cell">
                                                        <div class="d-flex align-items-center"><span
                                                                class="ml-2">Troy Alexander</span></div>
                                                    </td>
                                                    <td class="kt-table-cell">$241.00</td>
                                                    <td class="kt-table-cell">
                                                        <div class="text-right"><span
                                                                class="mr-0 text-success">Approved</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-header align-items-center  border-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Action Needed
                                    </h3>
                                </div>
                                <div class="card-toolbar">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton4"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="svg-icon">
                                            <svg width="20px" height="20px" viewBox="0 0 16 16"
                                                class="bi bi-three-dots text-body" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton4">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-4">
                                <div class="progress" data-percentage="80">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div class="text-body">
                                            80%<br>
                                            <span>completed</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-0">
                                    <p class="text-center font-weight-normal text-body">Notes: Current sprint requires stakeholders
                                    <br>to approve newly amended policies</p>
                                    <a href="#" class="btn btn-secondary text-white font-weight-bold w-100 py-3">Generate Report</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
