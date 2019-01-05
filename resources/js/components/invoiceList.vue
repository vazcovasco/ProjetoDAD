<template>
    <div class="container" id="people">
        <div class="filter" >
            <label><input  id="active"  v-on:click="isNinja = true" type="radio" v-model="selectedCategory" value="pending"/>pending </label>
            <label><input  type="radio"  v-on:click="isNinja = true" v-model="selectedCategory" value="paid"/> Paid</label>
            <label><input  type="radio" v-on:click="isNinja =true" v-model="selectedCategory" value="not paid" /> Not Paid</label>
        </div>
        <div class="filter" v-show="isNinja" >
            filter data
            <label><input type="text" v-on:click="isNinja2 = !isNinja2" v-show="isNinja" v-model="writtenDate" value="date" id="date"/>
            </label>
        </div>


        <div class="filter" v-show ="isNinja2"  v-if="writtenDate!=''">
            id_waiter_responsible
            <label><input  type="text"  v-model="writtenNumber" value="id_waiter"
                          id="id_waiter"/> </label>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>MealID</th>
                <th>Total Price</th>
                <th>Table Number</th>
                <th>Responsible Waiter ID</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="invoice in filteredInvoices"  :key="invoice.id" :class="{activerow: showingInvoice === invoice}">
                <td>{{ invoice.name }}</td>
                <td>{{ invoice.meal_id }}</td>
                <td>{{ invoice.total_price }}</td>
                <td>{{ invoice.table_number }}</td>
                <td>{{ invoice.responsible_waiter_id }}</td>
                <td>{{ invoice.date }}</td>
                <td>
                    <button  @click="showInvoice(invoice)">Show</button>
                    <button  v-if="invoice.state=='paid'" @click="downloadInvoice(invoice)">Download</button>
                    <button v-if="invoice.state=='pending'" @click="editInvoice(invoice)" >Nif/Name</button>
                </td>

            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    // Component code (not registered)
    import moment from 'moment';
    export default {
        props: ["invoices"],
        data: function() {
            return {
                showingInvoice:null,
                selectedCategory:'',
                writtenNumber:'',
                writtenDate:'',
                isNinja: false,
                isNinja2: false,
            };
        },
        methods: {
            showInvoice: function(invoice){
                this.showingInvoice = invoice;
                this.$emit('show-click', invoice);
            },
            editInvoice: function(invoice){
                this.$emit('edit-click', invoice);
            },
            downloadInvoice: function(invoice){
                this.$emit('download-click', invoice);
            },
            getDate(date) {
                return moment(date, 'YYYY-MM-DD').format('YYYY-MM-DD');
            },


        },
        computed: {
            filteredInvoices() {
                let category = this.selectedCategory;
                let inputValue = this.writtenNumber;
                let inputDate = this.writtenDate;


                return this.invoices.filter((invoice) => {
                    if (category === '' && invoice.state === 'pending') {
                        return true;
                    }

                    if (category === invoice.state) {

                        let dateCmp = moment(inputDate, 'YYYY-MM-DD');
                       // console.log(dateCmp);

                        let dateCmpItem = moment(invoice.date, 'YYYY-MM-DD');
                        console.log(dateCmpItem);

                        if (inputDate === '') {
                            return true;

                        }
                        console.log(dateCmp.diff(dateCmpItem));

                        if(dateCmp.diff(dateCmpItem) === 0) {
                            console.log("dentro do if ");
                            if (inputValue === '') {
                                return true;

                            }

                            if (inputValue.toString() === invoice.responsible_waiter_id.toString()) {
                                console.log("dentro do cenas ");
                                return true;
                            }
                                return false;

                        }
                        return false;

                    }
                    return false;
                });
            }
        }

    };
</script>

<style scoped>
    tr.activerow {
        background: #123456 !important;
        color: #fff !important;
    }
</style>