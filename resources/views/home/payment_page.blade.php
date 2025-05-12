<!DOCTYPE html>
<html lang="en">

<head>

    @include('home.css')

</head>

<body>

    @include('home.header')

  

    <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6 align-self-center">
                  <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                    <div class="row">
                      <div class="col-lg-12">
                        <h2>Pay Your Bill</h2>
                      </div>
      
                      <!-- FORM START -->
                      <div class="col-lg-12">
                        <form action="{{ route('check_bill_form') }}" method="POST" style="margin-top: 15px;">
                          @csrf
                          <div class="input-group mb-3" style="max-width: 400px;">
                            <input type="text" name="user_id" class="form-control" placeholder="Enter your User ID" required>
                            <button class="btn btn-primary" type="submit">Check Bill</button>
                          </div>
                        </form>
                        
                      </div>
                      <!-- FORM END -->
      
                   
                    </div>
                  </div>
                </div>
      
                <!-- Right image removed -->
                <!-- <div class="col-lg-6">
                  <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                    <img src="assets/images/slider-dec.png" alt="">
                  </div>
                </div> -->
      
              </div>
            </div>
          </div>
        </div>
      </div>
      
  

    @include('home.footer')

    @include('home.script')


</body>

</html>
