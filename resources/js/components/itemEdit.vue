<template>
	<div class="jumbotron">
	    <h2>Edit Item</h2>
	    <div class="form-group">
	        <label for="inputName">Name</label>
	        <input
	            type="text" class="form-control" v-model="item.name"
	            name="name" id="inputName" 
	           />
	    </div>
	    <div class="form-group">
	        <label for="inputPrice">Price</label>
	        <input
	            type="text" class="form-control" v-model="item.price"
	            name="name" id="inputPrice"
	            placeholder="Username"/>
	    </div>
	    <div class="form-group">
	        <label for="inputEmail">Email</label>
	        <input
	            type="email" class="form-control" v-model="item.description"
	            name="email" id="inputEmail"
	            placeholder="Email address"/>
	    </div>	    

	    <div class="form-group">
	        <a class="btn btn-default" v-on:click.prevent="saveItem()">Save</a>
	        <a class="btn btn-default" v-on:click.prevent="cancelEdit()">Cancel</a>
	    </div>
	</div>
</template>

<script type="text/javascript">
	module.exports={
		props: ['item'],
	    methods: {
	        saveItem: function(){

	            axios.put(`api/items/?id=`+this.item.id,this.item)
	                .then(response=>{
	                	// Copy object properties from response.data.data to this.user
						// without creating a new reference
						console.log(response.data);
	                	Object.assign(this.item, response.data.data);
	                	this.$emit('item-saved', this.item);
	                });
	        },
	        cancelEdit: function(){
	        	axios.get('api/items/'+this.item.id)
	                .then(response=>{
	                	// Copy object properties from response.data.data to this.user
	                	// without creating a new reference
	                	Object.assign(this.item, response.data.data);
	                	this.$emit('item-canceled', this.item);
	                });
	        }
		}
	}
</script>

<style scoped>	

</style>