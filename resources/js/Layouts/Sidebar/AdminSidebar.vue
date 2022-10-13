<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"
    import SidebarHead from "@/Layouts/Common/SidebarHead.vue"
    import SidebarBrand from "@/Layouts/Common/SidebarBrand.vue"
</script>
<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <SidebarBrand />

        <!-- Sidebar -->
        <div class="sidebar">
            <SidebarHead />

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <NavLink
                            :href="route('admin.dashboard')"
                            :active="route().current('admin.dashboard')"
                        >
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            Dashboard
                        </NavLink>
                    </li>
                    <li class="nav-item">
                        <NavLink
                            :href="route('admin.setting.index')"
                            :active="route().current('admin.setting.index')"
                        >
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            Setting
                        </NavLink>
                        
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Mailbox
                            <i class="fas fa-angle-left right"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/mailbox/mailbox.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Inbox</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/mailbox/compose.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Compose</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/mailbox/read-mail.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Read</p>
                            </a>
                        </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>