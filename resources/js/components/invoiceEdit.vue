<template>
    <div class="jumbotron">
        <h2>Edit Pending Invoice</h2>
        <p>
            <b>Please correct the following error(s):</b>
        <ul>

        </ul>


        <div class="form-group">
            <label for="name">Fullname</label>
            <input

                    type="text"
                    class="form-control"
                    v-model="invoiceCopy.name"
                    name="name"
                    id="inputName"

            >
            <span v-if="errors.has('name')">{{ errors.get('name') }}</span>

        </div>
        <div class="form-group">
            <label for="nif">nif</label>
            <input

                    type="text"
                    class="form-control"
                    v-model="invoiceCopy.nif"
                    name="nif"
                    id="inputNif"
            >
            <span v-if="errors.has('nif')">{{ errors.get('nif') }}</span>
        </div>
        <div class="form-group">
            <button class="btn btn-primary"  v-on:click.prevent="saveInvoice()">Save</button>
            <button class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</button>
        </div>
    </div>
</template>

<script type="text/javascript">

    const Errors = require('../errors.js');
    export default {
        props:["invoice"],

        data() {
            return {
                errors:new Errors(),
                invoiceCopy: {
                    name: '',
                    nif: '',
                }

            };
        },
        methods: {
            saveInvoice: function(){

                this.checkForm();

                if(this.errors.any())
                {
                    this.$forceUpdate();
                }
                else{

                    axios.put(`api/invoices/`+this.invoiceCopy.id,this.invoiceCopy)
                        .then(response=>{


                            // Copy object properties from response.data.data to this.user
                            // without creating a new reference
                            console.log(response.data);
                            Object.assign(this.invoice, response.data.data);
                            this.$emit('invoice-saved', this.invoice);
                        })
                        .catch(errors => {
                            this.errors.record(errors.response.data.errors);

                        });

                }

            },
            cancelEdit: function() {
                this.$router.push("/");
            },
            checkForm: function () {

                if (!this.invoiceCopy.name) {
                    this.errors.set('name',"Name required.");
                }
                if (!this.invoiceCopy.nif) {
                    this.errors.set('nif','Nif required.');

                }

            },
            /*validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
           },*/
        },
        mounted(){
            this.invoiceCopy = this.invoice;

        }


    };
</script>

<style scoped>
</style>