<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    onboardstaff: Object
})

const form = useForm({});
</script>
<template>
    <Head title="OnBoardStaff Information" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OnBoardStaff Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.onboardings.index')"> OnBoardStaff </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.onboardings.show', onboardstaff.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">OnBoardStaff</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{onboardstaff.name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{onboardstaff.email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>{{onboardstaff.department ? onboardstaff.department.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>{{onboardstaff.designation ? onboardstaff.designation.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Staff Type</th>
                                        <td>{{onboardstaff.staff_type_label}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nature of Job</th>
                                        <td>{{onboardstaff.nature_of_job}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nature of Employment</th>
                                        <td>{{onboardstaff.nature_of_employment}}</td>
                                    </tr>
                                    <tr>
                                        <th>Joining Date</th>
                                        <td>{{onboardstaff.joining_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Trail</th>
                                        <td>{{onboardstaff.trail_period == 1 ? 'Yes' : 'No'}}</td>
                                    </tr>
                                    <tr v-if="onboardstaff.trail_period == 1">
                                        <th>No Of Days</th>
                                        <td>{{onboardstaff.no_of_days}}</td>
                                    </tr>
                                    <tr v-if="onboardstaff.trail_period == 1">
                                        <th>Trail Start Date</th>
                                        <td>{{onboardstaff.trail_start_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>CV</th>
                                        <td>
                                            <a v-if="onboardstaff.cv != ''" :href="onboardstaff.cv" target="_blank" class="btn btn-sm btn-primary">Download</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Letter Type</th>
                                        <td>{{onboardstaff.letter ? onboardstaff.letter.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Letter Accept Date</th>
                                        <td>{{onboardstaff.letter_accept_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Supervisor Approval</th>
                                        <td>{{onboardstaff.supervisor_approval}} - {{onboardstaff.supervisor_approval_date}} <br> <span v-html="onboardstaff.supervisor_comment"></span></td>
                                    </tr>
                                    <tr>
                                        <th>HR Approval</th>
                                        <td>{{onboardstaff.hr_approval}} - {{onboardstaff.hr_approval_date}} <br> <span v-html="onboardstaff.hr_comment"></span></td>
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
