<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"

    let TaskMenu = Ziggy.routes['supervisor.tasks.index'] ? true : false;
</script>
<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <NavLink
                    :href="route('supervisor.dashboard')"
                    :active="route().current('supervisor.dashboard')"
                >
                    <i class="bi bi-grid"></i>
                    Dashboard
                </NavLink>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#hrm-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i><span>HRM</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="hrm-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('supervisor.attendances.index')" 
                            :active="route().current('supervisor.attendances.index')"
                        >
                            <i class="bi bi-calendar2-check"></i><span>Attendance</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.dailytasks.index')" 
                            :active="route().current('supervisor.dailytasks.index')"
                        >
                            <i class="bi bi-calendar2-check"></i><span>Daily Tasks</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li class="nav-item" v-if="TaskMenu">
                <a class="nav-link collapsed" data-bs-target="#tasks-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-pc-display"></i><span>Tasks</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tasks-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('supervisor.tasks.index')" 
                            :active="route().current('supervisor.tasks.index')"
                        >
                            <i class="bi bi-person-workspace"></i><span>Home</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.tasks.index')" 
                            :active="route().current('supervisor.tasks.index')"
                        >
                            <i class="bi bi-pc-horizontal"></i><span>Help Desk</span>
                        </NavLink>
                    </li>
                </ul>
            </li>


        </ul>
    </aside>
</template>