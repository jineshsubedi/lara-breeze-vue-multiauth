<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    staff: Object,
    outsource: Object,
})

</script>
<template>
    <Head title="Outsource Staff Information" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Outsource Staff Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.outsources.index')"> Outsource </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.outsources.show', outsource.id)"> Information </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.outsources.staffs.index', outsource.id)"> Staff </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.outsources.staffs.show', [outsource.id, staff.id])"> Staff Information</Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{outsource.project_name}} - {{staff.name}} - Information</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Official Detail</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Profile Image</th>
                                                <td><img :src="staff.image" v-if="staff.image" style="width:100px"></td>
                                            </tr>
                                            <tr>
                                                <th>Employee Code</th>
                                                <td>{{staff.staff_code}}</td>
                                            </tr>
                                            <tr>
                                                <th>Join Date</th>
                                                <td>{{staff.join_date}}</td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td>{{staff.department}}</td>
                                            </tr>
                                            <tr>
                                                <th>Designation</th>
                                                <td>{{staff.designation}}</td>
                                            </tr>
                                            <tr>
                                                <th>Contract Start</th>
                                                <td>{{staff.contract_start}}</td>
                                            </tr>
                                            <tr>
                                                <th>Contract End</th>
                                                <td>{{staff.contract_end}}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{staff.status}}</td>
                                            </tr>
                                        </thead>
                                    </table> 
                                </div>
                                <div class="col-md-4">
                                    <h4>Personal Detail</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{staff.email}}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone Number</th>
                                                <td>{{staff.phone_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>Temporary Address</th>
                                                <td>{{staff.temporary_address}}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>{{staff.sex}}</td>
                                            </tr>
                                            <tr>
                                                <th>DOB</th>
                                                <td>{{staff.dob}}</td>
                                            </tr>
                                            <tr>
                                                <th>Age</th>
                                                <td>{{staff.age}}</td>
                                            </tr>
                                            <tr>
                                                <th>Education</th>
                                                <td>{{staff.education}}</td>
                                            </tr>
                                        </thead>
                                    </table> 
                                </div>
                                <div class="col-md-4">
                                    <h4>Others Detail</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>PAN Number</th>
                                                <td>{{staff.pan_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>SSF Number</th>
                                                <td>{{staff.ssf_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>CIT Number</th>
                                                <td>{{staff.cit_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>Account Name</th>
                                                <td>{{staff.account_name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Account Number</th>
                                                <td>{{staff.account_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>Emergency Name</th>
                                                <td>{{staff.emergency_name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Emergency Relation</th>
                                                <td>{{staff.emergency_relation}}</td>
                                            </tr>
                                            <tr>
                                                <th>Emergency Number</th>
                                                <td>{{staff.emergency_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>Emergency Alternative</th>
                                                <td>{{staff.emergency_other_number}}</td>
                                            </tr>
                                        </thead>
                                    </table> 
                                </div>
                                <div class="col-md-12">
                                    <h4>Staff Contract</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Salary</th>
                                                <th>Position</th>
                                                <th>Contract From</th>
                                                <th>Contract To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(contract, dindex) in staff.contract" :key="dindex">
                                                <td>{{contract.salary}}</td>
                                                <td>{{contract.position}}</td>
                                                <td>{{contract.contract_start}}</td>
                                                <td>{{contract.contract_end}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <h4>Staff Documents</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>File </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(document, dindex) in staff.documents" :key="dindex">
                                                <td>{{document.document_label}}</td>
                                                <td><a :href="document.document_file" target="_blank">OPEN</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <h4>Staff Assets</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Handover </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(asset, dindex) in staff.asset_taken" :key="dindex">
                                                <td>{{asset.asset_title}}</td>
                                                <td>
                                                    <span v-if="asset.asset_action == 1">No</span>
                                                    <span v-if="asset.asset_action == 2">Yes</span>
                                                    <span v-if="asset.asset_action == 3">Hold</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <h4>Staff Medical</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Policy Number</th>
                                                <th>From</th>
                                                <th>To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(medical, dindex) in staff.medical" :key="dindex">
                                                <td>
                                                    <span v-if="medical.medical_type == 1">Group Medical Insurance</span>
                                                    <span v-if="medical.medical_type == 2">Group Accidental Insurance</span>
                                                </td>
                                                <td>{{medical.policy_number}}</td>
                                                <td>{{medical.medical_from}}</td>
                                                <td>{{medical.medical_to}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
