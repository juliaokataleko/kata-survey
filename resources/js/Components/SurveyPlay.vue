<template>
  <div>
    <div class="card">
      <div
        class="
          card-header
          d-flex
          flex-direction-row
          justify-content-between
          align-items-center
        "
      >
        <h1>{{ form.title }}</h1>
      </div>
      <div class="card-body">
        <div class="alert alert-success" v-if="loading">Carregando...</div>
        
          <survey :form="form" />

          
      </div>
    </div>
  </div>
</template>
<script>
import Survey from "./Survey.vue";

export default {
  components: {
    Survey,
  },
  data: function () {
    return {
      title: "Nova enquente",
      form: {
        uuid: "",
        title: "",
        about: "",
        seleted_option: "",
        options: [
          {
            number: 1,
            title: "",
          },
          {
            number: 2,
            title: "",
          },
        ],
      },
      loading: false,
      answer_sent: false,
      formReady: false,
    };
  },
  created() {
    if (this.$route.params.id) {
      this.getSurvey();
    }
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
            alert("Resposta enviada.");
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
      this.formReady = true;
      console.log(this.form);
    },
  },
};
</script>