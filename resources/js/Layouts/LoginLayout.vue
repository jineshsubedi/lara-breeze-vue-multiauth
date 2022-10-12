<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="hold-transition login-page">
        <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <Link :href="route('login')">
                    <b>Admin</b>LTE
                </Link>
            </div>
            <div class="card-body">
                <slot />
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
    </div>
</template>