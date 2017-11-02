<div class="navbar-default sidebar" role="navigation">
    <div class="" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="sidebar-nav slimscrollsidebar active" style="overflow: hidden; width: auto; height: 100%;">
            <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
            <div class="user-profile">
                <div class="dropdown user-pro-body">
                    <div><img src="<?= $root ?>plugins/images/users/varun.jpg" alt="user-img" class="img-circle"></div>
                    <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Steave Gection <span class="caret"></span></a>
                    <ul class="dropdown-menu animated flipInY">
                        <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                        <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                        <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            <ul class="nav in" id="side-menu">


                <li class="active"> <a href="#" class="waves-effect active"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level collapse in">
                        <li> <a href="<?= url('/home') ?>" class="active"><i class=" fa-fw">1</i><span class="hide-menu">Users Summary</span></a> </li>
                        @role('admin') <li> <a href="<?= url('logsummary') ?>"><i class=" fa-fw">2</i><span class="hide-menu">Login Summary</span></a> </li>

                        <li> <a href="<?= url('logs') ?>"><i class=" fa-fw">3</i><span class="hide-menu">Error Logs</span></a> </li>
                        @endrole
                    </ul>
                </li>
                <li>
                    @role('admin')
                    <a href="#" class="waves-effect">

                        <i class="mdi mdi-format-color-fill fa-fw"></i>
                        <span class="hide-menu">Database<span class="fa arrow"></span> 
                            <span class="label label-rouded label-info pull-right">20</span>
                        </span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="<?= url('database/compareTable') ?>"><i data-icon="" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Compare Tables</span></a></li>
                        <li><a href="<?= url('database/compareColumn') ?>"><i data-icon="" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Compare Columns</span></a></li>
                        <li><a href="<?= url('database/upgrade') ?>"><i class="ti-layout-menu fa-fw"></i> <span class="hide-menu">Create Upgrade</span></a></li>
                        <li><a href="sweatalert.html"><i class="ti-alert fa-fw"></i> <span class="hide-menu">Sweat alert</span></a></li>
                        <li><a href="typography.html"><i data-icon="k" class="linea-icon linea-software fa-fw"></i> <span class="hide-menu">Typography</span></a></li>
                        <li><a href="grid.html"><i data-icon="" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Grid</span></a></li>
                        <li><a href="tabs.html"><i class="ti-layers fa-fw"></i> <span class="hide-menu">Tabs</span></a></li>
                        <li><a href="tab-stylish.html"><i class=" ti-layers-alt fa-fw"></i> <span class="hide-menu">Stylish Tabs</span></a></li>
                        <li><a href="modals.html"><i data-icon="" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Modals</span></a></li>
                        <li><a href="progressbars.html"><i class="ti-line-double fa-fw"></i> <span class="hide-menu">Progress Bars</span></a></li>
                        <li><a href="notification.html"><i class="ti-info-alt fa-fw"></i> <span class="hide-menu">Notifications</span></a></li>
                        <li><a href="carousel.html"><i class="ti-layout-slider fa-fw"></i> <span class="hide-menu">Carousel</span></a></li>
                        <li><a href="list-style.html"><i data-icon="" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">List &amp; Media object</span></a></li>
                        <li><a href="user-cards.html"><i class="ti-user fa-fw"></i> <span class="hide-menu">User Cards</span></a></li>
                        <li><a href="timeline.html"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Timeline</span></a></li>
                        <li><a href="timeline-horizontal.html"><i class="ti-layout-list-thumb fa-fw"></i> <span class="hide-menu">Horizontal Timeline</span></a></li>
                        <li><a href="nestable.html"><i class="ti-layout-accordion-separated fa-fw"></i> <span class="hide-menu">Nesteble</span></a></li>
                        <li><a href="range-slider.html"><i class=" ti-layout-slider-alt fa-fw"></i> <span class="hide-menu">Range Slider</span></a></li>
                        <li><a href="tooltip-stylish.html"><i class="ti-comments-smiley fa-fw"></i> <span class="hide-menu">Stylish Tooltip</span></a></li>
                        <li><a href="bootstrap.html"><i class="ti-rocket fa-fw"></i> <span class="hide-menu">Bootstrap UI</span></a></li>
                    </ul>
                </li>
                @endrole
                <li> 
                    <a href="#" class="waves-effect"><i class="mdi mdi-content-copy fa-fw"></i> <span class="hide-menu">Message(s)<span class="fa arrow"></span><span class="label label-rouded label-warning pull-right">30</span></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?= url('message/create') ?>"><i class="ti-layout-width-default fa-fw"></i> <span class="hide-menu">Send Message</span></a></li>
                        <li><a href="<?= url('message/show/email') ?>"><i class="ti-email fa-fw"></i> <span class="hide-menu">Pending Emails</span></a></li>
                        <li><a href="<?= url('message/show/sms') ?>"><i class="ti-envelope fa-fw"></i> <span class="hide-menu">Pending SMS</span></a></li>
                 
                 
                        <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-info-alt fa-fw"></i><span class="hide-menu">Error Pages</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li><a href="400.html"><i class="ti-info-alt fa-fw"></i> <span class="hide-menu">Error 400</span></a></li>
                                <li><a href="403.html"><i class="ti-info-alt fa-fw"></i> <span class="hide-menu">Error 403</span></a></li>
                                <li><a href="404.html"><i class="ti-info-alt fa-fw"></i> <span class="hide-menu">Error 404</span></a></li>
                                <li><a href="500.html"><i class="ti-info-alt fa-fw"></i> <span class="hide-menu">Error 500</span></a></li>
                                <li><a href="503.html"><i class="ti-info-alt fa-fw"></i> <span class="hide-menu">Error 503</span></a></li>
                            </ul>
                        </li>
                        <li><a href="lightbox.html"><i class="fa-fw">L</i> <span class="hide-menu">Lightbox Popup</span></a></li>
                        <li><a href="treeview.html"><i class="fa-fw">T</i> <span class="hide-menu">Treeview</span></a></li>
                        <li><a href="search-result.html"><i class="fa-fw">S</i> <span class="hide-menu">Search Result</span></a></li>
                        <li><a href="utility-classes.html"><i class="fa-fw">U</i> <span class="hide-menu">Utility Classes</span></a></li>
                        <li><a href="custom-scroll.html"><i class="fa-fw">C</i> <span class="hide-menu">Custom Scrolls</span></a></li>
                        <li><a href="animation.html"><i class="fa-fw">A</i> <span class="hide-menu">Animations</span></a></li>
                        <li><a href="profile.html"><i class="fa-fw">P</i> <span class="hide-menu">Profile</span></a></li>
                        <li><a href="invoice.html"><i class="fa-fw">I</i> <span class="hide-menu">Invoice</span></a></li>
                        <li><a href="faq.html"><i class="fa-fw">F</i> <span class="hide-menu">FAQ</span></a></li>
                        <li><a href="gallery.html"><i class="fa-fw">G</i> <span class="hide-menu">Gallery</span></a></li>
                        <li><a href="pricing.html"><i class="fa-fw">P</i> <span class="hide-menu">Pricing</span></a></li>
                    </ul>
                </li>


                <!-- Payment navigations --->
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
                        <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-desktop fa-fw"></i><span class="hide-menu">Inbox</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li> <a href="inbox.html"><i class="ti-email fa-fw"></i><span class="hide-menu">Mail box</span></a></li>
                                <li> <a href="inbox-detail.html"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Inbox detail</span></a></li>
                                <li> <a href="compose.html"><i class="ti-layout-media-center-alt fa-fw"></i><span class="hide-menu">Compose mail</span></a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu">Contacts</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li> <a href="contact.html"><i class="icon-people fa-fw"></i><span class="hide-menu">Contact1</span></a></li>
                                <li> <a href="contact2.html"><i class="icon-user-follow fa-fw"></i><span class="hide-menu">Contact2</span></a></li>
                                <li> <a href="contact-detail.html"><i class="icon-user-following fa-fw"></i><span class="hide-menu">Contact Detail</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>




                <li><a href="inbox.html" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">Apps<span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="chat.html"><i class="ti-comments-smiley fa-fw"></i><span class="hide-menu">Chat-message</span></a></li>
                        <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-desktop fa-fw"></i><span class="hide-menu">Inbox</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li> <a href="inbox.html"><i class="ti-email fa-fw"></i><span class="hide-menu">Mail box</span></a></li>
                                <li> <a href="inbox-detail.html"><i class="ti-layout-media-left-alt fa-fw"></i><span class="hide-menu">Inbox detail</span></a></li>
                                <li> <a href="compose.html"><i class="ti-layout-media-center-alt fa-fw"></i><span class="hide-menu">Compose mail</span></a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu">Contacts</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li> <a href="contact.html"><i class="icon-people fa-fw"></i><span class="hide-menu">Contact1</span></a></li>
                                <li> <a href="contact2.html"><i class="icon-user-follow fa-fw"></i><span class="hide-menu">Contact2</span></a></li>
                                <li> <a href="contact-detail.html"><i class="icon-user-following fa-fw"></i><span class="hide-menu">Contact Detail</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                
                <li> <a href="#" class="waves-effect"><i class="mdi mdi-emoticon fa-fw"></i> <span class="hide-menu">Resources<span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li> <a href="<?= url('market/material') ?>"><i class="fa-fw">F</i>
                                <span class="hide-menu">Sales Materials</span></a> </li>
                        <li> <a href="<?= url('market/legal') ?>">
                                <i class="fa-fw">T</i>
                                <span class="hide-menu">Legal Documents </span></a> </li>
                        <li> 
                            <a href="<?= url('market/brand') ?>"><i class="fa-fw">S</i>
                                <span class="hide-menu">Personal Brands</span></a>
                        </li>
          
                    </ul>
                </li>
                <li> <a href="#" class="waves-effect"><i class="mdi mdi-emoticon fa-fw"></i> <span class="hide-menu">Training<span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li> <a href="<?= url('market/allocation') ?>"><i class="fa-fw">F</i>
                                <span class="hide-menu">Market Allocations</span></a> </li>
                        <li> <a href="<?= url('market/objective') ?>"><i class="fa-fw">T</i>
                                <span class="hide-menu">Values & Objectives</span></a> </li>
                        <li> <a href="<?= url('market/training') ?>"><i class="fa-fw">S</i>
                                <span class="hide-menu">How it works</span></a> </li>
                        <li> <a href="<?= url('market/presentation') ?>">
                                <i class="fa-fw">M</i><span class="hide-menu">Sample Presentations</span></a> </li>
                        <li><a href="<?= url('market/faq') ?>"><i class="fa-fw">L</i>
                                <span class="hide-menu">FAQ</span></a></li>
                        <li><a href="<?= url('market/test') ?>"><i class="fa-fw">W</i><span class="hide-menu">
                                    Knowledge Test</span></a></li>
                    </ul>
                </li>
                <li class="devider"></li>
 
            </ul>
        </div><div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.3); width: 6px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 36.7859px;"></div><div class="slimScrollRail" style="width: 6px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
</div>