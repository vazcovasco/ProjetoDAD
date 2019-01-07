<template>
  <div class="jumbotron">
    <h2>Edit Pending Invoice</h2>
<div>
    <div class="alert" :class="typeOfMessage" v-if="showSuccess">
      <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
      <strong>{{ message }}</strong>
    </div>


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
    <div class="form-group">
      <label for="nif">nif</label>
      <input type="text" class="form-control" v-model="invoiceCopy.nif" name="nif" id="inputNif">
      <span v-if="errors.has('nif')">{{ errors.get('nif') }}</span>
    </div>
    <div class="form-group">
      <button class="btn btn-primary" v-on:click.prevent="savedInvoice()">Save</button>
      <button class="btn btn-light" v-on:click.prevent="cancelEdit()">Canecel</button>
    </div>
  </div>
</template>

<script type="text/javascript">
const Errors = require("../errors.js");
export default {
  props: ["invoice"],

  data() {
    return {
      errors: new Errors(),
      invoiceCopy: {
        name: "",
        nif: ""
      },
      showSuccess: false,
      message: "",
      typeOfMessage: "alert-success"
    };
  },
  methods: {
    savedInvoice: function() {
      axios
        .put(`api/invoices/` + this.invoiceCopy.id, this.invoiceCopy)
        .then(response => {
          this.typeOfMessage = "alert-success";
          this.message = "Invoice Edited Successfully";
          this.showSuccess = true;
          Object.assign(this.invoice, response.data.data);
          this.$emit("invoice-saved", this.invoice);
        })
        .catch(response => {
          var str = this.invoiceCopy.nif;
          var strn = this.invoiceCopy.name;
          if (!str.match("^((?!(0))[0-9]{9})$")) {
            this.typeOfMessage = "alert-danger";
            this.message = "Nif must be a number with 9 digits";
            this.showSuccess = true;
          } else if (!strn.match("~ m/ / ") && !strn.match("/^[a-zA-Z]+$/")) {
            this.typeOfMessage = "alert-danger";
            this.message = "Invalid characters in name input";
            this.showSuccess = true;
          }
        });
    },
    cancelEdit: function() {
      this.$emit("invoice-canceled", this.invoice);
    }
    /*validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
           },*/
  },
  mounted() {
    this.invoiceCopy = this.invoice;
  }
};
</script>

<style scoped>
</style>