<template>
  <div class="container" id="people">
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
      <div>
        <input
          type="text"
          id="inputGlobal"
          class="inputchat"
          v-model="msgGlobalText"
          @keypress.enter="sendGlobalMsg"
        >
      </div>
      <div>
        <textarea id="textGlobal" class="inputchat" v-model="msgGlobalTextArea">Global Chat</textarea>
      </div>
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
              <button class="btn btn-xs btn-warning" @click="editUser(user)">Edit</button>

              <a
                v-if="user.id != currentUserId"
                :class="user.blocked ?  'btn btn-xs btn-success' : 'btn btn-xs btn-warning'"
                @click.prevent="toggleBlockUser(user)"
                v-text="user.blocked ?  'UnBlock' : 'Block'"
              ></a>
              <a v-if="user.deleted_at" class="btn btn-xs btn-success" @click.prevent="restoreUser(user)"
              >Restore</a>
              <a v-else class="btn btn-xs btn-warning"  @click.prevent="deleteUser(user)"
              >Delete</a>
              <button v-if="user.type == 'cook' || user.type == 'waiter'"
                @click="showPerformance(user)" class="btn btn-xs btn-warning"
              >Performance</button>
            </td>
          </tr>
          <tr v-show="!filteredUsers.length">
            <td colspan="6">  {{selectedCategory}} user not found</td>
            <
          </tr>
        </tbody>
      </table>
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
      currentSortDir: "asc",
      msgGlobalText: "",
      msgGlobalTextArea: "",
      isCookOrWaiter: false,
      currentUserId: this.$store.state.user.id
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
    },
    sendGlobalMsg() {}
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
  },
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