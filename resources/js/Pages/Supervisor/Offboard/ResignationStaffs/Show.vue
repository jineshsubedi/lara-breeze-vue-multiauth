<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    resignationstaff: Object,
})

const form = useForm({});

</script>
<template>
    <Head title="ResignationStaff Information" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ResignationStaff Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.resignationstaffs.index')"> ResignationStaff </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.resignationstaffs.show', resignationstaff.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Resignation Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{resignationstaff.user ? resignationstaff.user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Reason</th>
                                        <td>{{resignationstaff.reason ? resignationstaff.reason.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>{{resignationstaff.type ? resignationstaff.type.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{resignationstaff.resignation_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{resignationstaff.resignation_detail}}</td>
                                    </tr>
                                    <tr>
                                        <th>Supervisor</th>
                                        <td>
                                            <p>{{resignationstaff.supervisor_approval_status}} - {{resignationstaff.supervisor_approval_date}}</p>
                                            <hr>
                                            <p v-html="resignationstaff.supervisor_approval_detail"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>HR <p v-if="resignationstaff.authorize_user">{{resignationstaff.authorize_user.name}}</p></th>
                                        <td>
                                            <p>{{resignationstaff.status}} - {{resignationstaff.approval_date}}</p>
                                            <hr>
                                            <p v-html="resignationstaff.approval_detail"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Offboarding Date</th>
                                        <td>{{resignationstaff.offBoarding_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Retract</th>
                                        <td>
                                            <div v-if="resignationstaff.retraction != null">
                                                <tr>
                                                    <th>Retract Reason</th>
                                                    <td>{{resignationstaff.retraction.retraction_reason}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Work Commitment</th>
                                                    <td>{{resignationstaff.retraction.work_commitment}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td>{{resignationstaff.retraction.description}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Hr Approval</th>
                                                    <td>{{resignationstaff.retraction.hr_approval}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Hr Remark</th>
                                                    <td>{{resignationstaff.retraction.hr_remark}}</td>
                                                </tr>
                                            </div>
                                            <div v-else>
                                                <span v-html="resignationstaff.retract"></span>
                                            </div>
                                        </td>
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
