<script setup>
import AdminNav from "@/Layouts/Nav/Admin.vue"
import AdminSidebar from "@/Layouts/Sidebar/AdminSidebar.vue"

</script>

<template>
    <div class="">
        <body class="hold-transition sidebar-mini">
            <div class="wrapper">
                <!-- Navbar -->
                <AdminNav />
                <!-- /.navbar -->
                <!-- Main Sidebar Container -->
                <AdminSidebar />
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                        <div class="col-sm-6">
                            <slot name="header" />
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <slot name="breadcrum" />
                        </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                    </div>
                    <!-- /.content-header -->

                    <!-- Main content -->
                    <div class="content">
                        <slot />
                    <!-- /.container-fluid -->
                    </div>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->

                <!-- Main Footer -->
                <footer class="main-footer">
                    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
                    All rights reserved.
                    <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 3.2.0
                    </div>
                </footer>
            </div>
        </body>
    </div>
</template>
