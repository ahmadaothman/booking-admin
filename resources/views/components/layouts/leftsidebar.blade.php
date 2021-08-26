<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ url('/') }}">
            <img style="max-height:70px" src="{{ asset('/images/logo.png') }}" alt="">
        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <!--dashboard-->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="fa fa-home"></span><span class="mtext">Home</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ url('/') }}">Dashboard</a></li>
                        <li><a href="">Statistics</a></li>
                    </ul>
                </li>
               
         
                <!--Hotels-->
                <li>
                <a href="/hotels" class="dropdown-toggle no-arrow">
                    <i class="icon-copy fa fa-hotel" aria-hidden="true"></i><span class="mtext">Hotel</span>
                </a>
                </li>
                <!--Hotel Booking-->
                <li>
                    <a href="/hotels" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-hotel" aria-hidden="true"></i><span class="mtext">Hotel Booking</span>
                    </a>
                </li>
                 <!-- Trip Booking-->
                 <li>
                    <a href="/hotels" class="dropdown-toggle no-arrow">
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
                        <i class="icon-copy fa fa-dollar" aria-hidden="true"></i><span class="mtext">Trips</span>
                    </a>
                </li>
        
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <i class="icon-copy fa fa-user-circle" aria-hidden="true"></i> Users</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="/users?user_type_id=1">Admin Users</a></li>
                        <li><a href="/users?user_type_id=2">Private Users</a></li>
                        <li><a href="/users?user_type_id=3">Public Users</a></li>

                    </ul>
                </li>
                <!--reports-->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="fa fa-pie-chart"></span><span class="mtext">Reports</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="highchart.php">Highchart</a></li>
                        <li><a href="knob-chart.php">jQuery Knob</a></li>
                        <li><a href="jvectormap.php">jvectormap</a></li>
                    </ul>
                </li>
                <!--setting-->
                <li>
                    <a href="setting" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-cog" aria-hidden="true"></i><span class="mtext">Setting</span>
                    </a>
                </li>
                
          
             
            </ul>
        </div>
    </div>
</div>