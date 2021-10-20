<template>
  <div>
    <div
      class="
        d-flex
        flex-direction-row
        justify-content-between
        align-items-center
      "
    >
      <h4>{{ title }}</h4>
      <router-link class="btn btn-primary" :to="{ name: 'SurveyForm' }"
        ><i class="fa fa-plus"></i> Enquete</router-link
      >
    </div>
    <hr />
    <div v-if="!loading">
      <div class="card mb-4" v-for="survey in surveys" :key="survey.uuid">
        <div
          class="
            card-header
            d-flex
            flex-direction-row
            justify-content-between
            align-items-center
            bg-white
            text-dark
          "
        >
          <h5>{{ survey.title }}</h5>
          <div class="btn-group">
            <button
              v-on:click="survey.open = !survey.open"
              class="btn btn-sm btn-primary"
            >
              <i class="fa fa-eye"></i>
            </button>
            <router-link
              class="btn btn-success btn-sm"
              :to="{ name: 'SurveyFormEdit', params: { id: survey.uuid } }"
              ><i class="fa fa-edit"></i
            ></router-link>
            <button
              v-on:click="deleteSurvey(survey)"
              class="btn btn-sm btn-danger"
            >
              <i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <p class="text-primary">
            <a
              target="_blank"
              :href="linkFull + '/surveys/play/' + survey.uuid"
            >
              {{ linkFull + "/surveys/play/" + survey.uuid }}
            </a>
          </p>

          <option-list v-if="survey.open" :options="survey.options" />

        </div>
      </div>
    </div>
    <div v-if="loading" style="font-size: 28px">
      <i class="fas fa-circle-notch fa-spin"></i> Carregando
    </div>
  </div>
</template>
<script>
import OptionList from './OptionList.vue';
export default {
  data: function () {
    return {
      loading: false,
      title: "Minhas enquetes",
      surveys: {},
      loading: false,
      linkFull: "http://localhost:8000",
      // linkFull: "https://appkata.windmot.com"
    };
  },
  created() {
    this.getSurveys();
  },
  components: {
    OptionList
  },
  methods: {
    getSurveys() {
      this.loading = true;
      axios
        .get(`/surveys`, this.form)
        .then((res) => {
          this.surveys = res.data.data;

          console.log(this.surveys);
          setTimeout(() => {
            this.loading = false;
          }, 500)
          
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
        });
    },
    compare(a, b) {
      if (a.percent < b.percent) {
        return -1;
      }
      if (a.percent > b.percent) {
        return 1;
      }
      return 0;
    },
    deleteSurvey(survey) {
      if (confirm("Tens certeza?")) {
        this.loading = true;
        axios
          .delete(`/surveys/${survey.id}`)
          .then((res) => {
            console.log(res);
            this.loading = false;
            alert("Enquete excluída.");
            this.getSurveys();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
};
</script>