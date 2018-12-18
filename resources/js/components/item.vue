<template>

	<div>
		<div class="jumbotron">
			<h1>{{ title }}</h1>
		</div>

		<div>
			<router-link to="/items/add"> <button>Add</button>  </router-link>
		</div>

		<div> 
	    <item-list :items="items" @delete-click="deleteItem" ref="itemsListRef" @edit-click="editItem" ></item-list>

		<item-edit :item="currentItem" @item-saved="saveItem"  @item-canceled="cancelEdit" v-if="currentItem"></item-edit>


		</div>
	</div>

</template>

<script type="text/javascript">

import ItemEdit from './itemEdit.vue';
import ItemList from './itemList.vue';
	
	export default {
		data: function(){
			return { 
				title:'List item',
		        editingItem: false,
				showSuccess: false,
				showFailure: false,
				successMessage: '',
				failMessage: '',
				currentItem: null,
				currentItemIndex: -1,
				items: [],
			}
		},
	    methods: {
			editItem: function(item){
	            this.currentItem = item;
				this.showSuccess = false;
				
			},
			deleteItem: function(item){		
	             axios.delete('api/items/', {params:{id:item.id}})
	                .then(response => {
	                    this.showSuccess = true;
						this.successMessage = 'Item Deleted';
						this.getItems();	                    
	                }); 
			},
			saveItem: function(){
                this.currentItem = null;
                this.$refs.itemsListRef.editingItem = null;
                this.showSuccess = true;
                this.successMessage = 'Item Saved';
			},
			cancelEdit: function(){
                this.currentItem = null;
                this.$refs.itemsListRef.editingItem = null;
            },
			getItems: function(){
				
              axios.get('api/items')
					.then(response=>{ this.items = response.data; }); // ver a estrutura do json
						
			},
		},
		components: {
			'item-list':ItemList,
			'item-edit':ItemEdit
		},
	    mounted() {
			this.getItems();
		}	
	}

</script>

<style scoped>	
p {
	font-size: 2em;
	text-align: center;
}
</style>