<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    datas: Object,
    terminationstaff: Object
})

const form = useForm({ });

</script>
<template>
    <Head title="Terminate Staff Information" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Terminate Staff Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.terminatestaffs.index')"> Terminate Staff </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.terminatestaffs.show', terminationstaff.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Terminate Staff Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Staff Name</th>
                                        <td>{{terminationstaff.user ? terminationstaff.user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>{{terminationstaff.type ? terminationstaff.type.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Terminated By</th>
                                        <td>{{terminationstaff.terminteby ? terminationstaff.terminteby.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td>{{terminationstaff.start_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>End Date</th>
                                        <td>{{terminationstaff.end_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{terminationstaff.status}}</td>
                                    </tr>
                                    <tr>
                                        <th>Offboarding Date</th>
                                        <td>{{terminationstaff.offBoarding_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Detail</th>
                                        <td>{{terminationstaff.termination_detail}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
