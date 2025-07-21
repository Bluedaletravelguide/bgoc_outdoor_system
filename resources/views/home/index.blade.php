@extends('layouts.main')

@section('title')
<title>BGOC Outdoor System - Home</title>
@endsection('title')

@section('sidebar')
@include('layouts.sidebar')
@endsection


@section('app_content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
        <!-- BEGIN: General Report -->
        <div class="col-span-12 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    General Report
                </h2>
                <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="bookmark" class="report-box__icon text-theme-10"></i>
                                <!-- <div class="ml-auto">
                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                </div> -->
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">123</div>
                            <div class="text-base text-gray-600 mt-1">Total Billboard</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="bookmark" class="report-box__icon text-theme-10"></i>
                                <!-- <div class="ml-auto">
                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                </div> -->
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">123</div>
                            <div class="text-base text-gray-600 mt-1">Total Active Billboard</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="refresh-ccw" class="report-box__icon text-theme-11"></i>
                                <!-- <div class="ml-auto">
                                    <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer" title="2% Lower than last month"> 2% <i data-feather="chevron-down" class="w-4 h-4"></i> </div>
                                </div> -->
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">420</div>
                            <div class="text-base text-gray-600 mt-1">Total Bookings</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="user-check" class="report-box__icon text-theme-9"></i>
                                <!-- <div class="ml-auto">
                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="22% Higher than last month"> 22% <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                </div> -->
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">15</div>
                            <div class="text-base text-gray-600 mt-1">Total Active Bookings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: General Report -->
        <!-- BEGIN: Daily Report -->
        @CSRF
        <div class="col-span-12 lg:col-span-6 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Daily Report
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <i data-feather="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                    <input type="text" class="datepicker input w-full sm:w-56 box pl-10">
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <div class="flex flex-col xl:flex-row xl:items-center">
                    <!-- <div class="flex">
                        <div>
                            <div class="text-theme-20 dark:text-gray-300 text-lg xl:text-xl font-bold">$15,000</div>
                            <div class="mt-0.5 text-gray-600 dark:text-gray-600">This Month</div>
                        </div>
                        <div class="w-px h-12 border border-r border-dashed border-gray-300 dark:border-dark-5 mx-4 xl:mx-6"></div>
                        <div>
                            <div class="text-gray-600 dark:text-gray-600 text-lg xl:text-xl font-medium">$10,000</div>
                            <div class="mt-0.5 text-gray-600 dark:text-gray-600">Last Month</div>
                        </div>
                    </div> -->
                    <!-- <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <button class="dropdown-toggle button font-normal border dark:border-dark-5 text-white dark:text-gray-300 relative flex items-center text-gray-700"> Filter by Category <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                        <div class="dropdown-box w-40">
                            <div class="dropdown-box__content box dark:bg-dark-1 p-2 overflow-y-auto h-32"> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">PC & Laptop</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Smartphone</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Electronic</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Photography</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Sport</a> </div>
                        </div>
                    </div> -->
                </div>
                <div class="report-chart">
                    <canvas id="report-line-chart" class="mt-3" style="min-height: 250px"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Daily Report -->
        <!-- BEGIN: Category -->
        <!-- <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Category
                </h2>
                <a href="" class="ml-auto text-theme-1 dark:text-theme-10 truncate">See all</a>
            </div>
            <div class="intro-y flex box p-5 mt-5">
                <canvas class="mt-3" id="report-pie-chart" style="min-height: 250px"></canvas>
            </div>
        </div> -->
        <!-- END: Category -->
        <!-- BEGIN: Status -->
        <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Billboard Status
                </h2>
                <a href="" class="ml-auto text-theme-1 dark:text-theme-10 truncate">See all</a>
            </div>
            <div class="intro-y box p-5 mt-5">
                <canvas class="mt-3" id="report-donut-chart" style="min-height: 250px"></canvas>
            </div>
        </div>
        <!-- END: Status -->
        <!-- BEGIN: Status -->
        <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Booking Status
                </h2>
                <a href="" class="ml-auto text-theme-1 dark:text-theme-10 truncate">See all</a>
            </div>
            <div class="intro-y box p-5 mt-5">
                <canvas class="mt-3" id="report-donut-chart2" style="min-height: 250px"></canvas>
            </div>
        </div>
        <!-- END: Status -->
    </div>
    <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-10 pb-10">
        <div class="xxl:pl-6 grid grid-cols-12 gap-6">
            <!-- BEGIN: Attention -->
            <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3 xxl:mt-8">
                <div class="intro-x flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Attention
                    </h2>
                </div>
                @foreach($highAttention as $attention)
                    @if($loop->index < 4)
                    <a href="javascript:;" onclick="window.open('{{ route('workOrderProfile.index', ['id' => $attention -> id] )}}')" >
                        <div class="mt-5">
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <i data-feather="alert-circle" class="report-box__icon text-theme-6"></i>
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">{{$attention->work_order_no}}</div>
                                        <div class="text-gray-600 text-xs mt-0.5">More than 24 hours and have not been assigned to supervisor, high attention required!</div>
                                    </div>
                                    <!-- <div class="text-theme-9">+$99</div> -->
                                </div>
                            </div>
                            <!-- <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-14.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Kevin Spacey</div>
                                        <div class="text-gray-600 text-xs mt-0.5">16 May 2020</div>
                                    </div>
                                    <div class="text-theme-9">+$35</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Al Pacino</div>
                                        <div class="text-gray-600 text-xs mt-0.5">15 July 2022</div>
                                    </div>
                                    <div class="text-theme-9">+$76</div>
                                </div><
                            </div>
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-2.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Hugh Jackman</div>
                                        <div class="text-gray-600 text-xs mt-0.5">9 July 2020</div>
                                    </div>
                                    <div class="text-theme-9">+$49</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-14.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Kevin Spacey</div>
                                        <div class="text-gray-600 text-xs mt-0.5">12 February 2022</div>
                                    </div>
                                    <div class="text-theme-9">+$49</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-3.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Robert De Niro</div>
                                        <div class="text-gray-600 text-xs mt-0.5">10 July 2021</div>
                                    </div>
                                    <div class="text-theme-9">+$99</div>
                                </div>
                            </div> -->
                        </div>
                    </a>
                    @endif
                @endforeach
                <a href="" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">View More</a>
            </div>
            <!-- END: Attention -->
        </div>
    </div>
</div>
@endsection('app_content')

@section('script')
<script src="{{ asset('/dist/js/chart.umd.js')}}"></script>
<!-- <script src="./node_modules/chart.js/dist/chart.js"></script> -->

<script>

    const line = document.getElementById('report-line-chart');
    const pie = document.getElementById('report-pie-chart');
    const donut = document.getElementById('report-donut-chart');
    const donut2 = document.getElementById('report-donut-chart2');

    var linedata = @json($groupedData);
    var piedata = @json($groupedCategories);
    var donutdata = @json($groupedStatus);

    var linelabels = Object.keys(linedata);
    var linevalues = Object.values(linedata);
    var pielabels = Object.keys(piedata);
    var pievalues = Object.values(piedata);
    var donutlabels = Object.keys(donutdata);
    var donutvalues = Object.values(donutdata);

    // var ctx = document.getElementById('report-line-chart').getContext('10d');
    // var lineChart = new Chart(ctx, {
    //     type: 'line',
    //     data: {
    //         labels: labels,
    //         datasets: [{
    //             label: 'Count of Records',
    //             data: values,
    //             borderColor: 'rgba(75, 192, 192, 1)',
    //             borderWidth: 2,
    //             fill: false,
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             x: {
    //                 type: 'time',
    //                 time: {
    //                     unit: 'day',
    //                 },
    //             },
    //             y: {
    //                 beginAtZero: true,
    //                 title: {
    //                     display: true,
    //                     text: 'Count',
    //                 },
    //             },
    //         },
    //     },
    // });

  new Chart(pie, {
    type: 'pie',
    options: {
        plugins: {
            legend: {
                display: true
            },
            tooltip: {
                enabled: true
            }
        },
        maintainAspectRatio: true,
        responsive: true, // This enables automatic resizing based on the container size
    },
    data: {
      labels: pielabels,
      datasets: [{
        data: pievalues,
      }]
    },
  });

  new Chart(donut, {
    type: 'doughnut',
    options: {
        plugins: {
          legend: {
            display: true
          },
          tooltip: {
            enabled: true
          }
        },
        maintainAspectRatio: true,
        responsive: true, // This enables automatic resizing based on the container size
    },
    data: {
      labels: donutlabels,
      datasets: [{
        data: donutvalues,
      }]
    },
  });

  new Chart(donut2, {
    type: 'doughnut',
    options: {
        plugins: {
          legend: {
            display: true
          },
          tooltip: {
            enabled: true
          }
        },
        maintainAspectRatio: true,
        responsive: true, // This enables automatic resizing based on the container size
    },
    data: {
      labels: donutlabels,
      datasets: [{
        data: donutvalues,
      }]
    },
  });
  
  new Chart(line, {
    type: 'line',
    data: {
      labels: linelabels,
      datasets: [{
        label: 'Count of Records',
        data: linevalues,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      },
      maintainAspectRatio: false,
      responsive: true, // This enables automatic resizing based on the container size
    }
  });


//   document.addEventListener('DOMContentLoaded', function () {
//             var data = @json($groupedData);

//             var labels = Object.keys(data);
//             var values = Object.values(data);

//             var ctx = document.getElementById('report-line-chart').getContext('10d');
//             var lineChart = new Chart(ctx, {
//                 type: 'line',
//                 data: {
//                     labels: labels,
//                     datasets: [{
//                         label: 'Count of Records',
//                         data: values,
//                         borderColor: 'rgba(75, 192, 192, 1)',
//                         borderWidth: 2,
//                         fill: false,
//                     }]
//                 },
//                 options: {
//                     scales: {
//                         x: {
//                             type: 'time',
//                             time: {
//                                 unit: 'day',
//                             },
//                         },
//                         y: {
//                             beginAtZero: true,
//                             title: {
//                                 display: true,
//                                 text: 'Count',
//                             },
//                         },
//                     },
//                 },
//             });
//         });

</script>
@endsection('script')

<!-- @section('script') -->
<!-- BEGIN: JS Assets-->
    <!-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
    <script src="dist/js/app.js"></script> -->
<!-- END: JS Assets-->
<!-- @endsection('script') -->