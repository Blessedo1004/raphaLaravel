<x-head title="Rapha Hotel — Banquet & Conference halls" metaDescription="Rapha Hotel offers both small and large banquet halls, perfect for intimate gatherings or grand celebrations.">

    <x-slot name="body">
            <!-- content begin -->
      <div class="no-bottom no-top" id="content">

          <div id="top"></div>

          <section id="subheader" class="relative jarallax text-light">
              <img src="{{asset('images/banquet-conference-hall/3.webp')}}" class="jarallax-img" alt="">
              <div class="container relative z-index-1000">
                  <div class="row justify-content-center">
                      <div class="col-lg-12 text-center">
                          <h1>Banquet and Conference Halls</h1>
                          <ul class="crumb">
                              <li><a href="{{ route('rapha.home') }}">Home</a></li>
                              <li class="active">Banquet and Conference Halls<</li>
                          </ul>
                          <div class="spacer-double"></div>
                      </div>
                  </div>
              </div>
              <div class="de-overlay"></div>
          </section>

          <section class="relative z-4 no-top no-bottom">
              <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-lg-8">
                          <div class="mt-70">
                              <div class="row g-0">
                                  <div class="col-md-6 text-center">
                                      <div class="bg-color text-light p-4 h-100 wow fadeInRight" data-wow-delay=".0s">
                                          <div class="de_count fs-15 wow fadeInRight" data-wow-delay=".4s">
                                              <h2 class="mb-0">Multiple</h2>
                                              <span>Guests</span>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-md-6 text-center">
                                      <div class="text-light p-4 h-100 wow fadeInRight" data-bgcolor="#70533A" data-wow-delay=".2s">
                                          <div class="de_count fs-15 wow fadeInRight" data-wow-delay=".6s">
                                              <a class="btn-main btn-line no-bg mt-lg-4" href="{{ route('rapha.login') }}">Book Now</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>

          <section class="relative">
              <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-lg-7 text-center">
                          <h3 class="wow fadeInUp">Rapha Hotel offers both small and large banquet halls, perfect for intimate gatherings or grand celebrations.</h3>
                      </div>
                  </div>
              </div>

              <div class="spacer-single"></div>

              <div class="relative wow fadeIn">
                  <div class="owl-custom-nav menu-float" data-target="#room-carousel">
                      <a class="btn-next"></a>
                      <a class="btn-prev"></a>                                

                      <div id="room-carousel" class="owl-2-cols-center owl-carousel owl-theme">
                          <!-- room begin -->
                          <div class="item">
                            <div class="hover relative text-light">
                              <img src="{{asset('images/banquet-conference-hall/2.webp')}}" class="w-100" alt="">
                          </div>
                          </div>
                          <!-- room end -->
                          
                          <!-- room begin -->
                          <div class="item">
                              <div class="hover relative text-light">
                              <img src="{{asset('images/banquet-conference-hall/5.webp')}}" class="w-100" alt="">
                              </div>
                          </div>
                          <!-- room end -->

                          <!-- room begin -->
                          <div class="item">
                              
                              <div class="hover relative text-light">
                                <img src="{{asset('images/banquet-conference-hall/6.webp')}}" class="w-100" alt="">
                            </div>
                          </div>
                          <!-- room end -->
                      </div>
                  </div>
              </div>

              <div class="spacer-double"></div>

            
          </section>

            {{-- More rooms starts --}}
    <section class="relative bg-light pt80">
        <div class="container-fluid relative z-2">
            <div class="row g-4">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="subtitle id-color wow fadeInUp mb-3">Discover</div>
                    <h2 class="mb-0 wow fadeInUp">More Rooms</h2>
                </div>
                
                <div class="col-lg-12">
                    <div class="owl-custom-nav menu-float px-5" data-target="#more-rooms">
                        <a class="btn-next"></a>
                        <a class="btn-prev"></a>                                

                        <div id="more-rooms" class="owl-3-cols owl-carousel owl-theme">
                        <x-superstudio></x-superstudio>  
                      <x-exclusive></x-exclusive>
                    <x-classic></x-classic>   
                    <x-premier></x-premier>
                    <x-luxury></x-luxury>
                    <x-family></x-family>
                    <x-ambassador></x-ambassador>
                    <x-presidential></x-presidential>
                    <x-apartment></x-apartment>
                  </div>

                            

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    {{-- More rooms ends --}}
          
      </div>
      <!-- content close -->
    </x-slot>

</x-head>