<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    suggestions: {
        type: Object,
        default: () => ({}),
    },
    branches: Object,
    staffs: Object,
    categories: Object,
    defBranch: Number,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let HrHandler = props.can.includes('HrHandler');

let branch = ref(props.filters.branch_id);
let staff = ref(props.filters.staff);
let category = ref(props.filters.category);

function loadFilter()
{
    Inertia.get(
        route('supervisor.suggestions.index'),
        { branch: branch.value, staff: staff.value, category: category.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.suggestions.destroy", id));
    }
}
</script>
<template>
    <Head title="Suggestion Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suggestion
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.suggestions.index')" :only="['suggestions']"> Suggestion </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right" v-if="!SuperAdmin">
                <Link :href="route('supervisor.suggestions.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add Suggestion
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Suggestion</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col" v-if="(SuperAdmin || HrHandler)">Staff</th>
                                <th scope="col">Category</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td v-if="SuperAdmin">
                                    <select v-model="branch" class="form-control" @change="loadFilter" >
                                        <option value="">Select Branch</option>
                                        <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </td>
                                <td v-if="(SuperAdmin || HrHandler)">
                                    <select v-model="staff" class="form-control" @change="loadFilter" >
                                        <option value="">Select Staff</option>
                                        <option v-for="(staff, sindex) in staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="category" class="form-control" @change="loadFilter" >
                                        <option value="">Select Cateogy</option>
                                        <option v-for="(category, cindex) in categories" :key="cindex" :value="category.id">{{category.title}}</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(suggest, index) in suggestions.data"
                                :key="suggest.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ suggest.branch ? suggest.branch.name : '' }}</td>
                                <td scope="row" v-if="(SuperAdmin || HrHandler)"><span v-if="suggest.hide_name == 0">{{ suggest.user ? suggest.user.name : '' }}</span><span class="text-muted" v-else>hidden</span></td>
                                <td scope="row">{{ suggest.suggestion_for ? suggest.suggestion_for.title : '' }}</td>
                                <td scope="row">{{ suggest.request_date }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('supervisor.suggestions.show', suggest.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i> <span class="badge bg-danger">{{suggest.suggestion_reply_count}}</span>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(suggest.id)"
                                            v-if="(suggest.user_id == $page.props.auth.user.id && suggest.suggestion_reply_count < 1)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="suggestions.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
