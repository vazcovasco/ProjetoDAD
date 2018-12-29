<template>
	<table class="table table-striped">
		<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Photo</th>
			<th>Prices</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="item in items"  :key="item.id">
			<td>{{ item.name }}</td>
			<td>{{ item.description }}</td>
			<td>{{ item.price }}</td>
			<td ><img width="100px" :src="getFoodImage(item.photo_url)"></td>
				<td v-if="isLoggedIn && isManager">
				<button @click="editItem(item)">edit</button>
				<button @click="deleteItem(item)">Delete</button>
				<a :class="item.deleted_at ?  'btn btn-xs btn-success' : 'btn btn-xs btn-warning'"  @click.prevent="restoreItem(item)"
				   v-text="item.deleted_at ?  'Restore' : 'Delete'"></a>
			</td>


		</tr>
		</tbody>
	</table>
</template>

<script>
	// Component code (not registered)
	module.exports = {
		props: ["items"],
		data: function() {
			return {
		isLoggedIn: this.$store.getters.loggedIn,
		isManager: this.$store.getters.isManager
			};
		},
		methods: {
			getFoodImage(photo_url) {
				return `storage/items/${photo_url}`;
			},
			editItem: function(item){
				this.editingItem = item;
				this.$emit('edit-click', item);
			},
			deleteItem: function(item){
				this.$emit('delete-click', item);
			},
			restoreItem: function(item){
				this.$emit('restore-click', item);
			},

		}

	};
</script>

<style scoped>
	tr.activerow {
		background: #123456 !important;
		color: #fff !important;
	}
</style>