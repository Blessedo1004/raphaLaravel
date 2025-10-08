<x-head title="Rapha Hotel — Contact Us" metaDescription="Contact Us">
  <x-slot name="body">
              <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <section id="subheader" class="relative jarallax text-light">
                <img src="images/background/3.webp" class="jarallax-img" alt="">
                <div class="container relative z-index-1000">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h1>Contact Us</h1>
                            <p class="lead mt-3">
                                Have a question or need assistance with your booking? Our dedicated team is available around the clock to provide you with prompt and friendly service.
                            </p>
                            <ul class="crumb">
                                <li><a href="{{ route('rapha.home') }}">Home</a></li>
                                <li class="active">Contact Us</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="de-overlay"></div>
            </section>

            <section class="relative">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-11 col-lg-5 form-info">
                            <h3 class="col-12 text-center">
                                <i class="icofont-location-pin"></i>
                            </h3>
                            <h5 class="text-center">Our Address</h5>
                            <div class="col-12 text-center">
                                No. 1 Rapha Avenue
                                Secretariat Road, Umuahia
                                Abia State, Nigeria.
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4 col-lg-3 mt-4 mt-lg-0 form-info offset-md-2 offset-lg-0 ms-md-3">
                            <h3 class="col-12 text-center">
                                <i class="icofont-envelope"></i>
                            </h3>
                            <h5 class="text-center">Email Us</h5>
                            <div class="col-12 text-center">
                                raphahotelltd25@gmail.com 
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3 mt-4 mt-lg-0 form-info ms-md-3">
                            <h3 class="col-12 text-center">
                                <i class="icofont-phone"></i>
                            </h3>
                            <h5 class="text-center">Contact Us</h5>
                            <div class="col-12 text-center">
                                0916 443 9220, 0904 621 0001
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 justify-content-center mt-4">               
                        <div class="col-lg-12">
                            
                            <form name="contactForm" id="contact_form" class="position-relative z1000 form-message" method="post" action="https://madebydesignesia.com/themes/almaris/contact.php">
                                <div id="contact_form_wrap" class="row gx-4">
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <h3 class="mb-4">Write a Message</h3>
                                        </div>
                                    </div>

                                    
                                        <div class="field-set col-12">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required>
                                        </div>

                                        <div class="field-set col-12 col-md-6">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Your Email" required>
                                        </div>

                                        <div class="field-set  col-12 col-md-6">
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Your Phone Number" required>
                                        </div>
                                   
                                    
                                    <div class="col-12">
                                        <div class="field-set mb20">
                                            <textarea name="message" id="message" class="form-control" placeholder="Your Message" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <input type='submit' id='send_message' value='Send Message' class="btn-main">
                                        </div>
                                    </div>
                                </div>
                                

                                <div id="success_message" class='success'>
                                    Your message has been sent successfully. Refresh this page if you want to send more messages.
                                </div>
                                <div id="error_message" class='error'>
                                    Sorry there was an error sending your form.
                                </div>
                            </form>

                        </div>
                        
                    </div>
                </div>
            </section>            

        </div>
        <!-- content close -->
  </x-slot>
</x-head>