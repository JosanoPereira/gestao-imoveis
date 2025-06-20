<script>
import SideBar from "@/Components/SideBar.vue";
import NavBar from "@/Components/NavBar.vue";
import FooterComponent from "@/Components/FooterComponent.vue";

export default {
    name: "DashboardLayout",
    components: {FooterComponent, NavBar, SideBar},
}
</script>

<template>
    <div class="dashboard-layout">
        <SideBar/>
        <div class="wrapper d-flex flex-column min-vh-100">
            <NavBar/>
            <div class="body flex-grow-1">
                <slot/>
            </div>
            <FooterComponent/>
        </div>
    </div>
</template>

<style scoped>
.dashboard-layout {
    min-height: 100vh;
}
</style>
