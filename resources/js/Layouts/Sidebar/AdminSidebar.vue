<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"

</script>
<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <NavLink
                    :href="route('admin.dashboard')"
                    :active="route().current('admin.dashboard')"
                >
                    <i class="bi bi-grid"></i>
                    Dashboard
                </NavLink>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i><span>Configuration</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="setting-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li v-if="$page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.setting.index')" 
                            :active="route().current('admin.setting.index')"
                        >
                            <i class="bi bi-gear-fill"></i><span>Setting</span>
                        </NavLink>
                    </li>
                    <li v-if="$page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.roles.index')" 
                            :active="route().current('admin.roles.index')"
                        >
                            <i class="bi bi-bootstrap-reboot"></i><span>Roles</span>
                        </NavLink>
                    </li>
                    <li v-if="$page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.branches.index')" 
                            :active="route().current('admin.branches.index')"
                        >
                            <i class="bi bi-diagram-3"></i><span>Branch</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.departments.index')" 
                            :active="route().current('admin.departments.index')"
                        >
                            <i class="bi bi-node-plus"></i><span>Department</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.designations.index')" 
                            :active="route().current('admin.designations.index')"
                        >
                            <i class="bi bi-mortarboard-fill"></i><span>Designation</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.shift_times.index')" 
                            :active="route().current('admin.shift_times.index')"
                        >
                            <i class="bi bi-alarm-fill"></i><span>Shift Time</span>
                        </NavLink>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#hrm-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i><span>HRM</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="hrm-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('admin.setting.index')" 
                            :active="route().current('admin.setting.index')"
                        >
                            <i class="bi bi-person-fill"></i><span>Staffs</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.setting.index')" 
                            :active="route().current('admin.setting.index')"
                        >
                            <i class="bi bi-card-text"></i><span>Report</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.attendances.index')" 
                            :active="route().current('admin.attendances.index')"
                        >
                            <i class="bi bi-calendar2-check"></i><span>Attendance</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.dailytasks.index')" 
                            :active="route().current('admin.dailytasks.index')"
                        >
                            <i class="bi bi-calendar2-check"></i><span>Daily Tasks</span>
                        </NavLink>
                    </li>
                </ul>
            </li>


            <!-- <li class="nav-heading">Pages</li> -->

            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
                </a>
            </li> -->


        </ul>
    </aside>
</template>