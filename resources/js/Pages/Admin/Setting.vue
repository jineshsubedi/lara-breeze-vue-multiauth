<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Browser1 from "@/Components/Browser.vue";
import { ref } from "vue";

const props = defineProps({
    setting: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    logo: props.setting.logo,
    icon: props.setting.icon,
    name: props.setting.name,
    email: props.setting.email,
    phone: props.setting.phone,
    address: props.setting.address,
    item_perpage: props.setting.item_perpage,
    description_limit: props.setting.description_limit,
    google_analytics: props.setting.google_analytics,
    latitude: props.setting.latitude,
    longitude: props.setting.longitude,
    meta_title: props.setting.meta_title,
    meta_keyword: props.setting.meta_keyword,
    meta_description: props.setting.meta_description,

    protocal: props.setting.emails.protocal,
    parameter: props.setting.emails.parameter,
    host_name: props.setting.emails.host_name,
    username: props.setting.emails.username,
    password: props.setting.emails.password,
    encryption: props.setting.emails.encryption,
    smtp_port: props.setting.emails.smtp_port,

    socials: props.setting.socials
});
let logo_path = ref(props.setting.logo_path)
let icon_path = ref(props.setting.icon_path)

function addMoreSocial()
{
    let media = 
        {
            'name' : '',
            'icon' : '',
            'url' : '',
        }
    form.socials.push(media);
}
function removeSocial(index)
{
    form.socials.splice(index, 1)
}

function changeImage1(data) {
    logo_path = data.placeholder_img;
    form.logo = data.placeholder_img_path;
    $("#logo_path_browser").modal('hide');
}
function changeImage2(data) {
    icon_path = data.placeholder_img;
    form.icon = data.placeholder_img_path;
    $("#icon_path_browser").modal('hide');
}
function openModel(path) {
    $("#"+path).modal('show');
}
</script>
<template>
    <Head title="Setting Update" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Setting
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.setting.index')"> Setting </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-0 border-bottom-0">
                            <ul
                                class="nav nav-tabs"
                                id="custom-tabs-four-tab"
                                role="tablist"
                            >
                                <li class="nav-item">
                                    <a
                                        class="nav-link active"
                                        id="custom-tabs-four-home-tab"
                                        data-bs-toggle="pill"
                                        href="#custom-tabs-four-home"
                                        role="tab"
                                        aria-controls="custom-tabs-four-home"
                                        aria-selected="true"
                                        >Detail</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link"
                                        id="custom-tabs-four-profile-tab"
                                        data-bs-toggle="pill"
                                        href="#custom-tabs-four-profile"
                                        role="tab"
                                        aria-controls="custom-tabs-four-profile"
                                        aria-selected="false"
                                        >Email</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link"
                                        id="custom-tabs-four-messages-tab"
                                        data-bs-toggle="pill"
                                        href="#custom-tabs-four-messages"
                                        role="tab"
                                        aria-controls="custom-tabs-four-messages"
                                        aria-selected="false"
                                        >Social</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <form
                            class="form-horizontal"
                            @submit.prevent="
                                form.put(
                                    route('admin.setting.update', setting.id)
                                )
                            "
                        >
                        <div class="card-body">
                                <div
                                    class="tab-content"
                                    id="custom-tabs-four-tabContent"
                                >
                                    <div
                                        class="tab-pane fade active show"
                                        id="custom-tabs-four-home"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-four-home-tab"
                                    >
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputName"
                                                    class="col-form-label required"
                                                    >Site name</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputName"
                                                    placeholder="Website Name"
                                                    v-model="form.name"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.name"
                                                >
                                                    {{ form.errors.name }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputEmail"
                                                    class="col-form-label required"
                                                    >Email</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputEmail"
                                                    placeholder="Category Title"
                                                    v-model="form.email"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.email"
                                                >
                                                    {{ form.errors.email }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputPhone"
                                                    class="col-form-label"
                                                    >Phone</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputPhone"
                                                    placeholder="Phone"
                                                    v-model="form.phone"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.phone"
                                                >
                                                    {{ form.errors.phone }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputAddress"
                                                    class="col-form-label"
                                                    >Address</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputAddress"
                                                    placeholder="Address"
                                                    v-model="form.address"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.address"
                                                >
                                                    {{ form.errors.address }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label
                                                    for="inputItem"
                                                    class="col-form-label"
                                                    >Item Per Page</label
                                                >
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="inputItem"
                                                    placeholder="Items"
                                                    v-model="form.item_perpage"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.item_perpage"
                                                >
                                                    {{ form.errors.item_perpage }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label
                                                    for="inputDescriptionLimit"
                                                    class="col-form-label"
                                                    >Description limit</label
                                                >
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="inputDescriptionLimit"
                                                    placeholder="Limit char"
                                                    v-model="form.description_limit"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.description_limit"
                                                >
                                                    {{ form.errors.description_limit }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label
                                                    for="inputLatitude"
                                                    class="col-form-label"
                                                    >Latitude</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputLatitude"
                                                    placeholder="Latitude"
                                                    v-model="form.latitude"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.latitude"
                                                >
                                                    {{ form.errors.latitude }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label
                                                    for="inputLongitude"
                                                    class="col-form-label"
                                                    >Longitude</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputLongitude"
                                                    placeholder="Longitude"
                                                    v-model="form.longitude"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.longitude"
                                                >
                                                    {{ form.errors.longitude }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label
                                                    for="inputMetaTitle"
                                                    class="col-form-label"
                                                    >MetaTitle</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputMetaTitle"
                                                    placeholder="MetaTitle"
                                                    v-model="form.meta_title"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.meta_title"
                                                >
                                                    {{ form.errors.meta_title }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label
                                                    for="inputMetaKeyword"
                                                    class="col-form-label"
                                                    >MetaKeyword</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputMetaKeyword"
                                                    placeholder="MetaKeyword"
                                                    v-model="form.meta_keyword"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.meta_keyword"
                                                >
                                                    {{ form.errors.meta_keyword }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label
                                                    for="inputMetaDescription"
                                                    class="col-form-label"
                                                    >Meta Description</label
                                                >
                                                <textarea
                                                    v-model="form.meta_description"
                                                    id="inputMetaDescription"
                                                    class="form-control"
                                                    cols="5"
                                                ></textarea>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.meta_description"
                                                >
                                                    {{ form.errors.meta_description }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label
                                                    for="inputAnalytics"
                                                    class="col-form-label"
                                                    >Google Analytics</label
                                                >
                                                <textarea v-model="form.google_analytics" id="inputAnalytics" cols="5" class="form-control"></textarea>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.google_analytics"
                                                >
                                                    {{ form.errors.google_analytics }}
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputLogo"
                                                    class="col-form-label required"
                                                    >Logo</label
                                                >
                                                <input
                                                    type="input"
                                                    class="form-control"
                                                    id="inputLogo"
                                                    v-model="form.logo"
                                                    style="display:none;"
                                                />
                                                <img :src="logo_path" alt="" style="border:1px solid #dcdcff" @click="openModel('logo_path_browser')">
                                                <div>
                                                    <Browser1 
                                                        v-model="logo_path"
                                                        v-on:changeImage="changeImage1"
                                                        browserId="logo_path_browser"
                                                        :deleteFolder=true
                                                        :createFolder=true
                                                        :deleteFiles=true
                                                        :createFiles=true
                                                    />
                                                </div>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.logo"
                                                >
                                                    {{ form.errors.logo }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputIcon"
                                                    class="col-form-label required"
                                                    >Icon</label
                                                >
                                                <input
                                                    type="input"
                                                    class="form-control"
                                                    id="inputIcon"
                                                    v-model="form.icon"
                                                    style="display:none;"
                                                />
                                                <img :src="icon_path" alt="" style="border:1px solid #dcdcff" @click="openModel('icon_path_browser')">
                                                <div>
                                                    <Browser1 
                                                        v-model="icon_path"
                                                        v-on:changeImage="changeImage2"
                                                        browserId="icon_path_browser"
                                                        :deleteFolder=true
                                                        :createFolder=true
                                                        :deleteFiles=true
                                                        :createFiles=true
                                                    />
                                                </div>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.icon"
                                                >
                                                    {{ form.errors.icon }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="tab-pane fade"
                                        id="custom-tabs-four-profile"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-four-profile-tab"
                                    >
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputProtocal"
                                                    class="col-form-label required"
                                                    >Protocal</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputProtocal"
                                                    placeholder="Protocal"
                                                    v-model="form.protocal"
                                                    disabled
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.protocal"
                                                >
                                                    {{ form.errors.protocal }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputParameter"
                                                    class="col-form-label required"
                                                    >Parameter</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputParameter"
                                                    placeholder="parameter"
                                                    v-model="form.parameter"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.parameter"
                                                >
                                                    {{ form.errors.parameter }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputHostName"
                                                    class="col-form-label required"
                                                    >Host Name</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputHostName"
                                                    placeholder="HostName"
                                                    v-model="form.host_name"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.host_name"
                                                >
                                                    {{ form.errors.host_name }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputUsername"
                                                    class="col-form-label required"
                                                    >Username</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputUsername"
                                                    placeholder="Username"
                                                    v-model="form.username"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.username"
                                                >
                                                    {{ form.errors.username }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputPassword"
                                                    class="col-form-label required"
                                                    >Password</label
                                                >
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="inputPassword"
                                                    placeholder="Password"
                                                    v-model="form.password"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.password"
                                                >
                                                    {{ form.errors.password }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputPort"
                                                    class="col-form-label required"
                                                    >Port</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputPort"
                                                    placeholder="Port"
                                                    v-model="form.smtp_port"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.smtp_port"
                                                >
                                                    {{ form.errors.smtp_port }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label
                                                    for="inputEncryption"
                                                    class="col-form-label required"
                                                    >Encryption</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="inputEncryption"
                                                    placeholder="Encryption"
                                                    v-model="form.encryption"
                                                />
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.encryption"
                                                >
                                                    {{ form.errors.encryption }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="tab-pane fade"
                                        id="custom-tabs-four-messages"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-four-messages-tab"
                                    >
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Icon</th>
                                                    <th>Url</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(social, index) in form.socials" :key="index">
                                                    <td>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="SocialName"
                                                            v-model="form.socials[index].name"
                                                            required
                                                        />
                                                    </td>
                                                    <td>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="SocialIcon"
                                                            v-model="form.socials[index].icon"
                                                            required
                                                        />
                                                    </td>
                                                    <td>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="SocialUrl"
                                                            v-model="form.socials[index].url"
                                                            required
                                                        />
                                                    </td>
                                                    <td><button type="button" class="btn btn-outline-danger" @click="removeSocial(index)"><i class="bi bi-trash-fill"></i></button></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td><span class="mute"><a href="https://fontawesome.com/v5/search" target="_blank">Icon Code</a></span></td>
                                                    <td colspan="3" class="text-right">
                                                        <button type="button" class="btn bg-info btn-sm" @click="addMoreSocial">Add More</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group text-center">
                                <button
                                    type="submit"
                                    class="btn btn-outline-primary btn-sm"
                                >
                                    Update
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
