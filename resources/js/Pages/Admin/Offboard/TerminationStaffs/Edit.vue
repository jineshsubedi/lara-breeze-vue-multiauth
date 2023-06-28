<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    datas: Object,
    terminationstaff: Object
})

const form = useForm({
    user_id: props.terminationstaff.user_id,
    termination_type: props.terminationstaff.termination_type,
    termination_detail: props.terminationstaff.termination_detail,
    offBoarding_date: props.terminationstaff.offBoarding_date
});

</script>
<template>
    <Head title="Terminate Staff" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Terminate Staff
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.terminatestaffs.index')"> Terminate Staff </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.terminatestaffs.edit', terminationstaff.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Terminate Staff</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.terminatestaffs.update', terminationstaff.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="user_id"
                                        class="col-sm-2 col-form-label"
                                        >Staff</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.user_id" id="user_id" class="form-control">
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
                                        for="termination_type"
                                        class="col-sm-2 col-form-label"
                                        >Termination Type</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.termination_type" id="termination_type" class="form-control">
                                            <option v-for="(type, tindex) in datas.types" :key="tindex" :value="type.id">{{type.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.termination_type"
                                        >
                                            {{ form.errors.termination_type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="termination_detail"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea rows="3" v-model="form.termination_detail" class="form-control"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.termination_detail"
                                        >
                                            {{ form.errors.termination_detail }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="offBoarding_date"
                                        class="col-sm-2 col-form-label"
                                        >Offboarding Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="offBoarding_date"
                                            placeholder="offBoarding_date"
                                            v-model="form.offBoarding_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.offBoarding_date"
                                        >
                                            {{ form.errors.offBoarding_date }}
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
