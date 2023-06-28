<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    dailytask : Object,
})

const form = useForm({
    estimated_duration: props.dailytask.estimated_duration,
});

function approveBtn()
{
    if (confirm("Are you sure you want to Approve")) {
        form.post(route("staffs.dailytasks.approveById", props.dailytask.id));
    }
}

</script>
<template>
    <Head title="Daily Task" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daily Task
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dailytasks.index')"> Daily Task </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.dailytasks.show', dailytask.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daily Task</h5>
                            <div class="text-right" v-if="dailytask.status == '0'">
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#todayTaskModal" @click="approveBtn"><i class="bi bi-check2"></i> Approve</button>
                            </div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Staff</th>
                                        <td>{{dailytask.user ? dailytask.user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Kra</th>
                                        <td>{{dailytask.kra ? dailytask.kra.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>From</th>
                                        <td>{{dailytask.start_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>To</th>
                                        <td>{{dailytask.end_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>Duration</th>
                                        <td>{{dailytask.duration}} Min</td>
                                    </tr>
                                    <tr>
                                        <th>Estimated Duration</th>
                                        <td v-if="dailytask.status == '0'"><input type="number" v-model="form.estimated_duration"></td>
                                        <td v-else>{{dailytask.estimated_duration}} Min</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{dailytask.status == 1 ? 'Approved' : 'Pending'}}</td>
                                    </tr>
                                    <tr>
                                        <th>description</th>
                                        <td><p v-html="dailytask.description"></p></td>
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
