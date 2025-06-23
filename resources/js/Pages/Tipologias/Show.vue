<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import BaseForm from "@/Pages/Tipologias/BaseForm.vue";

export default {
    name: "Show",
    components: {BaseForm, DashboardLayout},
    props: {
        errors: Object,
        tipologia: Object
    },
    data() {
        return {
            form: {
                tipo: this.tipologia.tipo,
                descricao: this.tipologia.descricao,
                ativo: this.tipologia.ativo ? 1 : 0,
            }
        }
    },
}
</script>

<template>
    <DashboardLayout>
        <div class="d-flex justify-content-between mb-4">
            <h1 class="card-title mb-0">Tipologias</h1>
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
