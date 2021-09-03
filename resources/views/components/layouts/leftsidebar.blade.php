<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ url('/') }}">
            <img style="max-height:70px" src="{{ asset('/images/logo.png') }}" alt="">
        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
        
               
         
              
              
                 <!-- Trip Booking-->
                 <li>
                    <a href="/booking/trips/list" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-bookmark" aria-hidden="true"></i><span class="mtext">Trip Booking</span>
                    </a>
                </li>
                <!--Transportation-->
                <li>
                <a href="/vehicles" class="dropdown-toggle no-arrow">
                    <i class="icon-copy fa fa-car" aria-hidden="true"></i><span class="mtext">Vehicles</span>
                </a>
                </li>
                
                <!--Trip Pricing-->
                <li>
                    <a href="/trips" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-taxi" aria-hidden="true"></i><span class="mtext">Trips</span>
                    </a>
                </li>
        
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <i class="icon-copy fa fa-user-circle" aria-hidden="true"></i> Users</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="/users?user_type_id=1">Admin Users</a></li>
                        <li><a href="/users?user_type_id=2">Partners</a></li>
                        <li><a href="/users?user_type_id=3">Public Users</a></li>

                    </ul>
                </li>
             
                <!--setting-->
                <li>
                    <a href="/setting" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-cog" aria-hidden="true"></i><span class="mtext">Setting</span>
                    </a>
                </li>
                
          
             
            </ul>
        </div>
    </div>
</div>