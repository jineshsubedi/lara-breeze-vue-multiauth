<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import Feed from "./Feed.vue"

const form = useForm({});

const props = defineProps({
    event_categories: {
        type: Object,
        default: () => ({}),
    },
    staffs: Object,
    can: Array,
});
let SuperAdmin = props.can.includes("SuperAdmin");
let HrHandler = props.can.includes("HrHandler");

</script>
<template>
    <Head title="Newsfeed Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Newsfeed
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link
                        :href="route('supervisor.newsfeeds.index')"
                    >
                        Newsfeed
                    </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="col-sm-6 col-md-6">
                <Feed :auth="(SuperAdmin || HrHandler)" :category="event_categories" :staffs="staffs" />
            </div>
        </div>
    </SupervisorLayout>
</template>
<style>

</style>
