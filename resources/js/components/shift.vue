<template>
  <div v-if="user != null">
    <table class="table">
      <tbody class="center">
        <tr>
          <button class="button" v-if="!isShiftStarted" @click="startShift">Start Shift</button>
          <button class="button" v-if="isShiftStarted" @click="endShift">End Shift</button>
        </tr>
        <tr>
          <div v-if="isShiftStarted" class="alert alert-success">
            <p>
              <strong>{{user.name}} is working!!</strong>
            </p>
            <p>Shift started at: {{shiftStart}}</p>
            <p>Time Past: {{ this.timer }}</p>
          </div>
          <div v-if="!isShiftStarted" class="alert alert-danger">
            <p>
              <strong>{{user.name}} is not working!!</strong>
            </p>
            <p>Shift ended at: {{shiftEnd}}</p>
          </div>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
var moment = require("moment");
export default {
  props: ["user"],
  data() {
    return {
      moment: moment,
      isShiftStarted: this.$store.getters.isShiftStarted,
      timer: ""
    };
  },

  computed: {
    shiftStart() {
      return this.$store.state.shiftStarted;
    },
    shiftEnd() {
      return this.$store.state.shiftEnded;
    }
  },

  methods: {
    startShift() {
      let t = this;

      t.startTimer();

      axios
        .post("api/users/changeLastShiftEnd/" + t.user.id)
        .then(function(response) {
          t.$store.dispatch("startShift");
          t.user.last_shift_start = response.data.last_shift_start;
          t.isShiftStarted = !t.isShiftStarted;
        });
    },
    endShift() {
      let t = this;
      axios
        .post("api/users/changeLastShiftStart/" + t.user.id)
        .then(function(response) {
          t.$store.dispatch("endShift");
          t.user.last_shift_end = response.data.last_shift_end;
          t.isShiftStarted = !t.isShiftStarted;
        });
    },
    startTimer() {
      var setTimeStamp = this.moment().startOf(this.startShift);
      console.log("timestamp - " + setTimeStamp);

      setInterval(() => {
        setTimeStamp.add(1, "second");
        this.timer = null;
        this.timer = setTimeStamp.format("HH:mm:ss");
        console.log("timer - " + this.timer);
      }, 1000);
    }
  },
  created() {
    console.log(this.isShiftStarted);
    this.startTimer();
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