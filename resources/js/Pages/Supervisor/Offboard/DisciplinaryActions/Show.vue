<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    disciplinaryaction:Object,
})

const form = useForm({

});

</script>
<template>
    <Head title="DisciplinaryAction Information" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                DisciplinaryAction Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.disciplinaryactions.index')"> DisciplinaryAction </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.disciplinaryactions.show', disciplinaryaction.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">DisciplinaryAction Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Staff Name</th>
                                        <td>{{disciplinaryaction.user ? disciplinaryaction.user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Disciplinary Ground</th>
                                        <td>{{disciplinaryaction.grounds ? disciplinaryaction.grounds.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Issued Date</th>
                                        <td>{{disciplinaryaction.issued_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Issued By</th>
                                        <td>{{disciplinaryaction.isseudby ? disciplinaryaction.isseudby.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Previous Action (Any)</th>
                                        <td><p v-html="disciplinaryaction.previous"></p></td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td>
                                            <span v-html="disciplinaryaction.status" v-if="disciplinaryaction.termination === 0"></span>
                                            <span v-else-if="disciplinaryaction.termination === 1" class="badge bg-danger">Terminated</span>
                                            <span v-else class="badge bg-success">Hold</span>
                                        </td>
                                    </tr>
                                    <tr v-if="disciplinaryaction.justification_required == 1">
                                        <th>Justification </th>
                                        <td><span v-html="disciplinaryaction.justification_description"></span></td>
                                    </tr>
                                    <tr v-if="disciplinaryaction.justification_required == 1">
                                        <th>Justification Date</th>
                                        <td><span v-html="disciplinaryaction.justification_date"></span></td>
                                    </tr>
                                    <tr v-if="disciplinaryaction.suspension == 1">
                                        <th>Suspension Days </th>
                                        <td>{{disciplinaryaction.suspension_days}}</td>
                                    </tr>
                                    <tr v-if="disciplinaryaction.suspension == 2">
                                        <th>Penalty Charge</th>
                                        <td>{{disciplinaryaction.penalty_charge}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{disciplinaryaction.description}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
