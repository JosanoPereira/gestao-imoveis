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
        propertyTypes: Object
    },

    data() {
        return {
            visibleStaticBackdropDemo: ref(false)
        }
    },
    methods: {
        eliminar(id) {
            eliminarDados(route('property-types.destroy', id), this.$inertia)
        },
    }
}
</script>

<template>
    <DashboardLayout>
        <a class="mb-2 btn btn-primary" type="button" :href="route('property-types.create')"><span>Novo</span>
        </a>
        <DataTable class="table table-sm table-bordered">
            <thead class="head-datatable bg-gray-300" style="background: grey">
            <tr>
                <th class="gest-bg-grey-table">ID</th>
                <th class="gest-bg-grey-table">Tipo de Imovel</th>
                <th class="gest-bg-grey-table">-</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="tipo in propertyTypes" :key="tipo.id">
                <td>{{ tipo.id }}</td>
                <td>{{ tipo.name }}</td>
                <td>
                    <a class="btn btn-sm btn-info mr-2" :href="`/property-types/${tipo.id}/`">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-sm btn-danger mr-2" @click="eliminar(tipo.id)">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a class="btn btn-sm btn-primary mr-2" :href="`/property-types/${tipo.id}/edit/`">
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
