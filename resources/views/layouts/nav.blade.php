<div class="navbar-default sidebar" role="navigation">
    <div class=""><div class="sidebar-nav slimscrollsidebar active" style="overflow: hidden; width: auto; height: 100%;">
            <div class="sidebar-head" >
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
            <div class="user-profile">
                <div class="dropdown user-pro-body">
                    <div><img src="<?= $root ?>plugins/images/users/varun.jpg" alt="user-img" class="img-circle"></div>
                    <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> {{ Auth::user()->name() }}<span class="caret"></span></a>
                    <ul class="dropdown-menu animated flipInY">
                        <li><a href="{{url('users/'.Auth::user()->id)}}"><i class="ti-user"></i> My Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
            </div>
            <ul class="nav in" id="side-menu">

                <li class="active"> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level">
                        <?php if (can_access('view_users')) { ?>
                            <li> 
                                <a href="<?= url('/home') ?>" class="">
                                    <i class=" fa-fw">1</i><span class="hide-menu">Users Summary</span></a> 
                            </li> 
                        <?php } ?>
                        <?php if (can_access('view_users')) { ?>
                            <li> 
                                <a href="<?= url('web/logsummary') ?>">
                                    <i class=" fa-fw">2</i><span class="hide-menu">Login Summary</span></a>
                            </li>
                        <?php } ?>
                        <?php if (can_access('view_logs')) { ?>
                            <li> 
                                <a href="<?= url('web/logs') ?>">
                                    <i class=" fa-fw">3</i><span class="hide-menu">Error Logs</span></a>
                            </li>
                        <?php } ?>
                        <?php if (can_access('view_invoices')) { ?>
                            <li> <a href="<?= url('/home/invoice') ?>">
                                    <i class=" fa-fw">1</i><span class="hide-menu">Invoice Summary</span></a> </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if (can_access('view_invoices')) { ?>
                <!--                    <li class="active"> <a href="#" class="waves-effect"><i class="fa fa-money fa-fw" data-icon="v"></i> <span class="hide-menu">Invoices <span class="fa arrow"></span> </span></a>
                                        <ul class="nav nav-second-level ">
                                            <li> <a href="{{ url('payment/paid') }}" class=""><i class=" fa-fw">1</i><span class="hide-menu">All Paid Invoices</span></a> </li>
                                            <li> <a href="{{ url('payment/posted') }}" class=""><i class=" fa-fw">2</i><span class="hide-menu">Posted Invoices</span></a> </li>
                                            <li> <a href="{{url('invoice/searched')}}"><i class=" fa-fw">2</i><span class="hide-menu">Searched Invoices</span></a> </li>


                                        </ul>
                                    </li>-->
                <?php } ?>
<!--                 <li class=""> <a href="#" class="waves-effect"><i class="fa fa-users fa-fw" data-icon="v"></i> <span class="hide-menu"> User Roles <span class="fa arrow"></span> </span></a>
    <ul class="nav nav-second-level ">
       
        <li> <a href="{{ url('users') }}" class=""><i class=" fa-fw">2</i><span class="hide-menu">Management Users</span></a> </li>
        <li> <a href="{{url('roles')}}"><i class=" fa-fw">3</i><span class="hide-menu">User Types</span></a> </li>
        <li> <a href="#"><i class=" fa-fw">4</i><span class="hide-menu">Permissions</span></a> </li>

    </ul>
</li>-->
                <?php if (can_access('view_staff')) { ?>
                    <li class="">
                        <a href="#" class="waves-effect"><i class="fa fa-users fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> Staff Management <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level ">

                            <li> <a href="{{ url('users') }}" class=""><i class=" fa-fw">2</i><span class="hide-menu">Staff Users</span></a> </li>
                            <li> <a href="{{url('roles')}}"><i class=" fa-fw">3</i><span class="hide-menu">User Types</span></a> </li>
                            <li> <a href="#"><i class=" fa-fw">4</i><span class="hide-menu">Permissions</span></a> </li>

                            <li> <a href="{{url('roles/shulesoft')}}"><i class=" fa-fw">4</i><span class="hide-menu">ShuleSoft Roles</span></a> </li>

                        </ul>
                    </li>
                <?php } ?>
                <?php if (can_access('manage_schools')) { ?>
                    <li class="">
                        <a href="#" class="waves-effect"><i class="fa fa-users fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> Manage Schools <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level ">
                            <li> <a href="{{ url('management') }}" class="">
                                    <i class=" fa-fw">1</i><span class="hide-menu">School Settings</span></a> 
                            </li>
                            <li> <a href="{{ url('management/contact') }}" class="">
                                    <i class=" fa-fw">2</i><span class="hide-menu">School Contacts</span></a> 
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (can_access('manage_database')) { ?>
                    <li>
                        <a href="#" class="waves-effect">

                            <i class="mdi mdi-format-color-fill fa-fw"></i>
                            <span class="hide-menu">Database<span class="fa arrow"></span> 
                                <span class="label label-rouded label-info pull-right"></span>
                            </span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?= url('database/compareTable') ?>"><i data-icon="" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Compare Tables</span></a></li>
                            <li><a href="<?= url('database/compareColumn') ?>"><i data-icon="" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Compare Columns</span></a></li>
                            <li><a href="<?= url('database/constrains') ?>"><i data-icon="k" class="linea-icon linea-software fa-fw"></i> <span class="hide-menu">DB Constraints</span></a></li>
                            <li><a href="<?= url('database/upgrade') ?>"><i class="ti-layout-menu fa-fw"></i> <span class="hide-menu">Create Upgrade</span></a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (can_access('manage_messages')) { ?>
                    <li> 
                        <a href="#" class="waves-effect"><i class="mdi mdi-content-copy fa-fw"></i> <span class="hide-menu">Message(s)<span class="fa arrow"></span><span class="label label-rouded label-warning pull-right"></span></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="<?= url('message/create') ?>"><i class="ti-layout-width-default fa-fw"></i> <span class="hide-menu">Send Message</span></a></li>
                            <li><a href="<?= url('message/show/email') ?>"><i class="ti-email fa-fw"></i> <span class="hide-menu">Pending Emails</span></a></li>
                            <li><a href="<?= url('message/show/sms') ?>"><i class="ti-envelope fa-fw"></i> <span class="hide-menu">Pending SMS</span></a></li>
                            <li><a href="<?= url('message/shulesoft') ?>"><i class="ti-envelope fa-fw"></i> <span class="hide-menu">ShuleSoft Updates</span></a></li>
                            <li><a href="<?= url('message/feedback') ?>"><i class="ti-comments-smiley fa-fw"></i> <span class="hide-menu">User Feedbacks</span></a></li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Payment navigations --->
                <?php if (can_access('manage_payments')) { ?>
                    <li>
                        <a href="inbox.html" class="waves-effect">
                            <i class="mdi mdi-apps fa-fw"></i> 
                            <span class="hide-menu">Online Payment<span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?= url('api/request') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Api Request</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= url('api/payment') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Payment Status</span>
                                </a>
                            </li>
                            <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-desktop fa-fw"></i><span class="hide-menu">Invoices</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    <li> <a href="<?= url('api/invoices/1') ?>"><i class="ti-email fa-fw"></i><span class="hide-menu">Live Invoices</span></a></li>
                                    <li> <a href="<?= url('api/invoices/0') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Testing Invoices</span></a></li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (can_access('manage_sales')) { ?>
                    <li> <a href="#" class="waves-effect"><i class="mdi mdi-emoticon fa-fw"></i> <span class="hide-menu">Resources<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li> <a href="<?= url('market/material') ?>"><i class="fa-fw">F</i>
                                    <span class="hide-menu">Sales Materials</span></a> </li>
                            <li> <a href="<?= url('market/legal') ?>">
                                    <i class="fa-fw">T</i>
                                    <span class="hide-menu">Legal Documents </span></a> </li>
                            <!--                        <li> 
                                                        <a href="<?= url('market/brand') ?>"><i class="fa-fw">S</i>
                                                            <span class="hide-menu">Personal Brands</span></a>
                                                    </li>-->

                        </ul>
                    </li>
                <?php } ?>
                <?php if (can_access('manage_sales')) { ?>
                    <li> <a href="#" class="waves-effect"><i class="mdi mdi-emoticon fa-fw"></i> <span class="hide-menu">Training<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li> <a href="<?= url('market/allocation') ?>"><i class="fa-fw">F</i>
                                    <span class="hide-menu">Market Allocations</span></a> </li>
                            <li> <a href="<?= url('market/objective') ?>"><i class="fa-fw">T</i>
                                    <span class="hide-menu">How to Market</span></a> </li>
    <!--                        <li> <a href="<?= url('market/training') ?>"><i class="fa-fw">S</i>
                                    <span class="hide-menu">How it works</span></a> </li>-->
                            <li> <a href="<?= url('market/presentation') ?>">
                                    <i class="fa-fw">M</i><span class="hide-menu">Sample Presentations</span></a> </li>
                            <li><a href="<?= url('market/faq') ?>"><i class="fa-fw">L</i>
                                    <span class="hide-menu">FAQ</span></a></li>
    <!--                        <li><a href="<?= url('market/test') ?>"><i class="fa-fw">W</i><span class="hide-menu">
                                        Knowledge Test</span></a></li>-->
                        </ul>
                    </li>
                <?php } ?>
                <li> <a href="#" class="waves-effect"><i class="mdi mdi-emoticon fa-fw"></i> <span class="hide-menu">Help<span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level collapse">

                        <li><a href="<?= url('market/faq') ?>"><i class="fa-fw">Q</i>
                                <span class="hide-menu">FAQ</span></a></li>
                        <li> <a href="<?= url('market/presentation') ?>">
                                <i class="fa-fw">G</i><span class="hide-menu">Usage Guide</span></a> </li>

                    </ul>
                </li>
                <li class="devider"></li>

                <?php if (can_access('manage_exams')) { ?>
                    <li>
                        <a href="#" class="waves-effect">
                            <i class="mdi mdi-apps fa-fw"></i> 
                            <span class="hide-menu">Exams<span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?= url('exam/definition') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">definition</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= url('exam/schedule') ?>">
                                    <i class="ti-list fa-fw"></i>
                                    <span class="hide-menu">Schedule</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= url('exam/grade') ?>">
                                    <i class="ti-layers fa-fw"></i>
                                    <span class="hide-menu">Grades</span>
                                </a>
                            </li>
                            <!--                            <li>
                                                            <a href="<?= url('exam/schedule') ?>">
                                                                <i class="ti-comments-smiley fa-fw"></i>
                                                                <span class="hide-menu">Schedule</span>
                                                            </a>
                                                        </li>-->

                            <li><a href="#" class="waves-effect"><i class="ti-desktop fa-fw"></i><span class="hide-menu">Reports</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    <li> <a href="<?= url('exam/report/single') ?>"><i class="ti-book fa-fw"></i><span class="hide-menu">Single Exam</span></a></li>
                                    <!--<li> <a href="<?= url('exam/report/accumulative') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Accumulative Exams</span></a></li>-->
                                    <!--<li> <a href="<?= url('exam/insight') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Insight</span></a></li>-->
                                    <li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                <?php } ?>
                <?php if (can_access('manage_schools_records')) { ?>
                    <li>
                        <a href="inbox.html" class="waves-effect">
                            <i class="mdi mdi-apps fa-fw"></i> 
                            <span class="hide-menu">Schools<span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?= url('api/request') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= url('api/payment') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Exams</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= url('api/payment') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Books</span>
                                </a>
                            </li>
                            <li><a href="inbox5.html" class="waves-effect"><i class="ti-desktop fa-fw"></i><span class="hide-menu">Attendance</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    <li> <a href="<?= url('api/invoices/1') ?>"><i class="ti-email fa-fw"></i><span class="hide-menu">Student</span></a></li>
                                    <li> <a href="<?= url('api/invoices/0') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Teachers</span></a></li>
                                    <li> <a href="<?= url('api/invoices/0') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Staff</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a href="inbox.html" class="waves-effect">
                            <i class="mdi mdi-apps fa-fw"></i> 
                            <span class="hide-menu">Accounts<span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?= url('api/request') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Bank Account</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= url('api/payment') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Fees Definitions</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"> <i class="ti-comments-smiley fa-fw"></i><span>Fee Priority</span></a>                                                    </li>
                            <li>
                                <a href="#"> <i class="ti-comments-smiley fa-fw"></i><span>Due amount</span></a>

                            </li>

                            <li><a href="inbox5.html" class="waves-effect"><i class="ti-desktop fa-fw"></i><span class="hide-menu">Fees</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    <li> <a href="<?= url('api/invoices/1') ?>"><i class="ti-email fa-fw"></i><span class="hide-menu">Installment</span></a></li>
                                    <li> <a href="<?= url('api/invoices/0') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Fee details</span></a></li>
                                    <li> <a href="<?= url('api/invoices/0') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Fee Discount</span></a></li>
                                    <li>
                                        <a href="http://localhost/shule/fee/exclude_fee"><i class="fa icon-feetype"></i><span>Unsubscribe student</span></a> 
                                </ul>
                            </li>
                            <li>
                                <a href="<?= url('api/payment') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Invoices</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= url('api/payment') ?>">
                                    <i class="ti-comments-smiley fa-fw"></i>
                                    <span class="hide-menu">Collections</span>
                                </a>
                            </li>
                            <li><a href="inbox5.html" class="waves-effect"><i class="ti-desktop fa-fw"></i><span class="hide-menu">Account Reports</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    <li> <a href="<?= url('api/invoices/1') ?>"><i class="ti-email fa-fw"></i><span class="hide-menu">Summary</span></a></li>
                                    <li> <a href="<?= url('api/invoices/1') ?>"><i class="ti-email fa-fw"></i><span class="hide-menu">Transactions</span></a></li>
                                    <li> <a href="<?= url('api/invoices/0') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Income Statements</span></a></li>
                                    <li> <a href="<?= url('api/invoices/0') ?>"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Balance Sheet</span></a></li>
                                    <li>
                                        <a href="http://localhost/shule/fee/exclude_fee"><i class="fa icon-feetype"></i><span>Cash Flow</span></a> 
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

            </ul>

            </ul>
        </div><div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.3); width: 6px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 36.7859px;"></div><div class="slimScrollRail" style="width: 6px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
</div>