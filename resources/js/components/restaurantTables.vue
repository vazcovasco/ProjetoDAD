<template>
  <div>
    <div class="jumbotron">
      <h1>{{ title }}</h1>
    </div>

    <div>
      <table class="table">
        <tbody class="center">
          <tr>
            <router-link class="button" to="/restaurantTables/add">Register New Table</router-link>
          </tr>
        </tbody>
      </table>
    </div>

    <tables-list
      :restaurant_tables="restaurant_tables"
      @edit-table-click="editTable"
      @show-restaurant-table-click="showTable"
      @delete-click="deleteTable"
      @restore-table-click="restoreTable"
      ref="restaurantTablesListRef"
    ></tables-list>
    <table-edit
      :restaurant_table="currentTableEdit"
      @table-saved="saveTable"
      @table-canceled="cancelEdit"
      v-if="editingTable"
    ></table-edit>
    <table-show
      :restaurant_table="currentTableShow"
      @table-canceled="cancelEdit"
      v-if="showingTable"
    ></table-show>

    <div class="alert alert-success" v-if="showSuccess">
      <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
      <strong>{{ successMessage }}</strong>
    </div>
  </div>
</template>

<script type="text/javascript">
import r_tablesList from "./restaurantTablesList.vue";
import r_tablesEdit from "./restaurantTablesEdit.vue";
import r_tablesShow from "./restaurantTablesShow.vue";

export default {
  data: function() {
    return {
      title: "List Restaurant Tables",
      showSuccess: false,
      successMessage: "",
      showingTable: false,
      currentTableShow: null,
      currentTableEdit: null,
      editingTable: false,
      restaurant_tables: []
    };
  },
  methods: {
    getTables: function() {
      axios
        .get("/api/restaurant_tables/all")
        .then(response => {
          this.restaurant_tables = response.data;
        })
        .catch(error => {
          this.showFailure = true;
          this.failMessage = "Error while fetching the existing orders!";
        });
    },
    editTable: function(restaurant_table) {
      this.editingTable = true;
      this.currentTableEdit = restaurant_table;
      this.showSuccess = false;
    },
    saveTable: function() {
      this.currentTableEdit = null;
      this.$refs.restaurantTablesListRef.editingTable = null;
      this.showSuccess = true;
      this.successMessage = "Table Saved";
      this.getTables();
    },
    cancelEdit: function() {
      this.currentTableEdit = null;
      this.$refs.restaurantTablesListRef.editingTable = null;
    },
    showTable: function(restaurant_table) {
      this.editingTable = false;
      this.currentTableEdit = null;

      this.showingTable = true;
      this.currentTableShow = restaurant_table;

      this.showSuccess = false;

      axios
        .get("api/restaurant_tables/meal/" + restaurant_table.table_number)
        .then(response => {
          this.restaurant_tables = response.data;

                        console.log(response);
                    }); // ver a estrutura do json

				
    		},
			deleteTable: function(restaurant_table) {
				console.log(restaurant_table);
				axios.delete("api/restaurant_tables/", { params: { tableDelete: restaurant_table.table_number } }).then(response => {
					this.showSuccess = true;
					this.successMessage = "Table Deleted";
					console.log(response.data);
					this.getTables();
				});
			   },
			restoreTable: function(restaurant_table){
				if (restaurant_table.deleted_at === null) {
					this.message = 'Table not Softdeleted';
				} else {
					this.message = 'Table  Softdeleted';
				}
				console.log(restaurant_table);
				axios.post('api/restaurant_tables/delete/'+ restaurant_table.table_number)
						.then(response=>{
							restaurant_table.deleted_at = !restaurant_table.deleted_at;
							this.$emit('message', this.message)
							this.getTables();
						})
						.catch(erros => {
							console.log(erros);
						})

			},
	    },
	   	components: {
			'tables-list': r_tablesList,
			'table-edit': r_tablesEdit,
			'table-show': r_tablesShow
	    },
	    mounted() {
			this.getTables();
		}

	}
</script>

<style scoped>
p {
  font-size: 2em;
  text-align: center;
}
</style>