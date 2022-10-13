<script setup>
import AdminNav from "@/Layouts/Nav/Admin.vue"
import AdminSidebar from "@/Layouts/Sidebar/AdminSidebar.vue"

</script>

<template>
    <div class="">
        <!-- ======= Header ======= -->
        <AdminNav />
        <!-- End Header -->
        <!-- ======= Sidebar ======= -->
        <AdminSidebar />
        <!-- End Sidebar-->

        <main id="main" class="main">

        <div class="pagetitle">
            <slot name="header" />
            <slot name="breadcrum" />
        </div><!-- End Page Title -->

        <section class="section dashboard">
        <slot />
        </section>

        </main><!-- End #main -->
        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    </div>
</template>
