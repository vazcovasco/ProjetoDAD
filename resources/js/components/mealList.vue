<template>
<div>
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>id</th>
	            <th>State</th>
	            <th>TableNumber</th>
	            <th>Start</th>
	            <th>End</th>
				<th>Responsible Waiter Id</th>
				<th>Total Price Preview</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr v-for="meal in meals"  :key="meal.id">
	            <td>{{ meal.id }}</td>
	            <td>{{ meal.state }}</td>
				<td>{{ meal.start }}</td>
				<td>{{ meal.end }}</td>
	            <td>{{ meal.table_number }}</td>
				<td>{{ meal.responsible_waiter_id }}</td>
				<td>{{ meal.total_price_preview}}</td>	    
	            <!-- <td ><img width="100px" :src="getProfileImage(user.photo_url)"></td>
				<td>
					<button @click="editMeal(user)">edit</button>
                    <button @click="deleteUser(user)">Delete</button>
	        		<a :class="user.blocked ?  'btn btn-xs btn-success' : 'btn btn-xs btn-warning'"  @click.prevent="toggleBlockUser(user)" 
                    v-text="user.blocked ?  'UnBlock' : 'Block'" :id="user.id"></a>
	            </td> -->
			</tr>
	    </tbody>
	</table>
	</div>
</template>

<script type="text/javascript">
	// Component code (not registered)
	module.exports={
		props: ["meals"],
		data: function(){
			return{};			
		},
        methods: {
            getProfileImage(photo_url) {
      			return `storage/profiles/${photo_url}`;
			},
		}
	}
</script>

<style scoped>
	tr.activerow {
  		background: #123456  !important;
  		color: #fff          !important;
}

</style>