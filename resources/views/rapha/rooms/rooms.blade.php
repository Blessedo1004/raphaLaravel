<x-head title="Rapha Hotel — Rooms" metaDescription="Browse our selection of luxurious rooms and suites. Each room is designed for comfort and relaxation, with modern amenities to ensure a memorable stay.">


    <x-slot name="body">
      <!--Content Begins-->
              <div class="no-bottom no-top" id="content">

            <div id="top"></div>

            <section id="subheader" class="relative jarallax text-light">
                <img src="images/background/1.webp" class="jarallax-img" alt="">
                <div class="container relative z-index-1000">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h1>Our Rooms</h1>
                            <p class="mt-3 lead">Indulge in the ultimate blend of elegance and comfort in our meticulously designed rooms. Choose your room today.</p>
                            <ul class="crumb">
                                <li><a href="{{ route('rapha.home') }}">Home</a></li>
                                <li class="active">Our Rooms</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="de-overlay"></div>
            </section>

            <section id="section-rooms">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-lg-8 offset-lg-2 text-center">
                            <div class="subtitle id-color wow fadeInUp">Our Rooms</div>
                            <h2 class="wow fadeInUp mb-4">Accomodation</h2>
                        </div>
                    </div>

                    <div class="row g-4">
                          
                        <x-rooms></x-rooms>
                                                
                      
                    </div>
                </div>
            </section>

        </div>
        <!-- content close -->
    </x-slot>
</x-head>