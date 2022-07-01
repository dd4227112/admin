
<li class="header-notification">
<div class="dropdown-secondary dropdown">
    <div class="dropdown-toggle" data-toggle="dropdown">
        <i class="feather icon-bell text-light"></i>
        <span class="badge bg-c-pink" id="total_notifications">0</span>
    </div>
    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
        <li>
            <h6>Notifications</h6>
        </li>
        <li class="nav-item">
          <a href="<?= url('background/taskallocated') ?>">
                <div>
                    <p>
                    <strong><span  id="tasks_allocated">(0)</span>&nbsp;&nbsp;Active tasks Allocated to you</strong>             
                    </p>
                    <p><strong> Last time:&nbsp;&nbsp;&nbsp;&nbsp;<span class="notification-time"  id="last_task_allocated"></span> </strong> </p>
                </div>
           </a>
        </li>

       <?php if (can_access('approve_onboard')) { ?>
        <li class="nav-item">
          <a href="<?= url('sales/onboaredSchools') ?>">
                <div class="media-body">
                    <p class="notification-msg"><strong><span class="blue" id="onboarded">(0)</span>&nbsp;&nbsp; Schools to Approve Standing order</strong></p>
                </div>
            </a>
        </li>
      <?php } ?>

      <?php if (can_access('implement_tasks')) { ?>
        <li class="nav-item">
          <a href="<?= url('background/schoolTasks') ?>">
                <div class="media-body">
                    <p class="notification-msg"><strong><span class="blue" id="schools_to_implement">(0)</span>&nbsp;&nbsp; Allocate School tasks </strong></p>
                </div>
            </a>
        </li>
      <?php } ?>
    
    </ul>
</div>
</li> 


<script type="text/javascript">
        alerts = function () {  
            $.getJSON('<?= base_url('background/alerts/null') ?>', null, function (data) {
                    $('#tasks_allocated').html(data.tasks_allocated.length);
                    $('#last_task_allocated').html(data.last_created_task);
                    $('#onboarded').html(data.schools_to_approve);
                    $('#schools_to_implement').html(data.schools_to_implement);
                    $('#total_notifications').html(data.total);
            });
        }
        $(document).ready(alerts);
</script>