<script>

import {router} from "@inertiajs/vue3";
import Swal from "sweetalert2";

export default {
    name: "NavBar",

    props: {
        crudName: '',
    },

    data() {
        const path = this.$page.props.auth?.path;
        return {
            // Define any reactive data properties here if needed
            image: path
        };
    },

    methods: {
        lockAccount() {
            console.log('Lock Account');
            alert('Your account has been locked. Please contact support to unlock it.');
        },

        logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log me out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    router.post('/logout')
                        .then(() => {
                            console.log('Logged out successfully');
                        })
                        .catch(error => {
                            console.error('Error logging out:', error);
                        });
                }
            });

        },
    },
}
</script>

<template>
    <header class="header header-sticky p-0 mb-4">
        <div class="container-fluid border-bottom p-1">
            <button class="header-toggler m-2" type="button" @click="$emit('toggle-sidebar')"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
                    style="margin-inline-start: -14px;">
                <svg class="icon icon-lg">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-menu"></use>
                </svg>
            </button>
            <ul class="header-nav d-none d-lg-flex">
                <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/profile">Perfil</a></li>
<!--                <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>-->
            </ul>
            <ul class="header-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="/coreui/icons/sprites/free.svg#cil-bell"></use>
                    </svg>
                </a></li>
                <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="/coreui/icons/sprites/free.svg#cil-list-rich"></use>
                    </svg>
                </a></li>
                <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="/coreui/icons/sprites/free.svg#cil-envelope-open"></use>
                    </svg>
                </a></li>
            </ul>
            <ul class="header-nav">
                <li class="nav-item py-1">
                    <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button"
                            aria-expanded="false" data-coreui-toggle="dropdown">
                        <svg class="icon icon-lg theme-icon-active">
                            <use xlink:href="/coreui/icons/sprites/free.svg#cil-contrast"></use>
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                        <li>
                            <button class="dropdown-item d-flex align-items-center" type="button"
                                    data-coreui-theme-value="light">
                                <svg class="icon icon-lg me-3">
                                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-sun"></use>
                                </svg>
                                Claro
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center" type="button"
                                    data-coreui-theme-value="dark">
                                <svg class="icon icon-lg me-3">
                                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-moon"></use>
                                </svg>
                                Escuro
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center active" type="button"
                                    data-coreui-theme-value="auto">
                                <svg class="icon icon-lg me-3">
                                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-contrast"></use>
                                </svg>
                                Auto
                            </button>
                        </li>
                    </ul>
                </li>
                <li class="nav-item py-1">
                    <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button"
                       aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md">
                            <img class="avatar-img img-fluid rounded-circle object-fit-cover mr-1" :src="this.image" alt="user@email.com">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                            Conta
                        </div>
                        <a class="dropdown-item" href="#">
                            <svg class="icon me-2">
                                <use xlink:href="/coreui/icons/sprites/free.svg#cil-bell"></use>
                            </svg>
                            Atualizações
                            <span class="badge badge-sm bg-info ms-2">42</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <svg class="icon me-2">
                                <use xlink:href="/coreui/icons/sprites/free.svg#cil-envelope-open"></use>
                            </svg>
                            Mensagens
                            <span class="badge badge-sm bg-success ms-2">42</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <svg class="icon me-2">
                                <use xlink:href="/coreui/icons/sprites/free.svg#cil-task"></use>
                            </svg>
                            Tarefas
                            <span class="badge badge-sm bg-danger ms-2">42</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <svg class="icon me-2">
                                <use xlink:href="/coreui/icons/sprites/free.svg#cil-comment-square"></use>
                            </svg>
                            Comentários
                            <span class="badge badge-sm bg-warning ms-2">42</span>
                        </a>

                        <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                            <div class="fw-semibold">Configurações</div>
                        </div>
                        <a class="dropdown-item" href="/profile">
                            <svg class="icon me-2">
                                <use xlink:href="/coreui/icons/sprites/free.svg#cil-user"></use>
                            </svg>
                            Perfil
                        </a>
                        <a class="dropdown-item" href="#">
                            <svg class="icon me-2">
                                <use xlink:href="/coreui/icons/sprites/free.svg#cil-settings"></use>
                            </svg>
                            Configurações
                        </a>
                        <!--                        <a class="dropdown-item" href="#">
                                                    <svg class="icon me-2">
                                                        <use xlink:href="/coreui/icons/sprites/free.svg#cil-credit-card"></use>
                                                    </svg>
                                                    Payments<span class="badge badge-sm bg-secondary ms-2">42</span>
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <svg class="icon me-2">
                                                        <use xlink:href="/coreui/icons/sprites/free.svg#cil-file"></use>
                                                    </svg>
                                                    Projects<span class="badge badge-sm bg-primary ms-2">42</span>
                                                </a>-->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" @click.prevent="lockAccount">
                            <svg class="icon me-2">
                                <use xlink:href="/coreui/icons/sprites/free.svg#cil-lock-locked"></use>
                            </svg>
                            Lock Account
                        </a>
                        <a class="dropdown-item" href="#" @click.prevent="logout">
                            <svg class="icon me-2">
                                <use xlink:href="/coreui/icons/sprites/free.svg#cil-account-logout"></use>
                            </svg>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="container-fluid px-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0">
                    <!--                    <li class="breadcrumb-item"><a href="#">Home</a>-->
                    <!--                    </li>-->
                    <li class="breadcrumb-item active"><span>{{ crudName }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </header>
</template>

<style scoped>
.btn-toggler {
    background: transparent;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
}

.avatar-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
}
</style>
