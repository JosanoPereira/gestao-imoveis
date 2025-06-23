<script>
import {ref} from 'vue'
import SideBar from "@/Components/SideBar.vue";
import NavBar from "@/Components/NavBar.vue";
import FooterComponent from "@/Components/FooterComponent.vue";


export default {
    name: "DashboardLayout",
    components: {FooterComponent, NavBar, SideBar},
    setup() {
        const sidebarOpen = ref(true)

        function toggleSidebar() {
            sidebarOpen.value = !sidebarOpen.value
        }

        return {sidebarOpen, toggleSidebar}
    }
}
</script>

<template>
    <div>
        <SideBar :class="{ 'sidebar-open': sidebarOpen }"/>
        <div class="wrapper d-flex flex-column min-vh-100" :class="['wrapper', { 'wrapper-shifted': sidebarOpen }]">
            <NavBar @toggle-sidebar="toggleSidebar"/>
            <div class="body flex-grow-1">
                <main class="container-lg body-content">
                    <slot/>
                </main>
            </div>
            <FooterComponent/>
        </div>
    </div>
</template>

<style>
.dashboard-container {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    transition: margin-left 0.3s ease;
    margin-left: -250px; /* oculto por padrão */
}

.sidebar.sidebar-open {
    margin-left: 0; /* aparece quando aberto */
}

.wrapper {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    transition: margin-left 0.3s ease;
    margin-left: 0;
}

.wrapper-shifted {
    margin-left: 250px; /* empurra o conteúdo quando sidebar aparece */
}

.body-content {
    flex-grow: 1;
    padding: 1.5rem;
}
</style>
