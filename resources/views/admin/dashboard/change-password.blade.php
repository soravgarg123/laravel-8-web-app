@extends('admin/includes/template')

@section('main-section')

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            	<div class="tile">
                    <div class="t-header">
                        <div class="th-title"><span class="zmdi zmdi-key zmdi-hc-fw" aria-hidden="true"></span> Change Password</div>
                    </div>
                    
                    <div class="t-body tb-padding">
                        <div class="row">
                        	<form method="post" id="profile-form" class="profile-form" novalidate="novalidate">
                              <div class="form-group col-sm-12">
                                <div class="alert alert-warning col-sm-8" role="alert" style="font-size:16px;">
                                <strong>Important Info!</strong> We suggest you to change password on regular basis.
                              </div>
                              </div>
                              <div class="form-group col-sm-12">
                              <div class="col-sm-3">
                                <label class="control-label">Current Password</label>
                              </div>
                              <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="password" placeholder="Current Password" class="form-control" id="current_password" name="current_password" required>
                                    <span class="input-group-addon last view-password" title="Click Here To View Password"><i class="glyphicon glyphicon-eye-open"></i></span>
                                </div>
                              </div>
                              </div>
	                          <div class="form-group col-sm-12">
	                          <div class="col-sm-3">
	                          	<label class="control-label">New Password</label>
	                          </div>
	                          <div class="col-sm-5">
                              <div class="input-group">
                                    <input type="password" placeholder="New Password" class="form-control" id="new_password" name="new_password" required>
                                    <span class="input-group-addon last view-password" title="Click Here To View Password"><i class="glyphicon glyphicon-eye-open"></i></span>
                                </div>
	                          </div>
	                          </div>

	                          <div class="form-group col-sm-12">
	                          <div class="col-sm-3">
	                          	<label class="control-label">Confirm Password</label>
	                          </div>
	                          <div class="col-sm-5">
                              <div class="input-group">
                                    <input type="password" placeholder="Confirm Password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <span class="input-group-addon last view-password" title="Click Here To View Password"><i class="glyphicon glyphicon-eye-open"></i></span>
                                </div>
	                          </div>
	                          </div>
                                <div class="form-group col-sm-12 text-center">
                                    <button class="btn btn-primary create_btn" >Update</button>
                                    <button type="button" class="btn btn-danger reset-btn">Reset</button>
	                            </div>
                            <form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection