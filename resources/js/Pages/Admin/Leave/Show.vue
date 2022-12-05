<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    leave : Object,
})

const form = useForm();

</script>
<template>
    <Head title="Leave Request Information" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Request
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.leaves.index')"> Leave Request </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leaves.show', leave.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Leave Request</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Requested By</th>
                                        <td>{{ leave.user ? leave.user.name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Leave Type</th>
                                        <td>{{ leave.leave_type ? leave.leave_type.title : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Leave Nature</th>
                                        <td>{{ leave.type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Emergency</th>
                                        <td>{{ leave.emergency == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Paid</th>
                                        <td>{{ leave.paid == 1 ? 'Unpaid' : 'Paid' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Request Date</th>
                                        <td>{{ leave.request_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>From</th>
                                        <td>{{ leave.start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>To</th>
                                        <td>{{ leave.end_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Duration</th>
                                        <td>{{ leave.duration }} Days</td>
                                    </tr>
                                    <tr v-if="leave.compensation != null">
                                        <th>Compensation</th>
                                        <td>{{ leave.compensation }}</td>
                                    </tr>
                                    <tr v-if="leave.document != ''">
                                        <th>Document</th>
                                        <td><img :src="leave.document"></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><p v-html="leave.status"></p></td>
                                    </tr>
                                    <tr>
                                        <th>Reason</th>
                                        <td>{{ leave.description }}</td>
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
