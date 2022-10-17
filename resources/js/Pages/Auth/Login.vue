<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import LoginLayout from '@/Layouts/LoginLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <LoginLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="row g-3 needs-validation">
            
            <div class="col-12">
                <InputLabel for="email" class="form-label" value="Email" />
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-at"></i></span>
                    <TextInput id="email" type="email" v-model="form.email" required autofocus autocomplete="username" class="form-control" />
                    <InputError class="mt-2 invalid-feedback" :message="form.errors.email" />
                </div>
            </div>
            <div class="col-12">
                <InputLabel for="password" class="form-label border-info" value="Password" />
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-key"></i></span>
                    <TextInput id="password" type="password" v-model="form.password" required autocomplete="username" class="form-control" />
                    <InputError class="mt-2 invalid-feedback" :message="form.errors.password" />
                </div>
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </LoginLayout>
</template>
<style>
    .input-group-text{
        color: #fff;
        background-color: cadetblue;
        font-size: large;
        border: cadetblue;
    }
    .form-label{
        color: cadetblue;
        font-size: medium;
    }

</style>