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
        imoveis: Object
    },

    data() {
        return {
            visibleStaticBackdropDemo: ref(false)
        }
    },
    methods: {
        eliminar(id) {
            eliminarDados(route('imoveis.destroy', id), this.$inertia)
        },
    }
}
</script>

<template>
    <DashboardLayout crud-name="Imoveis">
        <a class="mb-2 btn btn-primary" type="button" :href="route('imoveis.create')"><span>Novo</span>
        </a>
        <DataTable class="table table-sm table-bordered">
            <thead class="fw-semibold text-nowrap">
            <tr>
                <th class="bg-body-secondary">ID</th>
                <th class="bg-body-secondary">Tipo de Imovel</th>
                <th class="bg-body-secondary">Tipologia</th>
                <th class="bg-body-secondary">Endereco</th>
                <th class="bg-body-secondary">Compartimentos</th>
                <th class="bg-body-secondary">-</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="dado in imoveis" :key="dado.id">
                <td>{{ dado.id }}</td>
                <td>{{ dado.name }}</td>
                <td>{{ dado.tipo }}</td>
                <td>{{ dado.endereco }}</td>
                <td>{{ dado.numero_compartimentos }}</td>
                <td>
                    <a class="btn btn-sm btn-info mr-2" :href="`/imoveis/${dado.id}/`">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-sm btn-danger mr-2" @click="eliminar(dado.id)">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a class="btn btn-sm btn-primary mr-2" :href="`/imoveis/${dado.id}/edit/`">
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
