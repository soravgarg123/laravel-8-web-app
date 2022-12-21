@extends('admin/includes/template')

@section('main-section')
<section id="content">
    <div class="container">
        <header class="page-header">
            <h3>Dashboard </h3>
        </header>
        <div class="overview row">

            <!-- Get Success Orders Count -->
            <div class="col-md-3 col-sm-4">
                <div class="o-item bg-orange">
                    <div class="oi-title">
                        <span data-value="450382"></span>
                        <span>Total Success Orders</span>
                    </div>
                    <h1>{{ addZero($statics['total_success_orders']) }}</h1>
                </div>
            </div>

            <!-- Get Failed Orders Count -->
            <div class="col-md-3 col-sm-4">
                <div class="o-item bg-cyan">
                    <div class="oi-title">
                        <span data-value="450382"></span>
                        <span>Total Failed Orders</span>
                    </div>
                    <h1>{{ addZero($statics['total_failed_orders']) }}</h1>
                </div>
            </div>

            <!-- Get Last Login -->
            <div class="col-md-3 col-sm-4">
                <div class="o-item bg-creat">
                    <div class="oi-title">
                        <span data-value="8737"></span>
                        <span>Last Login</span>
                    </div>
                    <h3 class="last_login">{{ convertDateTime(Session::get('admin_user')['last_login']) }}</h3>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection