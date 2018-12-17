<template>
<div>
	<div class="container" id="meals">
		<div class="filter">
		<label><input type="radio" v-model="selectedCategory" value="Active" /> Active</label>
		<label><input type="radio" v-model="selectedCategory" value="Terminated" /> Terminated</label>
		<label><input type="radio" v-model="selectedCategory" value="Paid" /> Paid</label>
		<label><input type="radio" v-model="selectedCategory" value="Not Paid" /> Not Paid</label>
		</div>

	<div class="filter">
		<label><input type="text" v-model="writtenNumber" value="id_waiter" id="id_waiter" /> </label>
		</div>id_waiter_responsible
		<button type="submit"  value="Submit">Filter ID</button>


	
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>id</th>
	              <th>Start</th>
				  <th>State</th>
	            <th>TableNumber</th>
	             <th>responsible_waiter_id</th>
				<th>Responsible Waiter Id</th>
				<th>Total Price Preview</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr v-for="meal in filteredMeals"  :key="meal.id">
	            <td>{{ meal.id }}</td>
	            <td>{{ meal.start }}</td>
				<td>{{ meal.end }}</td>
	            <td>{{ meal.table_number }}</td>
				<td>{{ meal.responsible_waiter_id }}</td>
				<td>{{ meal.total_price_preview}}</td>
				<td>{{ meal.state }}</td>	    
	          
				<td>
			<!-- 		<button @click="editMeal(Meal)">edit</button> -->
<!--                     <button @click="deleteMeal(meal)">Delete</button>
 -->	        <!-- 		<a :class="user.blocked ?  'btn btn-xs btn-success' : 'btn btn-xs btn-warning'"  @click.prevent="toggleBlockUser(user)" 
                    v-text="user.blocked ?  'UnBlock' : 'Block'" :id="user.id"></a> -->
	            </td>
			</tr>
	    </tbody>
	</table>
	</div>
</div>
</template>

<script type="text/javascript">
	// Component code (not registered)
	module.exports={
		props: ["meals"],
		data: function(){
			return{
				selectedCategory:'',
				writtenNumber:'',

			};			
		},
        methods: {
            
		},
		computed:{
			filteredMeals: function(){

				var category = this.selectedCategory;

				if(category === "Active") {
					return this.meals.filter(function(meal) {
						return meal.state == "active";
					});
				}
				if(category === "Terminated") {
					return this.meals.filter(function(meal) {
						return meal.state == "terminated";
					});
				}
				if(category === "Paid") {
					return this.meals.filter(function(meal) {
						return meal.state == "paid";
					});
				}
				if(category === "Not Paid") {
					return this.meals.filter(function(meal) {
						return meal.state == "not paid";
					});
				}
				if(!category)
				{
					
					return this.meals.filter(function(meal) {
						
					if(meal.state == "terminated")
							return true;
					if(meal.state == "active")
							return true;
					
					/* textBoxValue = document.getElementById("id_waiter");
					if(textBoxValue != '')
							return meal.responsible_waiter_id.match(this.writtenNumber);
					 */
					});	
						
				}
				
			}
			
		}

		
		
	}
</script>

<style scoped>
	tr.activerow {
  		background: #123456  !important;
  		color: #fff          !important;
}

</style>