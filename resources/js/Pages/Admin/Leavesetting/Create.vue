<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    branches: Object,
    datas: Object,
})
const form = useForm({
    branch_id: 0,
    quarter_day : 0,
    half_day : 0,
    sandwich : 0,
    handover : 0,
    s_approval : 0,
    h_approval : 0,
    m_approval : 0,
    accrual_basis : 0,
    hr_person : 0,
    m_person : 0,
    leave_handler : 0,
    maximum_leave : 0,
});
let staffs = ref([]);
function getStaffs()
{
    axios.post(route('getStaffsByBranch'), 
        {
            branch: form.branch_id
        }
    )
    .then(res => {
        staffs.value = ref(res.data)
    }).catch(err => {
        console.log(err)
    })
}
</script>
<template>
    <Head title="Leave Setting Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Setting Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.leave_setting.index')"> Leave Setting </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leave_setting.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Leave Setting</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.leave_setting.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="branch_id"
                                        class="col-sm-2 col-form-label"
                                        >Branch</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.branch_id" id="branch_id" class="form-control" @change="getStaffs" required>
                                            <option v-for="(branch, index) in branches" :key="index" :value="branch.id">{{branch.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.branch_id"
                                        >
                                            {{ form.errors.branch_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="quarter_day"
                                        class="col-sm-2 col-form-label"
                                        >Quarter Day</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.quarter_day" id="quarter_day" class="form-control">
                                            <option v-for="(allow, index) in datas.allow" :key="index" :value="allow.value">{{allow.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.quarter_day"
                                        >
                                            {{ form.errors.quarter_day }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="half_day"
                                        class="col-sm-2 col-form-label"
                                        >Half</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.half_day" id="half_day" class="form-control">
                                            <option v-for="(allow, index) in datas.allow" :key="index" :value="allow.value">{{allow.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.half_day"
                                        >
                                            {{ form.errors.half_day }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="sandwich"
                                        class="col-sm-2 col-form-label"
                                        >Sandwich</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.sandwich" id="sandwich" class="form-control">
                                            <option v-for="(allow, index) in datas.allow" :key="index" :value="allow.value">{{allow.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.sandwich"
                                        >
                                            {{ form.errors.sandwich }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="handover"
                                        class="col-sm-2 col-form-label"
                                        >Handover</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.handover" id="handover" class="form-control">
                                            <option v-for="(required, index) in datas.required" :key="index" :value="required.value">{{required.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.handover"
                                        >
                                            {{ form.errors.handover }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="s_approval"
                                        class="col-sm-2 col-form-label"
                                        >Supervisor Approval</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.s_approval" id="s_approval" class="form-control">
                                            <option v-for="(required, index) in datas.required" :key="index" :value="required.value">{{required.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.s_approval"
                                        >
                                            {{ form.errors.s_approval }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="h_approval"
                                        class="col-sm-2 col-form-label"
                                        >HR Approval</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.h_approval" id="h_approval" class="form-control">
                                            <option v-for="(required, index) in datas.required" :key="index" :value="required.value">{{required.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.h_approval"
                                        >
                                            {{ form.errors.h_approval }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="m_approval"
                                        class="col-sm-2 col-form-label"
                                        >Manager Approval</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.m_approval" id="m_approval" class="form-control">
                                            <option v-for="(required, index) in datas.required" :key="index" :value="required.value">{{required.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.m_approval"
                                        >
                                            {{ form.errors.m_approval }}
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
                                        for="hr_person"
                                        class="col-sm-2 col-form-label"
                                        >HR Person</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.hr_person" id="hr_person" class="form-control">
                                            <option v-for="(staff, index) in staffs.value" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.hr_person"
                                        >
                                            {{ form.errors.hr_person }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="m_person"
                                        class="col-sm-2 col-form-label"
                                        >Manager Person</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.m_person" id="m_person" class="form-control">
                                            <option v-for="(staff, index) in staffs.value" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.m_person"
                                        >
                                            {{ form.errors.m_person }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="leave_handler"
                                        class="col-sm-2 col-form-label"
                                        >Leave Handler</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.leave_handler" id="leave_handler" class="form-control">
                                            <option v-for="(staff, index) in staffs.value" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.leave_handler"
                                        >
                                            {{ form.errors.leave_handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="maximum_leave"
                                        class="col-sm-2 col-form-label"
                                        >Maximum Leave</label
                                    >
                                    <div class="col-sm-10">
                                        <input type="number" min="0" v-model="form.maximum_leave" id="maximum_leave" class="form-control">
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.maximum_leave"
                                        >
                                            {{ form.errors.maximum_leave }}
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
