<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    revenue: Object,
    divisions: Object
})

const form = useForm({
    division_id: props.revenue.division_id,
    revenue: props.revenue.revenue,
    direct_expenses: props.revenue.direct_expenses,
    indirect_expenses: props.revenue.indirect_expenses,
    net_profit: props.revenue.net_profit,
});

</script>
<template>
    <Head title="Revenue Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Revenue Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.revenues.index')"> Revenue </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.revenues.edit', revenue.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Revenue</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('admin.revenues.update', revenue.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="division_id"
                                        class="col-sm-2 col-form-label"
                                        >Division</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.division_id" class="form-control">
                                            <option v-for="(division, dindex) in divisions" :key="dindex" :value="division.id">{{division.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.division_id"
                                        >
                                            {{ form.errors.division_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="revenue"
                                        class="col-sm-2 col-form-label"
                                        >Revenue</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="revenue"
                                            placeholder="1500"
                                            v-model="form.revenue"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.revenue"
                                        >
                                            {{ form.errors.revenue }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="direct_expenses"
                                        class="col-sm-2 col-form-label"
                                        >Direct Expenses</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="direct_expenses"
                                            placeholder="1500"
                                            v-model="form.direct_expenses"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.direct_expenses"
                                        >
                                            {{ form.errors.direct_expenses }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="indirect_expenses"
                                        class="col-sm-2 col-form-label"
                                        >Indirect Expenses</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="indirect_expenses"
                                            placeholder="1500"
                                            v-model="form.indirect_expenses"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.indirect_expenses"
                                        >
                                            {{ form.errors.indirect_expenses }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="net_profit"
                                        class="col-sm-2 col-form-label"
                                        >Net Profit</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="net_profit"
                                            placeholder="1500"
                                            v-model="form.net_profit"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.net_profit"
                                        >
                                            {{ form.errors.net_profit }}
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
