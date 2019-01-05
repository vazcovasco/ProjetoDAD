<template>

    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div>
            <invoice-list :invoices="invoices"  @show-click="showInvoice" @edit-click="editInvoice" @download-click="downloadInvoice"></invoice-list>

            <invoice-show :invoice="currentInvoiceShow" :items="items" v-if="showingInvoice"   ></invoice-show>

            <invoice-edit :invoice="currentInvoiceEdit" @invoice-saved="saveInvoice"  @invoice-canceled="cancelEdit" v-if="editingInvoice"></invoice-edit>


        </div>
    </div>

</template>

<script type="text/javascript">


    import InvoiceList from './invoiceList.vue';
    import InvoiceShow from './invoiceShow.vue';
    import InvoiceEdit from './invoiceEdit.vue';

    export default {
        data: function () {
            return {
                title: 'List invoice',
                showingInvoice: false,
                editingInvoice:false,
                currentInvoiceShow: null,
                currentInvoiceEdit: null,
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

                this.editingInvoice=false;
                this.currentInvoiceEdit=null;

                this.showingInvoice = true;
                this.currentInvoiceShow =invoice ;

                this.showSuccess = false;


                axios.get('api/invoices/'+ invoice.id)
                    .then(response => {
                        this.items=response.data;

                        console.log(response);
                    }); // ver a estrutura do json

            },
            saveInvoice: function(){
                console.log("rwddd");

                this.currentInvoice = null;
                this.$refs.usersListRef.editingInvoice= null;
                this.showSuccess = true;
                this.successMessage = 'Invoice Saved';
                this.$socket.emit('invoice_changed', savedInvoice)
            },
            editInvoice: function (invoice) {
                //this.editingInvoice=false,
                this.showingInvoice=false;
                this.currentInvoiceShow = null;

                this.editingInvoice = true;
                this.currentInvoiceEdit = invoice;

                this.showSuccess = false;

                /*
                axios.get('api/invoices/'+ invoice.id)
                    .then(response => {
                        this.items=response.data;

                        console.log(response);
                    }); // ver a estrutura do json
                    */

            },
            cancelEdit: function(){
                this.currentInvoice= null;
                this.$refs.invoicesListRef.editingInvoice= null;
            },
            downloadInvoice: function (invoice) {
                console.log("cheguei");
                axios.get('api/invoices/pdf/' + invoice.id,{
                    url: 'http://api.dev/file-download',
                    responseType: 'blob', // important
                })
                    .then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'edgar.pdf');
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    });

            }

        },
        components: {
            'invoice-list': InvoiceList,
            'invoice-show': InvoiceShow,
            'invoice-edit': InvoiceEdit,

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