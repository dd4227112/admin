<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="Francis" content="Kichenje" />
    <title></title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="{{ url('public/dodoma/css/bootstrap.min.css ')}}" />

    <!-- custom-styles -->
    <link rel="stylesheet" href="{{ url('public/dodoma/css/thank.css ')}}" />
    <!-- GOOGLE WEB FONT -->
    <link
      href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600"
      rel="stylesheet"
    />

    <script type="text/javascript">
      function delayedRedirect() {
        window.location = "<?=base_url('Customer/collectData')?>";
      }
    </script>
  </head>
  <body
    onLoad="setTimeout('delayedRedirect()', 1600)"
    style="background-color: #fff">
    <div class="success-page">
      <div class="icon icon--order-success svg">
        <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
          <g fill="none" stroke="#1db899" stroke-width="2">
            <circle
              cx="36"
              cy="36"
              r="35"
              style="stroke-dasharray: 240px, 240px; stroke-dashoffset: 480px"
            ></circle>
            <path
              d="M17.417,37.778l9.93,9.909l25.444-25.393"
              style="stroke-dasharray: 50px, 50px; stroke-dashoffset: 0px"
            ></path>
          </g>
        </svg>
      </div>
      <h4><span>Request successfully sent!</span></h4>
      <small>You will be redirect back in 1 seconds.</small>
    </div>
  </body>
</html>
