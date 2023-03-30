<!DOCTYPE html>
<?php $root = url('/') . '/public/' ?>

<html lang="en-us" class="no-js">

	<head>
		<meta charset="utf-8">
        <title>ShuleSoft</title>
        <meta name="description" content="Comming soon page - flat able">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Codedthemes">
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?=$root?>comming\img\default.png">
        <link rel="stylesheet" href="<?=$root?>comming\css\style-minimal-flat.css">
		<script src="<?=$root?>comming\js\modernizr.custom.js"></script>
	</head>

    <body>

    	<!-- Loading overlay -->
		<!-- <div id="loading" class="dark-back">
			<div class="loading-bar"></div>
			<span class="loading-text opacity-0">So Excited ?</span>
		</div> -->

		<!-- Canvas for particles animation -->
		<div id="particles-js"></div>

    
    	<!-- END - Informations bar on top of the screen -->

        <!-- Slider Wrapper -->
        <div id="slider" class="sl-slider-wrapper">

			<div class="sl-slider">
			
				<!-- SLIDE 1 / Home -->
				<div class="sl-slide bg-1" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
					
					<div class="sl-slide-inner">

						<div class="content-slide">

							<div class="container">

								<img src="<?=$root?>comming\img\default.png" alt="" class="brand-logo text-intro opacity-0">
							
								<h2 class="text-intro opacity-0">WE WILL BE BACK SOON</h2>
							
								<p class="text-intro opacity-0"><strong>This Page is not available right now.</strong>
                                <br> This is because of technical issue we  are working to get fixed.
								</p>

								<a data-dialog="somedialog" class="text-intro opacity-0"></a>

							</div>
						</div>
					</div>
				</div>
				<!-- END - SLIDE 1 / Home -->

			</div>
			<!-- END - sl-slider -->

			

		</div>
		<!-- END - Slider Wrapper -->

        <!-- Newsletter Popup -->
		<div id="somedialog" class="dialog">

			<div class="dialog__overlay"></div>
					
			<!-- dialog__content -->
			<div class="dialog__content">

				<div class="header-picture"></div>
						
				<!-- dialog-inner -->
				<div class="dialog-inner">
							
					<h4>Notify Popup Highlight</h4>
							
					<p>Just write the pefect description for your launch product here.... <strong>Codedthemes Product launch in next XX weeks. Enjoy !!!</strong></p>

					<!-- Newsletter Form -->
					<div id="subscribe">

		                <form action="php/notify-me.php" id="notifyMe" method="POST">

		                    <div class="form-group">

		                        <div class="controls">
		                            
		                        	<!-- Field  -->
		                        	<input type="text" id="mail-sub" name="email" placeholder="Click here to write your email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address'" class="form-control email srequiredField">

		                        	<!-- Spinner top left during the submission -->
		                        	<i class="fa fa-spinner opacity-0"></i>

		                            <!-- Button -->
		                            <button class="btn btn-lg submit">Submit</button>

		                            <div class="clear"></div>

		                        </div>

		                    </div>

		                </form>

						<!-- Answer for the newsletter form is displayed in the next div, do not remove it. -->
						<div class="block-message">

							<div class="message">

								<p class="notify-valid">

							</div>

						</div>
						<!-- END - Answer for the newsletter form is displayed in the next div, do not remove it. -->

        			</div>
        			<!-- END - Newsletter Form -->
				</div>
				<!-- END - dialog-inner -->

				<!-- Cross for closing the Newsletter Popup -->
				<button class="close-newsletter" data-dialog-close=""><i class="icon ion-android-close"></i></button>

			</div>
			<!-- END - dialog__content -->
						
		</div>
		<!-- END - Newsletter Popup -->

		<!-- //////////////////////\\\\\\\\\\\\\\\\\\\\\\ -->
	    <!-- ********** List of jQuery Plugins ********** -->
	    <!-- \\\\\\\\\\\\\\\\\\\\\\////////////////////// -->
		
		<!-- * Libraries jQuery, Easing and Bootstrap - Be careful to not remove them * -->
		<script src="<?=$root?>comming\js\jquery.min.js"></script>
		<script src="<?=$root?>comming\js\jquery.easings.min.js"></script>
		<script src="<?=$root?>comming\js\bootstrap.min.js"></script>

		<!-- SlitSlider plugin -->
		<script src="<?=$root?>comming\js\jquery.ba-cond.min.js"></script>
		<script src="<?=$root?>comming\js\jquery.slitslider.js"></script>

		<!-- Newsletter plugin -->
		<script src="<?=$root?>comming\js\notifyMe.js"></script>

		<!-- Popup Newsletter Form -->
		<script src="<?=$root?>comming\js\classie.js"></script>
		<script src="<?=$root?>comming\js\dialogFx.js"></script>

		<!-- Particles effect plugin on the right -->
		<script src="<?=$root?>comming\js\particles.js"></script>

		<!-- Custom Scrollbar plugin -->
		<script src="<?=$root?>comming\js\jquery.mCustomScrollbar.js"></script>

		<!-- Countdown plugin -->
		<script src="<?=$root?>comming\js\jquery.countdown.js"></script>

		<script>
		$("#countdown")
			// Year/Month/Day Hour:Minute:Second
			.countdown("2018/10/24 15:30:30", function(event) {
				$(this).html(
					event.strftime('%D Days %Hh %Mm %Ss')
				);
		});
		</script>

		<!-- Main application scripts -->
		<script src="<?=$root?>comming\js\main-flat.js"></script>

	</body>

</html>