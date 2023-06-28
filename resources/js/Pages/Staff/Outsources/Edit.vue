<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    outsource: Object,
    datas: Object
})

const form = useForm({
    project_name: props.outsource.project_name,
    client_name: props.outsource.client_name,
    contract_start: props.outsource.contract_start,
    contract_end: props.outsource.contract_end,
    manager: props.outsource.manager,
    supervisor: props.outsource.supervisor,
    status: props.outsource.status
});

</script>
<template>
    <Head title="Outsource Edit" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Outsource Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.outsources.index')"> Outsource </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.outsources.edit', outsource.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Outsource</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('staffs.outsources.update', outsource.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="project_name"
                                        class="col-sm-2 col-form-label"
                                        >Project Name</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="project_name"
                                            placeholder="project_name"
                                            v-model="form.project_name"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.project_name"
                                        >
                                            {{ form.errors.project_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="client_name"
                                        class="col-sm-2 col-form-label"
                                        >Client Name</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="client_name"
                                            placeholder="client_name"
                                            v-model="form.client_name"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.client_name"
                                        >
                                            {{ form.errors.client_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="contract_start"
                                        class="col-sm-2 col-form-label"
                                        >Contract Start</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="contract_start"
                                            placeholder="contract_start"
                                            v-model="form.contract_start"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.contract_start"
                                        >
                                            {{ form.errors.contract_start }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="contract_end"
                                        class="col-sm-2 col-form-label"
                                        >Contract End</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="contract_end"
                                            placeholder="contract_end"
                                            v-model="form.contract_end"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.contract_end"
                                        >
                                            {{ form.errors.contract_end }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="manager"
                                        class="col-sm-2 col-form-label"
                                        >Manager</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.manager" class="form-control">
                                            <option v-for="(staff, sindex) in datas.staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.manager"
                                        >
                                            {{ form.errors.manager }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="supervisor"
                                        class="col-sm-2 col-form-label"
                                        >Supervisor</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.supervisor" class="form-control">
                                            <option v-for="(staff, sindex) in datas.staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.supervisor"
                                        >
                                            {{ form.errors.supervisor }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="status"
                                        class="col-sm-2 col-form-label"
                                        >Status</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.status" class="form-control">
                                            <option v-for="(status, stindex) in datas.status" :key="stindex" :value="status">{{status}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.status"
                                        >
                                            {{ form.errors.status }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
