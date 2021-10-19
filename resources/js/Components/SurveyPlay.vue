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
        <form @submit.prevent="saveSurvey()">
          <div class="form-group">
            <p>{{ form.about }}</p>
            <hr>
          </div>

          <div class="form-group">
              <h4>Opções</h4>
              <hr>
            <div
              class="d-flex
              justify-content-between
              align-items-center mb-2"
              v-for="option in form.options"
              :key="option.number"
            >
                <label>
                    <input type="radio" :disabled="answer_sent" v-on:click="selectOption(option)" name="answers[]" :id="'answer'+option.id">
                    {{ option.title }}
                </label>

                <span class="badge-dark badge-pill">
              ({{ option.votes }}/{{ option.total_votes }})
              {{ option.percent }}%</span>

            </div>
          </div>

          <div class="form-group">
              <hr>
              <div class="float-right">
                  <a href="" v-if="answer_sent" class="btn btn-primary">Recarregar</a>
                <button type="submit" :disabled="answer_sent" class="btn btn-success">Responder</button>
              </div>
            
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      title: "Nova enquente",
      form: {
        uuid: "",
        title: "",
        about: "",
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
        seleted_option: ''
      },
      loading: false,
        answer_sent: false
    };
  },
  created() {
    if (this.$route.params.id) {
      this.getSurvey();
    }
  },
  methods: {
    addOption() {
      if (this.form.options.length < 10) {
        let number = this.form.options.length + 1;
        this.form.options.push({
          number,
          title: "",
        });
      }
    },
    saveSurvey() {
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
        console.log(this.form);
    }

  },
};
</script>