<template>
	<div>
		<div class="jumbotron">
			<h1>{{ title }}</h1>
		</div>

		<!-- <order-list :orders="orders"> </order-list> -->
		<order-list :orders="orders" @delete-click="deleteOrder" @message="childMessage" ref="ordersListRef"></order-list>

		<div class="alert alert-success" v-if="showSuccess">
			 
			<button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
			<strong>{{ successMessage }}</strong>
		</div>
			
	</div>				
</template>

<script type="text/javascript">
	import OrderList from './orderList.vue';
	//import OrderEdit from './orderEdit.vue';
	
	export default {
		data: function(){
			return { 
		        title: 'List of Orders',
		        showSuccess: false,
		        successMessage: '',
		        currentOrder: null,
		        orders: [],   
			}
		},
	    methods: {
	        setState: function(order){
				this.currentOrder = order;				
	            this.showSuccess = false;
	        },
	        deleteOrder: function(order){
	            axios.delete('api/orders/'+order.id)
	                .then(response => {
	                    this.showSuccess = true;
	                    this.successMessage = 'Order Deleted';
	                    this.getOrders();
	                });
	        },
	        /*savedOrder: function(){
	            this.currentOrder = null;
	            this.$refs.ordersListRef.editingOrder = null;
	            this.showSuccess = true;
	            this.successMessage = 'Order Saved';
	        },
	        cancelEdit: function(){
	            this.currentOrder = null;
	            this.$refs.ordersListRef.editingOrder = null;
	            this.showSuccess = false;
	        },*/
	        getOrders: function(){
	            axios.get('api/orders')
	                .then(response=>{this.orders = response.data; });
			},
			childMessage: function(message){
				this.showSuccess = true;
	            this.successMessage = message;
			}
	    },
	   	components: {
	    	'order-list': OrderList,
	    	//'order-edit': OrderEdit
	    },
	    mounted() {
			this.getOrders();
			
		}

	}
</script>

<style scoped>	
p {
	font-size: 2em;
	text-align: center;
}
</style>