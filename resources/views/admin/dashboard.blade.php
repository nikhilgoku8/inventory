@extends('admin.layout.master')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="page-header my_style">
            <div class="left_section">
                <h1 class="">Welcome To CRM</h1>
                <ul class="breadcrumb">
                    <li><a>Home</a></li>
                    <li><a>Dashboard</a></li>
                </ul>
            </div>
            
            <div class="right_section">
                <!-- <div class="purple_hollow_btn">
                    <a href="{{ url('nwm/dashboard/export') }}" target="_blank">Export Data</a>
                </div>
                <div class="blue_filled_btn">
                    <a href="{{ url('nwm/dashboard/log_activities') }}" target="_blank">Activities</a>
                </div> -->
            </div>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

@endsection