@extends('layouts.app')

@section('title', 'Thank You - WatyAssessment')

@section('content')

<div class="container d-flex justify-content-center align-items-center"
     style="min-height: 75vh;">

    <div class="glass-card p-5 text-center"
         style="max-width: 650px; width: 100%;">

        <div class="mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="WatyAssessment Logo" style="height: 65px; width: auto;" class="mb-3 d-block mx-auto">
            <i class="fa-solid fa-circle-check text-success"
               style="font-size: 50px;"></i>
        </div>

        <h1 class="mb-3">
            Assessment Completed! 🎉
        </h1>

        <p class="lead mb-4">
            Thank you for completing your assessment with
            <strong>WatyAssessment</strong>.
        </p>

        <p class="text-muted mb-4">
            We hope you found the assessment useful.
            Your scorecard has been generated successfully.
        </p>

        <div class="mb-4">
            <h4>
                We'd love to hear from you! ❤️
            </h4>

            <p class="text-muted">
                Your feedback helps us improve WatyAssessment
                and helps other students discover
                <strong>WatY Learning Hub</strong>.
            </p>
        </div>

        <a href="https://www.google.com/search?client=ms-android-samsung-rvo1&hs=9oTq&sca_esv=6aa6f5dc69016758&hl=en-IN&cs=1&sxsrf=APpeQnv3DrhMOzWz6lSCPAK49HQSPQQxzw:1787227336423&kgmid=/g/11vz3kwbj8&q=wat%27y+learning+hub&shem=epsd1,ltae,rimspwouoe&shndl=30&source=sh/x/loc/act/m1/4&kgs=55e6d541a841a8f0&utm_source=epsd1,ltae,rimspwouoe,sh/x/loc/act/m1/4#cobssid=s"
           target="_blank"
           class="btn btn-premium px-4 py-3">

            <i class="fa-solid fa-star me-2"></i>
            Share Your Feedback
        </a>

    </div>

</div>

@endsection