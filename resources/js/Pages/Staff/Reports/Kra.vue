<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    kras: Object,
    auth: Boolean,
    userId: Number
});
const kradform = useForm();

const kraform = useForm({
    category: [],
});
function addCategory()
{
    kraform.category.push({'title' : '', 'weightage': ''});
}
function removeCategory(index)
{
    kraform.category.splice(index, 1)
}

function destroyKRA(id) {
    if (confirm("Are you sure you want to Delete")) {
        kradform.delete(route("staffs.kras.destroy", id), {
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
                    <div class="box-header">User's KRA</div>
                    <div class="box-body">
                    <form
                        class="form-horizontal"
                        @submit.prevent="
                            kraform.post(route('staffs.kras.store', userId), {preserveScroll: true, onSuccess: () => form.reset()})
                        "
                    >
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Weightage</th>
                                    <th v-if="auth">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(kra, krandex) in kras"
                                    :key="krandex"
                                >
                                    <th>{{ kra.title }}</th>
                                    <th>{{ kra.weightage }}</th>
                                    <th v-if="auth">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroyKRA(kra.id)"
                                        >
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </th>
                                </tr>
                                <tr v-for="(st, index) in kraform.category" :key="index">
                                    <td>
                                        <input type="text" v-model="kraform.category[index].title" class="form-control" placeholder="KRA title" required>
                                    </td>
                                    <td>
                                        <input type="number" v-model="kraform.category[index].weightage" class="form-control" placeholder="KRA Weightage" required>
                                    </td>
                                    <td v-if=auth>
                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot v-if=auth>
                                <tr>
                                    <td>
                                        <div colspan="4" class="text-danger" v-for="(kraform) in kraform.errors">
                                            {{kraform}}
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