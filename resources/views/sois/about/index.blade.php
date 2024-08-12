@extends('sois.layouts.app')
@section('content')
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class=" col-xl-12 col-md-12 col-xs-12 text-center" {{-- style="padding-top: 30px;" --}}>
                    <span {{-- style="    font-family: 'LFranklin Bold', Arial, sans-serif;
                font-size: 50px;
                text-align: center; padding: 5rem;

    text-transform: uppercase;" --}} class="page-title-text">ABOUT US</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-content-items">
            <div class="row">
                <div id="au-about" class="section-title col-xl-12 col-md-12 col-xs-12 ">
                    <span></span>
                </div>
            </div>

            <div class="row">

                {{-- <section class="content-section left p-5">
                <section class="flexbox-section right p-0">
                    <section class="image-section">
                        <div class="image-wrapper border border-green left">
                            <img src="../assets/img/sou/sou logo.png" alt="">
                        </div>
                    </section>

                    <section class="text-section lh-base">
                        <h4 class="title">Central Luzon State University</h4>
                    <div class="content lh-base">
                        <p>The Central Luzon State University (CLSU), one of the renowned and prestigious state institutions of higher learning in the country, straddles a 658-hectare campus in the Science City of Muñoz, Nueva Ecija, 150 kilometers north of Manila.</p>
                        <p>The lead agency of the Muñoz Science Community and the seat of Central Luzon Agriculture, Aquatic and Resources Research and Development Consortium (CLAARRDEC).</p>
                        <p>The university was designated by the Commission on Higher Education (CHED) – National Agriculture and Fisheries Education System (NAFES) as National University College of Agriculture (NUCA) and National University College of Fisheries (NUCF). Similarly, designated as CHED Center of Excellence (COE) in Agriculture, Agricultural Engineering, Biology, Fisheries, Teacher Education, and Veterinary Medicine - the most number of COEs in Central and Northern Luzon Regions. It is likewise designated as the Center of Research Excellence in Small Ruminants by the Philippine Council for Agriculture, Aquaculture, Forestry and Natural Resources Research and Development - Department of Science and Technology (PCAARRD-DOST). Also designated by the Department of Environment and Natural Resources (DENR) as the Regional Integrated Coastal Resources Management Center. Additionally, it was picked as the Model Agro-Tourism Site for Luzon.</p>
                        <p>CLSU stands out as the only comprehensive state university in the Philippines with the most number of curricular programs accredited by the Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP) with Level IV accreditation. The university is further declared Cultural Property of the Philippines with the code of PH-03-0027 due to its high historical, cultural, academic, and agricultural importance to the nation.</p>
                        <p>To date, CLSU remains as one of the premier institutions of agriculture in Southeast Asia known for its breakthrough researches in aquatic culture (pioneer in the sex reversal of tilapia), ruminant, crops, orchard, and water management, living through its vision of becoming “a world-class National Research University for science and technology in agriculture and allied fields.”</p>
                    </div>
                    </section>
                </section>
            </section> --}}
                <div class="page-cont section-cont col-xl-12 " style="margin-bottom: -5rem;">
                    <div class="flexbox-gen left m-b-2">
                        <div class="col-md-6 ">
                            <div class="d-block d-md-none">
                                <img style=  "display: block;
                                 height: 250px;
                                width: 300px;
                                margin-left: auto;
                                margin-right: auto;

                                "
                                    src="../assets/img/sou/sou logo.png">
                                <p class="caption"></p>
                            </div>
                            <div class="d-none d-md-block img-wrapper-black-sub ">
                                <img style=  "display: block;
                                 height: 400px;
                                width: 400px;
                                margin-left: auto;
                                margin-right: auto;

                                "
                                    src="../assets/img/sou/sou logo.png">
                                <p class="caption">CLSU Main Gate</p>
                            </div>
                        </div>

                        <div class="d-none d-md-block  ">
                            <div class="text-wrapper text-justify">
                                <h4 class="title">{{ $about->title ?? '' }}</h4>
                                <p>{!! $about->side_view_content ?? '' !!}</p>
                                {!! $about->main_content ?? '' !!}
                            </div>
                        </div>
                    </div>

                    <div class="d-block d-md-none intro-text  text-justify">
                        <h4 class="title">{{ $about->title ?? '' }}</h4>
                        <p>{!! $about->side_view_content ?? '' !!}</p>
                        {!! $about->main_content ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
