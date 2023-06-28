<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    leaveType: {
        type: Object,
        default: () => ({}),
    },
    datas: Object
});

const form = useForm({
    title: props.leaveType.title,
    days: props.leaveType.days,
    apply_before: props.leaveType.apply_before,
    eligible: props.leaveType.eligible,
    continuous: props.leaveType.continuous,
    accrual: props.leaveType.accrual,
    accrual_basis: props.leaveType.accrual_basis,
    is_extra: props.leaveType.is_extra,
});

</script>
<template>
    <Head title="Leave Type Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Type Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.leave_types.index')"> Leave Type </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leave_types.edit', leaveType.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Leave Types</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.leave_types.update', leaveType.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="title"
                                        class="col-sm-2 col-form-label"
                                        >Title</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            placeholder="Role Title"
                                            v-model="form.title"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.title"
                                        >
                                            {{ form.errors.title }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="days"
                                        class="col-sm-2 col-form-label"
                                        >Days</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            id="days"
                                            placeholder="Days"
                                            v-model="form.days"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.days"
                                        >
                                            {{ form.errors.days }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="apply_before"
                                        class="col-sm-2 col-form-label"
                                        >Apply Before</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            id="apply_before"
                                            placeholder="Apply Before"
                                            v-model="form.apply_before"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.apply_before"
                                        >
                                            {{ form.errors.apply_before }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="eligible"
                                        class="col-sm-2 col-form-label"
                                        >Eligible (Months)</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            id="eligible"
                                            placeholder="Eligible"
                                            v-model="form.eligible"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.eligible"
                                        >
                                            {{ form.errors.eligible }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="continuous"
                                        class="col-sm-2 col-form-label"
                                        >Continious (days)</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            id="continuous"
                                            placeholder="Continious (days)"
                                            v-model="form.continuous"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.continuous"
                                        >
                                            {{ form.errors.continuous }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="accrual_basis"
                                        class="col-sm-2 col-form-label"
                                        >Accrual Basis</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.accrual_basis" id="accrual_basis" class="form-control">
                                            <option v-for="(accrual, index) in datas.accrual" :key="index" :value="accrual.value">{{accrual.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.accrual_basis"
                                        >
                                            {{ form.errors.accrual_basis }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row mb-3">
                                    <label
                                        for="accrual"
                                        class="col-sm-2 col-form-label"
                                        >Accrual</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            id="accrual"
                                            placeholder="Accrual"
                                            v-model="form.accrual"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.accrual"
                                        >
                                            {{ form.errors.accrual }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label
                                        for="is_extra"
                                        class="col-sm-2 col-form-label"
                                        >Extra</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.is_extra" id="is_extra" class="form-control">
                                            <option v-for="(extra, index) in datas.extra" :key="index" :value="extra.value">{{extra.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.is_extra"
                                        >
                                            {{ form.errors.is_extra }}
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
    </AdminLayout>
</template>
