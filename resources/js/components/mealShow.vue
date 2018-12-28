<template>
    <div class="jumbotron">
        <h2>Show Meal</h2>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Table Number</th>
                <th>Total Price Preview</th>
                <th>Price</th>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="meal in meals"  :key="meal.id">
                <td>{{ meal.table_number }}</td>
                <td>{{ meal.total_price_preview }}</td>
                <td>{{ meal.price }}</td>
                <td>{{ meal.name }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script type="text/javascript">



    module.exports= {
        props: ['meals','items'],

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


