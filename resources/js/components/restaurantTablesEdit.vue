<template>
	<div class="jumbotron">
	    <h2>Edit Table Number</h2>
	    <div class="form-group">
	        <label for="inputPrice">Table Number</label>
	        <input
	            type="text" class="form-control" v-model="newTableNumber"
	            name="name" id="inputTableNumber"
	            placeholder="Table Number"/>
	    </div>   

	    <div class="form-group">
	        <a class="btn btn-default" v-on:click.prevent="saveTable()">Save</a>
	        <a class="btn btn-default" v-on:click.prevent="cancelEdit()">Cancel</a>
	    </div>
	</div>
</template>

<script type="text/javascript">
	module.exports={
        props: ['restaurant_table'],
        data() {
			return {
				newTableNumber: undefined
            };
        },
	    methods: {
	        saveTable: function(){
	            axios.put(`api/restaurant_tables/`+this.restaurant_table.table_number, {newTableNumber: this.newTableNumber} )
	                .then(response=>{
	                	// Copy object properties from response.data.data to this.user
						// without creating a new reference
	                	this.$emit('table-saved', response.data);
	                });
	        },
	        cancelEdit: function(){
	        	this.$router.push("/");
	        }
	
            
		},
		mounted(){
			this.newTableNumber = this.restaurant_table.table_number;
		}
	}
</script>

<style scoped>	

</style>