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