@extends('admin/includes/template')

@section('main-section')

<section id="content">
    <div class="container"> 
        <div class="tile">
            <div class="t-header">
                <div class="th-title"><i class="zmdi zmdi-settings zmdi-hc-fw"></i> Manage Configurations</div>
            </div>
            <div class="t-body tb-padding">
                <form role="form" method="post" class="update-configuration-form">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Stripe Mode</label>
                                <select class="form-control chosen-select" name="stripe_mode">
                                    <option value="Test" {{ ($configurations['stripe_mode'] == 'Test') ? 'selected' : '' }}>Sandbox (Test)</option>
                                    <option value="Production" {{ ($configurations['stripe_mode'] == 'Production') ? 'selected' : '' }}>Production (Live)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Stripe Currency</label>
                                <select class="form-control chosen-select" name="stripe_currency">
                                    <option value="AUD" {{ ($configurations['stripe_currency'] == 'AUD') ? 'selected' : '' }}>Australian Dollar (AUD)</option>
                                    <option value="CAD" {{ ($configurations['stripe_currency'] == 'CAD') ? 'selected' : '' }}>Canadian Dollar (CAD)</option>
                                    <option value="EUR" {{ ($configurations['stripe_currency'] == 'EUR') ? 'selected' : '' }}>Euro (EUR)</option>
                                    <option value="GBP" {{ ($configurations['stripe_currency'] == 'GBP') ? 'selected' : '' }}>British Pound (GBP)</option>
                                    <option value="USD" {{ ($configurations['stripe_currency'] == 'USD') ? 'selected' : '' }}>United States Dollar (USD)</option>
                                </select>

                            </div>
                        </div>
                        </div><div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Stripe Publishable Key</label>
                                <input type="text" class="form-control" name="stripe_publishable_key" value="{{ $configurations['stripe_publishable_key'] }}" placeholder="Stripe Publishable Key">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Stripe Secret Key</label>
                                <input type="text" class="form-control" name="stripe_secret_key" value="{{ $configurations['stripe_secret_key'] }}" placeholder="Stripe Secret Key">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Stripe Statement Descriptor</label>
                                <input type="text" class="form-control" name="statement_descriptor" value="{{ $configurations['statement_descriptor'] }}" placeholder="Stripe Statement Descriptor" maxlength="22">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" rows="4" placeholder="Description" name="description">{{ $configurations['description'] }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Website Name</label>
                                <input type="text" class="form-control" name="website_name" value="{{ $configurations['website_name'] }}" placeholder="Website Name">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Website Logo (JPEG | PNG | GIF)</label><br/>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="line-height: 150px;"><img src="{{ url('uploads/logo/') }}/{{ $configurations['website_logo'] }}" class="img-responsive"></div>
                                    <p>Image Size (150 * 150)</p>
                                    <div>
                                        <span class="btn btn-info btn-file">
                                            <span class="fileinput-new">Select Image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="hidden" value=""><input type="file" name="image">
                                        </span>
                                        <a href="javascript:void(0);" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-8 text-center m-t-20">
                                <button class="btn btn-primary" >Submit</button>
                                <button type="button" class="btn btn-danger reset-btn">Reset</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection