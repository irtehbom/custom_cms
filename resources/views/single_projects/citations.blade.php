@extends('layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Citations for {{$project->name}}</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                @include('partials.links_header')
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

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Question</th>
                            <th scope="col">Answer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="qa_citations_left">Company Owner (or a contact person at the company)</td>
                            <td>{{$citations->company_owners}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Company Owner (or Contact Person) Gender: M/F</td>
                            <td>{{$citations->genders}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Business Name</td>
                            <td>{{$citations->business_name}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Address Line 1</td>
                            <td>{{$citations->address_line_1}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Address Line 2</td>
                            <td>{{$citations->address_line_2}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">City</td>
                            <td>{{$citations->city}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Province/State</td>
                            <td>{{$citations->state}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Zip Code</td>
                            <td>{{$citations->postcode}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Is this location at a virtual office, UPS box, or a real office with full-time staff?</td>
                            <td>{{$citations->virtual}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Does this business have other offices in the same city?</td>
                            <td>{{$citations->offices_same_city}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Phone</td>
                            <td>{{$citations->phone}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Has the business ever changed its name, moved, or changed phone numbers? If you don't know, please ask. If yes, please provide details on any previous names, addresses, phone numbers and websites.</td>
                            <td>{{$citations->business_changes}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Business' email address for public display(optional, and not recommended. See note)</td>
                            <td>{{$citations->email_address}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Hours of operation</td>
                            <td>{{$citations->hours_of_operation}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Years in Business</td>
                            <td>{{$citations->years_in_business}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Headline/Tagline</td>
                            <td>{{$citations->tagline}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Business Description(minimum 400 characters)</td>
                            <td>{{$citations->business_description}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Payment Types Accepted</td>
                            <td>{{$citations->payments_accepted}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Website URL</td>
                            <td>{{$citations->website_url}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Google Maps URL</td>
                            <td>{{$citations->google_maps_url}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Twitter Profile URL</td>
                            <td>{{$citations->twitter}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Facebook Page URL</td>
                            <td>{{$citations->facebook}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Linkedin Company Page URL</td>
                            <td>{{$citations->linkedin}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">You Tube Page URL</td>
                            <td>{{$citations->youtube}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Google+ Page URL</td>
                            <td>{{$citations->google_plus}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Categories</td>
                            <td>{{$citations->categories}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Services You Offer</td>
                            <td>{{$citations->services_offer}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Products You Offer</td>
                            <td>{{$citations->products_offer}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Service/Product Description #1:</td>
                            <td>{{$citations->service_description_1}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">Service/Product Description #2:</td>
                            <td>{{$citations->service_description_2}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">Service/Product Description #3:</td>
                            <td>{{$citations->service_description_3}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">Areas You Serve</td>
                            <td>{{$citations->areas_served}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">Company Logo:</td>
                            <td>{{$citations->company_logo}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">Company Owner Profile Image</td>
                            <td>{{$citations->profile_logo}}</td>
                        </tr>
                        
                    </tbody>
                </table>

        </div>
    </div>
</div>

@endsection
