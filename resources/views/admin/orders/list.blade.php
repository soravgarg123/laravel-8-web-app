@extends('admin/includes/template')

@section('main-section')

<section id="content">
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="zmdi zmdi-shopping-cart zmdi-hc-fw" aria-hidden="true"></span> Orders ({{ addZero(count($orders)) }})
                    </div><br/>
                    <div class="current_games_section">
                        <table class="table table-striped table-bordered my-datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Zip Code</th>
                                    <th>Amount</th>
                                    <th>Transaction ID</th>
                                    <th>Order Status</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                            @if(!empty($orders))
                                @foreach ($orders as $key => $value)
                                <tr>
                                    <td>{{ addZero($key+1) }}</td>
                                    <td>{{ 'OID-'.str_pad($value['order_id'],6,"0",STR_PAD_LEFT) }}</td>
                                    <td>{{ $value['name'] }}</td>
                                    <td>{{ $value['email'] }}</td>
                                    <td>{{ $value['phone_number'] }}</td>
                                    <td>{{ $value['zip_code'] }}</td>
                                    <td>{{ $value['amount']." ".$value['currency'] }}</td>
                                    <td>{{ $value['stripe_transaction_id'] }}</td>
                                    <td style="color:{{ getUserStatusColor($value['order_status']) }}"><strong>{{ $value['order_status'] }}</strong></td>
                                    <td>{{ convertDateTime($value['created_at']) }}</td>
                                    <td>
                                        <button class="btn bg-cyan btn-icon" onclick="window.location.href='details/{{ $value['order_guid'] }}'" title="View Order Details"><i class="zmdi zmdi-eye"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>

@endsection