<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    resignationstaff: Object,
    datas: Object
})

const form = useForm({
    user_id: props.resignationstaff.user_id,
    resignation_reason_id: props.resignationstaff.resignation_reason_id,
    resignation_type_id: props.resignationstaff.resignation_type_id,
    resignation_detail: props.resignationstaff.resignation_detail,
});

</script>
<template>
    <Head title="ResignationStaff Edit" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ResignationStaff Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.resignationstaffs.index')"> ResignationStaff </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.resignationstaffs.edit', resignationstaff.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit ResignationStaff</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('staffs.resignationstaffs.update', resignationstaff.id))
                                "
                            >
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
    </StaffLayout>
</template>
