<template>
    <div class="row">
        <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">Consulta a Criptomoedas</div>

                <div class="card-body">

                    <div v-show="msg" class="alert alert-warning" role="alert">
                        {{msg}}
                    </div>

                    <form>
                        <div class="form-group">
                            <label for="frmQuant">Quantidade</label>
                            <input type="text" class="form-control" id="frmQuant" v-model="form.quant" @keyup="trataValor()">
                        </div>
                        <div class="form-group">
                            <label for="frmCompra">Token</label>
                            <select v-model="form.token" class="form-control">
                                <option v-for="token in tokens" :key="token" :value="token">{{token}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="frmCompra">Data da compra</label>
                            <date-picker v-model="form.dataCompra" :config="datePickerOptions" v-mask="'##/##/####'"></date-picker>
                        </div>
                        <div class="form-group">
                            <label for="frmVenda">Data da venda</label>
                            <date-picker v-model="form.dataVenda" :config="datePickerOptions" v-mask="'##/##/####'"></date-picker>
                        </div>
                    </form>

                </div>

                <div class="card-footer">
                    <button :disabled="consultando" class="btn btn-primary" @click="consulta">
                        <span v-if="!consultando">Consultar</span>
                        <span v-if="consultando">Consultando...</span>
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import datePicker from 'vue-bootstrap-datetimepicker'
    import {mask} from 'vue-the-mask'
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';


    export default {

        props: [
            'quant',
            'tokens',
            'dataCompra',
            'dataVenda',
            'consultando'
        ],

        components: {
            datePicker,
        },

        directives: {
            mask
        },

        data: function() {
            return {

                // Opções do datepicker
                datePickerOptions: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    locale: 'pt-br',
                },

                form: {
                    quant: null,
                    token: 'PSGFT',
                    dataCompra: null,
                    dataVenda: null,
                },

                msg: '',
            }
        },

        created() {
            /**
             * Copy the props to local object
             */
            this.msg             = this.msg
            this.tokens          = this.tokens
            this.form.quant      = this.quant
            this.form.dataCompra = this.dataCompra
            this.form.dataVenda  = this.dataVenda
        },

        methods: {
            trataValor: function() {

                this.msg = null

                if (!this.form.quant) {
                    return
                }

                this.form.quant = this.form.quant.replace(/[^0-9,]/g,'')

                while (this.form.quant.includes(',') && this.form.quant.match(/,/g).length > 1) {
                    let n = this.form.quant.lastIndexOf(',')
                    this.form.quant = this.form.quant.substr(0, n) + this.form.quant.substr(n+1)
                }
            },

            consulta: function() {


                //Trata o valor
                this.trataValor()
                if (!this.form.quant) {
                    this.msg = 'Quantidade é um campo obrigatório'
                    return
                }

                let quant = parseFloat(this.form.quant.replace(',','.'))

                if (isNaN(quant)) {
                    this.msg = 'A quantidade precisa ser um número válido'
                }

                if (!this.form.dataCompra) {
                    this.msg = 'Data de compra é um campo obrigatório'
                    return
                }

                if (!this.form.dataVenda) {
                    this.msg = 'Data de venda é um campo obrigatório'
                    return
                }

                //Trata a data inicial
                let dataCompra = this.form.dataCompra.split('/')
                let dataVenda = this.form.dataVenda.split('/')

                dataCompra = dataCompra[2] + '-' + dataCompra[1] + '-' + dataCompra[0]
                dataVenda  = dataVenda [2] + '-' + dataVenda [1] + '-' + dataVenda [0]

                if (isNaN(new Date(dataCompra))) {
                    this.msg = 'Data de compra inválida'
                    return
                }

                if (isNaN(new Date(dataVenda))) {
                    this.msg = 'Data de venda inválida'
                    return
                }

                if (dataCompra > dataVenda) {
                    this.msg = 'Intervalo de datas inválido'
                    return
                }

                if (new Date() - new Date(dataCompra) < 1000 * 60 * 60 * 24 || new Date() - new Date(dataVenda) < 1000 * 60 * 60 * 24) {
                    this.msg = 'Só é possível realizar cálculos usando datas passadas'
                    return
                }


                this.$emit('consulta', {
                    'quantidade': quant,
                    'token': this.form.token,
                    'dataCompra': dataCompra,
                    'dataVenda': dataVenda,
                })
            }
        }
    }
</script>