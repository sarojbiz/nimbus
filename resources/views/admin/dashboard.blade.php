@extends('admin.master')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{action('Admin\DashboardController@index')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</div>

<div class="row mb-3">
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Earnings (Monthly)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
            <div class="mt-2 mb-0 text-muted text-xs">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
            <span>Since last month</span>
            </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-primary"></i>
        </div>
        </div>
    </div>
    </div>
</div>
<!-- Earnings (Annual) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Sales</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">650</div>
            <div class="mt-2 mb-0 text-muted text-xs">
            <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
            <span>Since last years</span>
            </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-shopping-cart fa-2x text-success"></i>
        </div>
        </div>
    </div>
    </div>
</div>
<!-- New User Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">New User</div>
            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">366</div>
            <div class="mt-2 mb-0 text-muted text-xs">
            <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
            <span>Since last month</span>
            </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-users fa-2x text-info"></i>
        </div>
        </div>
    </div>
    </div>
</div>
<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Requests</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
            <div class="mt-2 mb-0 text-muted text-xs">
            <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
            <span>Since yesterday</span>
            </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-comments fa-2x text-warning"></i>
        </div>
        </div>
    </div>
    </div>
</div>

<!-- Area Chart -->
<div class="col-xl-12 col-lg-12">
    <div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Monthly Recap Report</h6>
    </div>
    <div class="card-body">
        <div class="chart-area">
        <canvas id="myAreaChart"></canvas>
        </div>
    </div>
    </div>
</div>
<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5" style="display:none;">
    <div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
        <div class="dropdown no-arrow">
        <a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="dropdownMenuLink"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Month <i class="fas fa-chevron-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
            aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header">Select Periode</div>
            <a class="dropdown-item" href="#">Today</a>
            <a class="dropdown-item" href="#">Week</a>
            <a class="dropdown-item active" href="#">Month</a>
            <a class="dropdown-item" href="#">This Year</a>
        </div>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
        <div class="small text-gray-500">Oblong T-Shirt
            <div class="small float-right"><b>600 of 800 Items</b></div>
        </div>
        <div class="progress" style="height: 12px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        </div>
        <div class="mb-3">
        <div class="small text-gray-500">Gundam 90'Editions
            <div class="small float-right"><b>500 of 800 Items</b></div>
        </div>
        <div class="progress" style="height: 12px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        </div>
        <div class="mb-3">
        <div class="small text-gray-500">Rounded Hat
            <div class="small float-right"><b>455 of 800 Items</b></div>
        </div>
        <div class="progress" style="height: 12px;">
            <div class="progress-bar bg-danger" role="progressbar" style="width: 55%" aria-valuenow="55"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        </div>
        <div class="mb-3">
        <div class="small text-gray-500">Indomie Goreng
            <div class="small float-right"><b>400 of 800 Items</b></div>
        </div>
        <div class="progress" style="height: 12px;">
            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        </div>
        <div class="mb-3">
        <div class="small text-gray-500">Remote Control Car Racing
            <div class="small float-right"><b>200 of 800 Items</b></div>
        </div>
        <div class="progress" style="height: 12px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        </div>
    </div>
    <div class="card-footer text-center">
        <a class="m-0 small text-primary card-link" href="#">View More <i
            class="fas fa-chevron-right"></i></a>
    </div>
    </div>
</div>
<!-- Invoice Example -->
<div class="col-xl-12 col-lg-12 mb-4">
    <div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
        <a class="m-0 float-right btn btn-danger btn-sm" href="{{action('Admin\OrderController@index')}}">View All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Amount</th>
            <th>Shipping</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{$order->order_no}}</td>                                
                <td>{{Carbon::parse($order->created_at)->format('Y-m-d g:i A')}}</td>
                <td>{{$order->b_first_name . ' ' . $order->b_last_name}}</td>
                <td>{{$order->b_email}}</td>
                <td>{{$order->b_phone}}</td>
                <td>{{'Rs '. round($order->total, 2)}}</td>
                <td>{{OrderStatus::fromValue($order->order_status_id)->description}}</td>
                <td>{{GeneralStatus::fromValue($order->status)->description}}</td>
                <th>
                    <a class="btn btn-sm btn-primary" href="{{ action('Admin\OrderController@show', $order->id) }}" title="View Order">Detail</a>
                </th>
            </tr>
            @empty
            <tr><td colspan="9"> No New Order Placed Yet. </td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
    <div class="card-footer"></div>
    </div>
</div>
<!-- Message From Customer-->
<div class="col-xl-4 col-lg-5" style="display:none;">
    <div class="card">
    <div class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-light">Message From Customer</h6>
    </div>
    <div>
        <div class="customer-message align-items-center">
        <a class="font-weight-bold" href="#">
            <div class="text-truncate message-title">Hi there! I am wondering if you can help me with a
            problem I've been having.</div>
            <div class="small text-gray-500 message-time font-weight-bold">Udin Cilok · 58m</div>
        </a>
        </div>
        <div class="customer-message align-items-center">
        <a href="#">
            <div class="text-truncate message-title">But I must explain to you how all this mistaken idea
            </div>
            <div class="small text-gray-500 message-time">Nana Haminah · 58m</div>
        </a>
        </div>
        <div class="customer-message align-items-center">
        <a class="font-weight-bold" href="#">
            <div class="text-truncate message-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit
            </div>
            <div class="small text-gray-500 message-time font-weight-bold">Jajang Cincau · 25m</div>
        </a>
        </div>
        <div class="customer-message align-items-center">
        <a class="font-weight-bold" href="#">
            <div class="text-truncate message-title">At vero eos et accusamus et iusto odio dignissimos
            ducimus qui blanditiis
            </div>
            <div class="small text-gray-500 message-time font-weight-bold">Udin Wayang · 54m</div>
        </a>
        </div>
        <div class="card-footer text-center">
        <a class="m-0 small text-primary card-link" href="#">View More <i
            class="fas fa-chevron-right"></i></a>
        </div>
    </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('backend/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('backend/js/demo/chart-area-demo.js')}}"></script> 
<script>
var _chartJsonData = {!! json_encode(array_values($graphPricing)) !!};
// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Sales",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.5)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: _chartJsonData,
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return 'Rs. ' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': Rs. ' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});
</script>
@endsection