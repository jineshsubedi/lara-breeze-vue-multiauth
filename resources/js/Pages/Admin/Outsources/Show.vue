<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    outsource: Object
})

</script>
<template>
    <Head title="Outsource Information" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Outsource Information
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
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.outsources.show', outsource.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Outsource Information</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Project Detail:</h4>
                                    <table class="table table-bordered">
                                        <tbody> 
                                            <tr>
                                                <th>Name of the Project:</th>
                                                <td>{{outsource.project_name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Client Name:</th>
                                                <td>{{outsource.client_name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Project Manager:</th>
                                                <td>{{outsource.manager_person ? outsource.manager_person.name : ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Project Supervisor:</th>
                                                <td>{{outsource.supervisor_person ? outsource.supervisor_person.name : ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td>{{outsource.status}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <h4>Contract Detail:</h4>
                                    <table class="table table-bordered">
                                        <tbody> 
                                            <tr>
                                                <th>Start Date:</th>
                                                <td>{{outsource.contract_start}}</td>
                                            </tr>
                                            <tr>
                                                <th>End Date:</th>
                                                <td>{{outsource.contract_end}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <h4>Staff Detail:</h4>
                                    <table class="table table-bordered">
                                        <tbody> 
                                            <tr>
                                                <th>Active</th>
                                                <td>{{outsource.contract_start}}</td>
                                            </tr>
                                            <tr>
                                                <th>Resigned:</th>  
                                                <td>{{outsource.contract_end}}</td>
                                            </tr>
                                            <tr>
                                                <th>Abscond:</th>  
                                                <td>{{outsource.contract_end}}</td>
                                            </tr>
                                            <tr>
                                                <th>Terminate:</th>  
                                                <td>{{outsource.contract_end}}</td>
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
