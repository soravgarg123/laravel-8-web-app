@extends('admin/includes/template')

@section('main-section')

<section id="content">
    <div class="container">
        <div class="tile">
            <div class="t-header">
                <div class="th-title">Edit Profile</div>
            </div>
            <div class="t-body tb-padding">
                <form role="form" method="post" class="edit-profile-form">
                    <input type="hidden" name="user_guid" value="{{  $details->user_guid }}">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Full Name</label>
                                <input type="text" value="{{ $details->name }}" class="form-control" name="name" placeholder="Enter Full Name" maxlength="150" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Select Gender</label>
                                <select class="form-control chosen-select" name="gender">
                                    <option  value="">Select Gender</option>
                                    <option {{ ($details->gender == "Male") ? "selected" : "" }} value="Male">Male</option>
                                    <option {{ ($details->gender == "Female") ? "selected" : "" }} value="Female">Female</option>
                                    <option {{ ($details->gender == "Other") ? "selected" : "" }} value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input  value="{{ $details->email }}" name="email" type="email" class="form-control" placeholder="Enter Email" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Mobile Number</label>
                                <input type="text" value="{{ $details->phone_number }}" class="form-control" placeholder="Enter Mobile Number" maxlength="15" name="phone_number" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group col-sm-8 text-center">
                            <button class="btn btn-primary create_btn" >Update</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='dashboard'">Cancel</button>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection