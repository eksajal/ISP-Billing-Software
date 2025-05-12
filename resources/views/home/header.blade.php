<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
  <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
          <span></span>
          <span></span>
          <span></span>
      </div>
  </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <nav class="main-nav">
                  <!-- ***** Logo Start ***** -->
                  <a href="{{ url('/') }}" class="logo">
                      <img src="assets/images/logo.png" alt="Chain App Dev">
                  </a>
                  <!-- ***** Logo End ***** -->
                  <!-- ***** Menu Start ***** -->
                  <ul class="nav">
                      <li class="scroll-to-section"><a href="{{ url('/') }}" class="active">Home</a></li>
                      <li class="scroll-to-section"><a href="#services">Services</a></li>
                      <li class="scroll-to-section"><a href="#about">About</a></li>
                      <li class="scroll-to-section"><a href="#pricing">Pricing</a></li>
                   
                      @if (Route::has('login'))
                      <li class="user-links">
                          @auth
                          <form method="POST" action="{{ route('logout') }}" id="logout-form">
                              @csrf
                              <div class="gradient-button">
                                  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                      <i class="fa fa-sign-out-alt"></i> Logout
                                  </a>
                              </div>
                          </form>
                          @else
                          <div class="gradient-button">
                              <a id="modal_trigger" href="{{ route('login') }}">
                                  <i class="fa fa-sign-in-alt"></i> Login
                              </a>
                          </div>

                          @if (Route::has('register'))
                          <div class="gradient-button">
                              <a id="modal_trigger" href="{{ route('register') }}">
                                  <i class="fa fa-user-plus"></i> Register
                              </a>
                          </div>
                          @endif
                          @endauth

                          <!-- Pay Bill Button -->
                          <div class="gradient-button">
                              <a id="modal_trigger" href="{{ url('payment_page') }}">
                                  <i class="fa fa-money-bill-wave"></i> Pay Bill
                              </a>
                          </div>
                      </li>
                      @endif

                  </ul>        
                  <a class='menu-trigger'>
                      <span>Menu</span>
                  </a>
                  <!-- ***** Menu End ***** -->
              </nav>
          </div>
      </div>
  </div>
</header>
<!-- ***** Header Area End ***** -->

<!-- CSS for Button Alignment Fix -->
<style>
  @media (max-width: 768px) {
      .user-links {
          display: flex;
          flex-direction: column; /* Stack buttons vertically */
          gap: 10px;
          align-items: flex-start;
          justify-content: flex-start;
          width: 100%;
      }

      .gradient-button {
          width: 100%; /* Make each button take full width */
      }

      .gradient-button a {
          display: flex;
          align-items: center;
          justify-content: center; /* Center the text and icon */
          gap: 5px;
          width: 100%; /* Ensure buttons are full width */
          text-align: center; /* Center the text inside */
      }

      .gradient-button a i {
          margin-right: 5px; /* Optional: adds space between icon and text */
      }
  }

  @media (min-width: 769px) {
      /* For larger screens, keep the buttons on the same row */
      .user-links {
          display: flex;
          gap: 10px;
          align-items: center;
          justify-content: flex-start;
      }

      .gradient-button a {
          display: inline-flex;
          align-items: center;
          gap: 5px;
      }
  }
</style>
