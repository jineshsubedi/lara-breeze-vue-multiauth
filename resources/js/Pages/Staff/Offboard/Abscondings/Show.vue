<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    absconding: Object,
})

const form = useForm({});
</script>
<template>
    <Head title="Absconding Information" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Absconding Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.abscondings.index')"> Absconding </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.abscondings.show', absconding.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Absconding</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Staff Name</th>
                                        <td>{{absconding.user ? absconding.user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Issued Date</th>
                                        <td>{{absconding.issued_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Issued By</th>
                                        <td>{{absconding.isseudby ? absconding.isseudby.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Previous Action (Any)</th>
                                        <td><p v-html="absconding.previous"></p></td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td>
                                            <span v-html="absconding.status" v-if="absconding.termination === 0"></span>
                                            <span v-else-if="absconding.termination === 1" class="badge bg-danger">Terminated</span>
                                            <span v-else class="badge bg-success">Hold</span>
                                        </td>
                                    </tr>
                                    <tr v-if="absconding.suspension == 1">
                                        <th>Suspension Days </th>
                                        <td>{{absconding.suspension_days}}</td>
                                    </tr>
                                    <tr v-if="absconding.suspension == 2">
                                        <th>Penalty Charge</th>
                                        <td>{{absconding.penalty_charge}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{absconding.description}}</td>
                                    </tr>
                                    <tr>
                                        <th>Follow Up Medium</th>
                                        <td>{{absconding.follow_up_medium}}</td>
                                    </tr>
                                    <tr>
                                        <th>Follow Up Description</th>
                                        <td>{{absconding.follow_up_description}}</td>
                                    </tr>
                                    <tr>
                                        <th>Follow Up Atachment</th>
                                        <td><a :href="absconding.follow_up_attachment" v-if="absconding.follow_up_attachment != ''" target="_blank" class="btn btn-sm btn-success">Download</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
