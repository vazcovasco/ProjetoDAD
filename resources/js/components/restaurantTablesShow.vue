<template>
	<div class="jumbotron">
	    <h2>Table Active Meal</h2>
	      <table class="table table-striped">
            <thead>
            <tr>
                <th>Table Number</th>
				<th>Meal ID</th>
				<th>Responsible Waiter</th>
                <th>Total Price Preview</th>
                <th>State</th>
				<th>Start</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="meal in meals"  :key="meal.id">
                <td>{{ meal.table_number }}</td>
				<td>{{ meal.id }}</td>
				<td>{{ meal.responsible_waiter_id }}</td>
                <td>{{ meal.total_price_preview }}</td>
                <td>{{ meal.state }}</td>
                <td>{{ meal.start }}</td>
            </tr>
            </tbody>
        </table>   
	</div>
</template>

<script type="text/javascript">
	module.exports={
        props: ['restaurant_table'],
        data() {
            return {
				meals: []
            };
        },
	    methods: { 
			getMeal(){
			 axios.get('api/restaurant_tables/meal/'+this.restaurant_table.table_number)
					.then(response=>{ this.meals = response.data; }); // ver a estrutura do json
			}
		},
		mounted() {
            this.getMeal();
		}
	}
</script>

<style scoped>	

</style>