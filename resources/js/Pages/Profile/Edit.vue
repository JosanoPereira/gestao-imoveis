<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import InputError from "@/Components/InputError.vue";
import {Link} from '@inertiajs/vue3';
import {ref} from "vue";
import axios from "axios";


export default {
    components: {DashboardLayout, InputError, Link},

    props: {
        mustVerifyEmail: Boolean,
        status: String,
        errors: Object,
    },

    data() {
        const user = this.$page.props.auth?.user || {name: '', email: ''};
        return {
            form: {
                name: user.name,
                email: user.email,
                path: '',
                current_password: '',
                password: '',
                password_confirmation: '',
            },
            userInstance: user,
            passwordInput: ref(null),
            currentPasswordInput: ref(null),
        }
    },

    methods: {
        async updateProfile() {
            const formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('email', this.form.email);
            if (this.form.path instanceof File) {
                formData.append('path', this.form.path);
            }

            try {
                const response = await axios.patch(route('profile.update'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                console.log('Profile updated!', response.data);
                // opcional: mostrar mensagem, resetar form, etc.
            } catch (error) {
                console.error('Erro ao atualizar perfil:', error);
                // opcional: exibir erros do backend no template
            }
        },
        updatePassword() {
            this.$inertia.put(route('password.update'), {
                ...this.form
            }, {
                onSuccess: () => this.form.reset(),
                onError: () => {
                    if (this.form.errors.password) {
                        this.form.reset('password', 'password_confirmation');
                        this.passwordInput.value.focus();
                    }
                    if (this.form.errors.current_password) {
                        this.form.reset('current_password');
                        this.currentPasswordInput.value.focus();
                    }
                },
            })
        }
    },

    created() {
    }


}
</script>

<template>
    <DashboardLayout>
        <div class="card mb-4">
            <div class="card-header">
                <header>
                    <h2 class="text-lg font-medium">
                        Profile Information
                    </h2>

                    <p class="mt-1 text-sm">
                        Update your account's profile information and email address.
                    </p>
                </header>
            </div>
            <form @submit.prevent="updateProfile" class="mt-6 space-y-6"
                  enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="mb-1">Name</label>
                            <input type="text" class="form-control" v-model="form.name" required>
                            <InputError class="mt-1 mb-2" :message="errors['name']"/>
                        </div>

                        <div class="col-md-6">
                            <label class="mb-1">Email</label>
                            <input type="email" class="form-control" v-model="form.email" required>
                            <InputError class="mt-1 mb-2" :message="errors['email']"/>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <input type="file" class="form-control" @input="form.path = $event.target.files[0]"
                                   accept="application/pdf">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div v-if="mustVerifyEmail && this.userInstance.email_verified_at === null">
                            <p class="mt-2 text-sm text-gray-800">
                                Your email address is unverified.
                                <Link
                                    :href="route('verification.send')"
                                    method="post"
                                    as="button"
                                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Click here to re-send the verification email.
                                </Link>
                            </p>

                            <div
                                v-show="status === 'verification-link-sent'"
                                class="mt-2 text-sm font-medium text-green-600"
                            >
                                A new verification link has been sent to your email address.
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p
                                    v-if="form.recentlySuccessful"
                                    class="text-sm text-gray-600"
                                >
                                    Saved.
                                </p>
                            </Transition>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success mr-2" :disabled="form.processing">Save</button>
                </div>
            </form>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <header>
                    <h2 class="text-lg font-medium">
                        Update Password
                    </h2>

                    <p class="mt-1 text-sm">
                        Ensure your account is using a long, random password to stay
                        secure.
                    </p>
                </header>
            </div>
            <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="mb-1">Current Password</label>
                            <input type="password" class="form-control" v-model="form.current_password" required>
                            <InputError class="mt-1 mb-2" :message="errors['current_password']"/>
                        </div>

                        <div class="col-md-4">
                            <label class="mb-1">New Password</label>
                            <input type="password" class="form-control" v-model="form.password" required>
                            <InputError class="mt-1 mb-2" :message="errors['password']"/>
                        </div>

                        <div class="col-md-4">
                            <label class="mb-1">Confirm Password</label>
                            <input type="password" class="form-control" v-model="form.password_confirmation" required>
                            <InputError class="mt-1 mb-2" :message="errors['password_confirmation']"/>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div v-if="mustVerifyEmail && this.userInstance.email_verified_at === null">
                            <p class="mt-2 text-sm text-gray-800">
                                Your email address is unverified.
                                <Link
                                    :href="route('verification.send')"
                                    method="post"
                                    as="button"
                                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Click here to re-send the verification email.
                                </Link>
                            </p>

                            <div
                                v-show="status === 'verification-link-sent'"
                                class="mt-2 text-sm font-medium text-green-600"
                            >
                                A new verification link has been sent to your email address.
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p
                                    v-if="form.recentlySuccessful"
                                    class="text-sm text-gray-600"
                                >
                                    Saved.
                                </p>
                            </Transition>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success mr-2" :disabled="form.processing">Save</button>
                </div>
            </form>
        </div>
    </DashboardLayout>

    <!--    <Head title="Profile"/>

        <AuthenticatedLayout>
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Profile
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>

                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <UpdatePasswordForm class="max-w-xl"/>
                    </div>

                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <DeleteUserForm class="max-w-xl"/>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>-->
</template>
