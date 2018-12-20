<template>
<div class="container" id="people">
    <div class="filter">
        <label><input type="radio" v-model="selectedCategory" value="All"/> All</label>
        <label><input type="radio" v-model="selectedCategory" value="Pending"/> Pending</label>

    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>MealID</th>
            <th>Total Price</th>
            <th>Table Number</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="invoice in filteredInvoices"  :key="invoice.id" :class="{activerow: showingInvoice === invoice}">
            <td>{{ invoice.name }}</td>
            <td>{{ invoice.meal_id }}</td>
            <td>{{ invoice.total_price }}</td>
            <td>{{ invoice.table_number }}</td>
            <td>
                <button @click="showInvoice(invoice)">Show</button>
            </td>

        </tr>
        </tbody>
    </table>
</div>
</template>

<script>
    // Component code (not registered)
    module.exports = {
        props: ["invoices"],
        data: function() {
            return {
                showingInvoice:null,
                selectedCategory:''
            };
        },
        methods: {
            showInvoice: function(invoice){
                this.showingInvoice = invoice;
                this.$emit('show-click', invoice);
            },
        },
        computed:{
            filteredInvoices: function() {
                var category = this.selectedCategory;

                if(category === "All") {

                    return this.invoices;
                }
                if(category ===	 "Pending") {
                    return this.invoices.filter(function(invoice) {
                        return invoice.state =="not paid";
                    });
                }
                if(!category)
                {
                    return this.invoices.filter(function(invoice) {
                        return invoice.state =="not paid";
                    });
                }
            }
        },

    };
</script>

<style scoped>
    tr.activerow {
        background: #123456 !important;
        color: #fff !important;
    }
</style>