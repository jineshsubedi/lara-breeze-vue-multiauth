<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"

    let DocumentMenu = Ziggy.routes['admin.documents.index'] ? true : false;
    let TaskMenu = Ziggy.routes['admin.tasks.index'] ? true : false;
</script>
<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <NavLink
                    :href="route('admin.dashboard')"
                    :active="$page.component.startsWith('Admin/Dashboard')"
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
                            :active="$page.component.startsWith('Admin/Setting')"
                        >
                            <i class="bi bi-gear-fill"></i><span>Setting</span>
                        </NavLink>
                    </li>
                    <li v-if="$page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.roles.index')" 
                            :active="$page.component.startsWith('Admin/Roles')"
                        >
                            <i class="bi bi-bootstrap-reboot"></i><span>Roles</span>
                        </NavLink>
                    </li>
                    <li v-if="$page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.branches.index')" 
                            :active="$page.component.startsWith('Admin/Branch')"
                        >
                            <i class="bi bi-diagram-3"></i><span>Branch</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.departments.index')" 
                            :active="$page.component.startsWith('Admin/Department')"
                        >
                            <i class="bi bi-node-plus"></i><span>Department</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.designations.index')" 
                            :active="$page.component.startsWith('Admin/Designation')"
                        >
                            <i class="bi bi-mortarboard-fill"></i><span>Designation</span>
                        </NavLink>
                    </li>
                    <li v-if="DocumentMenu">
                        <NavLink 
                            :href="route('admin.documents.index')" 
                            :active="$page.component.startsWith('Admin/Document')"
                        >
                            <i class="bi bi-escape"></i><span>Document</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.shift_times.index')" 
                            :active="$page.component.startsWith('Admin/Shifttime')"
                        >
                            <i class="bi bi-alarm-fill"></i><span>Shift Time</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Leave Configuration</li>
                    <li>
                        <NavLink 
                            :href="route('admin.leave_types.index')" 
                            :active="$page.component.startsWith('Admin/Leavetype')"
                        >
                            <i class="bi bi-escape"></i><span>Leave Type</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.leave_setting.index')" 
                            :active="$page.component.startsWith('Admin/Leavesetting')"
                        >
                            <i class="bi bi-escape"></i><span>Leave Setting</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Booking Configuration</li>
                    <li class="nav-heading">Travel Configuration</li>
                </ul>
            </li>

            <li class="nav-item" v-if="TaskMenu">
                <a class="nav-link collapsed" data-bs-target="#tasks-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-pc-display"></i><span>Tasks</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tasks-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('admin.tasks.index')" 
                            :active="$page.component.startsWith('Admin/Tasks')"
                        >
                            <i class="bi bi-person-workspace"></i><span>Home</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.helpdesks.index')" 
                            :active="$page.component.startsWith('Admin/Helpdesk')"
                        >
                            <i class="bi bi-pc-horizontal"></i><span>Help Desk</span>
                        </NavLink>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#hrm-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-briefcase-fill"></i><span>HRM</span><i class="bi bi-chevron-down ms-auto"></i>
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