<script>
import InputError from "@/Components/InputError.vue";
import InputNumber from 'primevue/inputnumber';
import Select from 'primevue/select';
import {VMoney} from 'v-money'


export default {
    name: "BaseForm",
    components: {InputError, InputNumber, Select},
    directives: {money: VMoney},
    props: {
        mainForm: Object,
        mainDisable: Boolean,
        errors: Object,
        tipologias: Object,
        tipoImoveis: Object,
        proprietarios: Object,
        provincias: Object,
        municipios: Object,
        tipoDocumentos: Object,
    },

    data() {
        return {
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'm ',
                suffix: '',
                precision: 2,

            },
            form: {
                //Imoveis
                area_util: "",
                numero_compartimentos: "",
                estado_conservacao: "",
                tipologias_id: "",
                property_types_id: "",
                proprietarios_id: "",

                //Documentos
                tipo_documentos_id: '',
                numero: '',
                emissao: '',
                path: '',
                validade: '',
                vitalicio: '',

                documentos: [],
                imagens: [],

                //Enderecos
                municipios_id: "",
                endereco: "",
                bairro: "",
                provincias_id: "",
            },
            isDisable: false,
            editDoc: false,
            indexEditDoc: null,
            municipiosSearch: [],
            selectedCountry: null,
        }
    },

    methods: {
        getMunicipios() {
            if (this.form.provincias_id) {
                this.municipiosSearch = this.municipios.filter(municipio =>
                    municipio.provincias_id === this.form.provincias_id
                );
            } else {
                this.form.municipios_id = ''
                this.municipiosSearch = [];
            }
        },

        editDocument(index) {
            this.editDoc = true
            this.indexEditDoc = index
            this.form.numero = this.form.documentos[index].numero
            this.form.emissao = this.form.documentos[index].emissao
            this.form.validade = this.form.documentos[index].validade
            this.form.tipo_documentos_id = this.form.documentos[index].tipo_documentos_id
        },

        validarEditDoc() {
            this.form.documentos[this.indexEditDoc].numero = this.form.numero
            this.form.documentos[this.indexEditDoc].emissao = this.form.emissao
            this.form.documentos[this.indexEditDoc].validade = this.form.validade
            this.form.documentos[this.indexEditDoc].tipo_documentos_id = this.form.tipo_documentos_id
            this.form.documentos[this.indexEditDoc].path = this.form.path ?? null
            this.indexEditDoc = null
            this.editDoc = false
        },

        addDocument() {
            if (this.form.tipo_documentos_id && this.form.numero && this.form.emissao && this.form.path) {
                const novoDocumento = {
                    tipo_documento: this.tipoDocumentos.find(doc => doc.id === this.form.tipo_documentos_id).tipo,
                    numero: this.form.numero,
                    emissao: this.form.emissao,
                    path: this.form.path,
                    validade: this.form.validade || null,
                    tipo_documentos_id: this.form.tipo_documentos_id
                };

                this.form.documentos.push(novoDocumento);

                this.form.numero = '';
                this.form.emissao = '';
                this.form.path = '';
                this.form.validade = '';
                this.form.tipo_documentos_id = '';

                this.errors['tipo_documentos_id'] = '';
                this.errors['numero'] = '';
                this.errors['emissao'] = '';
                this.errors['path'] = '';
            } else {
                // Mostrar erro de validação se algum campo estiver vazio
                this.errors['tipo_documentos_id'] = 'Selecione o tipo de documento';
                this.errors['numero'] = 'Informe o número do documento';
                this.errors['emissao'] = 'Informe a data de emissão';
                this.errors['path'] = 'Carregue o documento, por favor';
            }
        },

        removeDocument(index) {
            this.form.documentos.splice(index, 1);
        },

        removeAllDocs() {
            this.form.documentos = []
        },

        removeImage(index) {
            this.form.imagens.splice(index, 1);
        },
        createPreview(file) {
            return window.URL.createObjectURL(file);
        },
        handleImagens(event) {
            const novasImagens = Array.from(event.target.files);

            // Impede adicionar arquivos duplicados (por nome)
            const nomesExistentes = this.form.imagens.map(file => file.name);

            novasImagens.forEach(file => {
                if (!nomesExistentes.includes(file.name)) {
                    this.form.imagens.push(file);
                }
            });

            // Resetar o input para permitir selecionar a mesma imagem novamente
            event.target.value = '';
        }
    },

    created() {
        this.form = this.mainForm
        this.isDisable = this.mainDisable
        this.getMunicipios()
    },
}
</script>

<template>
    <div class="card mb-4">
        <h3 class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">Dados Imoveis</h3>
        <div class="card-body mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="mb-1">Tipologia</label>
                    <select v-model="form.tipologias_id" :disabled="isDisable" class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="tipo in tipologias" :value="tipo.id" :key="tipo.id">{{ tipo.tipo }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['tipologias_id']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Tipo de Imovel</label>
                    <select v-model="form.property_types_id" :disabled="isDisable" class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="tipo in tipoImoveis" :value="tipo.id" :key="tipo.id">{{ tipo.name }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['property_types_id']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Area Util</label>
                    <input type="text" class="form-control"
                           v-model="form.area_util"
                           v-money="money"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['area_util']"/>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label class="mb-1">Numero de Compartimentos</label>
                    <InputNumber class="form-control" v-model="form.numero_compartimentos" :disabled="isDisable"
                                 inputId="integeronly" fluid/>
                    <InputError class="mt-1 mb-2" :message="errors['area_util']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Proprietario</label>
                    <select v-model="form.proprietarios_id" :disabled="isDisable" class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="tipo in proprietarios" :value="tipo.id" :key="tipo.id">{{ tipo.nome }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['proprietarios_id']"/>
                </div>
                <div class="col-md-5">
                    <label class="mb-1">Estado de Conservacao</label>
                    <input type="text" class="form-control"
                           v-model="form.estado_conservacao"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['estado_conservacao']"/>
                </div>
            </div>
        </div>

        <h3 class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">Imagens</h3>
        <div class="card-body mb-2">
            <div class="row">
                <div class="col-md-12">
                    <input type="file" class="form-control" multiple
                           @change="handleImagens($event)"
                           accept="image/*">
                    <InputError class="mt-1 mb-2" :message="errors['tipologias_id']"/>
                </div>
            </div>
            <div v-if="form.imagens.length" class="mt-3">
                <h5>Imagens Carregadas</h5>
                <div class="row">
                    <div
                        class="col-md-2"
                        v-for="(img, index) in form.imagens"
                        :key="index"
                    >
                        <div class="card mb-2">
                            <div class="card-body p-2 text-center">
                                <img
                                    v-if="img.type.startsWith('image/')"
                                    :src="createPreview(img)"
                                    class="img-fluid rounded border"
                                    style="height:310px; width: 310px"
                                    :alt="img.name"
                                />

                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger mt-2"
                                    @click="removeImage(index)"
                                >
                                    Remover
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">
            Documentos</h3>
        <div class="card-body mb-2">
            <div class="row">
                <div class="col-md-6">
                    <label class="mb-1">Tipo de Documento</label>
                    <select v-model="form.tipo_documentos_id"
                            :required="form.tipo_clientes_id && !form.documentos.length" :disabled="isDisable"
                            class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="dado in tipoDocumentos" :value="dado.id" :key="dado.id">{{ dado.tipo }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['tipo_documentos_id']"/>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Path</label>
                    <input type="file" class="form-control" @input="form.path = $event.target.files[0]"
                           accept="application/pdf" :required="form.tipo_clientes_id  && !form.documentos.length">
                    <InputError class="mt-1 mb-2" :message="errors['path']"/>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-md-4 ">
                    <label class="mb-1">Numero</label>
                    <input type="text" class="form-control"
                           :required="form.tipo_clientes_id  && !form.documentos.length" v-model="form.numero"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['numero']"/>
                </div>
                <div class="col-md-4 ">
                    <label class="mb-1">Emissao</label>
                    <input type="date" class="form-control"
                           :required="form.tipo_clientes_id  && !form.documentos.length" v-model="form.emissao"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['emissao']"/>
                </div>
                <div class="col-md-4 ">
                    <label class="mb-1">Validade (Se vazio, sera vitalicio)</label>
                    <input type="date" class="form-control" v-model="form.validade"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['validade']"/>
                </div>
            </div>

            <!-- Botão para adicionar documentos -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <button v-if="!isDisable" type="button" class="btn btn-primary" @click="addDocument">+</button>
                    <button v-if="!isDisable && editDoc" type="button" class="btn btn-success ml-3"
                            @click="validarEditDoc">Validar Edicao
                    </button>
                    <button v-if="form.documentos.length>1" type="button" class="btn btn-danger ml-3"
                            @click="removeAllDocs">Remover Todos
                    </button>
                </div>
            </div>

            <h5 class="mt-3" v-if="form.documentos.length">Documentos Adicionados</h5>

            <!-- Lista de documentos adicionados -->
            <div v-if="form.documentos.length" class="row mt-3" v-for="(doc, index) in form.documentos" :key="index">
                <div class="col-md-3">
                    <label class="">Tipo de Documento</label>
                    <select v-model="form.documentos[index].tipo_documentos_id" :disabled="true"
                            class="form-control">
                        <option v-for="dado in tipoDocumentos" :value="dado.id" :key="dado.id">{{ dado.tipo }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="">Numero</label>
                    <input type="text" class="form-control" :required="form.tipo_clientes_id"
                           v-model="form.documentos[index].numero"
                           :disabled="true">
                </div>
                <div class="col-md-2">
                    <label class="">Emissao</label>
                    <input type="date" class="form-control" :required="form.tipo_clientes_id"
                           v-model="form.documentos[index].emissao"
                           :disabled="true">
                </div>
                <div class="col-md-2">
                    <label class="">Validade</label>
                    <input type="date" class="form-control" v-model="form.documentos[index].validade"
                           :disabled="true">
                </div>

                <div class="col-md-2 mt-4">
                    <button v-if="!isDisable" type="button" @click="removeDocument(index)"
                            class="btn btn-danger btn-sm ml-2">Remover
                    </button>
                    <button v-if="!isDisable && !this.editDoc" type="button" @click="editDocument(index)"
                            class="btn btn-danger btn-sm ml-2"><i class="fa fa-edit"></i>
                    </button>
                    <a v-if="form.documentos[index].download" :href="form.documentos[index].download_link"
                       target="_blank" class="btn btn-success btn-sm ml-2">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>

        <h3 class="bg-body-secondary text-xl-center p-2" style="font-size: 20px">Endereco
            Sede</h3>
        <div class="card-body mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="mb-1">Provincia</label>
                    <select v-model="form.provincias_id" :required="form.tipo_clientes_id" :disabled="isDisable"
                            class="form-control" @change="getMunicipios">
                        <option value="">Selecione</option>
                        <option v-for="dado in provincias" :value="dado.id" :key="dado.id">{{ dado.provincia }}</option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['provincias_id']"/>
                </div>

                <div class="col-md-4">
                    <label class="mb-1">Municipio</label>
                    <select v-model="form.municipios_id" :required="form.tipo_clientes_id" :disabled="isDisable"
                            class="form-control">
                        <option value="">Selecione</option>
                        <option v-for="dado in municipiosSearch" :value="dado.id" :key="dado.id">{{
                                dado.municipio
                            }}
                        </option>
                    </select>
                    <InputError class="mt-1 mb-2" :message="errors['municipios_id']"/>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Bairro</label>
                    <input type="text" class="form-control"
                           v-model="form.bairro" :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['bairro']"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label class="mb-1">Referencia</label>
                    <input type="text" class="form-control" :required="form.tipo_clientes_id" v-model="form.endereco"
                           :disabled="isDisable">
                    <InputError class="mt-1 mb-2" :message="errors['endereco']"/>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success mr-2" v-if="!isDisable">Submeter</button>
            <a href="/imoveis" type="button" class="btn btn-warning">Voltar</a>
        </div>
    </div>
</template>

<style scoped>

</style>
