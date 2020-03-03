@extends('layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Edit Project
                <span style="font-size:20px;position: relative;top: -3px;"><span style="color:black;">[ </span><span style="color:green;">{{$project->name}}</span><span style="color:black;"> ]</span></span>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Projects</li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        @if (Session::has('message'))
        <div class="spacer"></div>
        {!! session('message') !!}
        @endif
    </div>
</div>

<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form action="{{ route('projectsEditSave', $project->id) }}" method="POST" id="form-validate" name="form-validate" >
                {{ csrf_field() }}
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-details-tab" data-toggle="pill" href="#pills-details" role="tab" aria-controls="pills-details" aria-selected="true">Project Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-citations-tab" data-toggle="pill" href="#pills-citations" role="tab" aria-controls="pills-citations" aria-selected="false">Citations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-qa-tab" data-toggle="pill" href="#pills-qa" role="tab" aria-controls="pills-qa" aria-selected="false">Questions and Answers</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab">
                        <div class="spacer"></div>
                        <div class="row push">


                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label for="name">
                                        Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$project->name}}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Project Brief</label>
                                    <textarea class="form-control ckeditor" id="description" name="description" rows="6" placeholder="Description">{{$project->description}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="website">
                                        Website <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="website" name="website" placeholder="Website" value="{{$project->website}}">
                                </div>

                                <div class="form-group">
                                    <label for="hours">
                                        Hours <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="hours" name="hours" placeholder="Enter the customer hours" value="{{$project->hours}}">
                                </div>

                                <div class="form-group">
                                    <label>Start Day</label>
                                    <div id="datepicker" class="input-group date" data-date-format="dd">
                                        <input class="form-control" name="start" type="text" value="{{$project->start}}" />
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>End Day</label>
                                    <div id="datepicker2" class="input-group date" data-date-format="dd">
                                        <input class="form-control" name="end" type="text" value="{{$project->end}}"/>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <h3 class="content-heading pt-0">CMS</h3>
                                <div class="form-group">
                                    <label for="description">URL</label>
                                    <input type="text" class="form-control" id="cms_url" name="cms_url" placeholder="Url" value="{{$project->cms_url}}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Username</label>
                                    <input type="text" class="form-control" id="cms_username" name="cms_username" placeholder="Username" value="{{$project->cms_username}}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Password</label>
                                    <input type="text" class="form-control" id="cms_password" name="cms_password" placeholder="Password" value="{{$project->cms_password}}">
                                </div>

                                <h3 class="content-heading pt-0">FTP</h3>

                                <div class="form-group">
                                    <label for="description">IP/Website::Port</label>
                                    <input type="text" class="form-control" id="ftp_ip" name="ftp_ip" placeholder="IP/Port" value="{{$project->ftp_ip}}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Username</label>
                                    <input type="text" class="form-control" id="ftp_username" name="ftp_username" placeholder="Username" value="{{$project->ftp_username}}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Password</label>
                                    <input type="text" class="form-control" id="ftp_password" name="ftp_password" placeholder="Password" value="{{$project->ftp_password}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-citations" role="tabpanel" aria-labelledby="pills-citations-tab">
                        <div class="spacer"></div>
                        <div class="row push">


                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>
                                        Company Owners
                                    </label>
                                    <input type="text" class="form-control" id="company_owners" name="company_owners" placeholder="Company Owners" value="{{$project->citations->company_owners}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Gender(s)
                                    </label>
                                    <input type="text" class="form-control" id="genders" name="genders" placeholder="Gender(s)" value="{{$project->citations->genders}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Business Name
                                    </label>
                                    <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Business Name" value="{{$project->citations->business_name}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Address Line 1
                                    </label>
                                    <input type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="Address Line 1" value="{{$project->citations->address_line_1}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Address Line 2
                                    </label>
                                    <input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Address Line 2" value="{{$project->citations->address_line_2}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        City
                                    </label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{$project->citations->city}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        State/Province
                                    </label>
                                    <input type="text" class="form-control" id="state" name="state" placeholder="State/Province" value="{{$project->citations->state}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Postcode
                                    </label>
                                    <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" value="{{$project->citations->postcode}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Virtual Office
                                    </label>
                                    <input type="text" class="form-control" id="virtual" name="virtual" placeholder="Virtual Office" value="{{$project->citations->virtual}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Offices in the same city?
                                    </label>
                                    <input type="text" class="form-control" id="offices_same_city" name="offices_same_city" placeholder="Offices in the same city?" value="{{$project->citations->offices_same_city}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Business Phone Number
                                    </label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Business Phone Number" value="{{$project->citations->phone}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Business Changes
                                    </label>
                                    <input type="text" class="form-control" id="business_changes" name="business_changes" placeholder="Business Changes" value="{{$project->citations->business_changes}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Main Business Email Address
                                    </label>
                                    <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Main Business Email Address" value="{{$project->citations->email_address}}">
                                </div>

                                <div class="form-group">
                                    <label>Hours of Operation</label>
                                    <textarea class="form-control ckeditor" id="hours_of_operation" name="hours_of_operation" rows="6" placeholder="Hours of Operation">{{$project->citations->hours_of_operation}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Years in Business
                                    </label>
                                    <input type="text" class="form-control" id="years_in_business" name="years_in_business" placeholder="Years in Business" value="{{$project->citations->years_in_business}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Business Tagline
                                    </label>
                                    <input type="text" class="form-control" id="tagline" name="tagline" placeholder="Business Tagline" value="{{$project->citations->tagline}}">
                                </div>

                                <div class="form-group">
                                    <label>Business Description</label>
                                    <textarea class="form-control ckeditor" id="business_description" name="business_description" rows="6" placeholder="Business Description">{{$project->citations->business_description}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Payments Accepted
                                    </label>
                                    <input type="text" class="form-control" id="payments_accepted" name="payments_accepted" placeholder="Payments Accepted" value="{{$project->citations->payments_accepted}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Website URL
                                    </label>
                                    <input type="text" class="form-control" id="website_url" name="website_url" placeholder="Website URL" value="{{$project->citations->website_url}}">
                                </div>


                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>
                                        Google Maps URL
                                    </label>
                                    <input type="text" class="form-control" id="google_maps_url" name="google_maps_url" placeholder="Google Maps URL" value="{{$project->citations->google_maps_url}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Twitter URL
                                    </label>
                                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter URL" value="{{$project->citations->twitter}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Facebook URL
                                    </label>
                                    <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook URL" value="{{$project->citations->facebook}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        LinkedIn URL
                                    </label>
                                    <input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="LinkedIn URL" value="{{$project->citations->linkedin}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Youtube URL
                                    </label>
                                    <input type="text" class="form-control" id="youtube" name="youtube" placeholder="Youtube URL" value="{{$project->citations->youtube}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Google+
                                    </label>
                                    <input type="text" class="form-control" id="google_plus" name="google_plus" placeholder="Google+" value="{{$project->citations->google_plus}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Categories
                                    </label>
                                    <input type="text" class="form-control" id="categories" name="categories" placeholder="Categories" value="{{$project->citations->categories}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Services You Offer
                                    </label>
                                    <input type="text" class="form-control" id="services_offer" name="services_offer" placeholder="Services You Offer" value="{{$project->citations->services_offer}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Products You Offer
                                    </label>
                                    <input type="text" class="form-control" id="products_offer" name="products_offer" placeholder="Products You Offer" value="{{$project->citations->products_offer}}">
                                </div>

                                <div class="form-group">
                                    <label>Service/Product Description #1</label>
                                    <textarea class="form-control ckeditor" id="service_description_1" name="service_description_1" rows="6" placeholder="Service/Product Description #1">{{$project->citations->service_description_1}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Service/Product Description #2</label>
                                    <textarea class="form-control ckeditor" id="service_description_2" name="service_description_2" rows="6" placeholder="Service/Product Description #2">{{$project->citations->service_description_2}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Service/Product Description #3</label>
                                    <textarea class="form-control ckeditor" id="service_description_3" name="service_description_3" rows="6" placeholder="Service/Product Description #3">{{$project->citations->service_description_3}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Areas Covered
                                    </label>
                                    <input type="text" class="form-control" id="areas_served" name="areas_served" placeholder="Areas Covered" value="{{$project->citations->areas_served}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Business Logo URL
                                    </label>
                                    <input type="text" class="form-control" id="company_logo" name="company_logo" placeholder="Business Logo URL" value="{{$project->citations->company_logo}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Company Owner Profile URL
                                    </label>
                                    <input type="text" class="form-control" id="company_logo" name="profile_logo" placeholder="Company Owner Profile URL" value="{{$project->citations->profile_logo}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-qa" role="tabpanel" aria-labelledby="pills-qa-tab">
                        <div class="spacer"></div>
                        <div class="row push">


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        Main Contact
                                    </label>
                                    <input type="text" class="form-control" id="main_contact" name="main_contact" placeholder="Main Contact" value="{{$project->qa->main_contact}}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Other Contacts
                                    </label>
                                    <input type="text" class="form-control" id="other_contact" name="other_contact" placeholder="Other Contacts" value="{{$project->qa->other_contact}}">
                                </div>

                                 <div class="form-group">
                                    <label>
                                        Current Sales/Leads/Traffic
                                    </label>
                                    <textarea class="form-control ckeditor" id="sales" name="sales" rows="6">{{$project->qa->sales}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Potential Keywords
                                    </label>
                                    <textarea class="form-control ckeditor" id="potential_keywords" name="potential_keywords" rows="6">{{$project->qa->potential_keywords}}</textarea>
  
                                </div>

                                <div class="form-group">
                                    <label>
                                        Popular Products and Services
                                    </label>
                                     <textarea class="form-control ckeditor" id="popular_products_services" name="popular_products_services" rows="6">{{$project->qa->popular_products_services}}</textarea>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>
                                        Profitable Products and Services
                                    </label>
                                    <textarea class="form-control ckeditor" id="profitable_products_services" name="profitable_products_services" rows="6">{{$project->qa->profitable_products_services}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Competitors
                                    </label>
                                    <textarea class="form-control ckeditor" id="competitors" name="competitors" rows="6">{{$project->qa->competitors}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Geography
                                    </label>
                                    <input type="text" class="form-control" id="geography" name="geography" placeholder="Geography" value="{{$project->qa->geography}}">
                                </div>

                                 <div class="form-group">
                                    <label>
                                        Business Goals
                                    </label>
                                     <textarea class="form-control ckeditor" id="goals" name="goals" rows="6">{{$project->qa->goals}}</textarea>
                                </div>


                                <div class="form-group">
                                    <label>
                                        Other Websites
                                    </label>
                                    <input type="text" class="form-control" id="other_urls" name="other_urls" placeholder="Other Websites" value="{{$project->qa->other_urls}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right">
                            <i class="fa fa-check-circle mr-1"></i> Update Project
                        </button>
                    </div>


            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {



        $("#datepicker").datepicker("setDate", "{{$project->start}}");
        $("#datepicker2").datepicker("setDate", "{{$project->end}}");

        $("form[name='form-validate']").validate({
            errorElement: 'div',
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                name: "required",
                website: "required"
            },
            // Specify validation error messages
            messages: {
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {
                form.submit();
            }
        });

        CKEDITOR.replace('.ckeditor');

    });
</script>

@endsection
