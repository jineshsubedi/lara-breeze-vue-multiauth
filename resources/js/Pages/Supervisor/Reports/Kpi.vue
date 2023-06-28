<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    kpis: Object,
    auth: Boolean,
    userId: Number
});
const kpidform = useForm();

const kpiform = useForm({
    category: [],
});
function addCategory()
{
    kpiform.category.push({'title' : ''});
}
function removeCategory(index)
{
    kpiform.category.splice(index, 1)
}

function destroyKPI(id) {
    if (confirm("Are you sure you want to Delete")) {
        kpidform.delete(route("supervisor.kpis.destroy", id) , {
            preserveScroll: true
        });
    }
}

</script>

<template>
    <div>
        <div class="mt-3 row">
            <div class="col-xl-12">
                <div class="box">
                    <div class="box-header">User's KPI</div>
                    <div class="box-body">
                    <form
                        class="form-horizontal"
                        @submit.prevent="
                            kpiform.post(route('supervisor.kpis.store', userId), {preserveScroll: true, onSuccess: () => form.reset()})
                        "
                    >
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>First Quarter</th>
                                    <th>Second Quarter</th>
                                    <th>Third Quarter</th>
                                    <th>Fourth Quarter</th>
                                    <th v-if="auth">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(kpi, kpindex) in kpis"
                                    :key="kpindex"
                                >
                                    <th>{{ kpi.title }}</th>
                                    <th>{{ kpi.first_quearter }}</th>
                                    <th>{{ kpi.second_quearter }}</th>
                                    <th>{{ kpi.third_quearter }}</th>
                                    <th>{{ kpi.fourth_quearter }}</th>
                                    <th v-if="auth">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroyKPI(kpi.id)"
                                        >
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </th>
                                </tr>
                                <tr v-for="(st, index) in kpiform.category" :key="index">
                                    <td colspan="5">
                                        <input type="text" v-model="kpiform.category[index].title" class="form-control" placeholder="Category title" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot v-if=auth>
                                <tr>
                                    <td colspan="5">
                                        <div class="text-danger" v-for="(kpiform) in kpiform.errors">
                                            {{kpiform}}
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-sm btn-outline-primary" @click="addCategory"><i class="bi bi-plus"></i>  Add More</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <div class="form-group row mb-3" v-if=auth>
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
</template>
<style scoped>
thead,
tbody {
    font-size: 13px;
}
.box{border: 1px solid #ededed; margin:0px; padding:0px;}
.box-header{
    background-color: #8484b3;
    color: #fff;
    padding: 4px 5px;
}
</style>