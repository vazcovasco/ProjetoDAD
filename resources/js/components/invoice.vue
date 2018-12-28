<template>

    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div>
            <invoice-list :invoices="invoices"  @show-click="showInvoice"></invoice-list>

            <invoice-show :invoice="currentInvoice" :items="items" v-if="currentInvoice"   ></invoice-show>

        </div>
    </div>

</template>

<script type="text/javascript">


    import InvoiceList from './invoiceList.vue';
    import InvoiceShow from './invoiceShow.vue';

    export default {
        data: function () {
            return {
                title: 'List invoice',
                showingInvoice: false,
                currentInvoice: null,
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentInvoiceIndex: -1,
                invoices: [],
                items:[]
            }
        },
        methods: {
            getInvoices: function () {

                axios.get('api/invoices')
                    .then(response => {
                        this.invoices = response.data;
                    }); // ver a estrutura do json

            },
            showInvoice: function (invoice) {
                console.log(invoice);
                this.currentInvoice = invoice;
                this.showSuccess = false;


                axios.get('api/invoices/'+ invoice.id)
                    .then(response => {
                        this.items=response.data;

                        console.log(response);
                    }); // ver a estrutura do json

            },
            saveUser: function(){
                this.currentUser = null;
                this.$refs.usersListRef.editingUser = null;
                this.showSuccess = true;
                this.successMessage = 'User Saved';
                this.$socket.emit('user_changed', savedUser)
            },

        },
        components: {
            'invoice-list': InvoiceList,
            'invoice-show': InvoiceShow,

        },
        mounted() {
            this.getInvoices();
        }
    }

</script>

<style scoped>
    p {
        font-size: 2em;
        text-align: center;
    }
</style>