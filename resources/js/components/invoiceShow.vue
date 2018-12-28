<template>
    <div class="jumbotron">
        <h2>Show Invoice</h2>
        <div class="form-group">
            <label>Date:</label>
            <span>{{invoice.date}} </span>
        </div>
        <div class="form-group">
            <label>Table Number:</label>
            <span>{{invoice.table_number}} </span>
        </div>
        <div class="form-group">
            <label>Name Waiter:</label>
            <span>{{invoice.name}} </span>
        </div>
        <div class="form-group">
            <label>Total Price:</label>
            <span>{{invoice.total_price}} </span>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>quantity</th>
                <th>unit_price</th>
                <th>sub_total_price</th>
                <th>name</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items"  :key="item.id">
                <td>{{ item.quantity }}</td>
                <td>{{ item.unit_price }}</td>
                <td>{{ item.sub_total_price }}</td>
                <td>{{ item.name }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script type="text/javascript">



    module.exports= {
        props: ['invoice','items'],

        data() {
            return {


            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>