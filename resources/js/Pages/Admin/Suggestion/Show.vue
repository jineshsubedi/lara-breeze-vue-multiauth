<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import moment from 'moment';

const props = defineProps({
    suggestion : Object,
})

const form = useForm({
    description: null,
});
function humanTime(value)
{
    return moment(value).fromNow();
}

function submitForm()
{
    form.put(route('admin.suggestions.update', props.suggestion.id), {
        description: form.description,
    })
    form.reset();
}
</script>
<template>
    <Head title="Suggestion Detail" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suggestion Detail
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.suggestions.index')"> Suggestion </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.suggestions.show', suggestion.id)"> Show </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Suggestion Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Branch</th>
                                        <td>{{suggestion.branch ? suggestion.branch.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Suggestion By</th>
                                        <td v-if="suggestion.hide_name == 0">{{suggestion.user ? suggestion.user.name : ''}}</td>    <td v-else></td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ suggestion.suggestion_for ? suggestion.suggestion_for.title : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{suggestion.request_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{suggestion.description}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{suggestion.suggestion_reply.length}} Suggestion Replies </h3>
                            <div class="chat_container">
                                <div class="chatme" v-for="(suggest, index) in suggestion.suggestion_reply">
                                    <div v-if="suggest.user_id == $page.props.auth.user.id">
                                        <p class="text-right" v-html="suggest.description"></p>
                                        <p class="text-right text-muted">{{suggest.user.name}}</p>
                                        <p class="text-right text-muted">{{humanTime(suggest.created_at)}}</p>
                                    </div>
                                    <div v-else>
                                        <p class="text-left" v-html="suggest.description"></p>
                                        <p class="text-left text-muted">{{suggest.user.name}}</p>
                                        <p class="text-left text-muted">{{humanTime(suggest.created_at)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form
                            class="form-horizontal"
                            @submit.prevent="
                                submitForm
                            "
                        >
                            <div class="card-footer">
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <textarea v-model="form.description" id="description" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<style scoped>
    .chat_container {
        min-height: 200px;
        overflow-y: scroll;
        background: aliceblue;
        max-height: 300px;
    }
    .img-circle{
        width: 50px;
        height: auto;
        border-radius: 50%;
        border: 1px solid blue;
    }
    .chatme{
        margin: 10px;
        border: 1px solid #e5edf3;
        padding: 10px;
        text-align: justify;
        background: #fff;
    }
</style>