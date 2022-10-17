<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm  } from "@inertiajs/inertia-vue3";

const props = defineProps(['user']);

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: null,
    confirm_password: null,
})
const avatarForm = useForm({
    avatar: ''
})

</script>
<template>
    <Head title="Profile" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')">
                        Home
                    </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.profile')">
                        User Profile
                    </Link>
                </li>
            </ol>
        </template>
        
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <form @submit.prevent="avatarForm.post(route('admin.updateAvatar'))" enctype="multipart/form-data" >
                            <input type="file" @input="avatarForm.avatar = $event.target.files[0]" @change="$refs.profileUpdateForm.click()" ref="fileInput" style="display:none">
                            <button type="submit" ref="profileUpdateForm" style="display:none">Submit</button>
                        </form>
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <div @click="$refs.fileInput.click()" class="profile-imageUploader"><i class="bi bi-camera"></i></div>
                            <img :src="user.avatarpath" alt="Profile" class="rounded-circle">

                            <h2>{{user.name}}</h2>
                            <h3>Designation</h3>
                            <p>{{user.email}}</p>
                            <!-- <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs nav-tabs-bordered">
    
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Notification</button>
                                </li>
    
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                </li>
    
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Documents</button>
                                </li>
    
                                <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                </li>
    
                            </ul>
                        </div>
                        <form class="form-horizontal" @submit.prevent="form.post(route('admin.updateProfile'))">
                        <div class="card-body pt-3">
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Notification</h5>
                                    <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>
                                </div>
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.name" type="text" class="form-control" id="fullName">
                                            <div class="text-red-400 text-sm" v-if="form.errors.name">
                                                {{ form.errors.name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.email" type="email" class="form-control" id="email">
                                            <div class="text-red-400 text-sm" v-if="form.errors.email">
                                                {{ form.errors.email }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-settings">
                                    <div id="document">
                                        <h2>Document upload</h2>
                                    </div>
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.password" type="password" class="form-control" id="password">
                                            <div class="text-red-400 text-sm" v-if="form.errors.password">
                                                {{ form.errors.password }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="confirm_password" class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.confirm_password" type="password" class="form-control" id="confirm_password">
                                            <div class="text-red-400 text-sm" v-if="form.errors.confirm_password">
                                                {{ form.errors.confirm_password }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Bordered Tabs -->
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>