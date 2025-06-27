<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {ref} from 'vue'
import DataTablesCore from 'datatables.net-bs5';
import DataTable from 'datatables.net-vue3';
import {eliminarDados} from '@/helpers/metodosComuns.js'

DataTable.use(DataTablesCore);

export default {
    name: "Index",
    components: {DashboardLayout, DataTable, DataTablesCore},
    props: {
        typologies: Object
    },

    data() {
        return {
            visibleStaticBackdropDemo: ref(false)
        }
    },
    methods: {
        eliminar(id) {
            eliminarDados(route('tipologias.destroy', id), this.$inertia)
        },
    }
}
</script>

<template>
    <DashboardLayout :crud-name="'Tipologias'">
        <a class="mb-2 btn btn-primary" type="button" :href="route('tipologias.create')"><span>Novo</span>
        </a>
        <DataTable class="table border mb-0">
            <thead class="fw-semibold text-nowrap">
            <tr class="align-middle">
                <th class="bg-body-secondary">ID</th>
                <th class="bg-body-secondary">Tipologia</th>
                <th class="bg-body-secondary">Descricao</th>
                <th class="bg-body-secondary">Ativo</th>
                <th class="bg-body-secondary">-</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="tipo in typologies" :key="tipo.id">
                <td>{{ tipo.id }}</td>
                <td>{{ tipo.tipo }}</td>
                <td>{{ tipo.descricao }}</td>
                <td>
                    <span class="badge" :class="tipo.ativo? 'text-bg-success':'text-bg-danger'">{{
                            tipo.ativo ? 'Disponivel' : 'Indisponivel'
                        }}</span>
                </td>
                <td>
                    <a class="btn btn-sm btn-info mr-2" :href="`/tipologias/${tipo.id}/`">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-sm btn-danger mr-2" @click="eliminar(tipo.id)">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a class="btn btn-sm btn-primary mr-2" :href="`/tipologias/${tipo.id}/edit/`">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
            </tbody>
        </DataTable>
    </DashboardLayout>
</template>

<style scoped>

</style>
