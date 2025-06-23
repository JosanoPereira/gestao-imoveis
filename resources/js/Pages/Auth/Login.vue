<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import {Link, useForm} from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthLayout>
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="card col-md-7 p-4 mb-0">
            <div class="card-body">
                <h1>Login</h1>
                <p class="text-body-secondary mb-3">Sign In to your account</p>
                <form @submit.prevent="submit">
                    <div class="">
                        <div class="input-group mb-3"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="/coreui/icons/sprites/free.svg#cil-user"></use>
                      </svg></span>
                            <input class="form-control" type="email" v-model="form.email" required autofocus
                                   placeholder="Email">
                        </div>
                        <InputError class="mt-0 mb-2" :message="form.errors.email"/>
                    </div>

                    <div class="">
                        <div class="input-group mb-4"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="/coreui/icons/sprites/free.svg#cil-lock-locked"></use>
                      </svg></span>
                            <input class="form-control" type="password" placeholder="Password" v-model="form.password"
                                   required
                                   autocomplete="current-password">
                        </div>
                        <InputError class="mt-0 mb-2" :message="form.errors.password"/>
                    </div>

                    <div class="input-group mb-4">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember"/>
                            <span class="ms-2 text-sm text-gray-600"
                            >Remember me</span
                            >
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary px-4" type="submit"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">Login
                            </button>
                        </div>
                        <div class="col-6 text-end">
                            <Link v-if="canResetPassword"
                                  :href="route('password.request')" class="btn btn-link px-0" type="button">Forgot
                                password?
                            </Link>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="card col-md-5 text-white bg-primary py-5">
            <div class="card-body text-center">
                <div>
                    <!--                    <h2>Sign up</h2>-->
                    <!--                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                            labore et dolore magna aliqua.</p>
                                        <button class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</button>-->
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
