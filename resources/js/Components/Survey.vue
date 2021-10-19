<template>
  <form @submit.prevent="saveSurvey()">
    <div class="form-group">
      <p>{{ form.about }}</p>
      <hr />
    </div>

    <div class="form-group">
      <h4>Opções</h4>
      <hr />
      <div
        class="d-flex justify-content-between align-items-center mb-2 cursor-pointer"
        :class="option_choosed == option.id ? 'bg-primary text-white p-2 rounded' : ''"
        v-for="option in orderedOptions"
        :key="option.number"
      >
          <label class="mt-2 cursor-pointer">
            <input
              type="radio"
              :disabled="answer_sent"
              v-on:click="selectOption(option)"
              name="answers[]"
              :id="'answer' + option.id"
            />
            {{ option.title }}
          </label>

        <span class="badge-dark badge-pill">
          ({{ option.votes }}/{{ option.total_votes }})
          {{ option.percent }}%</span
        >
      </div>
    </div>
    <div class="form-group">
      <hr />
      <div class="float-right">
        <a href="" v-if="answer_sent" class="btn btn-primary">Recarregar</a>
        <button type="submit" :disabled="answer_sent" class="btn btn-success">
          Responder
        </button>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  data() {
    return {
      title: "Nova enquente",
      loading: false,
      answer_sent: false,
      formReady: false,
      option_choosed: '',
    };
  },
  props: ["form"],
  computed: {
    orderedOptions: function () {
      return _.orderBy(this.form.options, "percent", "desc");
    },
  },
  created() {
    this.form = this.survey;
  },
  methods: {
    saveSurvey() {
      console.log(this.form);
      if (this.form.seleted_option == "") {
        alert("Por favor selecione uma opção.");
      } else {
        this.loading = true;
        axios
          .put(`/play-surveys/${this.form.id}`, this.form)
          .then((res) => {
            console.log(res);
            this.loading = false;
            // alert("Resposta enviada.");
            this.answer_sent = true;
            this.getSurvey();
            // this.$router.push("/");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    getSurvey() {
      axios
        .get("/play-surveys/" + this.$route.params.id)
        .then((res) => {
          this.form = res.data.data[0];

          console.log(res);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    selectOption(option) {
      this.form.seleted_option = option.id;
      this.option_choosed = option.id;
      this.formReady = true;
      console.log(this.form);

      // this.saveSurvey();
    },
  },
};
</script>
