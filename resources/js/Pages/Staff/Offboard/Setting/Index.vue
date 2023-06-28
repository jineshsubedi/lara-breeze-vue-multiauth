<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    offboardsettings: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.offboardsettings.destroy", id));
    }
}
</script>
<template>
    <Head title="OffboardSetting Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OffboardSetting
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.offboardsettings.index')" :only="['offboardsettings']"> OffboardSetting </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.offboardsettings.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New OffboardSetting
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">OffboardSetting</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Retirement</th>
                                <th scope="col">Retirement Alert</th>
                                <th scope="col">Retraction</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(offboardsetting, index) in offboardsettings.data"
                                :key="offboardsetting.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ offboardsetting.branch ? offboardsetting.branch.name : '' }}</td>
                                <td scope="row">{{ offboardsetting.retirement }}</td>
                                <td scope="row">{{ offboardsetting.retirement_alert }}</td>
                                <td scope="row">{{ offboardsetting.retraction }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.offboardsettings.edit', offboardsetting.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(offboardsetting.id)"
                                            v-if="SuperAdmin"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="offboardsettings.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
