@extends('admin/includes/template')

@section('main-section')

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="zmdi zmdi-shopping-cart zmdi-hc-fw" aria-hidden="true"></span> View Order Details
                        <a href="../../../admin/orders/list" class="btn btn-primary pull-right admin-right-btn">Back to order list</a>
                        <a href="javascript:void(0);" class="btn btn-success pull-right reprocess-btn" style="margin-right:5px;">Re-process Payment</a>
                    </div>
                    <br/>
                    @php
                        $stripe_response = json_decode($details['stripe_payload'], TRUE);
                    @endphp
                    <div class="current_games_section">
                          <table id="example" class="table">
                            <tr>
                                <td>Order ID</td>
                                <td>OID-{{ str_pad($details['order_id'],6,"0",STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{ $details['name'] }}</td>
                            </tr>
                            <tr>
                                <td>Email Address</td>
                                <td>{{ $details['email'] }}</td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>{{ $details['phone_number'] }}</td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td>{{ $details['zip_code'] }}</td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>{{ $details['amount']." ".$details['currency'] }}</td>
                            </tr>
                            <tr>
                                <td>Client Account No</td>
                                <td>{{ $details['account_no'] }}</td>
                            </tr>
                            <tr>
                                <td>Client IP</td>
                                <td>{{ $details['client_ip'] }}</td>
                            </tr>
                            <tr>
                                <td>Credit Card No</td>
                                <td>**** **** **** {{ $stripe_response['source']['last4'] }}</td>
                            </tr>
                            <tr>
                                <td>Credit Card Brand</td>
                                <td>{{ $stripe_response['source']['brand'] }}</td>
                            </tr>
                            <tr>
                                <td>Stripe Transaction ID</td>
                                <td>{{ $details['stripe_transaction_id'] }}</td>
                            </tr>
                            <tr>
                                <td>Stripe Payment Mode</td>
                                <td>
                                    @if ($stripe_response['livemode'])
                                        <span class="badge badge-success">Production (Live)</span>
                                    @else
                                        <span class="badge badge-warning">Sandbox (Test)</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Stripe Receipt</td>
                                <td><a href="{{ $stripe_response['receipt_url'] }}" target="_blank">Click here</a></td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td style="color:{{ getUserStatusColor($details['order_status']) }}"><strong>{{ $details['order_status'] }}</strong> </td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td style="width:1200px;">{{ convertDateTime($details['created_at']) }}</td>
                            </tr>   
                          </table>
                      </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>

<!-- Re-process Payment Modal -->
<div class="modal" id="noAnimation" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green m-b-10"> 
                <button type="button" class="close white-clr" data-dismiss="modal">X</button>
                <h4 class="modal-title white-clr">Re-process Payment - {{ $details['name'] }}</h4>
            </div>
            <form role="form" method="post" class="reprocess-order-form">
                <div class="modal-body">
                    <input type="hidden" name="order_guid" value="{{ $details['order_guid'] }}">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Amount ({{ $configurations['stripe_currency'] }})</label>
                                <input type="text" class="form-control validate-no" name="amount" placeholder="Amount ({{ $configurations['stripe_currency'] }})" autocomplete="off" maxlength="4" min="1" max="{{ $max_amount_limit }}" value="{{ $details['amount'] }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection