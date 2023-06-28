<script setup>
import SupervisorNav from "@/Layouts/Nav/Supervisor.vue"
import SupervisorSidebar from "@/Layouts/Sidebar/SupervisorSidebar.vue"
import Footer from "@/Layouts/Common/Footer.vue"
import FlashMessasge from "@/Layouts/Common/FlashMessasge.vue"
import {Link} from "@inertiajs/inertia-vue3"
import Floating from "@/Layouts/Common/Floating.vue"

    function toggleClassSidebar()
    {
        $('#jinesh').toggleClass('toggle-sidebar')
    }
</script>

<template>
    <div class="" id="jinesh">
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
            <Link :href="route('supervisor.dashboard')" class="logo d-flex align-items-center">
                <img :src="$page.props.logo_path" alt="">
                <span class="d-none d-lg-block">{{$page.props.site.name}}</span>
            </Link>
            <i class="bi bi-list toggle-sidebar-btn" @click="toggleClassSidebar"></i>
            </div><!-- End Logo -->
            <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
            </div><!-- End Search Bar -->
            <SupervisorNav />
        </header>
        
        <!-- End Header -->
        <!-- ======= Sidebar ======= -->
        <SupervisorSidebar />
        <!-- End Sidebar-->

        <main id="main" class="main">

        <div class="pagetitle">
            <slot name="header" />
            <slot name="breadcrum" />
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <FlashMessasge />
            <slot />
        </section>

        </main><!-- End #main -->
        <!-- ======= Footer ======= -->
        <Floating />
        <Footer />
    </div>
</template>
