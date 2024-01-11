<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shulesoft</title>

  <!-- font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

  <!-- Bootstrap-5 -->
  <link rel="stylesheet" href=" {{ url('public/dodoma/css/bootstrap.min.css')}}" />

  <!-- custom-styles -->
  <link rel="stylesheet" href="{{ url('public/dodoma/css/style.css') }}" />
  <link rel="stylesheet" href="{{ url('public/dodoma/css/responsive.css') }}" />
  <link rel="stylesheet" href="{{ url('public/dodoma/css/animation.css')}}" />

  <!-- color sceme -->
  <link rel="stylesheet" href=" {{ url('public/dodoma/css/colorvariants/default.css')}}" id="defaultscheme" />
</head>

<body>
  <main>
    <div class="inner">
      <header>
        <div class="logo">
          <div class="logo-text">
            <span style="color: #1db899">Shule</span>soft
          </div>
        </div>
        <div class="bar-end">
          <h3>Welcome {{Auth::user()->name }}</h3>
        </div>
      </header>
      <div class="container">
        <div class="wrapper">
          <style>
            label.error {
              color: #ff4444;
              font-size: 14px;
            }

          </style>
          <!-- form -->
          <form action="" id="steps" class="show-section" method="post">

            <!-- step2 -->
            <section class="steps">
              <article>
                <div class="main-heading">Shulesoft Data Collection Form</div>
                <div class="main-text">
                  Please provide the correct user details
                </div>
              </article>

              <!-- step-2 form -->
              <div id="step2" class="form-inner">
                <div class="steps-inner lightSpeedIn">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="input-field">
                        <label> Contact Person Name </label>
                        <input required type="text" name="name" class="name" placeholder="Enter Full Name" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="input-field">
                        <label for="phone"> Phone Number </label>

                        <input type="text" required name="phone" class="phone" placeholder="Example: 07xx xxx xxx" maxlength="10" minlength="10" />
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="input-field">
                        <label> School Name </label>
                        <input required type="text" name="school_name" class="school_name" placeholder="Enter School Name" />
                      </div>
                    </div>
                    <h5>School Address</h5>
                    <div class="col-md-4">
                      <div class="input-field select-field">
                        <label for="regions"> Region </label>
                        <input type="text" name="region" required id="region">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-field select-field">
                        <label for="ward"> District </label>
                        <input type="text" name="district" required id="district">

                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-field select-field">
                        <label for="ward"> Ward </label>
                        <input type="text" name="ward" required id="ward">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="radio-box">
                        <label> Range of Average Number of Students </label>
                        <div class="radio-single">
                          <input type="radio" name="student_number" value="< 200" checked />
                          <span>
                            < 200</span>
                        </div>
                        <div class="radio-single">
                          <input type="radio" name="student_number" value="201-400" />
                          <span> 201 - 400</span>
                        </div>
                        <div class="radio-single">
                          <input type="radio" name="student_number" value="401-1000" />
                          <span>401 - 1000</span>
                        </div>
                        <div class="radio-single">
                          <input type="radio" name="student_number" value="1000+" />
                          <span>1000+</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="next-prev">
                    <button id="sub" type="submit" class="apply btn-success">
                      Send Form<i class="fa-solid fa-arrow-right"></i>
                    </button>
                  </div>
                </div>
              </div>
            </section>
            <?= csrf_field() ?>
          </form>
        </div>
      </div>
    </div>
  </main>

  <div id="error"></div>

  <!-- Bootstrap-5 -->
  <script src="{{ url('public/dodoma/js/bootstrap.min.js') }}"></script>

  <!-- Jquery -->
  <script src="{{ url('public/dodoma/js/jquery-3.6.1.min.js') }}"></script>

  <!-- My js -->
  <script src="{{ url('public/dodoma/js/custom.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</body>

</html>