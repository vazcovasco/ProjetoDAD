<template>
	<div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Table Number</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="restaurant_table in restaurant_tables"  :key="restaurant_table.table_number" :class="{activerow: editingRestaurantTable === restaurant_table}">
					<td>Table Number nº{{ restaurant_table.table_number }}</td>
					<td>
						<a  class="btn btn-sm btn-primary"  v-on:click.prevent="editTable(restaurant_table)">Edit</a>
						<a  class="btn btn-sm btn-danger" v-on:click.prevent="deleteTable(restaurant_table)">Delete</a>
						<a :class="restaurant_table.deleted_at ?  'btn btn-xs btn-success' : 'btn btn-xs btn-warning'"  @click.prevent="restoreTable(restaurant_table)"
								v-text="restaurant_table.deleted_at ?  'Restore' : 'Delete'"></a>
                        <button  @click="showRestaurantTable(restaurant_table)">Show</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script type="text/javascript">
	// Component code (not registered)
	module.exports={
		props:["restaurant_tables"],
		data: function () {
			return {
				showingRestaurant_table: null,
                currentRestaurant_table: null,
                editingRestaurantTable: null,
			}
		},
		methods: {
			editTable: function(restaurant_table){
                this.editingRestaurantTable = restaurant_table;
				this.$emit('edit-table-click', restaurant_table);
			},
			deleteTable: function(restaurant_table){
				this.currentRestaurant_table = restaurant_table;
				this.$emit('delete-click', restaurant_table);
			},
			restoreTable: function(restaurant_table){
				this.$emit('restore-table-click', restaurant_table);
			},
            showRestaurantTable: function(restaurant_table){
                this.showingRestaurant_table = restaurant_table;
                this.$emit('show-restaurant-table-click', restaurant_table);
            },
			
		},
	}
</script>

<style scoped>
	/*	  Specific style applied only on the component*/
</style>