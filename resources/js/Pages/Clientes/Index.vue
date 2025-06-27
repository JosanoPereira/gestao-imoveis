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
        clientes: Object
    },

    data() {
        return {
            visibleStaticBackdropDemo: ref(false)
        }
    },
    methods: {
        eliminar(id) {
            eliminarDados(route('clientes.destroy', id), this.$inertia)
        },
    }
}
</script>

<template>
    <DashboardLayout crud-name="Clientes">
        <a class="mb-2 btn btn-primary" type="button" :href="route('clientes.create')"><span>Novo</span>
        </a>
        <DataTable class="table table-sm table-bordered">
            <thead class="fw-semibold text-nowrap">
            <tr>
                <th class="bg-body-secondary">ID</th>
                <th class="bg-body-secondary">Tipo de Cliente</th>
                <th class="bg-body-secondary">Nome</th>
                <th class="bg-body-secondary">Provincia</th>
                <th class="bg-body-secondary">Municipio</th>
                <th class="bg-body-secondary">-</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="dado in clientes" :key="dado.id">
                <td>{{ dado.id }}</td>
                <td>{{ dado.tipo }}</td>
                <td>{{ dado.nome }}</td>
                <td>{{ dado.provincia }}</td>
                <td>{{ dado.municipio }}</td>
                <td>
                    <a class="btn btn-sm btn-info mr-2" :href="`/clientes/${dado.id}/`">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-sm btn-danger mr-2" @click="eliminar(dado.id)">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a class="btn btn-sm btn-primary mr-2" :href="`/clientes/${dado.id}/edit/`">
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
