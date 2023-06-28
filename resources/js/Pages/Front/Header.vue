<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    const props = defineProps({
        loginAccess : Boolean
    })
</script>
<template>
    <header
        class="header-area header-sticky wow slideInDown"
        data-wow-duration="0.75s"
        data-wow-delay="0s"
    >
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <Link :href="route('front.landing.index')" class="logo">
                            <img :src="$page.props.logo_path" />
                        </Link>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section">
                                <a href="#top" class="active">Home</a>
                            </li>
                            <li class="scroll-to-section">
                                <a href="#services">Services</a>
                            </li>
                            <li class="scroll-to-section">
                                <a href="#about">About</a>
                            </li>
                            <li class="scroll-to-section">
                                <a href="#portfolio">Portfolio</a>
                            </li>
                            <li class="scroll-to-section">
                                <a href="#video">Videos</a>
                            </li>
                            <li class="scroll-to-section">
                                <a href="#contact">Contact Us</a>
                            </li>
                            <li class="scroll-to-section">
                                <div
                                    class="main-red-button-hover"
                                    v-if="loginAccess"
                                >
                                    <Link :href="route('login')"
                                        >Dashboard</Link
                                    >
                                </div>
                                <div class="main-red-button-hover" v-else>
                                    <Link :href="route('login')">Login</Link>
                                </div>
                            </li>
                        </ul>
                        <a class="menu-trigger">
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
</template>
