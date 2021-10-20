<template>
  <div class="form-group">
    <ul class="list-group list-group list-group-flush">
      <li
        class="
          list-group-item
          d-flex
          justify-content-between
          align-items-center
        "
        v-for="option in orderedOptions"
        :key="option.id"
      >
        {{ option.title }}
        <span class="badge-dark badge-pill">
          ({{ option.votes }}/{{ option.total_votes }})
          {{ option.percent }}%</span
        >
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "Nova enquente",
      loading: false,
      answer_sent: false,
      formReady: false,
      option_choosed: "",
    };
  },
  props: ["options"],
  computed: {
    orderedOptions: function () {
      return _.orderBy(this.options, "percent", "desc");
    },
  },
  created() {
    this.form = this.survey;
  },
  methods: {},
};
</script>
