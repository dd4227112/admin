<div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar" >
                        <div class="pcoded-inner-navbar main-menu" style="background-color: #2C3E50;">
                            <div class="pcoded-navigatio-lavel">menu</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                  <?php if (can_access('view_dashboard')) { ?>
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="icofont icofont-ui-home"></i></span>
                                        <span class="pcoded-mtext">DASHBOARD</span>
                                    </a>
                                   <?php } ?>
                                    <ul class="pcoded-submenu">
                                        <?php if (can_access('view_home_dashboard')) { ?>
                                        <li class="active">
                                            <a href="<?= url('analyse/index') ?>">
                                                <span class="pcoded-mtext">Home</span>
                                            </a>
                                        </li>
                                        <?php } ?>

                                    <?php if (can_access('cro_dashboard')) { ?>
                                      <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-mtext text-bold">CRO</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="">
                                                <a href="<?= url('analyse/marketing') ?>">
                                                    <span class="pcoded-mtext">Marketing</span>
                                                </a>
                                                </li>
                                            
                                                <li class="">
                                                <a href="<?= url('analyse/sales') ?>">
                                                    <span class="pcoded-mtext">Sales</span>
                                                </a>
                                                </li>

                                                <li class="">
                                                <a href="<?= url('sales/salesStatus') ?>">
                                                    <span class="pcoded-mtext">customers</span>
                                                </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>


                                      <?php if (can_access('operations_dashboard')) { ?>
                                         <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Operations</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('analyse/accounts') ?>">
                                                       <span class="pcoded-mtext">Accounts</span>
                                                    </a>
                                                 </li>
                                             
                                                 <li class="">
                                                    <a href="<?= url('#') ?>">
                                                        <span class="pcoded-mtext">HR reports</span>
                                                    </a>
                                                  </li>
                                             </ul>
                                          </li>
                                        <?php } ?>
                                        
                                                            
                                         <?php if (can_access('engineering_dashboard'))  { ?>
                                          <li class=" ">
                                            <a href="<?= url('analyse/software') ?>">
                                                <span class="pcoded-mtext">Engineering</span>
                                            </a>
                                        </li>
                                        <?php } ?>
<!--                                        <li class=" ">
                                            <a href="<?= url('customer/collectData') ?>">
                                                <span class="pcoded-mtext">School Data</span>
                                            </a>
                                        </li>-->
                                    </ul>
                                </li>

                            
                              <?php if (can_access('manage_revenue')) { ?>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="icofont icofont-bank"></i></span>
                                        <span class="pcoded-mtext">REVENUE</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Sales</span>
                                            </a>
                                            <ul class="pcoded-submenu">

                                             <?php if(\Auth::user()->role_id == 15)  { ?>
                                                <li class="">
                                                <a href="<?= url('partner/index') ?>">
                                                    <span class="pcoded-mtext">Partner request</span>
                                                </a>
                                                </li>
                                                <li class="">
                                                <a href="<?= url('partner/transactions') ?>">
                                                    <span class="pcoded-mtext">School Transactions</span>
                                                </a>
                                                </li>
                                            <?php } else { ?>
                                                <li class="">
                                                    <a href="<?= url('sales/index') ?>">
                                                       <span class="pcoded-mtext">Sales materials</span>
                                                    </a>
                                                 </li>
                                             
                                                 <li class="">
                                                    <a href="<?= url('sales/schools') ?>">
                                                        <span class="pcoded-mtext">List of Schools</span>
                                                    </a>
                                                  </li>

                                                   <li class="">
                                                    <a href="<?= url('sales/schoolrequests') ?>">
                                                        <span class="pcoded-mtext">School Requests</span>
                                                    </a>
                                                  </li>


                                                <?php if (can_access('sales_plan')) { ?>
                                                <li class="">
                                                    <a href="<?= url('sales/salesStatus') ?>">
                                                       <span class="pcoded-mtext">Sales Plan</span>
                                                    </a>
                                                 </li>
                                                <?php } ?>

                                               <?php } ?>

                                            </ul>

                                        </li>


                                         <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Marketing</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <?php if (can_access('digital_marketing')) { ?>
                                                 <li class=" ">
                                                    <a href="<?= url('marketing/socialmedia') ?>">
                                                        <span class="pcoded-mtext">Digital marketing</span>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                             
                                                <?php if (can_access('event_seminar')) { ?>
                                                <li class="">
                                                  <a href="<?= url('marketing/events') ?>">
                                                        <span class="pcoded-mtext">Events and seminars</span>
                                                  </a>
                                                </li>
                                                <?php } ?>

                                                <?php if (can_access('communication')) { ?>
                                                    <li class=" pcoded-hasmenu">
                                                        <a href="javascript:void(0)">
                                                        <span class="pcoded-mtext text-bold">Communications</span>
                                                    </a>
                                                      <ul class="pcoded-submenu">
                                                        <li class="">
                                                            <a href="<?= url('marketing/communication') ?>">
                                                                <span class="pcoded-mtext">Compose</span>
                                                            </a>
                                                        </li>
                                                            
                                                         <li class="">
                                                            <a href="<?= url('marketing/templates') ?>">
                                                                <span class="pcoded-mtext">Template</span>
                                                            </a>
                                                          </li>

                                                         <li class="">
                                                            <a href="<?= url('marketing/summary') ?>">
                                                                <span class="pcoded-mtext">Summary</span>
                                                            </a>
                                                          </li>

                                                        </ul>
                                                        </li>
                                                  <?php } ?>

                                                <?php if (can_access('manage_sequence')) { ?>
                                                 <li class="">
                                                    <a href="<?= url('customer/sequence') ?>">
                                                        <span class="pcoded-mtext">Sequence</span>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <?php if (can_access('customer_success')) { ?>
                                          <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Customer Success</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                  <li class=" ">
                                                    <a href="<?= url('customer/modules') ?>">
                                                        <span class="pcoded-mtext">Modules</span>
                                                    </a>
                                                </li>
                                             
                                               <li class="">
                                                    <a href="<?= url('analyse/ratings') ?>">
                                                        <span class="pcoded-mtext">User ratings</span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="<?= url('customer/feedbacks/null') ?>">
                                                        <span class="pcoded-mtext">Customer feedbacks</span>
                                                    </a>
                                                </li>

                                              <?php if (can_access('comm_logs')) { ?>
                                                <li class="">
                                                    <a href="<?= url('Phone_call/index') ?>">
                                                        <span class="pcoded-mtext">Communication Logs</span>
                                                    </a>
                                                </li>

                                               <li class="">
                                                    <a href="<?= url('customer/emailsms') ?>">
                                                        <span class="pcoded-mtext">SMS & Email logs</span>
                                                    </a>
                                                </li> 

                                              
                                              <?php } ?>

                                              <?php if (can_access('create_update')) { ?>
                                                  <li class="">
                                                    <a href="<?= url('customer/update') ?>">
                                                        <span class="pcoded-mtext">Updates</span>
                                                    </a>
                                                </li> 
                                              <?php } ?>

                                            
                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <?php if (can_access('manage_partnership')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Partnerships</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('Partner/index') ?>">
                                                    <span class="pcoded-mtext"> Integration Requests </span>
                                                    </a>
                                                </li>

                                               <?php if(can_access('view_epayments')) { ?>
                                                 <li class=" ">
                                                    <a href="<?= url('customer/epayments') ?>">
                                                        <span class="pcoded-mtext">e-payments</span>
                                                    </a>
                                                </li>
                                                <?php } ?>

                                                 <?php if(can_access('nmb_integration')) { ?>
                                                   <li class=" ">
                                                    <a href="<?= url('software/banksetup') ?>">
                                                        <span class="pcoded-mtext">NMB Bank Setup</span>
                                                    </a>
                                                  </li>
                                                <?php } ?>

                                                <?php if(can_access('reconciliation')) { ?>
                                               <li class="">
                                                <a href="<?= url('software/reconciliation') ?>">
                                                    <span class="pcoded-mtext">NMB Payments </span>
                                                </a>
                                               </li>
                                            <?php } ?>
                                            <?php if(can_access('reconciliation')) { ?>
                                               <li class="">
                                                <a href="<?= url('Partner/nmbTransactions') ?>">
                                                    <span class="pcoded-mtext">Sync NMB Payments </span>
                                                </a>
                                               </li>
                                            <?php } ?>
                                    
                                            <?php if(can_access('integration_requests')) { ?>
                                                   <li class=" ">
                                                    <a href="<?= url('Partner/transactions') ?>">
                                                        <span class="pcoded-mtext">CRDB Payments</span>
                                                    </a>
                                                  </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                      <?php } ?>

                                      
                                        <?php if (can_access('manage_products')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Products</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                
                                               <?php if(can_access('task_allocation')) { ?>
                                                 <li class="">
                                                    <a href="<?= url('customer/logs') ?>">
                                                        <span class="pcoded-mtext">Tasks Allocation</span>
                                                    </a>
                                                </li>
                                            <?php } ?>

                                               <?php if(can_access('manage_Karibusms')) { ?>
                                                 <li class="">
                                                    <a href="<?= url('customer/karibu') ?>">
                                                        <span class="pcoded-mtext"> Karibusms </span>
                                                    </a>
                                                </li>
                                                <?php } ?>

                                               <?php if(can_access('whatsapp_integrations')) { ?>
                                                 <li class="">
                                                    <a href="<?= url('general/show/whatsapp_integrations') ?>">
                                                        <span class="pcoded-mtext">WhatsApp Integration</span>
                                                    </a>
                                                 </li>
                                                <?php } ?>
                                                <?php if (can_access('add_requirements')) {?>

                                                <li class="">
                                                    <a href="<?= url('customer/requirements') ?>">
                                                            <span class="pcoded-mtext">Customer Requirements</span>
                                                    </a>
                                                </li>
                                                <?php  } ?>
                                                <?php if (can_access('view_guide')) {?>

                                                <li class="">
                                                    <a href="<?= url('customer/guide') ?>">
                                                        <span class="pcoded-mtext">User Guide</span>
                                                    </a>
                                                </li> 
                                                <?php } ?>

                                               <?php if(can_access('manage_joina')) { ?>
                                                 <li class="">
                                                    <a href="<?= url('users/usergroup') ?>">
                                                        <span class="pcoded-mtext"> ShuleSoft Joina</span>
                                                    </a>
                                                </li>
                                              <?php } ?>

                                               <?php if(can_access('view_sms_status')) { ?>
                                                <li class=" ">
                                                    <a href="<?= url('software/smsstatus') ?>">
                                                        <span class="pcoded-mtext">SMS Status</span>
                                                    </a>
                                                </li>
                                            <?php } ?>


                                            </ul>
                                        </li>
                                      <?php } ?>
                                
                                    </ul>
                                </li>
                                <?php }  ?>

                                


                                <?php if (can_access('manage_operations')) { ?>
                                   <li class="pcoded-hasmenu">
                                      <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                        <span class="pcoded-mtext">OPERATIONS</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                       
                                       <?php if (can_access('manage_talents')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Talents</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('users/index') ?>">
                                                        <span class="pcoded-mtext">Users</span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="<?= url('attendance/index') ?>">
                                                        <span class="pcoded-mtext">Attendance</span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="<?= url('users/courses') ?>">
                                                        <span class="pcoded-mtext">Learning/Courses</span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="<?= url('users/applicant') ?>">
                                                        <span class="pcoded-mtext">Partners</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('users/applicant') ?>">
                                                        <span class="pcoded-mtext">Applicants</span>
                                                    </a>
                                                 </li>


                                                 <li class="">
                                                    <a href="<?= url('users/template') ?>">
                                                        <span class="pcoded-mtext">Forms & Templates</span>
                                                    </a>
                                                </li>

                                                
                                                   <?php if (Auth::user()->role_id == 1) { ?>
                                                    <li class=" ">
                                                        <a href="<?= url('role/userpermission') ?>">
                                                            <span class="pcoded-mtext">Permissions</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <li class=" ">
                                                        <a href="<?= url('role/manage_permission') ?>">
                                                            <span class="pcoded-mtext">Manage Permissions</span>
                                                        </a>
                                                    </li>
                                                    <li class=" ">
                                                        <a href="<?= url('role/manage_quarters') ?>">
                                                            <span class="pcoded-mtext">Manage Quaters</span>
                                                        </a>
                                                    </li>
                                                    <li class=" ">
                                                        <a href="<?= url('report/staffs') ?>">
                                                            <span class="pcoded-mtext">Staff Reports</span>
                                                        </a>
                                                    </li>
                                                    <li class=" ">
                                                        <a href="<?= url('report/manuals') ?>">
                                                            <span class="pcoded-mtext">Operation Manuals</span>
                                                        </a>
                                                    </li>

                                            </ul>
                                        </li>
                                     <?php } ?>

                                              
                                   

                                          {{-- <?php if (can_access('manage_customers')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Customer service</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('customer/setup') ?>">
                                                        <span class="pcoded-mtext">System Setup</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                     <?php } ?> --}}

                                 
                                          <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Administration</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                
                                            <li class=" ">
                                                <a href="<?= url('users/minutes') ?>">
                                                <span class="pcoded-mtext">Meetings</span>
                                                </a>
                                            </li>
                                        
                                            <?php if (can_access('hr_request')) { ?>
                                            <li class=" ">
                                                <a href="<?= url('users/hrrequest') ?>">
                                                <span class="pcoded-mtext">HR Requests</span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                            </li>
                                          </ul>

                                     <?php if (Auth::user()->role_id != 7 ) { ?>
                                       <li class=" ">
                                         <a href="<?= url('#') ?>">
                                            <span class="pcoded-mtext">Legals</span>
                                         </a>
                                       </li>
                                     <?php } ?>

                                   

                                     <?php if (Auth::user()->role_id != 7 ) { ?>
                                      <li class=" ">
                                         <a href="<?= url('#') ?>">
                                            <span class="pcoded-mtext">Compliances</span>
                                         </a>
                                       </li>
                                     <?php } ?>

                                      <?php if (Auth::user()->role_id != 7 ) { ?>
                                      <li class=" ">
                                         <a href="<?= url('#') ?>">
                                            <span class="pcoded-mtext">Processes</span>
                                         </a>
                                       </li>
                                     <?php } ?>
                                   

                                   
                                      {{-- <?php  if (can_access('my_schools')) { ?>
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Schools</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                 <li class="">
                                                    <a href="<?= url('analyse/myschools') ?>">
                                                        <span class="pcoded-mtext">Clients list</span>
                                                    </a>
                                                </li> 

                                                 <li class="">
                                                    <a href="<?= url('analyse/myreport') ?>">
                                                        <span class="pcoded-mtext">Task reports</span>
                                                    </a>
                                                </li>
                                                
                                                 <li class="">
                                                    <a href="<?= url('sales/schoolVisit/1') ?>">
                                                        <span class="pcoded-mtext">School visitation</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                     <?php } ?> --}}

                                 

                                    
                                
{{-- 
                                     <?php if (Auth::user()->department == 9 || Auth::user()->department == 10) { ?>
                                       <li class=" ">
                                         <a href="<?= url('partner/index') ?>">
                                            <span class="pcoded-mtext">Onboarded Schools</span>
                                         </a>
                                       </li>
                                   <?php } ?> --}}


                                    </ul>
                                </li>
                               <?php } ?>

                                 <?php if(can_access('engineering')) { ?>
                                    <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="icofont icofont-code-alt"></i></span>
                                        <span class="pcoded-mtext">ENGINEERING</span>
                                     </a>        
                                 
                                        <ul class="pcoded-submenu">
                                            <li class=" ">
                                                <a href="<?= url('general/create') ?>">
                                                    <span class="pcoded-mtext">Task Management</span>
                                                </a>
                                            </li>

                                            <li class=" ">
                                                <a href="<?= url('software/template') ?>">
                                                    <span class="pcoded-mtext">Manuals</span>
                                                </a>
                                            </li>



                                            <?php if (can_access('manage_database')) { ?>
                                            <li class=" pcoded-hasmenu">
                                                <a href="javascript:void(0)">
                                                    <span class="pcoded-mtext">Database</span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                    <li class="">
                                                        <a href="<?= url('software/compareTable') ?>">
                                                            <span class="pcoded-mtext">Tables</span>
                                                        </a>
                                                    </li>

                                                    <li class="">
                                                        <a href="<?= url('software/compareColumn') ?>">
                                                            <span class="pcoded-mtext">Columns</span>
                                                        </a>
                                                    </li>

                                                    <li class="">
                                                        <a href="<?= url('software/constrains') ?>">
                                                            <span class="pcoded-mtext">Constrains</span>
                                                        </a>
                                                    </li>

                                                      <li class="">
                                                        <a href="<?= url('software/upgrade') ?>">
                                                            <span class="pcoded-mtext">Create Script</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                               </li>
                                           <?php } ?>

                                           <?php if (can_access('manage_errors')) { ?>
                                            <li class=" pcoded-hasmenu">
                                                <a href="javascript:void(0)">
                                                    <span class="pcoded-mtext">System errors</span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                    <li class="">
                                                        <a href="<?= url('software/logs') ?>">
                                                            <span class="pcoded-mtext">Error Logs</span>
                                                        </a>
                                                    </li>

                                                    <li class="">
                                                        <a href="<?= url('software/statistics') ?>">
                                                            <span class="pcoded-mtext">Error Statistics</span>
                                                        </a>
                                                    </li>
                                                 
                                                </ul>
                                               </li>
                                           <?php } ?>
                                           <li class=" ">
                                                <a href="<?= url('software/databaseErrors') ?>">
                                                    <span class="pcoded-mtext">Database Errors</span>
                                                </a>
                                            </li>
                                             <li class=" ">
                                                <a href="<?= url('software/serverErrors') ?>">
                                                    <span class="pcoded-mtext">Server Errors</span>
                                                </a>
                                            </li>
                                           
                                            <li class="">
                                                <a href="<?= url('software/api') ?>">
                                                    <span class="pcoded-mtext">API Requests</span>
                                                </a>
                                            </li>

                                            <li class=" ">
                                                <a href="<?= url('software/resetPassword') ?>">
                                                    <span class="pcoded-mtext">Reset school</span>
                                                </a>
                                            </li>
                                            <!-- <li class=" ">
                                                <a href="<?= url('software/migration') ?>">
                                                    <span class="pcoded-mtext">Migration</span>
                                                </a>
                                            </li> -->
                                     </ul>
                                </li>
                             <?php } ?>


                                 
                              <?php if (can_access('manage_finance')) { ?>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="icofont icofont-coins"></i></span>
                                        <span class="pcoded-mtext">ACCOUNTING</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                         <?php if(can_access('manage_invoice')) { ?>
                                            <li class=" ">
                                                <a href="<?= url('account/invoice') ?>">
                                                    <span class="pcoded-mtext">Invoice</span>
                                                </a>
                                            </li>
                                        <?php } ?>

                                          
                                         <?php if(can_access('add_si')) { ?>
                                          <li class=" ">
                                            <a href="<?= url('account/standingOrders') ?>">
                                                <span class="pcoded-mtext">Standing order</span>
                                            </a>
                                        </li>
                                        <?php } ?>


                                        
                                       <?php if (can_access('manage_transactions')) { ?>
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Transactions</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('revenue/index') ?>">
                                                        <span class="pcoded-mtext">Revenue</span>
                                                    </a>
                                                </li>
                                             
                                                <li class="">
                                                    <a href="<?= url('expense/index/4') ?>">
                                                        <span class="pcoded-mtext">  Expense</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('account/transaction/1') ?>">
                                                        <span class="pcoded-mtext">  Fixed assets</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('account/transaction/5') ?>">
                                                        <span class="pcoded-mtext"> Current assets</span>
                                                    </a>
                                                </li>

                                                  <li class="">
                                                    <a href="<?= url('account/transaction/2') ?>">
                                                        <span class="pcoded-mtext">Liabilities</span>
                                                    </a>
                                                </li>

                                                    <li class="">
                                                    <a href="<?= url('account/transaction/3') ?>">
                                                        <span class="pcoded-mtext"> Capital</span>
                                                    </a>
                                                </li>

                                                 
                                            </ul>
                                        </li>
                                     <?php } ?>

                                              
                                       <?php if (can_access('manage_payroll')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Payroll</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('payroll/taxes') ?>">
                                                        <span class="pcoded-mtext">TAX</span>
                                                    </a>
                                                </li>
                                             
                                                <li class="">
                                                    <a href="<?= url('payroll/pension') ?>">
                                                        <span class="pcoded-mtext">  Pension Fund </span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('allowance/index') ?>">
                                                        <span class="pcoded-mtext">  Allowances </span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('deduction/index') ?>">
                                                        <span class="pcoded-mtext"> Deductions </span>
                                                    </a>
                                                </li>
 
                                               <?php if(can_access('manage_salaries')) { ?>
                                                  <li class="">
                                                    <a href="<?= url('Payroll/index') ?>">
                                                        <span class="pcoded-mtext">Salaries</span>
                                                    </a>
                                                   </li>
                                                <?php } ?>

                                            </ul>
                                        </li>
                                     <?php } ?>


                                           <?php if(can_access('manage_loans')) { ?>
                                              <li class=" pcoded-hasmenu">
                                               <a href="javascript:void(0)">
                                                 <span class="pcoded-mtext text-bold">Loans</span>
                                               </a>
                                               <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('loan/type') ?>">
                                                       <span class="pcoded-mtext">Loans types</span>
                                                    </a>
                                                 </li>
                                             
                                                 <li class="">
                                                    <a href="<?= url('loan/index') ?>">
                                                        <span class="pcoded-mtext">Borrowers </span>
                                                    </a>
                                                  </li>
                                               </ul>
                                            </li> 
                                         <?php } ?>

                                        <?php if(can_access('settings')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Settings</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                 <li class="">
                                                    <a href="<?= url('account/client') ?>">
                                                        <span class="pcoded-mtext">Clients </span>
                                                    </a>
                                                </li> 

                                                 <li class="">
                                                    <a href="<?= url('account/bank') ?>">
                                                        <span class="pcoded-mtext">Banking</span>
                                                    </a>
                                                </li>
                                                
                                                 <li class="">
                                                    <a href="<?= url('account/groups') ?>">
                                                        <span class="pcoded-mtext">Account Groups</span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="<?= url('account/chart') ?>">
                                                        <span class="pcoded-mtext">Charts of Account</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('account/services') ?>">
                                                        <span class="pcoded-mtext">Company services</span>
                                                    </a>
                                                </li>

                                                 <li class="">
                                                    <a href="<?= url('account/holidays') ?>">
                                                        <span class="pcoded-mtext">Holidays</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="<?= url('account/dashboardsettings') ?>">
                                                        <span class="pcoded-mtext">Dashboard Settings</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                     <?php } ?> 

                                      
                                    </ul>
                                </li>
                               <?php } ?>




























                               <?php if (can_access('manage_lineshop')) { ?>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="icofont icofont-bank"></i></span>
                                        <span class="pcoded-mtext">LINESHOP</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Sales</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                <a href="<?= url('lineshop/salesMaterials') ?>">
                                                    <span class="pcoded-mtext">Sales Materials</span>
                                                </a>
                                                </li>
                                                <li class="">
                                                <a href="<?= url('lineshop/pharmacies') ?>">
                                                    <span class="pcoded-mtext">List of pharmacies</span>
                                                </a>
                                                </li>
                                                <li class="">
                                                    <a href="<?= url('lineshop/pharmacyRequest') ?>">
                                                       <span class="pcoded-mtext">Pharmacy requests</span>
                                                    </a>
                                                 </li>
                                            </ul>

                                        </li>


                                         <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Marketing</span>
                                            </a>
                                            <ul class="pcoded-submenu">                                             
                                                <?php if (can_access('event_seminar')) { ?>
                                                <li class="">
                                                  <a href="<?= url('lineshop/events') ?>">
                                                        <span class="pcoded-mtext">Events and seminars</span>
                                                  </a>
                                                </li>
                                                <?php } ?>

                                                <?php if (can_access('communication')) { ?>
                                                    <li class=" pcoded-hasmenu">
                                                        <a href="javascript:void(0)">
                                                        <span class="pcoded-mtext text-bold">Communications</span>
                                                    </a>
                                                      <ul class="pcoded-submenu">
                                                        <li class="">
                                                            <a href="<?= url('lineshop/communication') ?>">
                                                                <span class="pcoded-mtext">Compose</span>
                                                            </a>
                                                        </li>
                                                            
                                                         <li class="">
                                                            <a href="<?= url('lineshop/templates') ?>">
                                                                <span class="pcoded-mtext">Template</span>
                                                            </a>
                                                          </li>

                                                         <li class="">
                                                            <a href="<?= url('lineshop/summary') ?>">
                                                                <span class="pcoded-mtext">Summary</span>
                                                            </a>
                                                          </li>

                                                        </ul> 
                                                        </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <?php if (can_access('customer_success')) { ?>
                                          <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext text-bold">Customer Success</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                  <li class=" ">
                                                    <a href="<?= url('lineshop/customers') ?>">
                                                        <span class="pcoded-mtext">Customers</span>
                                                    </a>
                                                </li>
                        
                                                <li class="">
                                                    <a href="<?= url('lineshop/feedbacks/null') ?>">
                                                        <span class="pcoded-mtext">Customer feedbacks</span>
                                                    </a>
                                                </li>

                                              <?php if (can_access('comm_logs')) { ?>
                                                <li class="">
                                                    <a href="<?= url('lineshop/usage') ?>">
                                                        <span class="pcoded-mtext">Usage Summary</span>
                                                    </a>
                                                </li>

                                               <li class="">
                                                    <a href="<?= url('lineshop/reports') ?>">
                                                        <span class="pcoded-mtext">Reports</span>
                                                    </a>
                                                </li> 

                                              
                                              <?php } ?>                                            
                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <?php if (can_access('manage_partnership')) { ?>
                                        <li class=" pcoded-hasmenu">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-mtext">Product</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?= url('lineshop/customer_requirements') ?>">
                                                    <span class="pcoded-mtext"> Customer requirements </span>
                                                    </a>
                                                </li>

                                               <?php if(can_access('view_epayments')) { ?>
                                                 <li class=" ">
                                                    <a href="<?= url('lineshop/training_request') ?>">
                                                        <span class="pcoded-mtext">Training requests</span>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                      <?php } ?>
                                    </ul>
                                </li>
                                <?php }  ?>
                            </ul>
                        </div>
                    </nav>