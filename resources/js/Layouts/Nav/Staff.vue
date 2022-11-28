<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"
    import {Link} from "@inertiajs/inertia-vue3"
    import { Inertia } from '@inertiajs/inertia'
    import axios from "axios";
    import { ref } from "vue";
    import moment from 'moment';

    function toUpperCase(value)
    {
        return value.toUpperCase();
    }
    function humanTime(value)
    {
        return moment(value).fromNow();
    }

    function markAsRead(id = '', url = '')
    {
        axios.post(route('markNotification'), 
            {
                id: id
            }
        )
        .then(res => {
            Inertia.visit(url, {
                method: 'get'
            })
        }).catch(err => {
            console.log(err)
        })
    }

</script>

<template>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number">{{$page.props.countNotification}}</span>
                </a><!-- End Notification Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="max-height: 80vh; width:30vw; overflow-y: scroll;">
                    <li class="dropdown-header">
                    You have {{$page.props.countNotification}} new notifications
                    <!-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a> -->
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>
                    <span v-for="(notification, nindex) in $page.props.notifications" :key="nindex" style="cursor:pointer">
                        <li class="notification-item" @click="markAsRead(notification.id, notification.data.url)">
                                <i :class="notification.data.icon"></i>
                                <div>
                                    <h4>{{toUpperCase(notification.data.title)}}</h4>
                                    <p v-html="notification.data.message"></p>
                                    <p>{{humanTime(notification.created_at)}}</p>
                                </div>
                            </li>   
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                    </span>
                    <li>
                    <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <button type="button" @click="markAsRead()">Mark all Read Notification</button>
                    </li>

                </ul><!-- End Notification Dropdown Items -->
            </li><!-- End Notification Nav --><!-- End Notification Nav -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img :src="$page.props.auth.avatar" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{$page.props.auth.user.name}}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{$page.props.auth.user.name}}</h6>
                        <span>Designation</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <NavLink
                            class="dropdown-item d-flex align-items-center"
                            :href="route('staffs.profile')"
                            as="button"
                        >
                            <i class="bi bi-person"></i> My Profile
                        </NavLink>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>

                    <li>
                        <NavLink
                            class="dropdown-item d-flex align-items-center"
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </NavLink>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->
</template>