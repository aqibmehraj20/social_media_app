@extends('layouts.app')

@section('content')
<head>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }} ">

</head>
<main>
        <div id="image-section">

            <img class="header-image" src="https://github.com/malunaridev/Landing-Pages-Are-Fun/blob/master/1-business-agency-concept/assets/image.png?raw=true" alt="a business woman and man standing back to back to each other and smiling">
        </div>
        <div id="content">
            <div id="content-text">
                <h1>Social <br> Media</h1>
                
                <button>Learn More</button>
            </div>
            <div id="footer">
                <div id="contacts">
                    <div id="phone">
                        More Information call us <br>
                        <span>+91-84910-21018</span>
                    </div>
                </div>
                <div class="icons">
                    <i class="fa-solid fa-mobile-screen"></i>
                    <i class="fa-solid fa-location-dot"></i>
                </div>
            </div>
        </div>
    </main>

@endsection

