<nav class="navbar header-navbar pcoded-header" style="background-color: #2C3E50;color:white">
                <div class="navbar-wrapper">
                    <div class="navbar-logo" style="background-color: #2C3E50;">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                        <i class="icofont icofont-navigation-menu"></i>
                            
                        </a> 
                        <?php
                            if (strlen(request('token')) < 4) {
                                ?>
                        <a class="main-search morphsearch-search  d-lg-none d-md-none" style="padding:70px" href="#!" style="color: white">
                                        <i class="feather icon-search"></i>
                                    </a>
                                    <?php } ?>
                        <a href="#">
                            <img width="50" height="50" src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="ShuleSoft"  >
                        </a> 
                       
                    </div>

                    <div class="navbar-container container-fluid mobile-menu">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                     <div class="input-group">

                                    </div>  
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen" style="color: white"></i>
                                </a>
                            </li>

                              <?php
                            if (strlen(request('token')) < 4) {
                                ?>
                                  <li>
                                    <a class="main-search morphsearch-search" href="#!" style="color: white">
                                        <i class="feather icon-search"></i>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                        <ul class="nav-right">
                            {{-- <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="feather icon-bell text-light"></i>
                                        <span class="badge bg-c-pink">5</span>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <h6>Notifications</h6>
                                            <label class="label label-danger">New</label>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <img class="d-flex align-self-center img-radius" src="..\files\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">John Doe</h5>
                                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="notification-time">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                    
                                    </ul>
                                </div>
                            </li> --}}
                          
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <?php $id = Auth::user()->id;
                                        $path = \collect(DB::select("select f.path from admin.users a join admin.company_files f on a.company_file_id=f.id where a.id = '$id'"))->first(); 
                                        $local = $root . 'assets/images/user.png';
                                        ?>
                                        <img class="img-20 img-circle" src="<?= isset($path->path) && ($path->path != '')  ? $path->path : $local ?>" alt="User-Profile-Image" width="50" height="30"> 
                                        <span class="text-light" style="color: white"><?= \Auth::user()->name ?></span>
                                        <i class="feather icon-chevron-down text-light"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        
                                    <li>
                                        <a href="<?= url('users/show/' . Auth::user()->id) ?>">
                                            <i class="feather icon-user"></i> Profile
                                        </a>
                                    </li> 

                                    <li>
                                        <a href="<?= url('users/password/') ?>">
                                            <i class="feather icon-user"></i> Change Password
                                        </a>
                                    </li> 
                                      
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"><i class="feather icon-log-out"></i> Logout</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                        </form>
                                    </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
 
                        <script>
                            search_inputs = function () {
                                $('#search_inputs').keyup(function () {
                                    var val = $(this).val();
                                    $.ajax({
                                        type: "post",
                                        headers: {
                                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "<?= url('analyse/search') ?>",
                                        data: "q=" + val,
                                        dataType: 'JSON',
                                        success: function (data) {
                                            console.log(data);
                                            $('#search_people').html(data.people);
                                            $('#search_schools').html(data.schools);
                                            $('#search_activities').html(data.activities);
                                        }
                                    });
                                })
                            }
                            $(document).ready(search_inputs);
                        </script>
                         <div id="morphsearch" class="morphsearch">
                            <form class="morphsearch-form">
                                <input class="morphsearch-input" id="search_inputs" type="search" placeholder="Search..." />
                                <button class="morphsearch-submit" type="submit">Search</button>
                            </form>
                            <div class="morphsearch-content">
                                <div class="dummy-column">
                                    <h2>Invoices</h2>
                                    <span id="search_people"></span>
                                </div>
                                <div class="dummy-column" style="overflow-y: scroll;">
                                    <h2>Schools</h2>
                                    <span id="search_schools"></span>
                                </div>
                                <div class="dummy-column">
                                    <h2>Activity</h2>
                                    <span id="search_activities"></span>
                                </div>
                            </div>
                            <span class="morphsearch-close"><i class="icofont icofont-search-alt-1"></i></span>
                        </div>  
                    </div>
                </div>
            </nav>