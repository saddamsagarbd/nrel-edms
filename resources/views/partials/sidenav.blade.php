@php
    $islandManage= getReadPermission(1,1);
    $isPlotManage = getReadPermission(13,1);

@endphp

<div class="sidebar-body">
    <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
            <a href="{{route($role.'.dashboard')}}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard </span>
            </a>
        </li>

        @if($role==='admin')
        <li class="nav-item nav-category">User Management</li>
        <li class="nav-item">
            <a href="{{route($role.'.user.index')}}" class="nav-link">
                <i class="link-icon" data-feather="file-plus"></i>
                <span class="link-title">Users</span>
            </a>
        </li>
        @endif

        @if($islandManage)
        <li class="nav-item nav-category">Land Management</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#scheduleManagement" role="button" aria-expanded="false" aria-controls="scheduleManagement">
                <i class="link-icon" data-feather="activity"></i>
                <span class="link-title">Maintanance</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="scheduleManagement">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="{{route($role.'.project.index')}}" class="nav-link">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route($role.'.agent.index')}}" class="nav-link">Agent/Media/Seller</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route($role.'.mouza.index')}}" class="nav-link">Mouzas</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route($role.'.khatian.type')}}" class="nav-link">Khatians</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a href="{{route($role.'.entryFile.index')}}" class="nav-link">
                <i class="link-icon" data-feather="file-text"></i>
                <span class="link-title">Entry File</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route($role.'.entryFile.report')}}" class="nav-link">
                <i class="link-icon" data-feather="filter"></i>
                <span class="link-title">Reports</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route($role.'.estate.upload.index')}}" class="nav-link">
                <i class="link-icon" data-feather="upload"></i>
                <span class="link-title">Uploads</span>
            </a>
        </li>
        @endif
    
        
        @if($isPlotManage)
        <li class="nav-item nav-category">Plot & Apartment</li>
        <li class="nav-item">
            <a href="{{route($role.'.plot.index')}}" class="nav-link">
                <i class="link-icon" data-feather="list"></i>
                <span class="link-title">Plots/Apart</span>
            </a>
        </li>
        

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#plotManagement" role="button" aria-expanded="false" aria-controls="plotManagement">
                <i class="link-icon" data-feather="list"></i>
                <span class="link-title">Map View</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="plotManagement">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="{{route('map.show', '2')}}" class="nav-link">Highland 1</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('map.show', '3')}}" class="nav-link">Highland 2</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('map.show', '5')}}" class="nav-link">SouthernVille</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('map.index')}}" class="nav-link">Upload</a>
                    </li>
                </ul>
            </div>
        </li>


        @endif


        <!-- <li class="nav-item nav-category">CRM (Sales)</li>
        <li class="nav-item">
            <a href="{{route($role.'.lead.index')}}" class="nav-link">
                <i class="link-icon" data-feather="phone-call"></i>
                <span class="link-title">Leads</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="link-icon" data-feather="user-plus"></i>
                <span class="link-title">Clients</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="link-icon" data-feather="credit-card"></i>
                <span class="link-title">Accounts</span>
            </a>
        </li> -->

    </ul>
</div>