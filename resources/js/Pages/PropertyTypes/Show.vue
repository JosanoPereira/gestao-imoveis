<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import BaseForm from "@/Pages/PropertyTypes/BaseForm.vue";

export default {
    name: "Show",
    components: {BaseForm, DashboardLayout},
    props: {
        errors: Object,
        propertyType: Object
    },
    data() {
        return {
            form: {
                name: this.propertyType.name,
            }
        }
    },
}
</script>

<template>
    <DashboardLayout :crud-name="'Tipo de Imóveis / Verificar '">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="card-title mb-0">Tipo de Imóveis</h1>
        </div>
        <form enctype="multipart/form-data">
            <BaseForm
                :main-disable="true"
                :main-form="form"
                :errors="errors"
            />
        </form>
    </DashboardLayout>
</template>

<style scoped>

</style>
