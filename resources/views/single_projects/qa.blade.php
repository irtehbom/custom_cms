@extends('layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Questions and Answers for {{$project->name}}</h1>
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
                            <td class="qa_citations_left">Who is the main point of contact for the project (name, email, phone, mobile)?</td>
                            <td>{{$qa->main_contact}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Who else needs to be added to the Project Management System and kept updated (name, email)?</td>
                            <td>{{$qa->other_contact}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">Current situation - how much traffic does the site currently receive and how well does this convert into sales/leads?</td>
                            <td>{{$qa->sales}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">Potential Keywords - what do you think your potential customers are searching for when looking to buy products/services like yours?</td>
                            <td>{{$qa->potential_keywords}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">What are your most popular products/services?</td>
                            <td>{{$qa->popular_products_services}}</td>
                        </tr>
                         <tr>
                            <td class="qa_citations_left">What are your most profitable products/services?</td>
                            <td>{{$qa->profitable_products_services}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Competition - do you have any competitors providing similar products/services who appear to be doing well online?</td>
                            <td>{{$qa->competitors}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Geography - where are you looking to generate more business and are there any restrictions geographically?</td>
                            <td>{{$qa->geography}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Goals and expectations - what would a successful campaign look like in 6/12 months?</td>
                            <td>{{$qa->goals}}</td>
                        </tr>
                        <tr>
                            <td class="qa_citations_left">Does your company own any other URL’s and/or websites? (if so, please list them below or type N/A)</td>
                            <td>{{$qa->other_urls}}</td>
                        </tr>
                        

                    </tbody>
                </table>
        </div>
    </div>
</div>

@endsection
