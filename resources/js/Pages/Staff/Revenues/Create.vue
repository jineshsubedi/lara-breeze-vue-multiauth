<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    divisions: Object
})

const form = useForm({
    category: [{'revenue' : '', 'direct_expenses': '', 'indirect_expenses': '', 'net_profit': '', 'division_id': ''}],
});
function addCategory()
{
    form.category.push({'revenue' : '', 'direct_expenses': '', 'indirect_expenses': '', 'net_profit': '', 'division_id': ''});
}
function removeCategory(index)
{
    form.category.splice(index, 1)
}

</script>
<template>
    <Head title="Revenue Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Revenue Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.revenues.index')"> Revenue </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.revenues.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Revenue</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.revenues.store'))
                                "
                            >
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Division</th>
                                            <th>Revenue</th>
                                            <th>Direct Expenses</th>
                                            <th>InDirect Expenses</th>
                                            <th>Net Profit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.category" :key="index">
                                            <td>
                                                <select v-model="form.category[index].division_id" class="form-control" @change="loadFilter" required>
                                                <option v-for="(division, dindex) in divisions" :key="dindex" :value="division.id">{{division.title}}</option>
                                            </select>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.category[index].revenue" class="form-control" placeholder="Revenue" required>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.category[index].direct_expenses" class="form-control" placeholder="Direct Expenses" required>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.category[index].indirect_expenses" class="form-control" placeholder="Indirect Expenses" required>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.category[index].net_profit" class="form-control" placeholder="Net Profit" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div class="text-danger" v-for="(form) in form.errors">
                                                    {{form}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addCategory"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
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
