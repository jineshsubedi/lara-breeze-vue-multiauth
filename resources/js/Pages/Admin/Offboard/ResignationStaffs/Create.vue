<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    datas: Object,
})

const form = useForm({
    user_id: null,
    resignation_reason_id: null,
    resignation_type_id: null,
    resignation_detail: null,
});

</script>
<template>
    <Head title="ResignationStaff Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ResignationStaff Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.resignationstaffs.index')"> ResignationStaff </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.resignationstaffs.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New ResignationStaff</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.resignationstaffs.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="user_id"
                                        class="col-sm-2 col-form-label"
                                        >Staff</label
                                    >
                                    <div class="col-sm-10">
                                        <select class="form-control" v-model="form.user_id" id="user_id">
                                            <option v-for="(staff, sindex) in datas.staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.user_id"
                                        >
                                            {{ form.errors.user_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="resignation_reason_id"
                                        class="col-sm-2 col-form-label"
                                        >Resignation Reason</label
                                    >
                                    <div class="col-sm-10">
                                        <select class="form-control" v-model="form.resignation_reason_id" id="resignation_reason_id">
                                            <option v-for="(reason, rindex) in datas.reasons" :key="rindex" :value="reason.id">{{reason.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.resignation_reason_id"
                                        >
                                            {{ form.errors.resignation_reason_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="resignation_type_id"
                                        class="col-sm-2 col-form-label"
                                        >Resignation Type</label
                                    >
                                    <div class="col-sm-10">
                                        <select class="form-control" v-model="form.resignation_type_id" id="resignation_type_id">
                                            <option v-for="(type, tindex) in datas.types" :key="tindex" :value="type.id">{{type.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.resignation_type_id"
                                        >
                                            {{ form.errors.resignation_type_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="resignation_detail"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10"> 
                                        <textarea rows="3" v-model="form.resignation_detail" class="form-control" id="resignation_detail"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.resignation_detail"
                                        >
                                            {{ form.errors.resignation_detail }}
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
