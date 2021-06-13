<template>
    <div>
        <crypto-form
            v-show="showForm"
            :msg="form.msg"
            :quant="form.quantidade"
            :tokens="tokens"
            :consultando="consultando"
            :dataCompra="form.dataCompra"
            :dataVenda="form.dataVenda"
            @consulta="consulta"
        />

        <div v-show="!showForm" class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">Consulta a Criptomoedas</div>

                <div class="card-body">

                    <form>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Compra</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" :value="result.quantidade + ' ' + result.token">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Intervalo</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" :value="'De ' + result.dataCompra + ' a ' + result.dataVenda + ' (' + result.intervalo + (result.intervalo == 1 ? ' dia)' : ' dias)')">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Valor da compra</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" :value="result.valorCompra">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Valor da venda</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" :value="result.valorVenda">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Lucro</label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" :value="result.lucro + ' (' + result.lucroPercentual + '%)'">
                            </div>
                        </div>
                    </form>

                </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary" @click="novaConsulta()">
                    Nova consulta
                </button>
            </div>

        </div>
    </div>

</template>

<script>

    import Axios from 'axios'

    export default {

        data: function() {
            return {
                showForm: true,
                consultando: false,

                tokens: [
                    'BCH',   'BTC',   'CAIFT',  'CHZ',
                    'ETH',   'GALFT', 'IMOB01', 'JUVFT',
                    'LINK',  'LTC',   'OGFT',   'PAXG',
                    'PSGFT', 'USDC',  'WBX',    'XRP'
                ],

                form: {
                    msg: null,
                    quantidade: null,
                    dataCompra: null,
                    dataVenda: null,
                },

                result: {
                    quantidade: null,
                    token: null,
                    dataCompra: null,
                    dataVenda: null,
                    valorCompra: null,
                    valorvenda: null,
                    lucro: null,
                    lucroPercentual: null,
                    intervalo: null,
                }
            }
        },

        mounted() {
        },

        methods: {
            consulta: function(form) {
                this.consultando = true

                this.result.token = form.token
                let endpoint = '/api/crypto/' + form.token
                delete form.token

                Axios.post(endpoint, form)

                .then(response => {
                    console.log(response.data)
                    console.log(form)

                    this.consultando = false
                    this.showForm = false

                    this.result.quantidade      = form.quantidade
                    this.result.dataCompra      = form.dataCompra.split('-')[2] + '/' + form.dataCompra.split('-')[1] + '/' + form.dataCompra.split('-')[0]
                    this.result.dataVenda       = form.dataVenda.split('-')[2] + '/' + form.dataVenda.split('-')[1] + '/' + form.dataVenda.split('-')[0]
                    this.result.valorCompra     = new Intl.NumberFormat('pt-BR', {style:'currency', currency: 'BRL'}).format(response.data.valor_da_compra)
                    this.result.valorVenda      = new Intl.NumberFormat('pt-BR', {style:'currency', currency: 'BRL'}).format(response.data.valor_da_venda)
                    this.result.lucro           = new Intl.NumberFormat('pt-BR', {style:'currency', currency: 'BRL'}).format(response.data.lucro)
                    this.result.lucroPercentual = (Math.round(response.data.lucro_percentual * 100) / 100).toFixed(2)
                    this.result.intervalo       = response.data.intervalo_em_dias
                })

                .catch(e => {
                    console.log(e)
                })
            },

            novaConsulta: function() {

                this.showForm = true

            }
        }
    }
</script>
