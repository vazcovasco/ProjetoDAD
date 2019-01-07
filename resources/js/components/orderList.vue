<template>
	<div>
		<div class="filter">
            <label for="prepared">
                <input id="prepared" type="radio" v-model="selectedCategory" value="prepared"/> Prepared
            </label>
            <label><input type="radio" v-model="selectedCategory" value="pending"/> Pending</label>
            <label><input type="radio" v-model="selectedCategory" value="confirmed"/> Confirmed</label>
			<label v-if="isCook"><input type="radio" v-model="selectedCategory" value="in preparation"/> In preperation</label>
        </div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Order ID</th>
					<th>State</th>
					<th>Item</th>
					<th>Meal</th>
					<th>Cook</th>
					<th>Start</th>
					<th>End</th>
					<th v-if="isCook || isWaiter">Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="order in filteredOrders"  :key="order.id">
					<td>{{ order.id }}</td>
					<td v-if="order.state === 'confirmed'" style="color : green">{{ order.state }}</td>
					<td v-else-if="order.state === 'in preparation' " style="color : blue">{{ order.state }}</td>
					<td v-else-if="order.state === 'pending' " style="color : red">{{ order.state }}</td>
					<td v-else-if="order.state === 'prepared' ">{{ order.state }}</td>
					<td v-else-if="order.state === 'delivered' ">{{ order.state }}</td>
					<td v-else-if="order.state === 'not delivered' ">{{ order.state }}</td>
					<td>{{ order.item_id }}</td>
					<td>{{ order.meal_id }}</td>
					<td>{{ order.responsible_cook_id }}</td>
					<td>{{ order.start }}</td>
					<td>{{ order.end }}</td>
					<td>
						<a v-if="(isCook && (order.state=='confirmed' || order.state=='in preperation')) || (isWaiter && order.state=='prepared')" class="btn btn-sm btn-primary"  v-on:click.prevent="setState(order)">State</a>
						<a v-if="order.state=='pending'" class="btn btn-sm btn-danger" v-on:click.prevent="deleteOrder(order)">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script type="text/javascript">
	// Component code (not registered)
	module.exports={
		props:["orders"],
		data: function () {
			return {
				isCook: false,
				isWaiter: false,
				currentOrder: null,
				selectedCategory: '',
			}
		},
		methods: {
			setState: function(order){
				this.orderType = order.state;
				this.$emit('set_state-click', order);
			},
			deleteOrder: function(order){
				this.currentOrder = null;
				this.$emit('delete-click', order);
			},
		},
		computed:{
			filteredOrders: function() {
				var category = this.selectedCategory;

				
				if(category ===	 "pending") {
					return this.orders.filter(function(order) {
						return order.state == 'pending';
					});
				}
				if(category ===	 "confirmed") {
					return this.orders.filter(function(order) {
						return order.state == 'confirmed';
					});
				}
				if(category ===	 "prepared") {
					return this.orders.filter(function(order) {
						return order.state == 'prepared';
					});
				}
				if(category ===	 "in preparation") {
					return this.orders.filter(function(order) {
						return order.state == 'prepared';
					});
				}
				if(!category)
				{
					return this.orders;
				}
			}
		},
		created() {
			if(this.$store.state.user.type == 'cook') {
				this.isCook = true;
			} if(this.$store.state.user.type == 'waiter') {
				this.isWaiter = true;
			}
		}
	}
</script>

<style scoped>
	/*	  Specific style applied only on the component*/
</style>