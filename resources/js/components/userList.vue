<template>
  <div class="container" id="people">
    <div>
      <table class="table">
        <tbody class="center">
          <tr>
            <router-link class="button" to="/register">Register New User</router-link>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="filter">
      <label>
        <input type="radio" v-model="selectedCategory" value="All"> All
      </label>
      <label>
        <input type="radio" v-model="selectedCategory" value="Blocked"> Blocked
      </label>
      <label>
        <input type="radio" v-model="selectedCategory" value="SoftDelete"> Soft Delete
      </label>
    </div>
    <div class="container" id="people">
      <table class="table table-striped">
        <thead>
          <tr>
            <th @click="sort('name')">Name</th>
            <th @click="sort('username')">Username</th>
            <th @click="sort('email')">Email</th>
            <th>Photo</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in (sortedUsers, filteredUsers)"
            :key="user.id"
            :class="{activerow: editingUser === user}"
          >
            <td>{{ user.name }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.email }}</td>
            <td>
              <img width="100px" :src="getProfileImage(user.photo_url)">
            </td>
            <td>
              <button @click="editUser(user)">edit</button>
              <button @click="deleteUser(user)">Delete</button>
              <a
                :class="user.blocked ?  'btn btn-xs btn-success' : 'btn btn-xs btn-warning'"
                @click.prevent="toggleBlockUser(user)"
                v-text="user.blocked ?  'UnBlock' : 'Block'"
              ></a>
              <a
                :class="user.deleted_at ?  'btn btn-xs btn-success' : 'btn btn-xs btn-warning'"
                @click.prevent="restoreUser(user)"
                v-text="user.deleted_at ?  'Restore' : 'Delete'"
              ></a>
              <button
                @click="showPerformance(user)"
                v-if="user.type == 'cook' || user.type == 'waiter'"
              >Performance</button>
            </td>
          </tr>
        </tbody>
      </table>
      debug: sort={{currentSort}}, dir={{currentSortDir}}
    </div>
  </div>
</template>

<script type="text/javascript">
// Component code (not registered)
module.exports = {
  props: ["users"],
  data: function() {
    return {
      selectedCategory: "",
      editingUser: null,
      currentSort: "name",
      currentSortDir: "asc"
    };
  },
  methods: {
    editUser: function(user) {
      this.editingUser = user;
      this.$emit("edit-click", user);
    },
    getProfileImage(photo_url) {
      return `storage/profiles/${photo_url}`;
    },
    deleteUser: function(user) {
      this.$emit("delete-click", user);
    },
    restoreUser: function(user) {
      this.$emit("restore-click", user);
    },
    toggleBlockUser: function(user) {
      if (user.blocked === 1) {
        this.message = "User Unblocked";
      } else {
        this.message = "User Blocked";
      }
      axios
        .post("api/users/block/" + user.id)
        .then(response => {
          // Copy object properties from response.data.data to this.user
          // without creating a new reference
          user.blocked = !user.blocked;
          //Object.assign(user, response.data.data);
          this.$emit("message", this.message);
        })
        .catch(erros => {
          console.log(erros);
        });
    },
    showPerformance: function(user) {
      this.$emit("show-performance-click", user.id);
    },
    sort: function(s) {
      //if s == current sort, reverse
      if (s === this.currentSort) {
        this.currentSortDir = this.currentSortDir === "asc" ? "desc" : "asc";
      }
      this.currentSort = s;
    }
  },
  computed: {
    filteredUsers: function() {
      var category = this.selectedCategory;

      if (category === "All") {
        return this.users;
      }
      if (category === "Blocked") {
        return this.users.filter(function(user) {
          return user.blocked == 1;
        });
      }
      if (category === "SoftDelete") {
        return this.users.filter(function(user) {
          return user.deleted_at != null;
        });
      }
      if (!category) {
        return this.users;
      }
    },
    sortedUsers: function() {
      return this.users.sort((a, b) => {
        let modifier = 1;
        if (this.currentSortDir === "desc") modifier = -1;
        if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
        if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
        return 0;
      });
    }
  }
};
</script>

<style scoped>
tr.activerow {
  background: #123456 !important;
  color: #fff !important;
}

.center {
  text-align: center;
}

.button {
  background-color: #4caf50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>