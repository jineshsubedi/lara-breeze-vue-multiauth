<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    branch: Object,
    provinces: Object,
    yn: Object,
});

const form = useForm({
    name: props.branch.name,
    email: props.branch.email,
    description: props.branch.description,
    province_id: props.branch.province_id,
    district_id: props.branch.district_id,
    is_head: props.branch.is_head,
    login_ip: props.branch.login_ip
});

let districts = ref([]);
getDistrict()
function getDistrict()
{
    axios.get(route('getDistrict'), {
        params: {
            province: form.province_id
        }
    })
    .then(res => {
        districts.value = ref(res.data)
    }).catch(err => {
        console.log(err)
    })
}

</script>
<template>
    <Head title="Branch Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Branch Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.branches.index')"> Branch </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.branches.edit', branch.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Branch</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.branches.update', branch.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="inputName"
                                        class="col-sm-2 col-form-label"
                                        >Title/Name</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="inputName"
                                            placeholder="Branch Title"
                                            v-model="form.name"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.name"
                                        >
                                            {{ form.errors.name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="inputEmail"
                                        class="col-sm-2 col-form-label"
                                        >Email</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="inputEmail"
                                            placeholder="Branch Email"
                                            v-model="form.email"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.email"
                                        >
                                            {{ form.errors.email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="description"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea id="description" v-model="form.description" rows="5" class="form-control"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="province"
                                        class="col-sm-2 col-form-label"
                                        >Province</label
                                    >
                                    <div class="col-sm-10">
                                        <select id="province" v-model="form.province_id" class="form-control" @change="getDistrict">
                                            <option v-for="(province, index) in provinces" :key="index" :value="province.id">{{province.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.province_id"
                                        >
                                            {{ form.errors.province_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="district"
                                        class="col-sm-2 col-form-label"
                                        >District</label
                                    >
                                    <div class="col-sm-10">
                                        <select id="district" v-model="form.district_id" class="form-control">
                                            <option v-for="(district, index) in districts.value" :key="index" :value="district.id">{{district.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.district_id"
                                        >
                                            {{ form.errors.district_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="is_head"
                                        class="col-sm-2 col-form-label"
                                        >Is Head Office</label
                                    >
                                    <div class="col-sm-10">
                                        <select id="is_head" v-model="form.is_head" class="form-control">
                                            <option v-for="(yen, index) in yn" :key="index" :value="yen.value">{{yen.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.is_head"
                                        >
                                            {{ form.errors.is_head }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="login_ip"
                                        class="col-sm-2 col-form-label"
                                        >Login IP</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="login_ip"
                                            placeholder="192.168.1.1,192.168.1.2"
                                            v-model="form.login_ip"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.login_ip"
                                        >
                                            {{ form.errors.login_ip }}
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
