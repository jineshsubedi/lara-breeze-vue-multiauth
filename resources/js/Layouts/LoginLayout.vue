<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <Link :href="route('login')" class="logo d-flex align-items-center w-auto">
                    <img :src="$page.props.icon_path" alt="">
                    <span class="d-none d-lg-block">{{$page.props.site.name}}</span>
                </Link>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">
                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    </div>

                  <slot />

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</template>